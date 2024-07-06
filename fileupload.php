<?php
define('_VALID', true);
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require 'include/config.paths.php';
require 'include/config.local.php';

$basedir = $config['BASE_DIR'];				
$targetDir = $config['VDO_DIR'];
$cleanupTargetDir =true;
$maxFileAge = 5 * 3600; 
$allowed_ext = explode(',', $config['video_allowed_extensions']);
$site_url = $config['BASE_URL'];
$site_url= parse_url($site_url, PHP_URL_HOST);

$referal_url=parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
if ($site_url != $referal_url){
die('Invalid Upload!');
}

if (isset($_REQUEST["name"])) {
	$fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
	$fileName = $_FILES["file"]["name"];
} else {
	$fileName = uniqid("file_");
}

$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
if (!in_array($file_ext, $allowed_ext)) {
    die('{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "Invalid file extension."}, "id" : "id"}');
}

$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
	
if ($cleanupTargetDir) {
	if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	}

	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		if ($tmpfilePath == "{$filePath}.part") {
			continue;
		}

		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
			@unlink($tmpfilePath);
		}
	}
	closedir($dir);
}

if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
	$contentType = $_SERVER["CONTENT_TYPE"];

if (strpos($contentType, "multipart") !== false) {
	if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {

        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {	
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
	$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
	if ($out) {
		$in = fopen("php://input", "rb");

		if ($in) {
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		}
		fclose($in);
		fclose($out);
	} 
}


if (!$chunks || $chunk == $chunks - 1) {
	rename("{$filePath}.part", $filePath);
	if(isset($_REQUEST['id'])) {
		$extension = pathinfo($filePath, PATHINFO_EXTENSION);
		$dest = $targetDir.'/'.$_REQUEST['id'].'.'.$extension;
		if(rename($filePath,$dest)){
            unlink($filePath);
		}	
		
	}	
}
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

?>

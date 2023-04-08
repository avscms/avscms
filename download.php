<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';

$vid   = intval($_GET['id']);
$label = intval($_GET['label']);

$sql = "SELECT * FROM video WHERE VID = ".$vid." LIMIT 1";
$rs = $conn->execute($sql);	
$formats = $rs->fields['formats'];
$server  = $rs->fields['server'];
$formats_arr = explode(',', $formats);

if ($server != '') {
	$sql = "SELECT * FROM video v, servers s WHERE v.VID = ".$vid." AND v.server = s.video_url LIMIT 1";
	$rs  = $conn->execute($sql); 
	$video_root = $rs->fields['video_url']; 
}
if (!$video_root) {
	$video_root = $config['BASE_DIR']."/media/videos";
}
	
foreach ($formats_arr as $format) {
	$f = explode('.', $format);
	if ($label == $f[1]) {
		if ($f[0] >= 480) {
			$condition = $new_permisions['hd_downloads'];
		} else {
			$condition = $new_permisions['sd_downloads'];			
		}
		$file = $video_root.'/h264/'.$vid.'_'.$f[1].'.'.$f[2];
		$file_name = $vid.'_'.$f[1].'.'.$f[2];
		break;
	}

}
	
if ($condition == 1) {
	ini_set('memory_limit', '-1');
	if (!$server) {
		if (file_exists($file) && is_file($file) && is_readable($file)) {
			$conn->execute("UPDATE video SET download_num = download_num+1 WHERE VID = ".$vid." LIMIT 1");
			@ob_end_clean();
			if(ini_get('zlib.output_compression')) {
				ini_set('zlib.output_compression', 'Off');
			}	    
			header('Content-Type: application/force-download');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			header('Cache-control: private');
			header('Pragma: private');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-Length: ' .filesize($file));             
			readfile($file);
			exit();
		} else {
			VRedirect::go($config['BASE_URL']. '/error');
		}
	} else {
			$conn->execute("UPDATE video SET download_num = download_num+1 WHERE VID = ".$vid." LIMIT 1");
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: chunked'); 
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');

			$stream = fopen('php://output', 'w');

			$ch = curl_init($file);
			curl_setopt($ch, CURLOPT_READFUNCTION, function($ch, $fd, $length) use ($stream) {
				return fwrite($stream, fread($fd, $length));
			});

			curl_exec($ch);
			curl_close($ch);
	}
}
if ($condition == 0 && !$_SESSION['uid']) {
    $_SESSION['error'] = $lang['download.error'];
    VRedirect::go($config['BASE_URL']. '/signup');
}
if ($condition == 0 && $_SESSION['uid'] && $_SESSION['uid_premium'] == 0) {
	VRedirect::go($config['BASE_URL']. '/notfound/download_free');
}
if ($condition == 0 && $_SESSION['uid_premium']) {
	VRedirect::go($config['BASE_URL']. '/notfound/download_premium');
}
die();
?>

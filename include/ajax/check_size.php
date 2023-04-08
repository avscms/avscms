<?php

defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require_once $config['BASE_DIR']. '/include/function_thumbs.php';

function bytes($a) {
	$unim = array("B","kB","MB","GB","TB","PB");
	$c = 0;
	while ( $a >= 1000 ) {
		$c++;
		$a = $a/1000;
	}
	return number_format($a,($c ? 2 : 0),",",".")." ".$unim[$c];
}

function count_files($directory) {
	$filecount = 0;
	$files = glob($directory . "*");
	if ($files){
		$filecount = count($files);
	}
	return $filecount;
}

$response = array('size' => 0, 'sd_size' => 0, 'hd_size' => 0, 'mobile_size' => 0, 'thumbnails' => 0, 'ready' => FALSE, 'failed' => FALSE);
if ( isset($_POST['path']) ) {
	$path = $_POST['path'];
	$video = $path;
	$tmp = explode('/', $path);
	$vid = end($tmp);
	list($vid) = explode('.', $vid);
	$sd_video = $config['FLVDO_DIR'].'/'.$vid.'.flv';
	$hd_video = $config['HD_DIR'].'/'.$vid.'.mp4';
	$mobile_video = $config['IPHONE_DIR'].'/'.$vid.'.mp4';
	
	if (file_exists($video)) {
		$response['size'] = filesize($video);
	}
	if (file_exists($sd_video)) {
		$response['sd_size'] = bytes(filesize($sd_video));
	}
	if (file_exists($hd_video)) {
		$response['hd_size'] = bytes(filesize($hd_video));
	}
	if (file_exists($mobile_video)) {
		$response['mobile_size'] = bytes(filesize($mobile_video));
	}	

	$response['thumbnails'] = count_files(get_thumb_dir($vid).'/');
	
	if ($response['thumbnails'] >= 21) {
		$response['ready'] = TRUE;
	}

	$sql = "SELECT * FROM video WHERE VID = " .$conn->qStr($vid). " LIMIT 1";
	$conn->execute($sql);
	if (!$conn->Affected_Rows()) {
		$response['failed'] = TRUE;
	}
}

echo json_encode($response);
die();
?>

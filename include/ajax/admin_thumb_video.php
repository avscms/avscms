<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response	= array('status' => 0, 'msg' => '', 'src' => '', 'debug' => '');
$filter  	= new VFilter();
$vid     	= $filter->get('video_id', 'INTEGER');
	
$files 		= video_files($vid);
$found      = false;

foreach ($files['dir'] as $file) {
	if (file_exists($file) && filesize($file) > 100) {
		extract_video_thumbs($file, $vid, 'all', $config['thumbnail_remove_bb'], $config['thumbnail_keep_ar']);
		$found = true;
		break;
	}
}

if (!$found) {
	foreach ($files['url'] as $file) {
		if (file_url_exists($file)) {
			extract_video_thumbs($file, $vid, 'all', $config['thumbnail_remove_bb'], $config['thumbnail_keep_ar']);			
			$found = true;
			break;
		}
	}	
}

if (!$found) {
	$response['status'] = 0;
	echo json_encode($response);
	die();	
}

$sql 	= "SELECT thumb FROM video WHERE VID = " .$vid. " LIMIT 1";
$rs 	= $conn->execute($sql);
$thumb 	= $rs->fields['thumb'];
$response['src'] = get_thumb_url($vid).'/'.$thumb.'.jpg';
$thumb_path = get_thumb_dir($vid).'/'.$thumb.'.jpg';
if (file_exists($thumb_path)) {
	$response['status'] = 1;
} else {
	$response['status'] = 0;
}

echo json_encode($response);
die();
?>

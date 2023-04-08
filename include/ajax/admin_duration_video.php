<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'msg' => '', 'duration' => '00:00', 'debug' => '');

$filter     = new VFilter();
$vid        = $filter->get('video_id', 'INTEGER');

$files 		= video_files($vid);
$found      = false;

foreach ($files['dir'] as $file) {
	if (file_exists($file) && filesize($file) > 100) {
		$duration = get_video_duration($file, $vid);
		$found = true;
		break;		
	}
}

if (!$found) {
	foreach ($files['url'] as $file) {
		if (file_url_exists($file)) {
			$duration = get_video_duration($file, $vid);
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
			
$sql = "UPDATE video SET duration = ".$duration." WHERE VID = ".$vid." LIMIT 1";
$conn->execute($sql);
$response['status'] = 1;

$duration_formated  = NULL;
$duration           = round($duration);
if ( $duration > 3600 ) {
	$hours              = floor($duration/3600);
	$duration_formated .= sprintf('%02d',$hours). ':';
	$duration           = round($duration-($hours*3600));
}
if ( $duration > 60 ) {
	$minutes            = floor($duration/60);
	$duration_formated .= sprintf('%02d', $minutes). ':';
	$duration           = round($duration-($minutes*60));
} else {
	$duration_formated .= '00:';
}
$response['duration'] = $duration_formated . sprintf('%02d', $duration);

echo json_encode($response);
die();
?>

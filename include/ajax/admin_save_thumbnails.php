<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'src' => '');

$filter = new VFilter();
$vid    = $filter->get('video_id', 'INTEGER');
$thumb  = $filter->get('thumbnails_default', 'INTEGER');

$sql = "UPDATE video SET thumb = " .$conn->qStr($thumb). "
		WHERE VID = " .$conn->qStr($vid). " LIMIT 1";
$conn->execute($sql);
$response['status'] = 1;

$tmp_thumb_dir = $config['TMP_DIR'].'/thumbs/'.$vid.'_adm';
for ($i = 1; $i <= 20; $i++) {
	$temp_thumb_file  = $tmp_thumb_dir.'/'.$i.'.jpg';
	$final_thumb_file = get_thumb_dir($vid).'/'.$i.'.jpg';
	if (file_exists($temp_thumb_file)) {
		copy($temp_thumb_file, $final_thumb_file);
	}
}

$temp_thumb_file  = $tmp_thumb_dir.'/default.jpg';
$final_thumb_file = get_thumb_dir($vid).'/default.jpg';
if (file_exists($temp_thumb_file)) {
	copy($temp_thumb_file, $final_thumb_file);
}

$response['src'] = get_thumb_url($vid).'/'.$thumb.'.jpg';

echo json_encode($response);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'thumbnails' => array(), 'player' => false, 'thumb' => 1, 'count' => 20);

$filter  = new VFilter();
$vid     = $filter->get('video_id', 'INTEGER');

$sql = "SELECT thumb, thumbs from video WHERE VID = " .$conn->qStr($vid). " LIMIT 1";
$rs = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
	$response['thumb'] = $rs->fields('thumb');
	$count = $rs->fields('thumbs');	
	$response['count'] = $count;
}
$thumb_dir = get_thumb_dir($vid);
$thumb_url = get_thumb_url($vid);
$tmp_thumb_dir = $config['TMP_DIR'].'/thumbs/'.$vid.'_adm';

if (file_exists($tmp_thumb_dir)) {
	delete_directory($tmp_thumb_dir);
}

for ($i = 1; $i <= $count; $i++) {
	if (file_exists($thumb_dir.'/'.$i.'.jpg')) {

		$response['thumbnails'][$i] = $thumb_url.'/'.$i.'.jpg';
	} else {
		$response['thumbnails'][$i] = $config['TMB_URL'].'/default.jpg';
	}
}


if (file_exists($thumb_dir.'/default.jpg')) {
	$response['player'] = $thumb_url.'/default.jpg';	
}
$response['status'] = 1;

echo json_encode($response);
die();
?>

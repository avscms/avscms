<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 1);

$filter = new VFilter();
$vid    = $filter->get('video_id', 'INTEGER');
$tmp_thumb_dir = $config['TMP_DIR'].'/thumbs/'.$vid.'_adm';

if (file_exists($tmp_thumb_dir)) {
	delete_directory($tmp_thumb_dir);
}

echo json_encode($response);
die();
?>

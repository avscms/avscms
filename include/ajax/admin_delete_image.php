<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_admin.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'msg' => '', 'debug' => '');

$filter     = new VFilter();
$iid        = $filter->get('image_id', 'INTEGER');

$sql = "DELETE FROM notice_images WHERE image_id = " .$iid. " LIMIT 1";
$conn->execute($sql);
@unlink($config['BASE_DIR'].'/images/notice_images/'.$iid.'.jpg');
@unlink($config['BASE_DIR'].'/images/notice_images/thumbs/'.$iid.'.jpg');

$response['status'] = 1;

echo json_encode($response);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0);

$data = (array) $_POST['data'];

$sid          = trim($data['id']);
$url          = trim($data['url']);
$video_url    = trim($data['video_url']);
$server_ip    = trim($data['server_ip']);
$ftp_username = trim($data['ftp_username']);
$ftp_password = trim($data['ftp_password']);
$ftp_root     = trim($data['ftp_root']);
$current_used = trim($data['current_used']);
$status       = trim($data['active']);

settype($sid, 'integer');

$sql = "UPDATE servers
		SET url = ".$conn->qStr($url).",
			video_url = ".$conn->qStr($video_url).",
			server_ip = ".$conn->qStr($server_ip).",
			ftp_username = ".$conn->qStr($ftp_username).",
			ftp_password = ".$conn->qStr($ftp_password).",
			ftp_root = ".$conn->qStr($ftp_root).",
			current_used = '".$current_used."',
			status = '".$status."'
		WHERE server_id = ".$sid."
		LIMIT 1";

$conn->execute($sql);
$response['status'] = 1;

echo json_encode($response);
die();
?>

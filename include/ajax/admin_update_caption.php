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

$pid     = trim($data['id']);
$caption = trim($data['caption']);

settype($pid, 'integer');
settype($caption, 'string');

$sql = "UPDATE photos SET caption = " .$conn->qStr($caption). " 
		WHERE PID = " .$pid. " LIMIT 1";
$conn->execute($sql);
$response['status'] = 1;

echo json_encode($response);
die();
?>

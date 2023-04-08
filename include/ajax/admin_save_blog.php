<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

function nl2br2($string) { 
	$string = str_replace(array("\\r\\n", "\\r", "\\n"), "\n", $string);
	return $string; 
} 

$response = array('status' => 0);

$data = (array) $_POST['data'];

$bid            = trim($data['id']);
$title          = trim($data['title']);
$content        = trim($data['content']);
$viewnumber     = trim($data['viewnumber']);
$active         = trim($data['active']);

settype($bid, 'integer');
settype($viewnumber, 'integer');

$sql = "UPDATE blog SET title = " .$conn->qStr($title). ", 
						content = " .nl2br2($conn->qStr($content)). ", 
						total_views = " .$conn->qStr($viewnumber). ", 
						status  = " .$conn->qStr($active). " 
		WHERE BID = " .$conn->qStr($bid). " LIMIT 1";
$conn->execute($sql);
$response['status'] = 1;

echo json_encode($response);
die();
?>

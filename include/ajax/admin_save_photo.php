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

$pid            = trim($data['id']);
$caption        = trim($data['caption']);
$likes          = trim($data['likes']);
$dislikes       = trim($data['dislikes']);
$total_views    = trim($data['viewnumber']);
$status         = trim($data['active']);

settype($aid, 'integer');
settype($total_views, 'integer');
settype($likes, 'integer');
settype($dislikes, 'integer');
settype($category, 'integer');
if ( $likes != 0 || $dislikes !=0)
	$rate = round(($likes * 100)/($likes + $dislikes));
else
	$rate = 0;

$sql   = "UPDATE photos SET caption = " .$conn->qStr($caption). ", 
							likes = " .$conn->qStr($likes). ", 
							dislikes = " .$conn->qStr($dislikes). ", 
							rate = " .$conn->qStr($rate). ", 
							total_views = " .$conn->qStr($total_views). ", 
							status  = " .$conn->qStr($status). " 
		  WHERE PID = " .$conn->qStr($pid). " LIMIT 1";
$conn->execute($sql);
$response['status'] = 1;

echo json_encode($response);
die();
?>

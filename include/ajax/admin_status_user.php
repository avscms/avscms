<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0);

$filter  = new VFilter();
$uid     = $filter->get('user_id', 'INTEGER');
$ustatus = $filter->get('user_status', 'INTEGER');

if ($ustatus) {
	$sql = "UPDATE signup SET account_status = 'Inactive' WHERE UID = " .$conn->qStr($uid). " LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 ) {	
		$response['status'] = 1;	
	}
} else {
	$sql = "UPDATE signup SET account_status = 'Active' WHERE UID = " .$conn->qStr($uid). " LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 ) {
		$response['status'] = 1;
	}
}

echo json_encode($response);
die();
?>

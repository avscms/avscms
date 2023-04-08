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
$cid     = $filter->get('category_id', 'INTEGER');
$gstatus = $filter->get('category_status', 'INTEGER');

if ($gstatus) {
	$sql = "UPDATE notice_categories SET status = '0' WHERE category_id = " .$conn->qStr($cid). " LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 ) {	
		$response['status'] = 1;	
	}
} else {
	$sql = "UPDATE notice_categories SET status = '1' WHERE category_id = " .$conn->qStr($cid). " LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 ) {
		$response['status'] = 1;
	}
}

echo json_encode($response);
die();
?>

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
$bid     = $filter->get('blog_id', 'INTEGER');
$bstatus = $filter->get('blog_status', 'INTEGER');

if ($bstatus) {
	$sql = "UPDATE blog SET status = '0' WHERE BID = " .$conn->qStr($bid). " LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 ) {	
		$response['status'] = 1;	
	}
} else {
	$sql = "UPDATE blog SET status = '1' WHERE BID = " .$conn->qStr($bid). " LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 ) {
		//send_blog_approve_email($bid);
		$response['status'] = 1;
	}
}

echo json_encode($response);
die();
?>

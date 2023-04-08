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
$pid     = $filter->get('photo_id', 'INTEGER');

$sql = "SELECT * from photos WHERE PID = " .$conn->qStr($pid). " LIMIT 1";
$rs = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
	$photo = $rs->getrows();
	$photo = $photo[0];
	foreach ($photo as $key=>$value) {
		if ($key == 'status') {
			$key = 'active';
		}
		$response[$key] = $value;
		
	}		
	$response['status'] = 1;
}

echo json_encode($response);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'thumbs' => array(), 'photos' => array(), 'prev' => false, 'next' => false, 'count' => 0);

$filter  = new VFilter();
$aid     = $filter->get('album_id', 'INTEGER');
$start   = $filter->get('start', 'INTEGER');
$limit   = 8;
$total   = 0;

$sql            = "SELECT count(PID) AS total_photos FROM photos WHERE AID = " .$aid;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_photos'];

if ($total > $start + $limit) {
	$response['next'] = true;
}
if ($start > 0) {
	$response['prev'] = true;
}

if ($start != -1) {
	$sql    = "SELECT * FROM photos WHERE AID = " .$aid. " ORDER BY PID DESC LIMIT " .$start. ", ".$limit;
} else {
	$sql    = "SELECT * FROM photos WHERE AID = " .$aid. " ORDER BY PID DESC";
}
$rs     = $conn->execute($sql);

if ( $conn->Affected_Rows() ) {
	$photos = $rs->getrows();
	$count = 0;
	foreach ($photos as $key => $photo) {
		$response['thumbs'][$key]  = $config['BASE_URL'] . '/media/photos/tmb/' .$photo['PID']. '.jpg';
		$response['photos'][$key]  = $photo['PID'];
		$response['caption'][$key] = $photo['caption'];
		$response['active'][$key]  = $photo['status'];
		$response['total_comments'][$key]  = $photo['total_comments'];		
		$response['total_views'][$key]  = $photo['total_views'];				
		$count++;
	}	
	$response['status'] = 1;
}

$response['count'] = $count;

echo json_encode($response);
die();
?>

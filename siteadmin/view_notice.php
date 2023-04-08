<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_global.php';
require '../include/function_admin.php';
require '../include/function_smarty.php';
require '../classes/auth.class.php';

if (isset($_GET['NID']) && $_GET['NID'] != '') {
	$nid = intval($_GET['NID']);
} else {
	die();
}

$sql = "SELECT * from notice WHERE NID = " .$conn->qStr($nid). " LIMIT 1";
$rs = $conn->execute($sql);

if ( $conn->Affected_Rows() == 1 ) {
	$notice = $rs->getrows();
	$notice = $notice[0];
} else {
	die();
}

$smarty->assign('notice', $notice);
$smarty->display('view_notice.tpl');
?>

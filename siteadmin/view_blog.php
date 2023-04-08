<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_global.php';
require '../include/function_admin.php';
require '../include/function_smarty.php';
require '../classes/auth.class.php';

if (isset($_GET['BID']) && $_GET['BID'] != '') {
	$bid = intval($_GET['BID']);
} else {
	die();
}

$sql = "SELECT * from blog WHERE BID = " .$conn->qStr($bid). " LIMIT 1";
$rs = $conn->execute($sql);

if ( $conn->Affected_Rows() == 1 ) {
	$blog = $rs->getrows();
	$blog = $blog[0];
	$blog['content'] = blog_output_admin($blog['content']);	
} else {
	die();
}

$smarty->assign('blog', $blog);
$smarty->display('view_blog.tpl');
?>

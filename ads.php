<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';


if (isset($_GET['id']) && $_GET['id']!= '') {
	$id = $_GET['id'];
	
	
	$stmt = $conn->prepare("SELECT * FROM adv_pause WHERE id = ? LIMIT 1");
	$rs = $conn->execute($stmt, array($id));	
	$ad  = $rs->getrows();
	$ad = $ad['0'];	
	if ( $conn->Affected_Rows() != 1 ) {	
		exit;
	} else {
		$stmt = $conn->prepare("UPDATE adv_pause SET views = views+1 WHERE id =? LIMIT 1");
		$rs = $conn->execute($stmt, array($id));				
	}	
}
$smarty->assign('ad',$ad);
$smarty->display('ads.tpl');
?>
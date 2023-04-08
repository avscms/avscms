<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$from_to_version = "";
$file_version = "";

if ( isset($_POST['update-step1']) ) {
	$filter                     	= new VFilter();
    $from_to_version			    = $filter->get('from_to_version');
    $file_version			        = $filter->get('file_version');
}

$smarty->assign('from_to_version',$from_to_version);
$smarty->assign('file_version',$file_version);
?>
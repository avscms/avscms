<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$from_to_version = "";
$file_version = "";

if ( isset($_POST['update-step2']) ) {
	$filter                     	= new VFilter();
    $from_to_version			    = $filter->get('from_to_version');
    $file_version			        = $filter->get('file_version');
	remove_previous_update_sql();
}

$smarty->assign('from_to_version',$from_to_version);
$smarty->assign('file_version',$file_version);
?>
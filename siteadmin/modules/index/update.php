<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$version_c = AVS_VERSION.'.'.AVS_PATCHLEVEL;
$official_version = getversion();

//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);

$isupdate_available = false;

$result = version_compare($version_c, $official_version);
if ($result == -1) {
    $isupdate_available = true;
} elseif ($result == 1) {
    $isupdate_available = false;
} else {
    $isupdate_available = false;
}

if ( isset($_GET['updateStatus']) &&  $_GET['updateStatus']=='sucess') {
	$messages[] = 'Script has been updated successfully!';
}


$smarty->assign('is_update_available',$isupdate_available);
$smarty->assign('version_c',$version_c);
$smarty->assign('official_version',$official_version);
?>
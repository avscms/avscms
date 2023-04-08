<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_admin.php';
require '../classes/validation.class.php';
require '../classes/auth.class.php';
require '../classes/filter.class.php';
require '../include/function_update.php';

Auth::checkAdmin();

if ( isset($_GET['err']) ) {
    $errors[]   = trim($_GET['err']);
}

if ( isset($_GET['msg']) ) {
    $messages[] = trim($_GET['msg']);
}

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'dashboard';
$module_template    = 'index.tpl';
$modules_allowed    = array('dashboard', 'admin', 'main', 'check', 'mail', 'modules', 'static', 'media', 'encoding', 'encodingadd', 'encodingedit', 'miscellaneous', 'permissions', 'sessions', 'bandwidth',
                            'bans', 'emails', 'emailadd', 'emailedit', 'advgroups', 'advs', 'advadd', 'advgroupedit', 'advedit',
							'advpause', 'advtext', 'advpauseadd', 'advtextadd', 'advtextedit', 'advpauseedit', 'player', 'playeradd', 'playeredit', 'userpermisions', 'socialsignin', 'captcha', 'logo', 'playerlogo', 'analytics', 'advvastvpaid', 'advvastvpaidadd', 'advvastvpaidedit',
							'update', 'update-step1', 'update-step2', 'update-step3');
if ( in_array($module, $modules_allowed) ) {
    $module_template = ( $module == 'dashboard' ) ? 'index.tpl' : 'index_' .$module. '.tpl';
    require 'modules/index/' .$module. '.php';
} else {
    $err = 'Invalid Settings Module!';
}

$active_menu = 'settings';
if ( in_array($module, array('dashboard')) ) {	
	$active_menu = 'dashboard';
} elseif ( in_array($module, array('admin', 'main', 'check', 'mail', 'static', 'socialsignin', 'captcha', 'logo', 'analytics')) ) {
	$sub_menu = 'general';
} elseif ( in_array($module, array('media', 'encoding', 'encodingadd', 'encodingedit')) ) {
	$sub_menu = 'video-conversion';
} elseif ( in_array($module, array('modules', 'permissions', 'bandwidth', 'sessions', 'bans', 'userpermisions')) ) {
	$sub_menu = 'security';
} elseif ( in_array($module, array('emails', 'emailadd', 'emailedit')) ) {
	$sub_menu = 'email-templates';
} elseif ( in_array($module, array('advgroups', 'advs', 'advadd', 'advgroupedit', 'advedit', 'advpause', 'advtext', 'advpauseadd', 'advtextadd', 'advtextedit', 'advpauseedit', 'advvastvpaid', 'advvastvpaidadd', 'advvastvpaidedit',)) ) {
	$sub_menu = 'advertising-settings';
} elseif ( in_array($module, array('player', 'playeradd', 'playeredit', 'playerlogo')) ) {
	$sub_menu = 'player-settings';
} elseif ( in_array($module, array('update', 'update-step1', 'update-step2', 'update-step3')) ) {
	$sub_menu = 'update';
}


$smarty->assign('module', $module);
$smarty->assign('errors', $errors);
$smarty->assign('err', $err);
$smarty->assign('messages', $messages);
$smarty->assign('warnings', $warnings);
$smarty->assign('active_menu', $active_menu);
$smarty->assign('sub_menu', $sub_menu);
$smarty->display('header.tpl');
$smarty->display('leftmenu/menu.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>
<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_admin.php';
require '../include/function_global.php';
require '../classes/auth.class.php';

Auth::checkAdmin();

$errors             = ( isset($_GET['err']) ) ? array($_GET['err']) : $errors;
$messages           = ( isset($_GET['msg']) ) ? array($_GET['msg']) : $messages;
$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'list';
$modules_allowed    = array('list', 'view', 'add', 'edit', 'addgame', 'listgame', 'editgame', 'addalbum', 'listalbum', 'editalbum');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'list';
    $err    = 'Invalid Channels Module!';
}

switch ( $module ) {
    case 'view':
    case 'add':
    case 'edit':
    case 'addgame':
    case 'listgame':
    case 'editgame':
    case 'addalbum':
    case 'listalbum':
    case 'editalbum':	
        $module_template = 'channels_' .$module. '.tpl';
        break;
    case 'list':
    default:
        $module_template = 'channels.tpl';
}

require 'modules/channels/' .$module. '.php';

$smarty->assign('errors', $errors);
$smarty->assign('err', $err);
$smarty->assign('messages', $messages);
$smarty->assign('module', $module);
$smarty->assign('active_menu', 'channels');
$smarty->assign('sub_menu', $sub_menu);
$smarty->display('header.tpl');
$smarty->display('leftmenu/menu.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>

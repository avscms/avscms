<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_admin.php';
require '../include/function_notice.php';
require '../classes/auth.class.php';

Auth::checkAdmin();

$errors             = ( isset($_GET['err']) ) ? array($_GET['err']) : $errors;
$messages           = ( isset($_GET['msg']) ) ? array($_GET['msg']) : $messages;
$modules_allowed    = array('list', 'add', 'edit', 'add_image', 'list_images', 'view', 'delete', 'list_categories');
$module             = ( isset($_GET['m']) && in_array($_GET['m'], $modules_allowed) ) ? trim($_GET['m']) : 'list';
$module_template    = 'notices_list.tpl';

$module_keep = NULL;
switch ( $module ) {
    case 'edit':
    case 'add':
    case 'add_image':
    case 'list_images':
    case 'list_categories':
    case 'view':
        $module_template = 'notices_' .$module. '.tpl';
        break;
    case 'delete':
    case 'activate':
    case 'suspend':
    case 'list':
    default:
        break;
}

require 'modules/notice/' .$module. '.php';

$smarty->assign('module', $module);
$smarty->assign('errors', $errors);
$smarty->assign('err', $err);
$smarty->assign('messages', $messages);
$smarty->assign('active_menu', 'notices');
$smarty->assign('sub_menu', $sub_menu);
$smarty->display('header.tpl');
$smarty->display('leftmenu/menu.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>

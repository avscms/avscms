<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_global.php';
require '../include/function_admin.php';
require '../classes/auth.class.php';

Auth::checkAdmin();

if ( isset($_GET['err']) ) {
    $errors[]   = trim($_GET['err']);
}

if ( isset($_GET['msg']) ) {
    $messages[] = trim($_GET['msg']);
}

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'all';
$module_keep        = NULL;
$module_template    = 'videos.tpl';
$modules_allowed    = array('all', 'public', 'private', 'flagged', 'view', 'edit', 'comments',
                            'commentedit', 'add', 'spam', 'grabber', 'embed', 'membed', 'csv', 'csvformats', 'aembedder', 'yt', 'queue');
if ( !in_array($module, $modules_allowed) ) {
    $module = 'all';
    $err    = 'Invalid Videos Module!';
}

switch ( $module ) {
    case 'flagged':
    case 'spam':
    case 'edit':
    case 'view':
    case 'comments':
    case 'commentedit':
    case 'add':
	case 'queue':	
    case 'grabber':
    case 'membed':	
	case 'embed':
	case 'csv':
	case 'csvformats':
	case 'csvformatadd':	
	case 'csvformatedit':
	case 'aembedder':
	case 'yt':		
        $module_template = 'videos_' .$module. '.tpl';
        break;
    case 'all':
    case 'public':
    case 'private':
    default:
        $module_keep        = $module;
        $module             = 'all';
        $module_template    = 'videos.tpl';
        break;
}

if ( in_array($module, array('all', 'public', 'private', 'view', 'edit')) ) {
	$sub_menu = 'manage-videos';
} elseif ( in_array($module, array('flagged', 'comments', 'commentedit', 'spam')) ) {
	$sub_menu = 'requests';
} elseif ( in_array($module, array('add', 'grabber', 'membed', 'embed', 'csv', 'csvformats', 'aembedder', 'yt')) ) {
	$sub_menu = 'add-videos';
}

if ($module == 'queue') {
	$sub_menu = 'conversion-q';
}

require 'modules/videos/' .$module. '.php';

$smarty->assign('messages', $messages);
$smarty->assign('info', $info);
$smarty->assign('warnings', $warnings);
$smarty->assign('errors', $errors);
$smarty->assign('err',$err);
if ($module_keep) {
	$smarty->assign('module', $module_keep);
} else {
	$smarty->assign('module', $module);
}

$smarty->assign('active_menu', 'videos');
$smarty->assign('sub_menu', $sub_menu);
$smarty->display('header.tpl');
$smarty->display('leftmenu/menu.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>

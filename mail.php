<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/auth.class.php';

$auth   = new Auth();
$auth->check();

$uid        = intval($_SESSION['uid']);
$username   = $_SESSION['username'];
$sql        = "SELECT * FROM signup WHERE UID = " .$uid. " LIMIT 1";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/user_missing');
}
$user       = $rs->getrows();
$user       = $user['0'];

$sql        = "SELECT * FROM users_online WHERE UID = " .$uid. " AND online > " .(time()-300). " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 )
	$online = true;
else
	$online = false;

$request    = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : NULL;
$request    = str_replace('?' .$_SERVER['QUERY_STRING'], '', $request);
$query      = explode('/', $request);
foreach ( $query as $key => $value ) {
    if ( $value == 'mail' ) {
        $query = array_slice($query, $key+1);
    }
}

if ( isset($query['0']) && $query['0'] != '' ) {
    $module             = $query['0'];
    $modules_allowed    = array('inbox', 'outbox', 'compose', 'read');
    if ( !in_array($module, $modules_allowed) ) {
        $module         = 'inbox';
    }
}
$module     = ( isset($module) ) ? $module : 'inbox';
if ( $module == 'read' ) {
    $template = 'mail_read';
} elseif ( $module == 'compose' ) {
    $template = 'mail_compose';
} else {
    $template = 'mail';
}

require 'modules/mail/' .$module. '.php';

$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('submenu', '');
$smarty->assign('username', $username);
$smarty->assign('user', $user);
$smarty->assign('online', $online);
$smarty->assign('profile', true);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display($template. '.tpl');
$smarty->display('footer.tpl');
?>

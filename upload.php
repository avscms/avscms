<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/auth.class.php';
require 'classes/email.class.php';

if (isset($new_permisions['upload_video'])) {
	if ($new_permisions['upload_video'] == 0) {
		VRedirect::go($config['BASE_URL']. '/notfound/upload_permission');
	}
}

$auth = new Auth();
$auth->check();
$auth->confirm();

$sql        = "SELECT * FROM signup WHERE UID = " .intval($_SESSION['uid']). " LIMIT 1";
$rs         = $conn->execute($sql);
if ( !$conn->Affected_Rows() == 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/user_missing');
}

$user       = $rs->getrows();
$user       = $user['0'];
$username   = $user['username'];
$uid    = intval($user['UID']);

$sql        = "SELECT * FROM users_online WHERE UID = " .$uid. " AND online > " .(time()-300). " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 )
	$online = true;
else
	$online = false;
	
$module     = NULL;
$modules    = array('default', 'video', 'photo');
$request    = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : NULL;
$request    = ( isset($_SERVER['QUERY_STRING']) ) ? str_replace('?' .$_SERVER['QUERY_STRING'], '', $request) : $request;
$query      = explode('/', $request);
if ( is_array($query) ) {
    foreach ( $query as $key => $value ) {
        if ( $value == 'upload' ) {
            $module = ( isset($query[$key+1]) ) ? $query[$key+1] : 'default';
            if ( !in_array($module, $modules) ) {
                VRedirect::go($config['BASE_URL']. '/notfound/missing');
            }
        }
    }
}

function getAnonymousUID()
{
    global $conn;
    
    $sql    = "SELECT UID FROM signup WHERE username = 'anonymous' LIMIT 1";
    $rs     = $conn->execute($sql);
    
    return intval($rs->fields['UID']);
}

if ( $module == 'default' ) {
    $module_template = 'upload.tpl';
} else {
    $module_template = 'upload_' .$module. '.tpl';
    require $config['BASE_DIR']. '/modules/upload/' .$module. '.php';
}

$smarty->assign('self_title', $seo['upload_title']);
$smarty->assign('self_description', $seo['upload_desc']);
$smarty->assign('self_keywords', $seo['upload_keywords']);
$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'upload');
$smarty->assign('submenu', '');
$smarty->assign('user', $user);
$smarty->assign('online', $online);
$smarty->assign('username', $username);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>

<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';

if ( isset($_POST['submit_login']) ) {
    require 'classes/filter.class.php';
    $filter     = new VFilter();
    $username   = $filter->get('username');
    $password   = $filter->get('password');
    $current_url= $filter->get('current_url');	
    
    if ( $username == '' || $password == '' ) {
        $errors[] = $lang['login.empty'];
    }
    
    if ( !$errors ) {
        $sql    = "SELECT UID, email, pwd, emailverified, photo, fname, logintime, gender,premium
                   FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $user   = $rs->getrows();
			$password = md5($password);
			if ( $password == $user['0']['pwd'] ) {
                $yesterday  = time() - 86400;
                $sql_add    = NULL;
                if ( intval($user['0']['logintime']) < $yesterday ) {
                    $sql_add = ", points = points+5";
                }
            
                $sql    = "UPDATE signup SET logintime = '" .time(). "'" .$sql_add. " WHERE username = " .$conn->qStr($username). " LIMIT 1";
                $conn->execute($sql);
                $_SESSION['uid']            = $user['0']['UID'];
				if ($user['0']['premium'] == '1') {
					$_SESSION['uid_premium'] = 1;
				}
                $_SESSION['username']       = $username;
                $_SESSION['email']          = $user['0']['email'];
                $_SESSION['emailverified']  = $user['0']['emailverified'];
                $_SESSION['photo']          = $user['0']['photo'];
                $_SESSION['fname']          = $user['0']['fname'];
                $_SESSION['gender']         = $user['0']['gender'];
                $_SESSION['message']        = $lang['login.welcome'] .$username. '!';
                
                if (isset($_POST['login_remember']) && $config['user_remember'] == '1') {
                    Remember::set($username, $user['0']['pwd']);
                }
                    
				if (strpos(strtolower($current_url), 'signup') !== false || strpos(strtolower($current_url), 'login') !== false) {
					$current_url = '';
				}
                $_URL = $config['BASE_URL'].$current_url; 
                VRedirect::go($_URL);
            } else {
                $errors[] = $lang['login.invalid'];
            }
        } else {
            $errors[] = $lang['login.invalid'];
        }
    }
}

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('submenu', '');
$smarty->assign('self_title', $seo['login_title']);
$smarty->assign('self_description', $seo['login_desc']);
$smarty->assign('self_keywords', $seo['login_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('login.tpl');
$smarty->display('footer.tpl');
?>

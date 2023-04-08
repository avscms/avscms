<?php
define('_VALID', true);
define('_ADMIN', true);
include('../include/config.php');

if ((isset($_SESSION['AUID']) && $_SESSION['AUID'] == $config['admin_name']) && $_SESSION['APASSWORD'] == $config['admin_pass']) {
	$_SESSION['AUID']   = $config['admin_name'];
	$_SESSION['APASSWORD']  = $config['admin_pass'];
	VRedirect::go($config['BASE_URL']. '/siteadmin/index.php');
}

$username = '';
$password = '';
$err = NULL;
$msg = NULL;

if ( isset($_POST['submit_login']) ) {
    $username   = trim($_POST['username']);
    $password   = trim($_POST['password']);
        
    if ( $username == '' or $password == '' ) {
        $errors[] = 'Please provide a username and password!';
		$err['account'] = 1;
    } else {
        if ( $username == $config['admin_name'] && $password == $config['admin_pass'] ) {
            $_SESSION['AUID']   = $config['admin_name'];
            $_SESSION['APASSWORD']  = $config['admin_pass'];
            VRedirect::go($config['BASE_URL']. '/siteadmin/index.php');
        } else {
            $errors[] = 'Invalid username and/or password!';
			$err['account'] = 1;			
        }
    }
}

if ( isset($_POST['submit_forgot']) ) {
    if ( !isset($_SESSION['email_forgot']) )
        $_SESSION['email_forgot'] = 1;
    
    if ( $_SESSION['email_forgot'] > 2 ) {
        $errors[] = 'Please try again later!';
    }
    
    if ( !$errors ) {
		require '../classes/email.class.php';
        $mail           = new VMail();
        $mail->set();
        $mail->Subject  = 'Your ' .$config['site_name']. ' administrator username and password!';
        $message        = 'Username: ' .$config['admin_name']. "\n";
        $message       .= 'Password: ' .$config['admin_pass']. "\n";
        $mail->AltBody  = $message;
        $mail->Body     = nl2br($message);
        $mail->AddAddress($config['admin_email']);
        $mail->Send();
        $messages[] = 'Email was successfuly sent!';
    }
    
    $_SESSION['email_forgot'] = $_SESSION['email_forgot']+1;
}

$smarty->assign('username',$username);
$smarty->assign('password',$password);
$smarty->assign('messages',$messages);
$smarty->assign('err',$err);
$smarty->assign('errors',$errors);
$smarty->display('login.tpl');
?>

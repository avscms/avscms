<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_socialsignin']) ) {
	$fb_signin 			 = $_POST['fb_signin'];
	$fb_appid 			 = $_POST['fb_appid'];
	$g_signin			 = $_POST['g_signin'];
	$g_cid               = $_POST['g_cid'];

	if ($fb_appid == '' && $fb_signin == '1') {
		$errors[] = 'Facebook App ID is required to enable Facebook sign-in!';
		$err['fb_appid']    = 1;
	}		
	if ($g_cid == '' && $g_signin == '1') {
		$errors[]     = 'Google Client ID is required to enable Google sign-in!';
		$err['g_cid'] = 1;		
	}
	
	if (!$errors) {
		$config['fb_signin'] = $fb_signin;
		$config['fb_appid']  = $fb_appid;
		$config['g_signin']  = $g_signin;
		$config['g_cid']     = $g_cid;
		
		update_config($config);
		update_smarty();
		$messages[] = 'Social Sign-in Settings Successfuly Updated!';
	}
}
$smarty->assign('err', $err);
?>

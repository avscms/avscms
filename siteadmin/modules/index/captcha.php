<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_captcha']) ) {
	$captcha 			 = $_POST['captcha'];
	$recaptcha_site_key    = $_POST['recaptcha_site_key'];
	$recaptcha_secret_key  = $_POST['recaptcha_secret_key'];

	if ($recaptcha_site_key == '' && $captcha == '1') {
		$errors[] = 'Site Key is required to enable reCAPTCHA!';
		$err['recaptcha_site_key']    = 1;
	}		
	if ($recaptcha_secret_key == '' && $captcha == '1') {
		$errors[] = 'Secret Key is required to enable reCAPTCHA!';
		$err['recaptcha_secret_key']    = 1;
	}
	
	if (!$errors) {
		$config['captcha'] = $captcha;
		$config['recaptcha_site_key']  = $recaptcha_site_key;
		$config['recaptcha_secret_key']  = $recaptcha_secret_key;
		
		update_config($config);
		update_smarty();
		$messages[] = 'Sign-in Captcha Settings Successfuly Updated!';
	}
}
$smarty->assign('err', $err);
?>

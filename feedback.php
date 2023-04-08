<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/validation.class.php';
require 'classes/filter.class.php';

$feedback       = array('department' => 'General', 'email' => '', 'name' => '', 'message' => '');
$departments    = array('General', 'Violations', 'Advertising');

if ( $config['captcha'] == '1' ) {
	$captcha_language = substr($_SESSION['language'], 0, 2);
	switch ($_SESSION['language']) {
		case 'sa_SA':
			$captcha_language = 'ar';
			break;
		case 'he_IL':
			$captcha_language = 'iw';
			break;
		case 'jp_JP':
			$captcha_language = 'ja';
			break;
		case 'cn_CS':
			$captcha_language = 'zh-CN';
			break;
		case 'cn_CT':
			$captcha_language = 'zh-TW';
			break;
		case 'dk_DK':
			$captcha_language = 'da';
			break;
		case 'cz_CZ':
			$captcha_language = 'cs';
			break;
		case 'rs_RS':
			$captcha_language = 'sr';
			break;
		case 'si_SI':
			$captcha_language = 'sl';
			break;
		case 'ba_BA':
			$captcha_language = 'sl';
			break;			
	}
}

if ( isset($_POST['submit_feedback']) ) {
    $filter     = new VFilter();
    $valid      = new VValidation();
    $department = $filter->get('department');
    $email      = $filter->get('email');
    $name       = $filter->get('name');
    $message    = $filter->get('message');

    if ( !in_array($department, $departments) ) {
        $errors[]               = $lang['feedback.department_invalid'];
		$err['department']		= 1;
    } else {
        $feedback['department'] = $department;
    }
    
    if ( $email == '' ) {
        $errors[]               = $lang['global.email_empty'];
		$err['email']		    = 1;
    } elseif ( !$valid->email($email) ) {
        $errors[]               = $lang['global.email_invalid'];
		$err['email']		    = 1;
    } else {
        $feedback['email']      = $email;
    }
    
    if ( $name == '' ) {
        $errors[]               = $lang['feedback.name_empty'];
		$err['name']		    = 1;
    } else {
        $feedback['name']       = $name;
    }
    
    if ( $message == '' ) {
        $errors[]               = $lang['global.message_empty'];
		$err['message']		    = 1;
    } elseif ( mb_strlen($message) > 1000 ) {
        $errors[]               = translate('message_length', '1000');
		$err['email']		    = 1;
    } else {
        $feedback['message']    = $message;
    }

	if ( $config['captcha'] == '1' ) {

		$secret = $config['recaptcha_secret_key'];
		require('modules/captcha/recaptchalib.php');
		$response = null;
		$reCaptcha = new ReCaptcha($secret);	
		$response = $reCaptcha->verifyResponse(
						$_SERVER["REMOTE_ADDR"],
						$_POST["g-recaptcha-response"]
					);
		if ($response != null && $response->success) {
			// verified!
		} else {
			$errors[] = $lang['signup.captcha'];
		}		
	}
    
	if ( !$errors ) {
		require $config['BASE_DIR']. '/classes/email.class.php';
        $message            = "Department: " .$department. "\n\nMessage: " .$message;
        $mail               = new VMail();
        $mail->From         = $email;
        $mail->FromName     = $name;
        $mail->Sender       = $email;
        $mail->AddReplyTo($email, $name);
        $mail->Subject      = 'Feedback from ' .htmlspecialchars($name);
        $mail->AltBody      = $message;
        $mail->Body         = nl2br($message);
        $mail->AddAddress($config['admin_email']);
        $mail->Send();
        $messages[]         = $lang['feedback.sent'];
    }
}

$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('feedback', $feedback);
$smarty->assign('self_title', $seo['feedback_title']);
$smarty->assign('self_description', $seo['feedback_desc']);
$smarty->assign('self_keywords', $seo['feedback_keywords']);
$smarty->assign('captcha_language',$captcha_language);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('feedback.tpl');
$smarty->display('footer.tpl');
?>

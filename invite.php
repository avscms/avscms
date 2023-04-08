<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/filter.class.php';
require 'classes/validation.class.php';
require 'classes/email.class.php';

$message    = "Hey buddy! " .$config['site_name']. " is a site for sharing and hosting porn videos and it's awesome. You should definitely come and join it!";
$invite     = array('name' => '', 'message' => $message);
$emails     = array('0' => '', '1' => '', '2' => '', '3' => '', '4' => '');

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

if ( isset($_POST['submit_invite']) ) {
    $filter         = new VFilter();
    $valid          = new VValidation();
    $emails         = array();
    $emails[]       = $filter->get('friend_1');
    $emails[]       = $filter->get('friend_2');
    $emails[]       = $filter->get('friend_3');
    $emails[]       = $filter->get('friend_4');
    $emails[]       = $filter->get('friend_5');
    $name           = $filter->get('name');
    $message        = $filter->get('message');

    
    if ( $name == '' ) {
        $errors[]       = $lang['invite.name_empty'];
		$err['name']    = 1;
    } elseif ( mb_strlen($name) >= 100 ) {
        $errors[]       = $lang['invite.name_invalid'];
		$err['name']    = 1;
    } else {
        $invite['name'] = $name;
    }
    
    if ( $message == '' ) {
        $errors[]       = $lang['global.message_empty'];
		$err['message'] = 1;
    } elseif ( strlen($message) > 999 ) {
        $errors[]       = translate($lang['global.message_length'], '999');
		$err['message'] = 1;
    } else {
        $invite['message']  = $message;
    }
    
    if ( $emails[0] == '' && $emails[1] == '' && $emails[2] == '' && $emails[3] == '' && $emails[4] == '' ) {
        $errors[]       = $lang['invite.emails_empty'];
		$err['emails']  = 1;
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
        $valid  = new VValidation();
        $index  = 0;
        foreach ( $emails as $email ) {
            if ( !$valid->email($email) ) {
                $emails[$index] = '';
            }
            ++$index;
        }
        
        if ( !$emails ) {
            $errors[]       = $lang['invite.emails_invalid'];
        }
        
        if ( !$errors ) {
            $sql                = "SELECT email_subject, email_path FROM emailinfo
                                   WHERE email_id = 'invite_friends_email' LIMIT 1";
            $rs                 = $conn->execute($sql);
            $email_subject      = str_replace('{$sender_name}', $name, $rs->fields['email_subject']);
            $email_path         = $rs->fields['email_path'];
            $smarty->assign('message', $message);
            $smarty->assign('sender_name', $name);
            $body               = $smarty->fetch($config['BASE_DIR'].'/templates/'.$email_path);
            $mail               = new VMail();
            $mail->set();
            $mail->Subject      = $email_subject;
            $mail->AltBody      = $body;
            $mail->Body         = nl2br($body);
            foreach ($emails as $email ) {
                $mail->AddAddress($email);
            }
            $mail->Send();
            $messages[]         = $lang['invite.sent'];
        }
    }
}

$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'community');
$smarty->assign('self_title', $seo['invite_title']);
$smarty->assign('self_description', $seo['invite_desc']);
$smarty->assign('self_keywords', $seo['invite_keywords']);
$smarty->assign('invite', $invite);
$smarty->assign('emails', $emails);
$smarty->assign('captcha_language',$captcha_language);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('invite.tpl');
$smarty->display('footer.tpl');
?>

<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_mail']) ) {
    $filter         = new VFilter();
	$mailer			= $filter->get('mailer');
	$sendmail		= $filter->get('sendmail');
	$smtp			= $filter->get('smtp');
    $smtp_auth      = $filter->get('smtp_auth', 'INTEGER');
	$smtp_username	= $filter->get('smtp_username');
	$smtp_password	= $filter->get('smtp_password');
	$smtp_port		= $filter->get('smtp_port', 'INTEGER');
	$smtp_prefix	= $filter->get('smtp_prefix');
	$smtp_autotls	= $filter->get('smtp_autotls');
	$smtp_debug	= $filter->get('smtp_debug');
    
    if ( $mailer != 'mail' && $mailer != 'sendmail' && $mailer != 'smtp' ) {
        $errors[]   = 'Mailer can only be: PHP Mail Function, Sendmail or a SMTP server!';
    }
    
    if ( $mailer == 'sendmail' && $sendmail == '' ) {
        $errors[]   = 'Please enter sendmail path!';
		$err['sendmail'] = 1;
    }
    
    if ( $mailer == 'smtp' ) {
        if ( $smtp == '' ) {
            $errors[]   = 'SMTP server cannot be null!';
			$err['smtp'] = 1;			
        }
        
        if ( $smtp_auth == '1' ) {
            if ( $smtp_username == '' ) {
                $errors[]  = 'SMTP Username field cannot be blank!';
				$err['smtp_username'] = 1;
            }
            
            if ( $smtp_password == '' ) {
                $errors[]   = 'SMTP Password field cannot be blank!';
				$err['smtp_password'] = 1;
            }
        }
    }
    
    if ( !$errors ) {
        $config['mailer']           = $mailer;
        $config['sendmail']         = $sendmail;
        $config['smtp']             = $smtp;
        $config['smtp_auth']        = $smtp_auth;
        $config['smtp_username']    = $smtp_username;
        $config['smtp_password']    = $smtp_password;
        $config['smtp_port']        = $smtp_port;
        $config['smtp_prefix']      = $smtp_prefix;
        $config['smtp_autotls']      = $smtp_autotls;
        $config['smtp_debug']      = $smtp_debug;
        update_config($config);
        update_smarty();
        $messages[] = 'Mail Settings Updated Successfully!';
    }

	$smarty->assign('err', $err);
	$smarty->assign('mailer', $mailer);
	$smarty->assign('sendmail', $sendmail);
	$smarty->assign('smtp', $smtp);
	$smarty->assign('smtp_auth', $smtp_auth);
	$smarty->assign('smtp_username', $smtp_username);
	$smarty->assign('smtp_password', $smtp_password);
	$smarty->assign('smtp_port', $smtp_port);
	$smarty->assign('smtp_prefix', $smtp_prefix);
	$smarty->assign('smtp_autotls', $smtp_autotls);
	$smarty->assign('smtp_debug', $smtp_debug);
}
?>

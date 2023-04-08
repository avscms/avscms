<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/email.class.php';
require $config['BASE_DIR']. '/include/function_editor.php';

$subject    = NULL;
$email      = ( isset($_GET['email']) ) ? trim($_GET['email']) : NULL;
$username   = ( isset($_GET['username']) ) ? trim($_GET['username']) : NULL;
$specific   = ( $email && $username ) ? true : false;
if ( isset($_POST['send_email']) ) {
    $email      = ( isset($_POST['email']) ) ? trim($_POST['email']) : NULL;
    $subject    = trim($_POST['subject']);
    $message    = trim($_POST['email-content']);
    $username   = trim($_POST['username']);
    
    if ( $specific ) {
        if ( $email == '' ) {
            $errors[] = 'Email field cannot be blank!';
			$err['email'] = 1;
		} elseif ( !check_email($email) ) {
            $errors[] = 'Email is not a valid email address!';
			$err['email'] = 1;			
		}
    } else {
        if ( $username == '' ) {
            $errors[] = 'Username field cannot be empty!';
			$err['username'] = 1;
		} else {
            $sql = "SELECT email FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
            $rs  = $conn->execute($sql);
            if ( $conn->Affected_Rows() )
                $email = $rs->fields['email'];
            else {
				$errors[] = 'Username does not exist!';
				$err['username'] = 1;
			}
        }        
    }
    
    if ( $subject == '' ) {
        $errors[] = 'Subject field cannot be empty!';
		$err['subject'] = 1;
	}
    if ( $message == '' ) {
        $errors[] = 'Email message cannot be empty!';
		$err['message'] = 1;
	}
    
    if (!$errors) {
        $mail           = new VMail();
        $mail->set();
        $mail->Subject  = $subject;
        $mail->AltBody  = $message;
        $mail->Body     = wysiwygColorToCSS(nl2br($message));
        $mail->AddAddress($rs->fields['email']);
		$mail->CharSet="UTF-8"; 
        if ( $mail->Send() ) {
            $messages[] = 'Email was successfully sent to <b>' .$username. '</b>!';
        } else {
            $errors[]   = 'Failed to send email! Please check your <a href="index.php?m=mail">Mail Settings</a> and make sure the provided email is valid!';
        }
    }
}

$message   = ( isset($_POST['email-content']) ) ? trim($_POST['email-content']) : NULL;

$smarty->assign('email', $email);
$smarty->assign('username', $username);
$smarty->assign('specific', $specific);
$smarty->assign('subject', $subject);
$smarty->assign('message', $message);
$smarty->assign('editor', true);
?>

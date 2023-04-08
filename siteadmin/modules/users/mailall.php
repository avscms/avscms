<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/email.class.php';
require $config['BASE_DIR']. '/include/function_editor.php';

if ( isset($_SESSION['email_errors']) ) {
    $errors[] = $_SESSION['email_errors'];
    unset($_SESSION['email_errors']);
}

$subject    = NULL;
$message    = NULL;
if ( isset($_POST['email_users']) ) {
    $subject    = trim($_POST['subject']);
    $message    = trim($_POST['email-content']);
    
    if ( $subject == '' ) {
        $errors[] = 'Subject field cannot be empty!';
		$err['subject'] = 1;
	}
    if ( $message == '' ) {
        $errors[] = 'Email message cannot be empty!';
		$err['message'] = 1;
	}
    
    if ( !$errors ) {
        $email_errors   = array();
        $sql            = "SELECT email FROM signup WHERE account_status = 'Active'";
        $rs             = $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            while ( !$rs->EOF ) {
                $mail           = new VMail();
                $mail->set();
                $mail->Subject  = $subject;
                $mail->AltBody  = $message;
				$mail->Body     = wysiwygColorToCSS(nl2br($message));
                $mail->AddAddress($rs->fields['email']);
				$mail->CharSet="UTF-8"; 
                if ( !$mail->Send() ) {
                    $email_errors[] = $rs->fields['email'];
                }
                $mail->ClearAddresses();
                $rs->movenext();
            }
        } else 
            $errors[] = 'There are no users!';
        
        if ( !$errors ) {
            if ( $email_errors )
                $_SESSION['email_errors'] = 'Could not send email to the following addresses: ' .implode(', ', $email_errors). '!';
            else
                $messages[] = 'Email was successfully sent!';
        }
    }
}

$message   = ( isset($_POST['email-content']) ) ? trim($_POST['email-content']) : NULL;

$smarty->assign('subject', $subject);
$smarty->assign('message', $message);
$smarty->assign('editor', true);

?>

<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$emails_path = $config['BASE_DIR']. '/templates/emails';
if ( !file_exists($emails_path) or !is_dir($emails_path) or !is_writable($emails_path) )
    $errors[]= 'Emails directory ' .$emails_path. ' is not writable!';    

$email = array('email_id' => '', 'email_file' => '', 'subject' => '', 'content' => '', 'comment' => '');
if ( isset($_POST['add_email']) ) {
    $email_id   = trim($_POST['email_id']);
    $email_file = trim($_POST['email_file']);
    $subject    = trim($_POST['subject']);
    $content    = trim($_POST['content']);
    $comment    = trim($_POST['comment']);
    
    if ( $email_id == '' ) {
        $errors[]= 'Email Id field cannot be blank!';
		$err['email_id'] = 1;
	}	elseif ( emailExists($email_id) ) {
        $errors[]= 'An email with this email id already exists!';
		$err['email_id'] = 1;
	}	else
        $email['email_id'] = $email_id;
        
    if ( $email_file == '' ) {
        $errors[]= 'Email file field cannot be blank!';
		$err['email_file'] = 1;
	}	elseif ( strtolower(substr($email_file, strrpos($email_file, '.') + 1)) != 'tpl' ) {
        $errors[]= 'Email file must have .tpl as extension!';
		$err['email_file'] = 1;		
	}	elseif ( file_exists($emails_path. '/' .$email_file) ) {
        $errors[]= 'An email with the same file already exists!';
		$err['email_file'] = 1;		
	}
    else
        $email['email_file'] = $email_file;
    
    if ( $subject == '' ) {
        $errors[]= 'Email subject cannot be blank!';
		$err['email_subject'] = 1;
	}	else
        $email['email_subject'] = $subject;
    
    if ( $content == '' ) {
        $errors[]= 'Email content cannot be blank!';
		$err['content'] = 1;		
	}	else
        $email['content'] = $content;
        
    if ( $comment == '' ) {
        $errors[]= 'Email comment field cannot be blank!';
		$err['comment'] = 1;		
	}	else
        $email['comment'] = $comment;
    
    if ( !$errors ) {
        $sql = "INSERT INTO emailinfo (email_id, email_subject, email_path, comment)
                VALUES (" .$conn->qStr($email_id). ", " .$conn->qStr($subject). ",
                        'emails/" .trim($conn->qStr($email_file), "'"). "', " .$conn->qStr($comment). ")";
        $conn->execute($sql);
                                
        $handle = fopen($emails_path. '/' .$email_file, 'w');
		if ( $conn->Affected_Rows() > 0 ) {
			if ( $handle ) {
				fwrite($handle, $content);
				fclose($handle);
				$messages[] = 'Email added successfully!';
			} else
				$errors[]= 'Could not write email file!';
		} else {
			$errors[]= 'MySQL database update failed!';
		}
    }    
}

function emailExists( $email_id )
{
    global $conn;
    
    $sql = "SELECT email_id FROM emailinfo WHERE email_id = " .$conn->qStr($email_id). " LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() > 0 )
        return true;
    
    return false;
}

$smarty->assign('err', $err);
$smarty->assign('email', $email);
$smarty->assign('emails_path', $emails_path);
?>

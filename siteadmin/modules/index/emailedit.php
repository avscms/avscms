<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$email      = array();
$EID        = ( isset($_GET['EID']) && $_GET['EID'] != '' ) ? trim($_GET['EID']) : NULL;
if ( $EID ) {
    if ( isset($_POST['edit_email']) ) {
        $subject    = trim($_POST['subject']);
        $content    = trim($_POST['content']);
        $comment    = trim($_POST['comment']);
        $path       = trim($_POST['email_path']);
        $id       = trim($_POST['email_id']);
        
        if ( $subject == '' ) {
            $errors[] = 'Email subject field cannot be blank!';
			$err['email_subject'] = 1;
		}
		$email[0]['email_subject'] = $subject;

		if ( $content == '' ) {
            $errors[] = 'Email content field cannot be blank!';
			$err['content'] = 1;
		}
        $email[0]['details'] = $content;
		
		if ( $comment == '' ) {
			$errors[]= 'Email comment field cannot be blank!';
			$err['comment'] = 1;		
		}		
		$email[0]['comment'] = $comment;

		$email[0]['email_id'] = $id;
		$email[0]['email_path'] = $path;
		
        if ( !$errors ) {
            $sql = "UPDATE emailinfo SET email_subject = " .$conn->qStr($subject). ",
                                         comment = " .$conn->qStr($comment). "
                    WHERE email_id = " .$conn->qStr($EID). " LIMIT 1";
            $conn->execute($sql);

            $handle = fopen($config['BASE_DIR']. '/templates/' .$path, 'w');
            if ( $handle ) {
                fwrite($handle, $content);
                fclose($handle);
                $messages[] = 'Email was successfully updated!';
            } else
                $errors[] = 'Failed to write email! Please make sure \'' .$config['BASE_DIR']. '/templates/' .$path. '\' has the right permissions!';
        }
    } else {
		$sql                    = "SELECT * FROM emailinfo WHERE email_id = " .$conn->qStr($EID). " LIMIT 1";
		$rs                     = $conn->execute($sql);
		$email                  = $rs->getrows();
		$email['0']['details']  = @file_get_contents($config['BASE_DIR']. '/templates/' .$email['0']['email_path']);
		if ( !$email['0']['details'] )
			$errors[] = 'Could not read email file! Please make sure \'' .$config['BASE_DIR']. '/templates/' .$email['0']['email_path']. '\' has the right permissions!';
	}
} else {
    $errors[] = 'Email id is not set!';
}
$smarty->assign('err', $err);
$smarty->assign('email', $email);
?>

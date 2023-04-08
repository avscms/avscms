<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$comment    = NULL;
$WID        = ( isset($_GET['WID']) && is_numeric($_GET['WID']) ) ? intval(trim($_GET['WID'])) : NULL;
if ( isset($_POST['edit_comment']) ) {
    $comment = trim($_POST['comment']);
    
    if ( $comment == '' ) {
        $errors[] = 'Please enter your comment!';
		$err['comment'] = 1;		
    }
    
    if ( !$errors ) {
        $sql    = "UPDATE wall_comments SET message = " .$conn->qStr($comment). "
                   WHERE WID = " .$WID. " LIMIT 1";
        $conn->execute($sql);
        $messages[]    = 'Comment successfully updated!';
    } else {
		$scomment = $comment;
		$submit = 1;
	}
}

if ( $WID ) {
    $sql    = "SELECT message FROM wall_comments WHERE WID = " .$WID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $comment = $rs->fields['message'];
    } else {
        $errors[] = 'Invalid comment id or not set!?';
    }
	if ($submit) {		
		$comment = $scomment;		
	}	
}

$smarty->assign('err', $err);
$smarty->assign('WID', $WID);
$smarty->assign('comment', $comment);
?>

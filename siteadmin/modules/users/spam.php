<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$remove         = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $action     = trim($_GET['a']);
    $WID        = ( isset($_GET['WID']) && is_numeric($_GET['WID']) ) ? intval(trim($_GET['WID'])) : NULL;
    $SID        = ( isset($_GET['SID']) && is_numeric($_GET['SID']) ) ? intval(trim($_GET['SID'])) : NULL;
    switch ( $action ) {
        case 'delete':
            $sql    = "DELETE FROM wall WHERE wall_id = " .$WID. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $sql    = "DELETE FROM spam WHERE type = 'wall' AND comment_id = " .$WID;
                $conn->execute($sql);
                $messages[] = 'Successfully deleted comment!';
            } else {
                $errors[]   = 'Failed to delete comment! Are you sure this comment exists?!';
            }
			$remove = '&a=delete&WID=' .$WID;
            break;
        case 'unspam':
            $sql    = "DELETE FROM spam WHERE type = 'wall' AND spam_id = " .$SID;
            $conn->execute($sql);
            if ( $conn->Affected_Rows() > 0 ) {
                $messages[] = 'Successfully unspamed this comment!';
            } else {
                $errors[]   = 'Failed to unspam comment! Are you sure this spam flag exists?!';
            }
			$remove = '&a=unspam&SID=' .$SID;
            break;
    }
}

$sql            = "SELECT COUNT(spam_id) AS total_spam FROM spam WHERE type = 'wall'";
$rs             = $conn->execute($sql);
$total_spam     = $rs->fields['total_spam'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($total_spam);
$paging         = $pagination->getAdminPagination($remove);
$sql            = "SELECT s.spam_id, s.UID AS RID, s.addtime AS add_time, w.*, u.username
                   FROM spam AS s,  wall_comments AS w, signup AS u
                   WHERE s.comment_id = w.CID AND w.UID = u.UID
                   LIMIT " .$limit;
$rs             = $conn->execute($sql);
$comments       = $rs->getrows();

$smarty->assign('comments', $comments);
$smarty->assign('total_spam', $total_spam);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>

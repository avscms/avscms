<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$remove         = NULL;
if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $action     = trim($_GET['a']);
    $CID        = ( isset($_GET['CID']) && is_numeric($_GET['CID']) ) ? intval(trim($_GET['CID'])) : NULL;
    $SID        = ( isset($_GET['SID']) && is_numeric($_GET['SID']) ) ? intval(trim($_GET['SID'])) : NULL;
    switch ( $action ) {
        case 'delete':
            $sql    = "DELETE FROM blog_comments WHERE CID = " .$CID. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $sql    = "DELETE FROM spam WHERE type = 'blog' AND comment_id = " .$CID;
                $conn->execute($sql);
                $messages[] = 'Successfully deleted comment!';
            } else {
                $errors[]   = 'Failed to delete comment! Are you sure this comment exists?!';
            }
            break;
        case 'unspam':
            $sql    = "DELETE FROM spam WHERE type = 'blog' AND spam_id = " .$SID;
            $conn->execute($sql);
            if ( $conn->Affected_Rows() > 0 ) {
                $messages[] = 'Successfully unspamed this comment!';
            } else {
                $errors[]   = 'Failed to unspam comment! Are you sure this spam flag exists?!';
            }
            break;
    }
}

$sql            = "SELECT COUNT(spam_id) AS total_spam FROM spam WHERE type = 'blog'";
$rs             = $conn->execute($sql);
$total_spam     = $rs->fields['total_spam'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($total_spam);
$paging         = $pagination->getAdminPagination($remove);
$sql            = "SELECT s.spam_id, s.UID AS RID, s.addtime AS add_time, c.*, u.username
                   FROM spam AS s, blog_comments AS c, signup AS u
                   WHERE s.comment_id = c.CID AND s.parent_id = c.BID AND c.UID = u.UID
                   LIMIT " .$limit;
$rs             = $conn->execute($sql);
$comments       = $rs->getrows();

$smarty->assign('comments', $comments);
$smarty->assign('total_spam', $total_spam);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>

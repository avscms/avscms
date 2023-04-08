<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$remove         = NULL;
$BID            = ( isset($_GET['BID']) && is_numeric($_GET['BID']) && blogExists($_GET['BID']) ) ? intval(trim($_GET['BID'])) : NULL;
if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
    $COMID = ( isset($_GET['COMID']) && is_numeric($_GET['COMID']) ) ? intval(trim($_GET['COMID'])) : NULL;
    if ( $COMID ) {
        $sql    = "UPDATE blog SET total_comments = total_comments-1 WHERE BID = " .$BID. " LIMIT 1";
        $conn->execute($sql);
        $sql    = "DELETE FROM blog_comments WHERE CID = " .$COMID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $messages[] = 'Comment deleted successfully!';
        } else {
            $errors[] = 'Failed to delete comment! Invalid comment id!?';
        }
    } else {
        $errors[] = 'Invalid comment id or not set!';
    }
    $remove = '&a=delete&COMID=' .$COMID;
}

$sql            = "SELECT count(CID) AS total_comments FROM blog_comments WHERE BID = " .$BID;
$rs             = $conn->execute($sql);
$total_comments = $rs->fields['total_comments'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($total_comments);
$paging         = $pagination->getAdminPagination($remove);
$sql            = "SELECT c.*, u.username FROM blog_comments AS c, signup AS u
                   WHERE c.BID = " .$BID. " AND c.UID = u.UID LIMIT " .$limit;
$rs             = $conn->execute($sql);
$comments       = $rs->getrows();

$sql            = "SELECT BID, title FROM blog WHERE BID = " .$BID. " LIMIT 1";
$rs             = $conn->execute($sql);
$blog           = $rs->getrows();
$blog           = $blog['0'];

$smarty->assign('BID', $BID);
$smarty->assign('blog', $blog);
$smarty->assign('comments', $comments);
$smarty->assign('total_comments', $total_comments);
$smarty->assign('paging', $paging);
?>

<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/pagination.class.php';

$remove         = NULL;
$VID            = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? $_GET['VID'] : NULL;
if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
    $COMID = ( isset($_GET['COMID']) && is_numeric($_GET['COMID']) ) ? $_GET['COMID'] : NULL;
    if ( $COMID ) {
        $sql = "DELETE FROM video_comments WHERE CID = " .$conn->qStr($COMID). " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $msg = 'Comment deleted successfully!';
        } else {
            $err = 'Failed to delete comment! Invalid comment id!?';
        }
    } else {
        $err = 'Invalid comment id or not set!';
    }
    $remove = '&a=delete&COMID=' .$COMID;
}

$sql            = sprintf("SELECT count(CID) AS total_comments FROM video_comments WHERE VID = '%d'", $VID);
$rs             = $conn->execute($sql);
$total_comments = $rs->fields['total_comments'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($total_comments);
$paging         = $pagination->getAdminPagination($remove);
$sql            = "SELECT c.*, u.username FROM video_comments AS c, signup AS u
                   WHERE c.VID = " .$VID. " AND c.UID = u.UID LIMIT " .$limit;
$rs             = $conn->execute($sql);
$comments       = $rs->getrows();

$smarty->assign('VID', $VID);
$smarty->assign('comments', $comments);
$smarty->assign('total_comments', $total_comments);
$smarty->assign('paging', $paging);
?>

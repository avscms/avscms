<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/pagination.class.php';

if ( isset($_GET['delete']) ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    $filter     = new VFilter();
    $mail_id    = $filter->get('delete', 'INTEGER', 'GET');
    if ( $mail_id !== 0 ) {
        $sql    = "SELECT mail_id FROM mail 
                   WHERE mail_id = " .$mail_id. " AND sender = " .$conn->qStr($username). " 
                   LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $sql    = "DELETE FROM mail WHERE mail_id = " .$mail_id. " LIMIT 1";
            $conn->execute($sql);
            $messages[] = $lang['mail.delete_msg'];
        } else {
            VRedirect::go($config['BASE_URL']. '/notfound/mail_missing');
        }
    }
}

$sql_count      = "SELECT COUNT(mail_id) AS total_messages FROM mail WHERE sender = " .$conn->qStr($username). "
                  AND outbox = '1' AND status = '1'";
$rsc            = $conn->execute($sql_count);
$total          = $rsc->fields['total_messages'];
$pagination     = new Pagination(50);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT m.*, s.photo, s.gender
                   FROM mail AS m, signup AS s
				   WHERE m.sender = " .$conn->qStr($username). "
                   AND m.outbox = '1'
				   AND m.status = '1'
				   AND m.sender = s.username
				   ORDER BY mail_id DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$mails          = $rs->getrows();
$page_link      = $pagination->getPagination('mail');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$smarty->assign('mails', $mails);
$smarty->assign('total_mails', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('folder', 'outbox');
?>

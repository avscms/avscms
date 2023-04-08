<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/pagination.class.php';

$order          = ( isset($_GET['o']) ) ? $_GET['o'] : 'invite_date';
$orders_allowed = array('invite_date', 'recent_users', 'username', 'recent_logins');
if ( !in_array($order, $orders_allowed) ) {
    $order      = 'invite_date';
}

$sql_add        = NULL;
switch ( $order ) {
    case 'invite_date':
        $sql_add = "f.invite_date";
        break;
    case 'recent_users':
        $sql_add = "u.addtime";
        break;
    case 'recent_logins':
        $sql_add = "u.logintime";
        break;
    case 'username';
        $sql_add = "u.username";
        break;
}

$sql            = "SELECT COUNT(FID) AS total_friends FROM friends WHERE UID = " .$uid. " AND status = 'Confirmed'";
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_friends'];
$pagination     = new Pagination(24);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT f.FID, u.username, u.photo, u.gender FROM friends AS f, signup AS u
                   WHERE f.UID = " .$uid. " AND f.FID = u.UID AND f.status = 'Confirmed'
                   ORDER BY " .$sql_add. " DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$friends        = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/friends');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username. ' - ' .$lang['global.friends'];

$smarty->assign('order', $order);
$smarty->assign('friends', $friends);
$smarty->assign('friends_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

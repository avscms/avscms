<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/pagination.class.php';

$order          = ( isset($_GET['o']) ) ? $_GET['o'] : 'subscribe_date';
$orders_allowed = array('subscribe_date', 'recent_users', 'username', 'recent_logins');
if ( !in_array($order, $orders_allowed) ) {
    $order      = 'invite_date';
}

$sql_add        = NULL;
switch ( $order ) {
    case 'subscribe_date':
        $sql_add = "s.subscribe_date";
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

$sql            = "SELECT COUNT(SUID) AS total_subscriptions FROM video_subscribe WHERE SUID = " .$uid;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_subscriptions'];
$pagination     = new Pagination(24);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT u.UID, u.username, u.photo, u.gender FROM video_subscribe AS s, signup AS u
                   WHERE s.SUID = " .$uid. " AND s.UID = u.UID ORDER BY " .$sql_add. " DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$subscriptions  = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/friends');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username. ' - ' .$lang['user.subscriptions'];

$smarty->assign('order', $order);
$smarty->assign('subscriptions', $subscriptions);
$smarty->assign('subscriptions_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

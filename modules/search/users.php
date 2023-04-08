<?php
defined('_VALID') or die('Restricted Access!');

$page           = ( isset($_GET['page']) && is_numeric($_GET['page']) ) ? intval($_GET['page']) : NULL;
$orders         = array('on', 'mr', 'mv', 'ma', 'mp', 'tr');
$order          = ( isset($_GET['o']) && in_array($_GET['o'], $orders) ) ? $_GET['o'] : 'mr';
$genders        = array('Male', 'Female');
$gender         = ( isset($_GET['g']) && in_array($_GET['g'], $genders) ) ? $_GET['g'] : NULL;
$interests      = array('Guys','Girls', 'Guys+Girls');
$interest       = ( isset($_GET['i']) && in_array($_GET['i'], $interests) ) ? str_replace('+', ' + ', $_GET['i']) : NULL;
$avatar         = ( isset($_GET['a']) && ( $_GET['a'] == 'yes' or $_GET['a'] == 'no' ) ) ? $_GET['a'] : NULL;
$sql_add        = NULL;
$sql_add_count  = NULL;
$title_g        = NULL;
$title_o        = NULL;

if ( $search_query ) {
    $sql_add       .= " AND s.username LIKE '%" .trim($conn->qStr($search_query), "'"). "%'";
    $sql_add_count .= " AND s.username LIKE '%" .trim($conn->qStr($search_query), "'"). "%'";
}

if ( $gender ) {
    $sql_add       .= " AND s.gender = " .$conn->qStr($gender). "";
    $sql_add_count .= " AND s.gender = " .$conn->qStr($gender). "";
}

if ( $interest ) {
    $sql_add       .= " AND s.interested = " .$conn->qStr($interest). "";
    $sql_add_count .= " AND s.interested = " .$conn->qStr($interest). "";
}

if ( $avatar ) {
    $condition      = ( $avatar == 'yes' ) ? ' != \'\'' : ' = \'\'';
    $sql_add       .= " AND s.photo " .$condition;
    $sql_add_count .= " AND s.photo " .$condition;
}

switch ( $order ) {
    case 'mr':
        $sql_add   .= " ORDER BY s.addtime DESC";
        break;
    case 'mv':
        $sql_add   .= " ORDER BY s.profile_viewed DESC";
        break;
    case 'on':
        $sql_add   .= " AND o.online > " .(time()-300);
        $sql_add   .= " ORDER BY logintime DESC";
		$sql_add_count .= " AND o.online > " .(time()-300);
        break;
    case 'ma':
        $sql_add   .= " ORDER BY s.video_viewed+s.profile_viewed+s.watched_video DESC";
        break;
    case 'tr':
        $sql_add   .= " ORDER BY s.rate DESC";
        break;
    case 'mp':
        $sql_add   .= " ORDER BY s.popularity DESC";
        break;		
}

$sql            = "SELECT COUNT(s.UID) AS total_users FROM signup AS s, users_online AS o
                   WHERE s.account_status = 'Active' AND s.UID = o.UID" .$sql_add_count;
$rsc            = $conn->execute($sql);
$total_users    = $rsc->fields['total_users'];
$pagination     = new Pagination($config['users_per_page']);
$limit          = $pagination->getLimit($total_users);
$sql            = "SELECT s.UID, s.username, s.photo, s.gender FROM signup AS s, users_online AS o
                   WHERE s.account_status = 'Active' AND s.UID = o.UID" .$sql_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$users          = $rs->getrows();
$page_link      = $pagination->getPagination('search/users');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$smarty->assign('users', $users);
$smarty->assign('users_total', $total_users);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('order', $order);
$smarty->assign('gender', $gender);
$smarty->assign('interest', $interest);
$smarty->assign('avatar', $avatar);
?>

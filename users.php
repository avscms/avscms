<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';

$page           = ( isset($_GET['page']) && is_numeric($_GET['page']) ) ? intval($_GET['page']) : NULL;
$orders         = array('on', 'mr', 'mv', 'ma', 'tr', 'mp');
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

if ( $gender ) {
    $title_g        = ' ' .$gender;
    $sql_add       .= " AND u.gender = " .$conn->qStr($gender). "";
    $sql_add_count .= " AND u.gender = " .$conn->qStr($gender). "";
}

if ( $interest ) {
    $sql_add       .= " AND u.interested = " .$conn->qStr($interest). "";
    $sql_add_count .= " AND u.interested = " .$conn->qStr($interest). "";
}

if ( $avatar ) {
    $condition      = ( $avatar == 'yes' ) ? ' != \'\'' : ' = \'\'';
    $sql_add       .= " AND u.photo " .$condition;
    $sql_add_count .= " AND u.photo " .$condition;
}

switch ( $order ) {
    case 'mr':
        $title_o    = 'Most Recent';
        $sql_add   .= " ORDER BY u.addtime DESC";
        break;
    case 'mv':
        $title_o    = 'Most Viewed';
        $sql_add   .= " ORDER BY u.profile_viewed DESC";
        break;
    case 'on':
        $title_o    = 'Online';
        $sql_add   .= " AND o.online > " .(time()-300);
        $sql_add   .= " ORDER BY logintime DESC";
        break;
    case 'tr':
        $title_o    = 'Top Rated';
        $sql_add   .= " ORDER BY u.rate DESC";
        break;
    case 'mp':
        $title_o    = 'Most Popular';
        $sql_add   .= " ORDER BY u.popularity DESC";
        break;
    case 'ma':
        $title_o    = 'Most Active';
        $sql_add   .= " ORDER BY u.points DESC";
        break;
}

$sql            = "SELECT COUNT(u.UID) AS total_users FROM signup AS u, users_online AS o
                   WHERE u.account_status = 'Active' AND u.UID = o.UID" .$sql_add;
$rsc            = $conn->execute($sql);
$total_users    = $rsc->fields['total_users'];
$pagination     = new Pagination($config['users_per_page']);
$limit          = $pagination->getLimit($total_users);
$sql            = "SELECT u.UID, u.username, u.photo, u.gender, u.rate FROM signup AS u, users_online AS o
                   WHERE u.account_status = 'Active' AND u.UID = o.UID" .$sql_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$users          = $rs->getrows();
$page_link      = $pagination->getPagination('users');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$title              = $title_o . $title_g;
$self_title         = $title . $seo['users_title'];
$self_description   = $title . $seo['users_desc'];
$self_keywords      = $title . $seo['users_keywords'];

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'community');
$smarty->assign('title', $title);
$smarty->assign('users', $users);
$smarty->assign('users_total', $total_users);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('order', $order);
$smarty->assign('gender', $gender);
$smarty->assign('interest', $interest);
$smarty->assign('avatar', $avatar);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_description', $self_description);
$smarty->assign('self_keywords', $self_keywords);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('users.tpl');
$smarty->display('footer.tpl');
?>

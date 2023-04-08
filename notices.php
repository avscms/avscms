<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'include/function_notice.php';
require 'classes/pagination.class.php';

$sql_add        = NULL;
$sql_add_count  = NULL;
$timestamp      = ( isset($_GET['t']) && is_numeric($_GET['t']) ) ? $_GET['t'] : NULL;
$category       = ( isset($_GET['c']) ) ? intval($_GET['c']) : 0;
if ( $timestamp ) {
    $stamp          = date('Y-m', $timestamp);
    $sql_add        = " AND n.adddate LIKE '%" .$stamp. "%'";
    $sql_add_count  = " AND adddate LIKE '%" .$stamp. "%'";
}

if ( $category ) {
    $sql_add        .= " AND n.category = " .$category;
    $sql_add_count  .= " AND category = " .$category;
}

$sql            = "SELECT COUNT(NID) AS total_notices FROM notice WHERE status = '1'" .$sql_add_count;
$rsc            = $conn->execute($sql);
$total_notices  = $rsc->fields['total_notices'];
$pagination     = new Pagination(5);
$limit          = $pagination->getLimit($total_notices);
$sql            = "SELECT n.NID, n.title, n.content, n.addtime, n.total_views, n.total_comments, s.username, s.photo, s.gender 
                   FROM notice AS n, signup AS s WHERE n.status = '1' AND n.UID = s.UID" .$sql_add. "
                   ORDER BY n.NID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$notices        = $rs->getrows();
$page_link      = $pagination->getPagination('notices');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('notices', $notices);
$smarty->assign('category', $category);
$smarty->assign('timestamp', $timestamp);
$smarty->assign('notices_total', $total_notices);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('arhive', get_notice_arhive());
$smarty->assign('categories', get_notice_categories());
$smarty->assign('self_title', $seo['notices_title']);
$smarty->assign('self_description', $seo['notices_desc']);
$smarty->assign('self_keywords', $seo['notices_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('notices.tpl');
$smarty->display('footer.tpl');
?>

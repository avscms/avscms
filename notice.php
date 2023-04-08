<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'include/function_notice.php';
require 'classes/pagination.class.php';

$NID        = get_request_arg('notice');
if ( !$NID ) {
    VRedirect::go($config['BASE_URL']. '/error');
}

$timestamp      = NULL;
$category       = 0;

$sql            = "SELECT n.*, s.username, s.photo, s.gender 
                   FROM notice AS n, signup AS s WHERE status ='1' AND n.UID = s.UID AND n.NID = " .$NID. " LIMIT 1";
$rs             = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/invalid_notice');
}
$notice         = $rs->getrows();
$notice         = $notice['0'];

$sql            = "UPDATE notice SET total_views = total_views+1 WHERE NID = " .$NID. " LIMIT 1";
$conn->execute($sql);

$sql            = "SELECT COUNT(CID) AS total_comments FROM notice_comments WHERE NID = " .$NID. " AND status = '1'";
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_comments'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT c.*, s.username, s.photo, s.gender
                   FROM notice_comments AS c, signup AS s 
                   WHERE c.NID = " .$NID. " AND c.status = '1' AND c.UID = s.UID
                   ORDER BY c.addtime DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$comments       = $rs->getrows();
$page_link      = $pagination->getPagination('notice/' .$NID, 'p_notice_comments_' .$NID. '_');
$page_link_b    = $pagination->getPagination('notice/' .$NID, 'pp_notice_comments_' .$NID. '_');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('notice_js', true);
$smarty->assign('notice', $notice);
$smarty->assign('comments', $comments);
$smarty->assign('comments_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('page_link_b', $page_link_b);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('arhive', get_notice_arhive());
$smarty->assign('category', $category);
$smarty->assign('timestamp', $timestamp);
$smarty->assign('categories', get_notice_categories());
$smarty->assign('self_title', $seo['notice_title']);
$smarty->assign('self_description', $seo['notice_desc']);
$smarty->assign('self_keywords', $seo['notice_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('notice.tpl');
$smarty->display('footer.tpl');
?>

<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';

if ( $config['blog_module'] == '0' ) {
        VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$orders_allowed     = array('mr', 'mv', 'md');
$order              = ( isset($_GET['o']) && in_array($_GET['o'], $orders_allowed) ) ? $_GET['o'] : 'mr';
$timeframes_allowed = array('t', 'w', 'm', 'a');
$timeframe          = ( isset($_GET['t']) && in_array($_GET['t'], $timeframes_allowed) ) ? $_GET['t'] : 'a';
$sql_add            = NULL;
$sql_add_count      = NULL;
$title_t            = NULL;
$title_o            = NULL;

switch ( $timeframe ) {
    case 't':
        $title_t         = $lang['global.todays'];
        $sql_add        .= " AND DATE_FORMAT(b.adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        break;
    case 'w':
        $title_t         = $lang['global.this_weeks'];
        $sql_add        .= " AND DATE_FORMAT(b.adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        break;
    case 'm':
        $title_t         = $lang['global.this_months'];
        $sql_add        .= " AND DATE_FORMAT(b.adddate, '%y') = DATE_FORMAT(NOW(), '%y')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y') = DATE_FORMAT(NOW(), '%y')";
        break;
}

switch ( $order ) {
    case 'mr':
        $title_o        = ' '.$lang['global.most_recent'];
        $sql_add       .= " ORDER BY b.addtime DESC";
        break;
    case 'mv':
        $title_o        = ' '.$lang['global.most_viewed'];
        $sql_add       .= " ORDER BY b.total_views DESC";
        break;
    case 'md':
        $title_o        = ' '.$lang['global.most_commented'];
        $sql_add       .= " ORDER BY b.total_comments DESC";
        break;
}

$sql            = "SELECT COUNT(BID) AS total_blogs FROM blog WHERE status = '1'" .$sql_add_count;
$rsc            = $conn->execute($sql);
$total_blogs    = $rsc->fields['total_blogs'];
$pagination     = new Pagination($config['blogs_per_page']);
$limit          = $pagination->getLimit($total_blogs);
$sql            = "SELECT b.BID, b.UID, b.title, b.content, b.total_views, b.total_comments, b.addtime,
                          s.username, s.photo, s.gender
                   FROM blog AS b, signup AS s
                   WHERE b.status = '1' AND b.UID = s.UID" .$sql_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$blogs          = $rs->getrows();

foreach($blogs as $key => $content) {
	$blogs[$key]['content'] = blog_output($blogs[$key]['content']);
}

$page_link      = $pagination->getPagination('blogs');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$title              = $title_t . $title_o;
$self_title         = $title . $seo['blogs_title'];
$self_description   = $title . $seo['blogs_desc'];
$self_keywords      = $title . $seo['blogs_keywords'];

$smarty->assign('menu', 'blogs');
$smarty->assign('blogs', $blogs);
$smarty->assign('blogs_total', $total_blogs);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('order', $order);
$smarty->assign('timeframe', $timeframe);
$smarty->assign('title', $title);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_description', $self_description);
$smarty->assign('self_keywords', $self_keywords);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('blogs.tpl');
$smarty->display('footer.tpl');
?>

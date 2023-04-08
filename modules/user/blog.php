<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

if ( $config['blog_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$sql            = "SELECT COUNT(BID) AS total_blogs FROM blog WHERE status = '1' AND UID = " .$uid;
$rs             = $conn->execute($sql);
$total          = $rs->fields['total_blogs'];
$pagination     = new Pagination(5);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT BID, title, content, total_views, total_comments, addtime FROM blog
                   WHERE status = '1' AND UID = " .$uid. " ORDER BY addtime DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$blogs          = $rs->getrows();

foreach($blogs as $key => $content) {
	$blogs[$key]['content'] = blog_output($blogs[$key]['content']);
}

$page_link      = $pagination->getPagination('user/' .$username. '/blog');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username. '\'s Blog';

$smarty->assign('blogs', $blogs);
$smarty->assign('blogs_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

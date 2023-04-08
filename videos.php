<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';

$slug = get_request_arg('videos', 'STRING');
if ($slug != '') {
	$sql            = "SELECT CHID FROM channel WHERE slug = '".$slug."' LIMIT 1";
	$rs             = $conn->execute($sql);
	if ($conn->Affected_Rows()) {
		$cat_id         = $rs->fields['CHID'];
	}
} else {
	$cat_id = NULL;
}

$type	= ( $config['show_private_videos'] == '0' ) ? 'public' : NULL;
$type    = ( isset($_GET['type']) && ($_GET['type'] == 'private' or $_GET['type'] == 'public' or $_GET['type'] == 'featured') ) ? $_GET['type'] : $type;
$quality = ( isset($_GET['q']) && ($_GET['q'] == 'all' or $_GET['q'] == 'hd' ) ) ? $_GET['q'] : $quality;

if ($cat_id) {
	$category  = $cat_id;
} else {
	$category       = ( isset($_GET['c']) ) ? intval($_GET['c']) : 0;
}
$categories     = get_categories();
$orders         = array('bw', 'mr', 'mv', 'tr', 'md', 'tf', 'lg');
$order          = ( isset($_GET['o']) && in_array($_GET['o'], $orders) ) ? $_GET['o'] : 'mr';
$timeframes     = array('t', 'w', 'm', 'a');
$timeframe      = ( isset($_GET['t']) && in_array($_GET['t'], $timeframes) ) ? $_GET['t'] : 'a';

$sql_add        = NULL;
$sql_add_count  = NULL;
$sql_delim      = ' WHERE ';
$title_t        = NULL;
$title_c        = NULL;
$title_o        = NULL;
$title_p        = NULL;

if ( $type != '' ) {
    $title_p        = ' '.ucfirst(($type == 'private') ? $lang['global.private'] : $lang['global.public']);
    $sql_add        = $sql_delim. " type = '" .$type. "'";
    $sql_add_count  = $sql_delim. " type = '" .$type. "'";
    $sql_delim      = ' AND';
}

if ( $type == 'featured' ) {
	$title_p        =  ' '.$lang['global.featured'];
	$sql_delim      = ' WHERE ';	
    $sql_add        = $sql_delim. " featured = 'yes'";
    $sql_add_count  = $sql_delim. " featured = 'yes'";
    $sql_delim      = ' AND';	
}

if ( $quality == 'hd' ) {	
    $sql_add        .= $sql_delim. " hd = '1'";
    $sql_add_count  .= $sql_delim. " hd = '1'";
    $sql_delim      = ' AND';	
}

switch ( $timeframe ) {
    case 't':
        $title_t         = $lang['global.todays'];
        $sql_add        .= $sql_delim. " DATE_FORMAT(adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        $sql_add_count  .= $sql_delim. " DATE_FORMAT(adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        $sql_delim       = ' AND';
        break;
    case 'w':
        $title_t         = $lang['global.this_weeks'];
        $sql_add        .= $sql_delim. " DATE_FORMAT(adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        $sql_add_count  .= $sql_delim. " DATE_FORMAT(adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        $sql_delim       = ' AND';
        break;
    case 'm':
        $title_t         = $lang['global.this_months'];
        $sql_add        .= $sql_delim. " DATE_FORMAT(adddate, '%m') = DATE_FORMAT(NOW(), '%m')";
        $sql_add_count  .= $sql_delim. " DATE_FORMAT(adddate, '%m') = DATE_FORMAT(NOW(), '%m')";
        $sql_delim       = ' AND';
        break;
}

if ( $category ) {
    $sql_add        .= $sql_delim. " channel = " .$category;
    $sql_add_count  .= $sql_delim. " channel = " .$category;
    $sql_delim       = ' AND';
    foreach ( $categories as $categ ) {
        if ( $categ['CHID'] == $category ) {
            $title_c = ' ' .$categ['name'];
            break;
        }
    }
}

$sql_add       .= $sql_delim . " active = '1'";
$sql_add_count .= $sql_delim . " active = '1'";

switch ( $order ) {
    case 'bw':
        $title_o  = ' '.$lang['global.being_watched'];
        $sql_add .= ' ORDER BY viewtime DESC';
        break;
    case 'mr':
        $title_o  = ' '.$lang['global.most_recent'];
        $sql_add .= ' ORDER BY addtime DESC';
        break;
    case 'mv':
        $title_o  = ' '.$lang['global.most_viewed'];
        $sql_add .= ' ORDER BY viewnumber DESC';
        break;
    case 'tr':
        $title_o  = ' '.$lang['global.top_rated'];
        $sql_add .= ' ORDER BY rate DESC';
        break;
    case 'md':
        $title_o  = ' '.$lang['global.most_commented'];
        $sql_add .= ' ORDER BY com_num DESC';
        break;
    case 'tf':
        $title_o  = ' '.$lang['global.top_favorites'];
        $sql_add .= ' ORDER BY fav_num DESC';
        break;
    case 'lg':
		$title_o  = ' '.$lang['global.longest'];
        $sql_add .= ' ORDER BY duration DESC';
        break;		
}

$sql            = "SELECT count(VID) AS total_videos FROM video" .$sql_add_count;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_videos'];
$pagination     = new Pagination($config['videos_per_page']);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM video" .$sql_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();

if ($slug) {
	$page_link      = $pagination->getPagination('videos/'.$slug);	
	$smarty->assign('base', 'videos/'.$slug);
} else {
	$page_link      = $pagination->getPagination('videos');
	$smarty->assign('base', 'videos');	
}

$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$title              = $title_t . $title_o . $title_c . $title_p;
$self_title         = $title . $seo['videos_title'];
$self_description   = $title . $seo['videos_desc'];
$self_keywords      = $title . $seo['videos_keywords'];

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'videos');
$smarty->assign('categories', $categories);
$smarty->assign('type', $type);
$smarty->assign('videos', $videos);
$smarty->assign('videos_total', $total);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_link', $page_link);
$smarty->assign('category', $category);
$smarty->assign('quality', $quality);
$smarty->assign('timeframe', $timeframe);
$smarty->assign('order', $order);
$smarty->assign('title', $title);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_description', $self_description);
$smarty->assign('self_keywords', $self_keywords);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('videos.tpl');
$smarty->display('footer.tpl');
?>

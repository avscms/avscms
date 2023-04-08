<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';

$slug = get_request_arg('albums', 'STRING');
if ($slug != '') {
	$sql            = "SELECT CID FROM album_categories WHERE slug = '".$slug."' LIMIT 1";
	$rs             = $conn->execute($sql);
	if ($conn->Affected_Rows()) {
		$cat_id         = $rs->fields['CID'];
	}
} else {
	$cat_id = NULL;
}

if ( $config['photo_module'] == '0' ) {
        VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$type			= ( $config['show_private_albums'] == '0' ) ? 'public' : NULL;
$type           = ( isset($_GET['type']) && ( $_GET['type'] == 'public' or $_GET['type'] == 'private' ) ) ? $_GET['type'] : $type;
if ($cat_id) {
	$category  = $cat_id;
} else {
	$category       = ( isset($_GET['c']) ) ? intval($_GET['c']) : 0;
}
$categories     = get_albums_categories();
$orders         = array('mr', 'mv', 'mp', 'tr', 'md', 'tf');
$order          = ( isset($_GET['o']) && in_array($_GET['o'], $orders) ) ? $_GET['o'] : 'mr';
$timeframes     = array('t', 'w', 'm', 'a');
$timeframe      = ( isset($_GET['t']) && in_array($_GET['t'], $timeframes) ) ? $_GET['t'] : 'a';

$sql_add        = NULL;
$sql_add_count  = NULL;
$title_t        = NULL;
$title_c        = NULL;
$title_o        = NULL;
$title_p        = NULL;

if ( $category ) {
    $sql_add        .= " AND a.category = " .$conn->qStr($category). "";
    $sql_add_count  .= " AND category = " .$conn->qStr($category). "";
    foreach ( $categories as $categ ) {
        if ( $categ['CID'] == $category ) {
            $title_c = ' ' .$categ['name'];
            break;
        }
    }                                                
}

switch ( $timeframe ) {
    case 't':
        $title_t         = $lang['global.todays'];
        $sql_add        .= " AND DATE_FORMAT(a.adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        break;
    case 'w':
        $title_t         = $lang['global.this_weeks'];
        $sql_add        .= " AND DATE_FORMAT(a.adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        break;
    case 'm':
        $title_t         = $lang['global.this_months'];
        $sql_add        .= " AND DATE_FORMAT(a.adddate, '%y') = DATE_FORMAT(NOW(), '%y')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y') = DATE_FORMAT(NOW(), '%y')";
        break;
}

if ( $type != '' ) {
    $title_p        = ' '.ucfirst(($type == 'private') ? $lang['global.private'] : $lang['global.public']);
    $sql_add        .= " AND a.type = '" .$type. "'";
    $sql_add_count  .= " AND type = '" .$type. "'";
}

switch ( $order ) {
    case 'mr':
        $title_o  = ' '.$lang['global.most_recent'];
        $sql_add .= ' ORDER BY a.addtime DESC';
        break;
    case 'mv':
        $title_o  = ' '.$lang['global.most_viewed'];
        $sql_add .= ' ORDER BY a.total_views DESC';
        break;
    case 'mp':
        $title_o  = ' '.$lang['album.most_photos'];
        $sql_add .= ' ORDER BY a.total_photos DESC';
        break;
    case 'md':
        $title_o  = ' '.$lang['global.most_commented'];
        $sql_add .= ' ORDER BY a.total_comments DESC';
        break;
    case 'tr':
        $title_o  = ' '.$lang['global.top_rated'];
        $sql_add .= ' ORDER BY a.rate DESC';
        break;
    case 'tf':
        $title_o  = ' '.$lang['global.top_favorites'];
        $sql_add .= ' ORDER BY a.total_favorites DESC';
        break;
}

$sql            = "SELECT COUNT(AID) AS total_albums FROM albums WHERE status = '1'" .$sql_add_count;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_albums'];
$pagination     = new Pagination($config['albums_per_page']);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT a.*, s.username FROM albums AS a, signup AS s WHERE a.status = '1' AND a.UID = s.UID" .$sql_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$albums         = $rs->getrows();

if ($slug) {
	$page_link      = $pagination->getPagination('albums/'.$slug);	
	$smarty->assign('base', 'albums/'.$slug);
} else {
	$page_link      = $pagination->getPagination('albums');
	$smarty->assign('base', 'albums');	
}

$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$title              = $title_t . $title_o . $title_c . $title_p;
$self_title         = $title . $seo['albums_title'];
$self_description   = $title. ' '.$lang['global.albums'].' - ' .$config['site_name'];
$self_keywords      = $title. ' '.$lang['global.albums'].' '.$config['meta_keywords'];

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'albums');
$smarty->assign('submenu', '');
$smarty->assign('category', $category);
$smarty->assign('timeframe', $timeframe);
$smarty->assign('order', $order);
$smarty->assign('type', $type);
$smarty->assign('albums_total', $total);
$smarty->assign('albums', $albums);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('categories', $categories);
$smarty->assign('title', $title);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_description', $self_description);
$smarty->assign('self_keywords', $self_keywords);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('albums.tpl');
$smarty->display('footer.tpl');
?>

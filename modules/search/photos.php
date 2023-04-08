<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['photo_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$slug = get_request_arg($search_query, 'STRING');
if ($slug != '') {
	$sql            = "SELECT CID FROM album_categories WHERE slug = '".$slug."' LIMIT 1";
	$rs             = $conn->execute($sql);
	if ($conn->Affected_Rows()) {
		$cat_id         = $rs->fields['CID'];
	}
} else {
	$cat_id = NULL;
}

if ($cat_id) {
	$category  = $cat_id;
} else {
	$category       = ( isset($_GET['c']) ) ? intval($_GET['c']) : 0;
}

$orders         = array('mr', 'mv', 'mp', 'tr', 'md', 'tf');
$order          = ( isset($_GET['o']) && in_array($_GET['o'], $orders) ) ? $_GET['o'] : 'mr';
$timeframes     = array('t', 'w', 'm', 'a');
$timeframe      = ( isset($_GET['t']) && in_array($_GET['t'], $timeframes) ) ? $_GET['t'] : 'a';
$rating         = ( isset($_GET['r']) ) ? floatval($_GET['r']) : NULL;
$type           = ( isset($_GET['type']) && ( $_GET['type'] == 'public' or $_GET['type'] == 'private' ) ) ? $_GET['type'] : NULL;
$sql_add        = NULL;
$sql_add_count  = NULL;

if ( $type ) {
    $sql_add        .= " AND a.type = '" .$type. "'";
    $sql_add_count  .= " AND type = '" .$type. "'";
}

if ( $category ) {
    $sql_add        .= " AND a.category = " .$category;
    $sql_add_count  .= " AND category = " .$category;
}

if ( $rating ) {
    $sql_add        .= " AND a.rate >= " .$rating;
    $sql_add_count  .= " AND rate >= " .$rating;
}

switch ( $timeframe ) {
    case 't':
        $sql_add        .= " AND DATE_FORMAT(a.adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        break;
    case 'w':
        $sql_add        .= " AND DATE_FORMAT(a.adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        break;
    case 'm':
        $sql_add        .= " AND DATE_FORMAT(a.adddate, '%y') = DATE_FORMAT(NOW(), '%y')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y') = DATE_FORMAT(NOW(), '%y')";
        break;
}

if ( $search_query ) {
    $sql_add        .= " AND ( name LIKE '%" .trim($conn->qStr($search_query), "'"). "%' OR tags LIKE '%" .trim($conn->qStr($search_query), "'"). "%' )";
    $sql_add_count  .= " AND ( name LIKE '%" .trim($conn->qStr($search_query), "'"). "%' OR tags LIKE '%" .trim($conn->qStr($search_query), "'"). "%' )";
}

switch ( $order ) {
    case 'mp':
        $sql_add .= " ORDER BY a.total_photos DESC";
        break;
    case 'mr':
        $sql_add .= " ORDER BY a.addtime DESC";
        break;
    case 'mv':
        $sql_add .= " ORDER BY a.total_views DESC";
        break;
    case 'tr':
        $sql_add .= " ORDER BY a.rate DESC";
        break;
    case 'md':
        $sql_add .= " ORDER BY a.total_comments DESC";
        break;
    case 'tf':
        $sql_add .= " ORDER BY a.total_favorites DESC";
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
	$page_link      = $pagination->getPagination('search/photos/'.$slug);
	$smarty->assign('base', 'search/photos/'.$slug);	
} else {
	$page_link      = $pagination->getPagination('search/photos');
	$smarty->assign('base', 'search/photos');		
}

$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();
$smarty->assign('category', $category);
$smarty->assign('categories', get_albums_categories());
$smarty->assign('timeframe', $timeframe);
$smarty->assign('order', $order);
$smarty->assign('type', $type);
$smarty->assign('rating', $rating);
$smarty->assign('albums', $albums);
$smarty->assign('albums_total', $total);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_link', $page_link);
?>

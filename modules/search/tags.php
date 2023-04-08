<?php
defined('_VALID') or die('Restricted Access!');

//$conn->debug = true;

if ( $config['video_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$slug = get_request_arg($search_query, 'STRING');


$orders         = array('bw', 'mr', 'mv', 'tr', 'md', 'tf', 'lg');
$order          = ( isset($_GET['o']) && in_array($_GET['o'], $orders) ) ? $_GET['o'] : 'mr';
$timeframes     = array('t', 'w', 'm', 'a');
$timeframe      = ( isset($_GET['t']) && in_array($_GET['t'], $timeframes) ) ? $_GET['t'] : 'a';
$rating         = ( isset($_GET['r']) ) ? floatval($_GET['r']) : NULL;
$min_length     = ( isset($_GET['min_length']) && is_numeric($_GET['min_length']) ) ? intval($_GET['min_length']) : NULL;
$max_length     = ( isset($_GET['max_length']) && is_numeric($_GET['max_length']) ) ? intval($_GET['max_length']) : NULL;
$type    		= ( isset($_GET['type']) && ($_GET['type'] == 'private' or $_GET['type'] == 'public' or $_GET['type'] == 'featured') ) ? $_GET['type'] : $type;
$quality 		= ( isset($_GET['q']) && ($_GET['q'] == 'all' or $_GET['q'] == 'hd' ) ) ? $_GET['q'] : $quality;
$sql_add        = NULL;
$sql_add_count  = NULL;

if ( $type == 'featured' ) {
    $sql_add        .= " AND featured = 'yes'";
    $sql_add_count  .= " AND featured = 'yes'";
} elseif ( $type ) {
    $sql_add        .= " AND type = '" .$type. "'";
    $sql_add_count  .= " AND type = '" .$type. "'";
}

if ( $quality == 'hd' ) {
    $sql_add        = " AND hd = '1'";
    $sql_add_count  = " AND hd = '1'";
}


if ( $rating ) {
    $sql_add        .= " AND rate >= " .$rating;
    $sql_add_count  .= " AND rate >= " .$rating;
}

if ( $min_length ) {
    $min_length_s       = ( $min_length == '1' ) ? 3600 : $min_length*60;
    $sql_add           .= " AND duration > " .$min_length_s;
    $sql_add_count     .= " AND duration > " .$min_length_s;
}

if ( $max_length ) {
    $max_length_s       = ( $max_length == '1' ) ? 3600 : $max_length*60;
    $sql_add           .= " AND duration < " .$max_length_s;
    $sql_add_count     .= " AND duration < " .$max_length_s;
}

switch ( $timeframe ) {
    case 't':
        $sql_add        .= " AND DATE_FORMAT(adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y-%m-%d') = DATE_FORMAT(NOW(), '%y-%m-%d')";
        break;
    case 'w':
        $sql_add        .= " AND DATE_FORMAT(adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y-%u') = DATE_FORMAT(NOW(), '%y-%u')";
        break;
    case 'm':
        $sql_add        .= " AND DATE_FORMAT(adddate, '%y') = DATE_FORMAT(NOW(), '%y')";
        $sql_add_count  .= " AND DATE_FORMAT(adddate, '%y') = DATE_FORMAT(NOW(), '%y')";
        break;
}

if ( $search_query ) {	

    $sql_add        .= " AND (keyword REGEXP \"(^|, )".$search_query_f."(,|$)\")";
    $sql_add_count  .= " AND (keyword REGEXP \"(^|, )".$search_query_f."(,|$)\")";  

    
}

switch ( $order ) {
    case 'br':
        $sql_add .= " ORDER BY viewtime DESC";
        break;
    case 'mr':
        $sql_add .= " ORDER BY addtime DESC";
        break;
    case 'mv':
        $sql_add .= " ORDER BY viewnumber DESC";
        break;
    case 'tr':
        $sql_add .= " ORDER BY (ratedby*rate) DESC";
        break;
    case 'md':
        $sql_add .= " ORDER BY com_num DESC";
        break;
    case 'tf':
        $sql_add .= " ORDER BY fav_num DESC";
        break;		
    case 'lg':
        $sql_add .= " ORDER BY duration DESC";
        break;
}

$sql            = "SELECT count(VID) AS total_videos FROM video WHERE active = '1'". $sql_add_count;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_videos'];
$pagination     = new Pagination($config['videos_per_page']);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM video WHERE active = '1'". $sql_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();

if ($slug) {
	$page_link      = $pagination->getPagination('search/tags/'.$search_query.'/'.$slug);
	$smarty->assign('base', 'search/tags/'.$search_query.'/'.$slug);	
} else {
	$page_link      = $pagination->getPagination('search/tags/'.$search_query);
	$smarty->assign('base', 'search/tags/'.$search_query);		
}

$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();



$smarty->assign('category', $category);
$smarty->assign('categories', get_categories());
$smarty->assign('timeframe', $timeframe);
$smarty->assign('type', $type);
$smarty->assign('quality', $quality);
$smarty->assign('order', $order);
$smarty->assign('min_length', $min_length);
$smarty->assign('max_length', $max_length);
$smarty->assign('rating', $rating);
$smarty->assign('videos', $videos);
$smarty->assign('videos_total', $total);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_link', $page_link);
?>

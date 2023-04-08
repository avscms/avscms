<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require_once ($config['BASE_DIR']. '/include/function_thumbs.php');

$data   = array('status' => 0, 'videos' => '', 'page' => 0, 'pages' => 0, 'move' => '', 'debug' => '');
if ( isset($_POST['video_id']) && isset($_POST['move']) && isset($_POST['page']) ) {
    $filter         = new VFilter();
    $vid            = $filter->get('video_id', 'INTEGER');
    $page           = $filter->get('page', 'INTEGER');
    $move           = ( $_POST['move'] == 'next' ) ? 'next' : 'prev';
    if ( $move == 'prev' ) {
        $page   = ( $page < 1 ) ? 1: $page-1;
		$data['move']  = 'prev';
    } else {
        $page   = $page+1;
		$data['move']  = 'next';
    }
    
    $sql            = "SELECT title, channel, keyword, type FROM video WHERE VID = " .$vid. " LIMIT 1";
    $rs             = $conn->execute($sql);
    $video          = $rs->getrows();
    $video          = $video['0'];
    
    $sql_add        = NULL;
    if ( $video['keyword'] ) {
        $keywords   = explode(' ', $video['keyword']);
        $sql_add   .= " OR (";
        $sql_or     = NULL;
        foreach ( $keywords as $keyword ) {
            $sql_add .= $sql_or. " keyword LIKE '%" .trim($conn->qStr($keyword), "'"). "%'";
            $sql_or   = " OR ";
        }
        $sql_add   .= ")";
    }
    
	$type			= ($config['show_private_videos'] == '1') ? '' : " AND type = 'public'";
    $sql            = "SELECT COUNT(VID) AS total_videos FROM video WHERE channel = '" .$video['channel']. "' AND VID != " .$vid. "
					   AND active = '1'" .$type. "
                       AND ( title LIKE '%" .trim($conn->qStr($video['title']), "'"). "%' " .$sql_add. ")";
    $rs             = $conn->execute($sql);
    $total          = $rs->fields['total_videos'];
    if ( $total > 80 ) {
	$total = 80;
    }
    $total          = ( $total > 80 ) ? 80 : $total;
    $pagination     = new Pagination(8, $page);
    $limit          = $pagination->getLimit($total);
    $sql            = "SELECT VID, title, duration, addtime, rate, likes, dislikes, viewnumber, type, thumb, thumbs, hd
	                   FROM video 
                       WHERE channel = '" .intval($video['channel']). "' AND VID != " .$vid. "
					   AND active = '1'" .$type. "
                       AND ( title LIKE '%" .trim($conn->qStr($video['title']), "'"). "%' " .$sql_add. ")
                       ORDER BY addtime DESC LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $videos         = $rs->getrows();
    $code           = array();
    $total_pages    = $pagination->getTotalPages();
    $page           = ( $page >= $total_pages ) ? $total_pages : $page;

    $code[]     = '<div class="row">';	
    foreach ( $videos as $video ) {
		if ($video['type'] == 'private') {
			$img_class = 'class="img-responsive img-private"';
		}
		else {
			$img_class = 'class="img-responsive"';
		}
        $code[]     = '<div class="col-sm-6 col-md-3 col-lg-3">';
        $code[]     = '<div class="well well-sm m-b-0 m-t-20">';
        $code[]     = '<a href="' .$config['BASE_URL']. '/video/' .$video['VID']. '/' .prepare_string($video['title']). '">';		
        $code[]     = '<div class="thumb-overlay">';
		$code[]     = '<img src="' .get_thumb_url($video['VID']). '/'.$video['thumb'].'.jpg" title="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" alt="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" id="rotate_' .$video['VID']. '_'.$video['thumbs'].'_'.$video['thumb'].'" '.$img_class.' />';
		if ($video['type'] == 'private') {		
			$code[]     = '<div class="label-private">' .$lang['global.PRIVATE']. '</div>';
		}
		if ($video['hd'] == 1) {		
			$code[]     = '<div class="hd-text-icon">HD</div>';
		}		
        $code[]     = '<div class="duration">';
        $code[]     = duration($video['duration']);
        $code[]     = '</div>';
        $code[]     = '</div>';
        $code[]     = '<span class="video-title title-truncate m-t-5">' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '</span>';
        $code[]     = '</a>';
        $code[]     = '<div class="video-added">';
        $code[]     = time_range($video['addtime']);;
        $code[]     = '</div>';
        $code[]     = '<div class="video-views pull-left">';
		$views      = ($video['viewnumber'] == '1') ? $lang['global.view'] : $lang['global.views'];
        $code[]     = $video['viewnumber']. ' '.$views;
        $code[]     = '</div>';
		if ($video['rate'] == 0 && $video[dislikes] == 0) {
			$rate_class = 'no-rating"';
			$rate_icon  = '<i class="fa fa-heart video-rating-heart no-rating"></i> <b>-</b>';
			}
		else {
			$rate_class = '';
			$rate_icon  = '<i class="fa fa-heart video-rating-heart"></i> <b>' .$video['rate']. '%</b>';
		}
        $code[]     = '<div class="video-rating pull-right ' .$rate_class. '">';
        $code[]     = $rate_icon;
        $code[]     = '</div>';
        $code[]     = '<div class="clearfix"></div>';
        $code[]     = '</div>';
        $code[]     = '</div>';
    }
    $code[]     = '</div>';		
    $code[]     = '<div id="related_videos_container_' .$page. '"></div>';
	
	
    $data['page']   = $page;
    $data['status'] = ( $total_pages > 1 ) ? 1 : 0;
    $data['videos'] = implode("\n", $code);
    $data['pages']  = $total_pages;
}

echo json_encode($data);
die();
?>

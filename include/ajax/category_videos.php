<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'videos' => '', 'page' => 0, 'pages' => 0);
if ( isset($_POST['category_id']) && isset($_POST['move']) && isset($_POST['page']) ) {
    $filter         = new VFilter();
    $category       = $filter->get('category_id', 'INTEGER');
    $page           = $filter->get('page', 'INTEGER');
    $move           = ( $_POST['move'] == 'next' ) ? 'next' : 'prev';
    if ( $move == 'prev' ) {
        $page   = ( $page < 1 ) ? 1: $page-1;
    } else {
        $page   = $page+1;
    }
    
	$type           = ($config['show_private_videos'] == '1') ? '' : " AND type = 'public'";
    $approve        = ( $config['approve'] == '1' ) ? " AND active = '1'" : NULL;
    $sql            = "SELECT COUNT(VID) AS total_category_videos FROM video
                       WHERE channel = " .$category. " AND active = '1'" .$type;
    $rsc            = $conn->execute($sql);
    $total          = $rsc->fields['total_category_videos'];
    $pagination     = new Pagination(2, $page);
    $limit          = $pagination->getLimit($total);
    $sql            = "SELECT VID, title, duration, addtime, rate, viewnumber, type, thumb, thumbs
					   FROM video
                       WHERE active = '1' AND channel = " .$category . $type. "
                       ORDER BY addtime DESC LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $videos         = $rs->getrows();
    $code           = array();
    $total_pages    = $pagination->getTotalPages();
    $page           = ( $page >= $total_pages ) ? $total_pages : $page;
	$private_img	= '<img alt="" style="position: absolute; left: 0px; top: +0px; width: 160px; height: 120px;" src="'.$config['BASE_URL']. '/templates/frontend/' .$config['template']. '/images/'.private_photo('video').'" />';
    foreach ( $videos as $video ) {
        $code[]     = '<div class="video_c_box">';
        $code[]     = '<a href="' .$config['BASE_URL']. '/video/' .$video['VID']. '/' .prepare_string($video['title']). '">';
        $code[]     = '<img src="' .$config['BASE_URL']. '/media/videos/tmb/' .$video['VID']. '/'.$video['thumb'].'.jpg" title="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" alt="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" width="160" height="120" id="rotate_' .$video['VID']. '_'.$video['thumbs'].'_'.$video['thumb'].'" /><br />';
		if ($video['type'] == 'private') {
			$code[]		= $private_img;
		}
        $code[]     = '<span class="font-13 font-bold">' .htmlspecialchars(truncate($video['title'], 23), ENT_QUOTES, 'UTF-8'). '</span><br />';
        $code[]     = '</a>';
        $code[]     = '<div class="box_left">';
        $code[]     = duration($video['duration']). '<br />';
        $code[]     = time_range($video['addtime']);
        $code[]     = '</div>';
        $code[]     = '<div class="box_right">';
        $code[]     = video_rating_small($video['rate']);
        $code[]     = '<div class="clear_right"></div>';
		$view		= ($video['viewnumber'] == '1') ? $lang['global.view'] : $lang['global.views'];
        $code[]     = $video['viewnumber']. ' '.$view;
        $code[]     = '</div>';
        $code[]     = '<div class="clear"></div>';
        $code[]     = '</div>';
    }
    
    $data['page']   = $page;
    $data['status'] = ( $total_pages > 1 ) ? 1 : 0;
    $data['videos'] = implode("\n", $code);
    $data['pages']  = $total_pages;
}

echo json_encode($data);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'games' => '', 'page' => 0, 'pages' => 0, 'move' => '', 'debug' => '');
if ( isset($_POST['game_id']) && isset($_POST['move']) && isset($_POST['page']) ) {
    $filter         = new VFilter();
    $gid            = $filter->get('game_id', 'INTEGER');
    $page           = $filter->get('page', 'INTEGER');
    $move           = ( $_POST['move'] == 'next' ) ? 'next' : 'prev';
    if ( $move == 'prev' ) {
        $page   = ( $page < 1 ) ? 1 : $page-1;
		$data['move']  = 'prev';
    } else {
        $page   = $page+1;
		$data['move']  = 'next';
    }
    
    $sql            = "SELECT title, category, tags FROM game WHERE GID = " .$gid. " LIMIT 1";
    $rs             = $conn->execute($sql);
    $game           = $rs->getrows();
    $game           = $game['0'];
    
    $sql_add        = NULL;
    if ( $game['tags'] ) {
        $keywords   = explode(' ', $game['tags']);
        $sql_add   .= " OR (";
        $sql_or     = NULL;
        foreach ( $keywords as $keyword ) {
            $sql_add .= $sql_or. " tags LIKE '%" .trim($conn->qStr($keyword), "'"). "%'";
            $sql_or   = " OR ";
        }
        $sql_add   .= ")";
    }
    
	$type			= ($config['show_private_games'] == '1') ? '' : " AND type = 'public'";
    $sql            = "SELECT COUNT(GID) AS total_games FROM game WHERE status = '1' AND category = '" .$game['category']. "'" .$type. " AND GID != " .$gid. "
					   AND status = '1' AND ( title LIKE '%" .trim($conn->qStr($game['title']), "'"). "%' " .$sql_add. ")";
    $rs             = $conn->execute($sql);
    $total          = $rs->fields['total_games'];
    $total          = ( $total > 80 ) ? 80 : $total;
    $pagination     = new Pagination(8, $page);
    $limit          = $pagination->getLimit($total);
    $sql            = "SELECT GID, title, addtime, rate, total_plays FROM game 
                       WHERE status = '1' AND category = '" .intval($game['category']). "'" .$type. " AND GID != " .$gid. "
                       AND ( title LIKE '%" .trim($conn->qStr($game['title']), "'"). "%' " .$sql_add. ") 
                       ORDER BY addtime DESC LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $games          = $rs->getrows();
    $code           = array();
    $total_pages    = $pagination->getTotalPages();
    $page           = ( $page >= $total_pages ) ? $total_pages : $page;

    $code[]     = '<div class="row">';	
    foreach ( $games as $game ) {
		if ($game['type'] == 'private') {
			$img_class = 'class="img-responsive img-private"';
		}
		else {
			$img_class = 'class="img-responsive"';
		}
        $code[]     = '<div class="col-sm-6 col-md-3 col-lg-3">';
        $code[]     = '<div class="well well-sm m-b-0 m-t-20">';
        $code[]     = '<a href="' .$config['BASE_URL']. '/game/' .$game['GID']. '/' .prepare_string($game['title']). '">';
        $code[]     = '<div class="thumb-overlay">';
		$code[]     = '<img src="' .$config['BASE_URL']. '/media/games/tmb/' .$game['GID']. '.jpg" title="' .htmlspecialchars($game['title'], ENT_QUOTES, 'UTF-8'). '" alt="' .htmlspecialchars($game['title'], ENT_QUOTES, 'UTF-8'). '" '.$img_class.' />';
		if ($game['type'] == 'private') {		
			$code[]     = '<div class="label-private">' .$lang['global.PRIVATE']. '</div>';
		}
        $code[]     = '</div>';
        $code[]     = '<span class="game-title title-truncate m-t-5">' .htmlspecialchars($game['title'], ENT_QUOTES, 'UTF-8'). '</span>';
        $code[]     = '</a>';
        $code[]     = '<div class="game-added">';
        $code[]     = time_range($game['addtime']);;
        $code[]     = '</div>';
        $code[]     = '<div class="game-views pull-left">';
		$views		= ($game['total_plays'] == '1') ? $lang['global.play'] : $lang['global.plays'];
        $code[]     = $game['viewnumber']. ' '.$views;
        $code[]     = '</div>';
		if ($game['rate'] == 0 && $game[dislikes] == 0) {
			$rate_class = 'no-rating"';
			$rate_icon  = '<i class="fa fa-heart video-rating-heart no-rating"></i> <b>-</b>';
			}
		else {
			$rate_class = '';
			$rate_icon  = '<i class="fa fa-heart video-rating-heart"></i> <b>' .$game['rate']. '%</b>';
		}
        $code[]     = '<div class="game-rating pull-right ' .$rate_class. '">';
        $code[]     = $rate_icon;
        $code[]     = '</div>';
        $code[]     = '<div class="clearfix"></div>';
        $code[]     = '</div>';
        $code[]     = '</div>';
    }
    $code[]     = '</div>';		
    $code[]     = '<div id="related_games_container_' .$page. '"></div>';
    
    $data['page']   = $page;
    $data['status'] = ( $total_pages > 1 ) ? 1 : 0;
    $data['games']  = implode("\n", $code);
    $data['pages']  = $total_pages;
}

echo json_encode($data);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

if ( $config['game_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$sql            = "SELECT COUNT(GID) AS total_games FROM game WHERE UID = " .$uid. " AND status = '1'";
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_games'];
$pagination     = new Pagination(18);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT GID, title, addtime, rate, likes, dislikes, total_plays, type FROM game
                   WHERE UID = " .$uid. " AND status = '1'
                   ORDER BY GID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$games          = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/games');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$smarty->assign('games', $games);
$smarty->assign('games_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

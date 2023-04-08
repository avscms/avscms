<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

if ( $config['game_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

if ( isset($_GET['clear']) && $_GET['clear'] == 'yes' ) {
    if ( isset($_SESSION['uid']) && $_SESSION['uid'] == $user['UID'] ) {
        $sql        = "DELETE FROM game_favorites WHERE UID = " .$uid;
        $conn->execute($sql);
        $messages[] = $lang['user.fav_games_clear'];
    }
}

$sql            = "SELECT count(GID) AS total_games FROM game_favorites WHERE UID = " .$uid;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_games'];
$pagination     = new Pagination(18);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT g.GID, g.title, g.total_plays, g.addtime, g.rate, g.likes, g.dislikes, g.type FROM game AS g, game_favorites AS f
                   WHERE f.UID = " .$uid. " AND f.GID = g.GID ORDER BY g.GID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$favorites      = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/favorite/games');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username.' - '.$lang['user.fav_games'];

$smarty->assign('type', $type);
$smarty->assign('favorites', $favorites);
$smarty->assign('favorites_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

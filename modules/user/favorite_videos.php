<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

if ( $config['video_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

if ( isset($_GET['clear']) && $_GET['clear'] == 'yes' ) {
    if ( isset($_SESSION['uid']) && $_SESSION['uid'] == $user['UID'] ) {
        $sql        = "DELETE FROM favourite WHERE UID = " .$uid;
        $conn->execute($sql);
        $messages[] = $lang['user.fav_videos_clear'];
    }
}

$sql            = "SELECT count(VID) AS total_videos FROM favourite WHERE UID = " .$uid;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_videos'];
$pagination     = new Pagination(24);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT v.* FROM video AS v, favourite AS f
                   WHERE f.UID = " .$uid. " AND f.VID = v.VID ORDER BY v.VID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$favorites      = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/favorite/videos');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username. ' - '.$lang['user.fav_videos'];

$smarty->assign('favorites', $favorites);
$smarty->assign('favorites_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/pagination.class.php';

if ( isset($_GET['clear']) && $_GET['clear'] == 'yes' ) {
    if ( isset($_SESSION['uid']) && $_SESSION['uid'] == $user['UID'] ) {
        $sql        = "DELETE FROM playlist WHERE UID = " .$uid;
        $conn->execute($sql);
        $messages[] = $lang['user.playlist_all'];
    }
}

$sql            = "SELECT count(VID) AS total_videos FROM playlist WHERE UID = " .$uid;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_videos'];
$pagination     = new Pagination(24);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT v.VID, v.title, v.addtime, v.rate, v.likes, v.dislikes, v.viewnumber, v.duration, v.type, v.thumb, v.thumbs, v.hd
                   FROM video AS v, playlist AS p
                   WHERE p.UID = " .$uid. " AND p.VID = v.VID AND v.active = '1'
				   ORDER BY v.VID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$playlist       = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/playlist');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username. '\'s Playlist';

$smarty->assign('playlist', $playlist);
$smarty->assign('playlist_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

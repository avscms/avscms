<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

if ( $config['photo_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

if ( isset($_GET['clear']) && $_GET['clear'] == 'yes' ) {
    if ( isset($_SESSION['uid']) && $_SESSION['uid'] == $user['UID'] ) {
        $sql        = "DELETE FROM photo_favorites WHERE UID = " .$uid;
        $conn->execute($sql);
        $messages[] = $lang['user.fav_photos_clear'];
    }
}

$sql            = "SELECT count(PID) AS total_photos FROM photo_favorites WHERE UID = " .$uid;
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_photos'];
$pagination     = new Pagination(24);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT p.PID, p.caption FROM photos AS p, photo_favorites AS f
                   WHERE f.UID = " .$uid. " AND f.PID = p.PID ORDER BY p.PID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$favorites      = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/favorite/photos');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username.' - '.$lang['user.fav_photos'];

$smarty->assign('favorites', $favorites);
$smarty->assign('favorites_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

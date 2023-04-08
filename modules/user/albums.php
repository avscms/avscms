<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

$sql            = "SELECT COUNT(AID) AS total_albums FROM albums WHERE UID = " .$uid. " AND status = '1'";
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_albums'];
$pagination     = new Pagination(24);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM albums WHERE UID = " .$uid. " AND status = '1' LIMIT " .$limit;
$rs             = $conn->execute($sql);
$albums         = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/albums');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username. '\'s Photo Albums';

$smarty->assign('albums_total', $total);
$smarty->assign('albums', $albums);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

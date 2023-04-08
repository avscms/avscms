<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/pagination.class.php';

$sql            = "SELECT COUNT(VID) AS total_videos FROM video WHERE UID = " .$uid. " AND active = '1'";
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_videos'];
$pagination     = new Pagination(24);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM video
                   WHERE UID = " .$uid. " AND active = '1' ORDER BY VID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/videos');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$smarty->assign('videos', $videos);
$smarty->assign('videos_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

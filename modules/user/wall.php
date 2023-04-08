<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/pagination.class.php';

$sql            = "SELECT COUNT(wall_id) AS total_messages FROM wall WHERE OID = " .$uid. " AND status = '1'";
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_messages'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT w.wall_id, w.UID, w.message, w.addtime, u.username, u.photo, u.gender
                   FROM wall AS w, signup AS u WHERE w.OID = " .$uid. " AND w.status = '1' AND w.UID = u.UID
                   ORDER BY w.addtime DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$walls          = $rs->getrows();
$page_link      = $pagination->getPagination('user/' .$username. '/wall', 'p_wall_comments_' .$uid. '_');
$page_link_b    = $pagination->getPagination('user/' .$username. '/wall', 'pp_wall_comments_' .$uid. '_');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title     = $username. ' - ' .$lang['user.wall'];

$smarty->assign('walls_total', $total);
$smarty->assign('walls', $walls);
$smarty->assign('page_link', $page_link);
$smarty->assign('page_link_b', $page_link_b);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
?>

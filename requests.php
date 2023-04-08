<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';
require 'classes/auth.class.php';

$auth   = new Auth();
$auth->check();

$uid            = intval($_SESSION['uid']);
$username       = $_SESSION['username'];
$sql            = "SELECT * FROM signup WHERE UID = " .$uid. " LIMIT 1";
$rs             = $conn->execute($sql);
$user           = $rs->getrows();
$user           = $user['0'];

$sql        = "SELECT * FROM users_online WHERE UID = " .$uid. " AND online > " .(time()-300). " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 )
	$online = true;
else
	$online = false;

$sql            = "SELECT COUNT(FID) AS total_requests FROM friends WHERE UID = " .$uid. " AND status = 'Pending'";
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_requests'];
$pagination     = new Pagination(16);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT r.FID, r.message, s.username, s.photo, s.gender 
                   FROM friends AS r, signup AS s
                   WHERE r.UID = " .$uid. " AND r.status = 'Pending' AND r.FID = s.UID
                   ORDER BY r.invite_date DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$requests       = $rs->getrows();
$page_link      = $pagination->getPagination('requests');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('profile', true);
$smarty->assign('menu', 'home');
$smarty->assign('user', $user);
$smarty->assign('online', $online);
$smarty->assign('username', $username);
$smarty->assign('requests', $requests);
$smarty->assign('requests_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('requests.tpl');
$smarty->display('footer.tpl');
?>

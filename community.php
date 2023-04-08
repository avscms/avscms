<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';

$sql            = "SELECT UID, username, photo, gender, rate FROM signup WHERE account_status = 'Active'
                   ORDER BY popularity DESC LIMIT 12";
$rs             = $conn->execute($sql);
$popular_users  = $rs->getrows();

$sql            = "SELECT UID, username, photo, gender, rate FROM signup WHERE account_status = 'Active' AND gender = 'Male'
                   ORDER BY addtime DESC LIMIT 12";
$rs             = $conn->execute($sql);
$male_users     = $rs->getrows();

$sql            = "SELECT UID, username, photo, gender, rate FROM signup WHERE account_status = 'Active' AND gender = 'Female'
                   ORDER BY addtime DESC LIMIT 12";
$rs             = $conn->execute($sql);
$female_users   = $rs->getrows();

$sql            = "SELECT s.UID, s.username, s.photo, s.gender, s.rate FROM signup AS s, users_online AS u
                   WHERE s.account_status = 'Active' AND u.online > " .(time()-300). "
                   AND s.gender = 'Male' AND s.UID = u.UID
                   ORDER BY s.addtime DESC LIMIT 8";
$rs             = $conn->execute($sql);
$online_m_users = $rs->getrows();

$sql            = "SELECT s.UID, s.username, s.photo, s.gender, s.rate FROM signup AS s, users_online AS u
                   WHERE s.account_status = 'Active' AND u.online > " .(time()-300). "
                   AND s.gender = 'Female' AND s.UID = u.UID
                   ORDER BY s.addtime DESC LIMIT 8";
$rs             = $conn->execute($sql);
$online_f_users = $rs->getrows();


$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'community');
$smarty->assign('community', true);
$smarty->assign('male_users', $male_users);
$smarty->assign('total_musers', count($male_users));
$smarty->assign('female_users', $female_users);
$smarty->assign('total_fusers', count($female_users));
$smarty->assign('online_male_users', $online_m_users);
$smarty->assign('total_omusers', count($online_m_users));
$smarty->assign('online_female_users', $online_f_users);
$smarty->assign('total_ofusers', count($online_f_users));
$smarty->assign('popular_users', $popular_users);
$smarty->assign('total_pusers', count($popular_users));
$smarty->assign('self_title', $seo['community_title']);
$smarty->assign('self_description', $seo['community_desc']);
$smarty->assign('self_keywords', $seo['community_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('community.tpl');
$smarty->display('footer.tpl');
?>

<?php
defined('_VALID') or die('Restricted Access!');

$sql    = "SELECT u.username, u.UID
           FROM signup AS u, users_blocks AS b
           WHERE b.UID = " .$uid. " AND b.BID = u.UID";
$rs     = $conn->execute($sql);
$blocks = $rs->getrows();

$smarty->assign('blocks', $blocks);
?>

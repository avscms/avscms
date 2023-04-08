<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$exists = true;
$BID    = ( isset($_GET['BID']) && is_numeric($_GET['BID']) && blogExists($_GET['BID']) ) ? intval(trim($_GET['BID'])) : NULL;
if ( !$BID ) {
    $exists     = false;
    $errors[]   = 'Invalid blog identifier. Are you sure this blog exists!?';
}

if ( $exists ) {
    $sql    = "SELECT b.*, s.username FROM blog AS b, signup AS s
               WHERE b.BID = " .$BID. " AND b.UID = s.UID LIMIT 1";
    $rs     = $conn->execute($sql);
    $blog   = $rs->getrows();
    $blog   = $blog['0'];
}

$smarty->assign('blog', $blog);
?>

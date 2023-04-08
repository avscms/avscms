<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$channel    = array();
$CID        = ( isset($_GET['CID']) && is_numeric($_GET['CID']) ) ? trim($_GET['CID']) : NULL;
$CID        = ( $CID && channelExists($CID) ) ? $CID : NULL;
if ( $CID ) {
    $sql        = "SELECT * FROM channel WHERE CHID = " .$conn->qStr($CID). " LIMIT 1";
    $rs         = $conn->execute($sql);
    $channel    = $rs->getrows();
} else {
    $err = 'Channel does not exist! Invalid channel id!?';
    session_write_close();
    header('Location: channels.php?err=' .$err);
    die();
}

$smarty->assign('channel', $channel);
?>

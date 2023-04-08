<?php
defined('_VALID') or die('Restricted Access!');

if ( isset($_POST['prefs_submit']) ) {
    $show_playlist      = trim($_POST['show_playlist']);
    $show_playlist      = ( $show_playlist == '1' or $show_playlist == '2' ) ? $show_playlist : 0;
    $show_favorites     = trim($_POST['show_favorites']);
    $show_favorites     = ( $show_favorites == '1' or $show_favorites == '2' ) ? $show_favorites : 0;
    $show_friends       = trim($_POST['show_friends']);
    $show_friends       = ( $show_friends == '1' or $show_friends == '2' ) ? $show_friends : 0;
    $show_subscriptions = trim($_POST['show_subscriptions']);
    $show_subscriptions = ( $show_subscriptions == '1' or $show_subscriptions == '2' ) ? $show_subscriptions : 0;
    $show_subscribers   = trim($_POST['show_subscribers']);
    $show_subscribers   = ( $show_subscribers == '1' or $show_subscribers == '2' ) ? $show_subscribers : 0;
    $friends_requests   = ( isset($_POST['friends_requests']) ) ? 1 : 0;
    $wall_public        = ( isset($_POST['wall_public']) ) ? 1 : 0;
    $video_approve      = ( isset($_POST['video_approve']) ) ? 1 : 0;
    $album_approve      = ( isset($_POST['album_approve']) ) ? 1 : 0;
    $video_subscribe    = ( isset($_POST['video_subscribe']) ) ? 1 : 0;
    $friend_request     = ( isset($_POST['friend_request']) ) ? 1 : 0;
    $wall_write         = ( isset($_POST['wall_write']) ) ? 1 : 0;
    $video_comment      = ( isset($_POST['video_comment']) ) ? 1 : 0;
    $photo_comment      = ( isset($_POST['photo_comment']) ) ? 1 : 0;
    $blog_comment       = ( isset($_POST['blog_comment']) ) ? 1 : 0;
    $game_comment       = ( isset($_POST['game_comment']) ) ? 1 : 0;
    $send_message       = ( isset($_POST['send_message']) ) ? 1 : 0;
    
    $sql                = "UPDATE users_prefs SET show_playlist = '" .$show_playlist. "', show_favorites = '" .$show_favorites. "',
                                                  show_friends = '" .$show_friends. "', show_subscriptions = '" .$show_subscriptions. "',
                                                  show_subscribers = '" .$show_subscribers. "', friends_requests = '" .$friends_requests. "',
                                                  wall_public = '" .$wall_public. "', video_approve = '" .$video_approve. "',
                                                  album_approve = '" .$album_approve. "', video_subscribe = '" .$video_subscribe. "',
                                                  friend_request = '" .$friend_request. "', wall_write = '" .$wall_write. "',
                                                  video_comment = '" .$video_comment. "', photo_comment = '" .$photo_comment. "',
                                                  blog_comment = '" .$blog_comment. "', send_message = '" .$send_message. "',
                                                  game_comment = '" .$game_comment. "'
                            WHERE UID = " .intval($user['UID']). " LIMIT 1";
    $conn->execute($sql);
    $messages[]         = $lang['user.prefs_success'];
}

$sql    = "SELECT * FROM users_prefs WHERE UID = " .intval($user['UID']). " LIMIT 1";
$rs     = $conn->execute($sql);
$prefs  = $rs->getrows();
$prefs  = $prefs['0'];

$smarty->assign('prefs', $prefs);
?>

<?php
define('_VALID', true);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

require 'include/config.paths.php';
require 'include/config.db.php';
require 'include/config.local.php';
require 'include/security.php';
require 'include/function_global.php';
require 'include/sessions.php';

disableRegisterGlobals();
require $config['BASE_DIR']. '/include/function_language.php';
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = $config['language'];
}
require $config['BASE_DIR']. '/language/'.$_SESSION['language'].'.lang.php';

$request            = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : NULL;
if ( !$request ) {
    die('Invalid Request! Aborting!!!');
}

$module             = strtolower(substr($request, strrpos($request, '/')+1));
$modules_allowed    = array(
    'upload_progress'   => 1,
    'check_username'    => 1,
    'vote_video'        => 1,
    'vote_photo'        => 1,
    'vote_user'         => 1,
    'album_cover'       => 1,
    'share_video'       => 1,
    'share_photo'       => 1,
    'photo_comment'     => 1,
    'video_comment'     => 1,
    'wall_comment'      => 1,
    'blog_comment'      => 1,
    'notice_comment'        => 1,
    'video_comment_delete'  => 1,
    'photo_comment_delete'  => 1,
    'wall_comment_delete'   => 1,
    'notice_comment_delete' => 1,
    'blog_comment_delete'   => 1,
    'favorite_video'        => 1,
    'favorite_photo'        => 1,
    'flag_video'            => 1,
    'flag_photo'            => 1,
    'photo_pagination'  => 1,
    'video_pagination'  => 1,
    'wall_pagination'   => 1,
    'blog_pagination'   => 1,
    'notice_pagination' => 1,
    'report_user'   => 1,
    'report_spam'   => 1,
    'static_read'   => 1,
    'static_write'  => 1,
    'static_preview'    => 1,
    'remove_photo_favorite' => 1,
    'remove_video_favorite' => 1,
    'remove_video_playlist' => 1,
    'related_videos'    => 1,
    'search'    => 1,
    'accept_friend' => 1,
    'reject_friend' => 1,
    'invite_friend' => 1,
    'remove_friend' => 1,
    'blog_preview'  => 1,
    'subscribe' => 1,
    'unsubscribe'   => 1,
    'block_user'    => 1,
    'unblock_user'  => 1,
    'users' => 1,
    'insert_favorite_photos'    => 1,
    'insert_favorite_videos'    => 1,
    'insert_my_photos'  => 1,
    'insert_my_videos'  => 1,
    'insert_playlist_videos'    => 1,
    'category_videos'   => 1,
    'notice_preview'    => 1,
    'delete_photo'  => 1,
	'remove_subscriber' => 1,
	'remove_subscription' => 1,
	'language' => 1,
	'delete_video' => 1,
	'delete_album' => 1,
	'fb_signup' => 1,
	'g_signup' => 1,
	'signup_check_username' => 1,	
	'check_size' => 1,
	'admin_get_comments' => 1,
	'admin_delete_comment' => 1,
	'admin_save_comment' => 1,
	'admin_view_video' => 1,
	'admin_delete_video' => 1,
	'admin_unflag_video' => 1,		
	'admin_thumb_video' => 1,
	'admin_duration_video' => 1,
	'admin_status_video' => 1,
	'admin_get_video' => 1,
	'admin_save_video' => 1,
	'admin_get_thumbs_video' => 1,
	'admin_save_thumbnails' => 1,
	'admin_thumbnails_video' => 1,
	'admin_delete_tmp' => 1,
	'admin_delete_album' => 1,	
	'admin_status_album' => 1,
	'admin_get_album' => 1,
	'admin_save_album' => 1,
	'admin_get_photos_album' => 1,
	'admin_save_cover' => 1,
	'admin_delete_photo' => 1,
	'admin_get_photo' => 1,
	'admin_save_photo' => 1,
	'admin_status_photo' => 1,	
	'admin_update' => 1,
	'admin_update_caption' => 1,
	'admin_unflag_photo' => 1,
	'admin_delete_blog' => 1,
	'admin_get_blog' => 1,
	'admin_save_blog' => 1,
	'admin_status_blog' => 1,
	'admin_delete_user' => 1,
	'admin_get_user' => 1,
	'admin_save_user' => 1,
	'admin_status_user' => 1,
	'admin_unflag_user' => 1,	
	'admin_suggest_users' => 1,
	'admin_check_user_email' => 1,	
	'admin_delete_category' => 1,
	'admin_save_category' => 1,
	'admin_check_category' => 1,
	'admin_delete_image' => 1,
	'admin_status_category' => 1,
	'admin_delete_notice' => 1,
	'admin_get_notice' => 1,
	'admin_save_notice' => 1,
	'admin_status_notice' => 1,
	'admin_delete_server' => 1,
	'admin_get_server' => 1,
	'admin_save_server' => 1,
	'admin_used_server' => 1,
	'admin_status_server' => 1,
	'admin_get_csvformat' => 1,
	'admin_save_csvformat' => 1,
	'admin_delete_csvformat' => 1,
	'admin_check_csvimport' => 1,
	'admin_delete_source' => 1,
	'admin_status_source' => 1,
	'admin_aembedder_cron' => 1,
	'admin_get_yt_settings' => 1,
	'admin_save_yt_settings' => 1,
	'comments_get_fvideos' => 1,
	'comments_get_svideos' => 1,
	'comments_get_fphotos' => 1,
	'comments_get_sphotos' => 1,
	'vote_comment' => 1,
	'post_comment' => 1,
	'post_reply' => 1, 
	'delete_comment' => 1,
	'report_comment' => 1,	
	'load_comments' => 1,
	'load_replies' => 1,
	'total_replies' => 1,
	'vote' => 1,
	'user_subscription' => 1,
	'user_friendship' => 1,
	'user_block' => 1,
	'user_report' => 1,
	'user_message' => 1,
	'delete_blog' => 1
);
  
if ( isset($modules_allowed[$module]) && $modules_allowed[$module] === 1 ) {
    require 'include/ajax/' .$module. '.php';
} else {
    header('HTTP/1.0 404 Not Found');
}

die();
?>

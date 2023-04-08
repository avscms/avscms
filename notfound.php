<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';

$relative = $config['RELATIVE'];

$error_type = 'default';
$request    = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : NULL;
$query      = explode('/', $request);


if ( is_array($query) ) {
    $arr_size = count($query);
    if ($relative !== ''){
        $count = 0;
        foreach ( $query as $key => $value ) {
            
            if ($arr_size>3){
                if ( $count == 3 ) {
                    $error_type = $value;
                }
            }
            $count++;
        }    
    } else {
        $count = 0;
        foreach ( $query as $key => $value ) {
            
            if ($arr_size>2){
                if ( $count == 2 ) {
                    $error_type = $value;
                }
            }
            $count++;
        }      
    
    }
}

switch ( $error_type ) {
    case 'video_private':
        $message = $lang['error.video_private'];
        break;
    case 'album_private':
        $message =  $lang['error.album_private'];
        break;
    case 'photo_private':
        $message =  $lang['error.photo_private'];
        break;
    case 'user_missing':
        $message =  $lang['error.user_missing'];
        break;
    case 'video_missing':
        $message =  $lang['error.video_missing'];
        break;
    case 'album_missing':
        $message =  $lang['error.album_missing'];
        break;
    case 'photo_missing':
        $message =  $lang['error.photo_missing'];
        break;
    case 'registration_disabled':
        $message =  $lang['error.registration_disabled'];
        break;
    case 'page_invalid':
        $message =  $lang['error.page_invalid'];
        break;
    case 'invalid_notice':
        $message =  $lang['error.invalid_notice'];
        break;
    case 'blog_missing':
        $message =  $lang['error.blog_missing'];
        break;
    case 'blog_private':
        $message =  $lang['error.blog_private'];
        break;
    case 'album_permission':
        $message =  $lang['error.album_permission'];
        break;
    case 'private_messages_friends':
        $message =  $lang['error.private_messages_friends'];
        break;
    case 'private_messages_disabled':
        $message =  $lang['error.private_messages_disabled'];
        break;
    case 'mail_missing':
        $message =  $lang['error.mail_missing'];
        break;
    case 'invalid_search_type':
        $message =  $lang['error.invalid_search_type'];
        break;
    case 'game_missing':
        $message =  $lang['error.game_missing'];
        break;
	case 'free_watch_permission':
        $message =  $lang['error.free_watch_permission'];
		break;
	case 'premium_watch_permission':
        $message =  $lang['error.premium_watch_permission'];
		break;
	case 'upload_permission':
        $message =  $lang['error.upload_permission'];
		break;
	case 'blog_permission':
        $message =  $lang['error.blog_permission'];
		break;
	case 'free_limit_reached':
        $message =  $lang['error.free_limit_reached'];
		break;
	case 'premium_limit_reached':
        $message =  $lang['error.premium_limit_reached'];
		break;
	case 'download_free':
        $message =  $lang['error.download_free'];
		break;
	case 'download_premium':
        $message =  $lang['error.download_premium'];
		break;
    default:
        $message =  $lang['error.unexpected_error'];
        break;
}


$smarty->assign('message', $message);
$smarty->assign('menu', 'home');
$smarty->assign('categories', get_categories());
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('notfound.tpl');
$smarty->display('footer.tpl');
?>

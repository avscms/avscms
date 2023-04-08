<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'include/function_user.php';

$template   = 'user';
$options    = getUserQuery();
$username   = $options['username'];
$module     = $options['module'];
if ( !$username ) {
    require 'classes/auth.class.php';
    $auth   = new Auth();
    $auth->check();
}

$sql    = "SELECT * FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/user_missing');
}
$user   = $rs->getrows();
$user   = $user['0'];
$uid    = intval($user['UID']);

$sql        = "SELECT * FROM users_online WHERE UID = " .$uid. " AND online > " .(time()-300). " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 )
	$online = true;
else
	$online = false;

if ( $options['module'] != '' ) {
    $profile_menu  = $module;
    $template       = 'user_' .$module;
    require 'modules/user/' .$module. '.php';
} else {
    $options    = getUserModule($options['query']);
    $module     = $options['module'];
    if ( !$module == '' ) {
        if ( $module == 'favorite' ) {
            $submodules_allowed = array('videos', 'photos');
            if ( isset($options['query']['0']) && in_array($options['query']['0'], $submodules_allowed) ) {
                $submodule  = $options['query']['0'];
                $template   = 'user_favorite_' .$submodule;
                require 'modules/user/favorite_' .$submodule. '.php';
            } else {
                session_write_close();
                header('Location: ' .$config['BASE_URL']. '/notfound/invalid_module');
                die();
            }
        } else {
            $template = 'user_' .$module;
            require 'modules/user/' .$module. '.php';
        }
    } else {		
        $prefs          = get_user_prefs($uid);
        $is_friend      = is_friend($uid);
        $friends        = get_user_friends($uid, $prefs['show_friends'], $is_friend);
        $playlist       = get_user_playlist($uid, $prefs['show_playlist'], $is_friend);
        $favorites      = get_user_favorites($uid, $prefs['show_favorites'], $is_friend);
        $subscriptions  = get_user_subscriptions($uid, $prefs['show_subscriptions'], $is_friend);
        $subscribers    = get_user_subscribers($uid, $prefs['show_subscribers'], $is_friend);
        $total_subscribers = get_user_total_subscribers($uid);	
        $albums         = get_user_albums($uid);
        $photos         = get_user_favorite_photos($uid, $prefs['show_favorites'], $is_friend);

        $show_wall      = false;
        $wall_public    = $prefs['wall_public'];
        $walls          = array();
        $comments_total    = 0;
        if ( $wall_public == '1' ) {
            $show_wall  = true;
        } else {
            if ( $is_friend ) {
                $show_wall  = true;
            } elseif ( isset($_SESSION['uid']) && $_SESSION['uid'] == $uid ) {
                $show_wall  = true;
            }
        }
        
        if ( $show_wall ) {
            require 'classes/pagination.class.php';
            $sql            = "SELECT COUNT(CID) AS total_walls FROM wall_comments WHERE WID = " .$uid. " AND status = '1'";
            $rsc            = $conn->execute($sql);
            $comments_total = $rsc->fields['total_walls'];
            $pagination     = new Pagination(10);
            $limit          = $pagination->getLimit($comments_total);            
            $sql            = "SELECT w.*, u.username, u.photo, u.gender
                               FROM wall_comments AS w, signup AS u WHERE w.WID = " .$uid. " AND w.status = '1' AND w.UID = u.UID 
                               ORDER BY w.addtime DESC LIMIT 10";
            $rs             = $conn->execute($sql);
            $comments       = $rs->getrows();
            $page_link      = $pagination->getPagination('user/' .$username, 'p_wall_comments_' .$uid. '_');
			$start_num      = $pagination->getStartItem();
			$end_num        = $pagination->getEndItem();			
            $smarty->assign('page_link', $page_link);
			$smarty->assign('start_num', $start_num);
			$smarty->assign('end_num', $end_num);
        }
        
        $blog           = array();
        $sql            = "SELECT BID, UID, title, content, total_views, total_comments, addtime
                           FROM blog WHERE UID = " .$uid. " AND status = '1'
                           ORDER BY addtime DESC LIMIT 1";
        $rs             = $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $blog       = $rs->getrows();
            $blog       = $blog['0'];
			$blog['content'] = blog_output($blog['content']);
        }
        
        $sql            = "UPDATE signup SET profile_viewed = profile_viewed+1, popularity = popularity+0.1 WHERE UID = " .$uid. " LIMIT 1";
        $conn->execute($sql);
          
        $self_title         = $username. '\' Profile - Free Adult Sex Tube Porno';
      
        $smarty->assign('friends', $friends);
        $smarty->assign('playlist', $playlist);
        $smarty->assign('favorites', $favorites);
        $smarty->assign('subscriptions', $subscriptions);
        $smarty->assign('subscribers', $subscribers);
        $smarty->assign('total_subscribers', $total_subscribers);
        $smarty->assign('videos', get_user_videos($uid));
        $smarty->assign('show_wall', $show_wall);
        $smarty->assign('comments', $comments);
        $smarty->assign('comments_total', $comments_total);
        $smarty->assign('albums', $albums);
        $smarty->assign('blog', $blog);
        $smarty->assign('photos', $photos);
        $smarty->assign('user_wall', true);
    }
}

$total_subscribers = get_user_total_subscribers($uid);	
$smarty->assign('total_subscribers', $total_subscribers);

$self_title = ( isset($self_title) ) ? $self_title . ' - ' .$config['site_name'] : $config['site_name'];

$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'community');
$smarty->assign('submenu', '');
$smarty->assign('username', $username);
$smarty->assign('user', $user);
$smarty->assign('online', $online);
$smarty->assign('popularity', '$popularity');
$smarty->assign('points', '$points');
$smarty->assign('profile', true);
$smarty->assign('self_title', $self_title);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
if ( isset($profile_menu) ) {
    $smarty->assign('profile_menu', $profile_menu);
    $smarty->display('user_profile_menu.tpl');
}
$smarty->display($template. '.tpl');
$smarty->display('footer.tpl');
?>

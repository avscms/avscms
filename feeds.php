<?php
define('_VALID', true);
require 'include/config.php';
require 'classes/auth.class.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';
require 'classes/validation.class.php';

Auth::check_();

$username       = ( isset($_GET['u']) && VValidation::username_($_GET['u']) && VValidation::usernameExists_($_GET['u']) ) ? $_GET['u'] : 'all';
$table          = ( isset($_GET['t']) && ctype_alpha($_GET['t']) ) ? $_GET['t'] : 'all';
$tables_allowed = array('all' => 1, 'videos' => 1, 'games' => 1, 'blogs' => 1, 'albums' => 1, 'photos' => 1);
if ( $table != 'all' && !isset($tables_allowed[$table]) ) {
    VRedirect::go($config['BASE_URL']. '/error');
}

$uid            = intval($_SESSION['uid']);
$sql            = "SELECT s.UID, u.username
                  FROM video_subscribe AS s, signup AS u
                  WHERE s.SUID = " .$uid . "
                  AND s.UID = u.UID";
$rs             = $conn->execute($sql);
$subscriptions  = $rs->getrows();

$feeds      = array();
$page_link  = NULL;
if ( $subscriptions ) {
    $photo_approve  = ( $config['approve_photos'] == '1' ) ? " AND a.status = '1'" : NULL;
    $blog_approve   = ( $config['approve_blogs'] == '1' ) ? " AND b.status = '1'" : NULL;
    if ( $username == 'all' ) {
        $suids              = array();
        foreach ( $subscriptions as $subscription ) {
            $suids[]        = $subscription['UID'];
        }
        $sql_add            = " AND PREFIX.UID IN (" .implode(",", $suids). ")";
    } else {
        $sql                = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $rs                 = $conn->execute($sql);
        if ( !$conn->Affected_Rows() === 1 ) {
            VRedirect::go($config['BASE_URL']. '/notfound/user_missing');
        }
        $UID                = intval($rs->fields['UID']);
        $sql                = "SELECT SUID FROM video_subscribe WHERE UID = " .$uid. " AND SUID = " .$UID. " LIMIT 1";
        $conn->execute($sql);
        if ( !$conn->Affected_Rows() === 1 ) {
            VRedirect::go($config['BASE_URL']. '/error');
        }
        $sql_add            = " AND PREFIX.UID = " .$UID;
    }
    
    $total_feeds = 0;
    if ( $table == 'videos' || $table == 'all' ) {
        $video_approve      = ( $config['approve'] == '1' ) ? " AND v.active = '1'" : NULL;
        $sql_count_videos   = "SELECT COUNT(v.VID) AS total_videos
                           FROM video AS v
                           WHERE v.type = 'public'"
                           .$video_approve . str_replace('PREFIX', 'v', $sql_add);
        $rs                 = $conn->execute($sql_count_videos);
        $total_videos       = $rs->fields['total_videos'];
        $total_feeds        = $total_feeds + $total_videos;
        $pagination         = new Pagination(10);
        $limit              = $pagination->getLimit($total_videos);
        $sql_videos         = "SELECT v.*, s.username, s.photo, s.gender 
                           FROM video AS v, signup AS s
                           WHERE v.type = 'public'
                           AND v.UID = s.UID" .$video_approve . str_replace('PREFIX', 'v', $sql_add). "
                           ORDER BY v.VID DESC LIMIT " .$limit;
        $rs                 = $conn->execute($sql_videos);
        $videos             = $rs->getrows();
        foreach ( $videos as $video ) {
            $feeds[]    = array(
                'time' => $video['addtime'],
                'type' => 'video',
                'data' => array('VID' 		=> $video['VID'], 
								'title' 	=> $video['title'], 
								'thumb' 	=> $video['thumb'], 
								'viewnumber'=> $video['viewnumber'], 								
								'rate'		=> $video['rate'], 		
								'hd' 		=> $video['hd'], 								
								'vthumbs' 	=> $video['vthumbs'], 
								'duration' 	=> $video['duration'], 	
								'photo' 	=> $video['photo'], 	
								'gender'    => $video['gender'], 									
								'username' 	=> $video['username'])
            );
        }
    }

    if ( $table == 'albums' || $table == 'all' ) {
        $photo_approve      = ( $config['approve_photos'] == '1' ) ? " AND a.status = '1'" : NULL;
        $sql_count_albums   = "SELECT COUNT(a.AID) AS total_albums
                           FROM albums AS a
                           WHERE a.type = 'public'"
                           .$photo_approve . str_replace('PREFIX', 'a', $sql_add);
        $rs                 = $conn->execute($sql_count_albums);
        $total_albums       = $rs->fields['total_albums'];
        $total_feeds        = $total_feeds + $total_albums;
        $pagination         = new Pagination(10);
        $limit              = $pagination->getLimit($total_albums);
        $sql_albums         = "SELECT a.*, s.username, s.photo, s.gender 
                           FROM albums AS a, signup AS s
                           WHERE a.type = 'public'
                           AND a.UID = s.UID" .str_replace('PREFIX', 'a', $sql_add) . $photo_approve. "
                           ORDER BY a.AID DESC LIMIT " .$limit;
        $rs                 = $conn->execute($sql_albums);
        $albums             = $rs->getrows();
        foreach ( $albums as $album ) {
            $feeds[]    = array(
                'time' => $album['addtime'],
                'type' => 'album',
                'data' => array('AID' 			=> $album['AID'], 
								'name' 			=> $album['name'], 
								'total_photos'	=> $album['total_photos'],								
								'rate' 			=> $album['rate'], 		
								'photo' 		=> $album['photo'], 	
								'gender'    	=> $album['gender'], 	
								'username' 		=> $album['username'])
            );
        }
    }

    if ( $table == 'blogs' || $table == 'all' ) {
        $blog_approve       = ( $config['approve_blogs'] == '1' ) ? " AND b.status = '1'" : NULL;
        $sql_count_blogs    = "SELECT COUNT(b.BID) AS total_blogs
                           FROM blog AS b
                           WHERE 1 = 1"
                           .$blog_approve . str_replace('PREFIX', 'b', $sql_add);
        $rs                 = $conn->execute($sql_count_blogs);
        $total_blogs        = $rs->fields['total_blogs'];
        $total_feeds        = $total_feeds + $total_blogs;
        $pagination         = new Pagination(10);
        $limit              = $pagination->getLimit($total_blogs);
        $sql_blogs          = "SELECT b.BID, b.title, b.addtime, s.username, s.photo, s.gender 
                           FROM blog AS b, signup AS s
                           WHERE b.UID = s.UID" .str_replace('PREFIX', 'b', $sql_add) . $blog_approve. "
                           ORDER BY b.BID DESC LIMIT " .$limit;
        $rs                 = $conn->execute($sql_blogs);
        $blogs              = $rs->getrows();
        foreach ( $blogs as $blog ) {
            $feeds[]    = array(
                'time' => $blog['addtime'],
                'type' => 'blog',
                'data' => array('BID' 		=> $blog['BID'], 
								'title' 	=> $blog['title'], 
								'photo' 	=> $blog['photo'], 	
								'gender'    => $blog['gender'], 								
								'username' 	=> $blog['username'])
            );
        }
    }
}

if ( $table == 'all' ) {
    function compare_time( $a, $b )
    {
        $a_time = intval($a['time']);
        $b_time = intval($b['time']);
        if ( $a_time === $b_time ) {
            return 0;
        }
    
        return ($a_time < $b_time) ? 1 : -1;
    }

    usort($feeds, 'compare_time');
}

if ( $subscriptions ) {
    $pagination             = new Pagination(40);
    $limit                  = $pagination->getLimit($total_feeds);
    $page_link              = $pagination->getPagination('feeds');
}

$self_title             = $config['site_title'];
$self_meta_description  = $config['meta_description'];
$self_meta_keywords     = $config['meta_keywords'];

$smarty->assign('menu', '');
$smarty->assign('subscriptions', $subscriptions);
$smarty->assign('username', $username);
$smarty->assign('table', $table);
$smarty->assign('feeds', $feeds);
$smarty->assign('page_link', $page_link);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_meta_description', $self_meta_description);
$smarty->assign('self_meta_keywords', $self_meta_keywords);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('feeds.tpl');
$smarty->display('footer.tpl');
?>

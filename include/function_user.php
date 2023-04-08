<?php
defined('_VALID') or die('Restricted Access!');
require_once ($config['BASE_DIR']. '/include/function_thumbs.php');

function getUserQuery()
{
    $options    = array('username' => NULL, 'module' => NULL, 'query' => NULL);
    if ( isset($_SESSION['uid']) && isset($_SESSION['username']) ) {
        if ( $_SESSION['uid'] != '' && $_SESSION['username'] != '' ) {
            $options['username']    = $_SESSION['username'];
        }
    }
    
    $request            = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : NULL;
    $request            = ( isset($_SERVER['QUERY_STRING']) ) ? str_replace('?' .$_SERVER['QUERY_STRING'], '', $request) : $request;
    $query              = explode('/', $request);
    foreach ( $query as $key => $value ) {
        if ( $value == 'user' ) {
            $query = array_slice($query, $key+1);
        }
    }
    
    if ( isset($query['0']) && $query['0'] != '' ) {
        $module             = $query['0'];
        $modules_allowed    = array(
            'edit' => 1,
            'avatar' => 1,
            'prefs' => 1,
            'blocks' => 1,
            'delete' => 1
        );
        
        if ( isset($modules_allowed[$module]) ) {
            $options['module']      = $module;
        } else {
            $options['username']    = $module;
            $options['query']       = array_slice($query, 1);
        }
    }
    return $options;
}

function getUserModule( $query )
{
    $options = array('module' => NULL, 'query' => NULL);
    if ( isset($query['0']) && $query['0'] != '' ) {
        $module             = $query['0'];
        $modules_allowed    = array(
            'videos'        => 1,
            'favorite'      => 1,
            'wall'          => 1,
            'addblog'       => 1,
            'blog'          => 1,
            'friends'       => 1,
            'playlist'      => 1,
            'albums'        => 1,
            'subscribers'   => 1,
            'subscriptions' => 1
        );
        
        if ( isset($modules_allowed[$module]) ) {
            $options['module']  = $module;
            $options['query']   = array_slice($query, 1);
        }
    }
    
    return $options;
}

function get_user_prefs( $uid )
{
    global $conn;
    
    $sql    = "SELECT * FROM users_prefs WHERE UID = " .intval($uid). " LIMIT 1";
    $rs     = $conn->execute($sql);
    $prefs  = $rs->getrows();
    
    return $prefs['0'];
}

function is_friend( $uid )
{
    global $conn;
    
    $is_friend  = false;
    if ( isset($_SESSION['uid']) ) {
        $sql        = "SELECT UID FROM friends WHERE UID = " .intval($uid). " AND FID = " .intval($_SESSION['uid']). " AND status = 'Confirmed' LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $is_friend = true;
        }
    }
    
    return $is_friend;    
}

function get_user_friends( $uid, $prefs, $is_friend, $limit=6 )
{
    $friends = array();
    $show    = false;
    if ( $prefs == 2 ) {
        $show = true;
    } elseif ( $prefs == 1 && $is_friend ) {
        $show = true;
    } elseif ( $prefs == 0 && isset($_SESSION['uid']) && $_SESSION['uid'] == $uid ) {
        $show = true;
    }
    
    if ( $show ) {
        global $conn;
        $sql        = "SELECT f.FID, u.username, u.photo, u.gender FROM friends AS f, signup AS u
                       WHERE f.UID = " .$uid. " AND f.FID = u.UID AND f.status = 'Confirmed'
                       ORDER BY f.invite_date DESC LIMIT " .$limit;
        $rs         = $conn->execute($sql);
        $friends    = $rs->getrows();
    }
    
    return $friends;
}

function get_user_playlist( $uid, $prefs, $is_friend, $limit=4 )
{
    $playlist = array();
    $show    = false;
    if ( $prefs == 2 ) {
        $show = true;
    } elseif ( $prefs == 1 && $is_friend ) {
        $show = true;
    } elseif ( $prefs == 0 && isset($_SESSION['uid']) && $_SESSION['uid'] == $uid ) {
        $show = true;
    }
    
    if ( $show ) {
        global $conn;
        $sql        = "SELECT p.VID, v.*
                       FROM playlist AS p, video AS v
                       WHERE p.UID = " .intval($uid). " AND p.VID = v.VID ORDER by v.viewtime DESC LIMIT " .$limit;
        $rs         = $conn->execute($sql);
        $playlist   = $rs->getrows();
    }
    
    return $playlist;
}

function get_user_favorites( $uid, $prefs, $is_friend, $limit=4 )
{
    $favorites = array();
    $show    = false;
    if ( $prefs == 2 ) {
        $show = true;
    } elseif ( $prefs == 1 && $is_friend ) {
        $show = true;
    } elseif ( $prefs == 0 && isset($_SESSION['uid']) && $_SESSION['uid'] == $uid ) {
        $show = true;
    }
    
    if ( $show ) {
        global $conn;
        $sql        = "SELECT f.VID, v.*
                       FROM favourite AS f, video AS v
                       WHERE f.UID = " .intval($uid). " AND f.VID = v.VID ORDER by v.viewtime DESC LIMIT " .$limit;
        $rs         = $conn->execute($sql);
        $favorites  = $rs->getrows();
    }
    
    return $favorites;
}

function get_user_subscribers( $uid, $prefs, $is_friend, $limit=6 )
{
    $favorites = array();
    $show    = false;
    if ( $prefs == 2 ) {
        $show = true;
    } elseif ( $prefs == 1 && $is_friend ) {
        $show = true;
    } elseif ( $prefs == 0 && isset($_SESSION['uid']) && $_SESSION['uid'] == $uid ) {
        $show = true;
    }
    
    if ( $show ) {
        global $conn;
        $sql            = "SELECT vs.SUID, s.username, s.photo, s.gender FROM video_subscribe AS vs, signup AS s
                           WHERE vs.UID = " .$uid. " AND vs.SUID = s.UID LIMIT " .$limit;
        $rs             = $conn->execute($sql);
        $subscribers    = $rs->getrows();
		return $subscribers;
    } else {
		return false;
	}
}

function get_user_total_subscribers( $uid )
{
	global $conn;
	$sql            = "SELECT count(UID) AS total_subscribers FROM video_subscribe WHERE UID = " .$uid. "";
	$rsc             = $conn->execute($sql);
	$total          = $rsc->fields['total_subscribers'];
	return $total;
}

function get_user_subscriptions( $uid, $prefs, $is_friend, $limit=6 )
{
    $favorites = array();
    $show    = false;
    if ( $prefs == 2 ) {
        $show = true;
    } elseif ( $prefs == 1 && $is_friend ) {
        $show = true;
    } elseif ( $prefs == 0 && isset($_SESSION['uid']) && $_SESSION['uid'] == $uid ) {
        $show = true;
    }
    
    if ( $show ) {
        global $conn;
        $sql            = "SELECT vs.UID, s.username, s.photo, s.gender FROM video_subscribe AS vs, signup AS s
                           WHERE SUID = " .$uid. " AND vs.UID = s.UID LIMIT " .$limit;
        $rs             = $conn->execute($sql);
        $subscriptions  = $rs->getrows();
		return $subscriptions;
    } else {
		return false;
	}
}

function get_user_videos( $uid, $limit=4 )
{
    global $conn;
    $sql    = "SELECT *
	           FROM video
               WHERE UID = " .$uid. " AND active = '1'
               ORDER BY addtime DESC LIMIT " .$limit;
    $rs     = $conn->execute($sql);
    return $rs->getrows();
}

function get_user_albums( $uid, $limit=4 )
{
    global $conn;
    $sql        = "SELECT AID, name, rate, likes, dislikes, total_photos, addtime, type FROM albums
                   WHERE UID = " .$uid. " AND status = '1' ORDER BY addtime DESC LIMIT " .$limit;
    $rs         = $conn->execute($sql);
    
    return $rs->getrows();
}

function get_user_favorite_photos( $uid, $prefs, $is_friend, $limit=4 )
{
    $favorites  = array();
    $show       = false;
    if ( $prefs == 2 ) {
        $show = true;
    } elseif ( $prefs == 1 && $is_friend ) {
        $show = true;
    } elseif ( $prefs == 0 && isset($_SESSION['uid']) && $_SESSION['uid'] == $uid ) {
        $show = true;
    }
    
    if ( $show ) {
        global $conn;
        $sql        = "SELECT p.* FROM photos AS p, photo_favorites AS f
                       WHERE f.UID = " .$uid. " AND p.PID = f.PID ORDER BY p.PID DESC LIMIT " .$limit;
        $rs         = $conn->execute($sql);
        $favorites  = $rs->getrows();
    }
    
    return $favorites;
}

function get_vid_server($srv)
{
    global $conn;
	$sql = "SELECT * FROM servers WHERE video_url = '".$srv."'";
	$rs  = $conn->execute($sql);
	if ($conn->Affected_Rows()) {
		$servers = $rs->getrows();
		return $servers[0];
	} else {
		die('Failed to find a active server! Please check your settings!');
	}
}

function delete_video_ftp( $video_id, $srv )
{
    global $config, $conn;
    
    $server 	= get_vid_server($srv);
	$conn_id    = ftp_connect($server['server_ip']);
	$ftp_root 	= $server['ftp_root'];
	$ftp_login  = ftp_login($conn_id, $server['ftp_username'], $server['ftp_password']);
	if ( !$conn_id or !$ftp_login ) {
        die('Failed to connect to FTP server!');
    }

	
	
	ftp_pasv($conn_id, 1);

	if ( !ftp_chdir($conn_id, $ftp_root) ) {
	    die('Failed to change directory to: ' .$ftp_root);
	}
	
	// Change dir to flv and delete flv
	if ( !ftp_chdir($conn_id, 'flv') ) {
	    die('Failed to change directory to: flv');
	}	
	ftp_delete($conn_id, $video_id.'.flv');
	if ( !ftp_chdir($conn_id, '..') ) {
	    die('Failed to change directory to: ' .$ftp_root);
	}		

	// Change dir to iphone and delete video
	if ( !ftp_chdir($conn_id, 'iphone') ) {
	    die('Failed to change directory to: iphone');
	}	
	ftp_delete($conn_id, $video_id.'.mp4');
	if ( !ftp_chdir($conn_id, '..') ) {
	    die('Failed to change directory to: ' .$ftp_root);
	}		

	// Change dir to hd and delete video
	if ( !ftp_chdir($conn_id, 'hd') ) {
	    die('Failed to change directory to: hd');
	}	
	ftp_delete($conn_id, $video_id.'.mp4');
	if ( !ftp_chdir($conn_id, '..') ) {
	    die('Failed to change directory to: ' .$ftp_root);
	}	

	// Change dir to h264 and delete video
	if ( !ftp_chdir($conn_id, 'h264') ) {
	    die('Failed to change directory to: iphone');
	}
	$files = video_files($video_id);
	foreach ($files['server_h264_fn'] as $file) {
		ftp_delete($conn_id, $file);
	}
	if ( !ftp_chdir($conn_id, '..') ) {
	    die('Failed to change directory to: ' .$ftp_root);
	}	
	
	ftp_close($conn_id);    

}

function deleteVideo( $vid )
{
    global $config, $conn;
    
    $vid        = intval($vid);
    $sql        = "SELECT channel, server,keyword FROM video WHERE VID = " .$vid. " LIMIT 1";
    $rs         = $conn->execute($sql);
    $chid    	= $rs->fields['channel'];  
    $srv    	= $rs->fields['server']; 
    $keyword	= $rs->fields['keyword'];
    if ( $srv != '' ) {
		delete_video_ftp($vid,$srv);
    }
    
    // Define All Video Formats Possible

	$files = video_files($vid, true);
	foreach ($files['dir'] as $file) {
		if ( file_exists($file) ) {
			@chmod($file, 0777);
			@unlink($file);
		}
	}

	// AVS thumbs format
	delete_directory(get_thumb_dir($vid));
		
	// Update Channel Video Totals
    $sql = "UPDATE channel SET total_videos = total_videos - 1 WHERE CHID = " .$chid;
    $conn->execute($sql);

    //delete & update tags
	if ($keyword !== '') {	
		$searchForValue = ',';
		$stringValue = $keyword;

		if( strpos($stringValue, $searchForValue) !== false ) {
		   $var=explode(',',$keyword);
		   foreach($var as $value)
		    {
		    remove_tags($value);
		    }
		     	
		} else {
			remove_tags($keyword);
		}
	}
    
    $tables = array('video_comments', 'favourite', 'playlist', 'video');
    foreach ( $tables as $table ) {
        $sql = "DELETE FROM " .$table. " WHERE VID = " .$vid;
        $conn->execute($sql);
    }
}

function deleteAlbum( $aid )
{
    global $config, $conn;
    
    $sql    = "SELECT PID FROM photos WHERE AID = " .$aid;
    $rs     = $conn->execute($sql);
    $photos = $rs->getrows();
    $index  = 0;
    foreach ( $photos as $photo ) {
		//delete photos + thumbs
		$file = $config['BASE_DIR'].'/media/photos/'.$photo['PID'].'.jpg';
		if ( file_exists($file) ) {
			@chmod($file, 0777);
			@unlink($file);
		}
		$file = $config['BASE_DIR'].'/media/photos/tmb/'.$photo['PID'].'.jpg';
		if ( file_exists($file) ) {
			@chmod($file, 0777);
			@unlink($file);
		}
		
        $sql    = "DELETE FROM photos WHERE PID = " .$photo['PID']. " LIMIT 1";
        $conn->execute($sql);
        $sql    = "DELETE FROM photo_comments WHERE PID = " .$photo['PID'];
        $conn->execute($sql);
        $sql    = "DELETE FROM spam WHERE type = 'photo' AND parent_id = " .$photo['PID'];
        $conn->execute($sql);
        ++$index;
    }
    
    $sql    = "DELETE FROM albums WHERE AID = " .$aid;
    $conn->execute($sql);
	
	//delete album cover
	$file = $config['BASE_DIR'].'/media/albums/'.$aid.'.jpg';
	if ( file_exists($file) ) {
		@chmod($file, 0777);
		@unlink($file);
	}    
}

function deleteBlog( $bid )
{
    global $conn;
    
    $bid    = intval($bid);
    $sql    = "SELECT UID FROM blog WHERE BID = " .$bid. " LIMIT 1";
    $rs     = $conn->execute($sql);
    $buid   = $rs->fields['UID'];
    $sql    = "UPDATE signup SET total_blogs = total_blogs-1 WHERE UID = " .$buid. " LIMIT 1";
    $conn->execute($sql);
    $sql    = "DELETE FROM blog_comments WHERE BID = " .$bid;
    $conn->execute($sql);
    $sql    = "DELETE FROM blog WHERE BID = " .$bid. " LIMIT 1";
    $conn->execute($sql);
}

?>

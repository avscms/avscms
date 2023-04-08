<?php
defined('_VALID') or die('Restricted Access!');

function insert_time_range( $options )
{
	global $lang;

    $range          = NULL;
    $time           = $options['time'];
    $current_time   = time();    
    $interval       = $current_time-$time;
	if ( $interval > 0 ) {
        $year    = $interval/(12*30.416*60*60*24);
        if ( $year >= 1 ) {
			if ($year < 2) {
				$range      = floor($year).' '.$lang['global.year'];				
			} else {
				$range      = floor($year).' '.$lang['global.years'];
			}
            $interval   = $interval-(12*30.416*60*60*24*floor($year));            
        }			        
        if ( $interval > 0 && $range == '' ) {
			$month    = $interval/(30.416*60*60*24);
			if ( $month >=1 ) {			
				if ($month < 2) {
					$range      = floor($month).' '.$lang['global.month'];				
				} else {
					$range      = floor($month).' '.$lang['global.months'];
				}
				$interval   = $interval-(30.416*60*60*24*floor($month));            
			}
        }		
        if ( $interval > 0 && $range == '' ) {
			$day    = $interval/(60*60*24);	
			if ( $day >=1 ) {
				if ($day < 2) {
					$range      = floor($day).' '.$lang['global.day'];				
				} else {
					$range      = floor($day).' '.$lang['global.days'];
				}
				$interval   = $interval-(60*60*24*floor($day));            
			}
        }
        if( $interval > 0 && $range == '' ) {
            $hour       = $interval/(60*60);
            if ( $hour >=1 ) {
				if ($hour < 2) {
					$range      = floor($hour). ' ' .$lang['global.hour'];					
				} else {
					$range      = floor($hour). ' ' .$lang['global.hours'];
				}
                $interval   = $interval-(60*60*floor($hour));
            }            
        }
        if ( $interval > 0 && $range == '' ) {
            $min        = $interval/(60);
            if ( $min >= 1 ) {
				if ($min < 2) {				
					$range=floor($min). ' '.$lang['global.minute'];
				} else {
					$range=floor($min). ' '.$lang['global.minutes'];					
				}
                $interval=$interval-(60*floor($min));
            }
        }
        if ( $interval > 0 && $range == '' ) {
            $scn        = $interval;
            if ( $scn < 2 ) {
				if ($min == 1) {				
					$range  = $scn. ' '.$lang['global.second'];
				} else {
					$range  = $scn. ' '.$lang['global.seconds'];					
				}
            }
        }
        
        return ( $range != '' ) ? $range. ' '.$lang['global.ago'] : $lang['global.just_now'];
    }
}

function insert_views( $options )
{
	global $lang;

	$number = $options['views'];
	
	if ($number == 1) 
		return '1'. ' ' . $lang['global.view'];	
	elseif ($number == 0) 
		return '0'. ' ' . $lang['global.views'];	
		
	$abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");
	foreach($abbrevs as $exponent => $abbrev) {
		if($number >= pow(10, $exponent)) {
			$display_num = $number / pow(10, $exponent);
			$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;		
			$result = number_format($display_num,$decimals);
			if ($result == (int)$result) {
				$result = (int)$result;
			}
			return $result . $abbrev. ' ' . $lang['global.views'];
		}
	}   
}

function insert_pviews( $options )
{
	global $lang;

	$number = $options['views'];
	
	if ($number == 1) 
		return '<span class="text-highlighted">1</span>'. ' ' . $lang['user.profile_view'];	
	elseif ($number == 0) 
		return '<span class="text-highlighted">0</span>'. ' ' . $lang['user.profile_views'];	
		
	$abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");
	foreach($abbrevs as $exponent => $abbrev) {
		if($number >= pow(10, $exponent)) {
			$display_num = $number / pow(10, $exponent);
			$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;		
			$result = number_format($display_num,$decimals);
			if ($result == (int)$result) {
				$result = (int)$result;
			}
			return '<span class="text-highlighted">' . $result . $abbrev. '</span> ' . $lang['user.profile_views'];
		}
	}   
}

function insert_vviews( $options )
{
	global $lang;

	$number = $options['views'];
	
	if ($number == 1) 
		return '<span class="text-highlighted">1</span>'. ' ' . $lang['user.watched_video'];	
	elseif ($number == 0) 
		return '<span class="text-highlighted">0</span>'. ' ' . $lang['user.watched_videos'];	
		
	$abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");
	foreach($abbrevs as $exponent => $abbrev) {
		if($number >= pow(10, $exponent)) {
			$display_num = $number / pow(10, $exponent);
			$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;		
			$result = number_format($display_num,$decimals);
			if ($result == (int)$result) {
				$result = (int)$result;
			}
			return '<span class="text-highlighted">' . $result . $abbrev. '</span> ' . $lang['user.watched_videos'];
		}
	}   
}

function insert_ownvviews( $options )
{
	global $lang;

	$number = $options['views'];
	
	if ($number == 1) 
		return '<span class="text-highlighted">1</span>'. ' ' . $lang['user.video_view'];	
	elseif ($number == 0) 
		return '<span class="text-highlighted">0</span>'. ' ' . $lang['user.video_views'];	
		
	$abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");
	foreach($abbrevs as $exponent => $abbrev) {
		if($number >= pow(10, $exponent)) {
			$display_num = $number / pow(10, $exponent);
			$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;		
			$result = number_format($display_num,$decimals);
			if ($result == (int)$result) {
				$result = (int)$result;
			}
			return '<span class="text-highlighted">' . $result . $abbrev. '</span> ' . $lang['user.video_views'];
		}
	}   
}

function insert_tsubscribers( $options )
{
	global $lang;

	$number = $options['subscribers'];
	
	if ($number == 1) 
		return '<span class="text-highlighted">1</span>'. ' ' . $lang['user.subscriber'];	
	elseif ($number == 0) 
		return '<span class="text-highlighted">0</span>'. ' ' . $lang['user.subscribers'];	
		
	$abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");
	foreach($abbrevs as $exponent => $abbrev) {
		if($number >= pow(10, $exponent)) {
			$display_num = $number / pow(10, $exponent);
			$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;		
			$result = number_format($display_num,$decimals);
			if ($result == (int)$result) {
				$result = (int)$result;
			}
			return '<span class="text-highlighted">' . $result . $abbrev. '</span> ' . $lang['user.subscribers'];
		}
	}   
}

function insert_duration ( $options )
{
    $duration_formated  = NULL;
    $duration           = round($options['duration']);
    if ( $duration > 3600 ) {
        $hours              = floor($duration/3600);
        $duration_formated .= sprintf('%02d',$hours). ':';
        $duration           = round($duration-($hours*3600));
    }
    if ( $duration > 60 ) {
        $minutes            = floor($duration/60);
        $duration_formated .= sprintf('%02d', $minutes). ':';
        $duration           = round($duration-($minutes*60));
    } else {
        $duration_formated .= '00:';
    }
        
    return $duration_formated . sprintf('%02d', $duration);
}

function insert_uid_to_username( $options )
{
    global $conn;
    
    $uid        = intval($options['uid']);
    $sql        = "SELECT username FROM signup WHERE UID = " .$uid. " LIMIT 1";
    $rs         = $conn->execute($sql);
    
    return $rs->fields['username'];
}

function insert_adv( $options )
{
    global $conn, $config;
    
    if ( $config['ads'] == '0' ) {
        return false;
    }
    
    $adv        = NULL;
    $adv_group  = $options['group'];    
    $sql        = "SELECT * FROM adv_group
                   WHERE advgrp_name = " .$conn->qStr($adv_group). " AND advgrp_status = '1' LIMIT 1";
    $rs         = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $adv_rotate 	= $rs->fields['advgrp_rotate'];
        $adv_group  	= $rs->fields['advgrp_id'];
		$adv['help'] 	= true;		
		$adv['width'] 	= $rs->fields['adv_width'];
		$adv['height'] 	= $rs->fields['adv_height'];		
        if ( $adv_rotate == '1' ) {
            $sql    = "SELECT adv_id, adv_text FROM adv WHERE adv_group = " .intval($adv_group). "
                       AND adv_status = '1' ORDER BY adv_addtime ASC";
        } else {
            $sql    = "SELECT adv_id, adv_text FROM adv WHERE adv_group = " .intval($adv_group). "
                       AND adv_status = '1' LIMIT 1";
        }
        
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() > 0 ) {
            if ( $adv_rotate == '1' ) {
                $advs       = $rs->getrows();
                $adv_count  = count($advs)-1;
                $random     = rand(0, $adv_count);
                $adv['ad']  = $advs[$random]['adv_text'];
                $adv_id     = $advs[$random]['adv_id'];
            } else {
                $adv['ad']  = $rs->fields['adv_text'];
                $adv_id     = $rs->fields['adv_id'];
            }
            
            $sql    = "UPDATE adv SET adv_views = adv_views+1 WHERE adv_id = " .$adv_id. " LIMIT 1";
            $conn->execute($sql);
        }
    }
    
    return $adv;
}

function insert_age( $options )
{
    $birth_date = $options['bdate'];
    $birth_expl = explode('-', $birth_date);
    $year       = $birth_expl['0'];
    if ( $year != '0000' ) {
        return date('Y')-$year;
    }
    
    return '';
}

function insert_is_subscribed( $options )
{
    global $conn;

    $uid    = intval($options['UID']);
    $suid   = intval($options['SUID']);    
    $sql    = "SELECT UID FROM video_subscribe WHERE UID = " .$uid. " AND SUID = " .$suid. " LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return true;
    }
    
    return false;
}

function insert_is_friend( $options )
{
    global $conn;

    $uid    = intval($options['UID']);
    $fid    = intval($options['FID']);    
    $sql    = "SELECT UID FROM friends WHERE UID = " .$uid. " AND FID = " .$fid. "
               AND status = 'Confirmed' LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return true;
    }

    $sql    = "SELECT UID FROM friends WHERE UID = " .$fid. " AND FID = " .$uid. "
               AND status = 'Confirmed' LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return true;
    }
    
    return false;
}


function insert_check_friend( $options )
{
    global $conn;
    $uid     = intval($options['UID']);
    $user_id = intval($options['user_id']);    
    $sql     = "SELECT status FROM friends WHERE UID = " .$user_id. " AND FID = " .$uid. " LIMIT 1";
    $rs      = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->fields['status'].'_sent';
    } 
    $sql     = "SELECT status FROM friends WHERE UID = " .$uid. " AND FID = " .$user_id. " LIMIT 1";
    $rs      = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->fields['status'].'_received';
    } 	
    return false;
}

function insert_requests_count( $options )
{
    global $conn;
    
    $uid    = intval($options['UID']);
    $sql    = "SELECT COUNT(UID) AS total_requests FROM friends WHERE UID = " .$uid;
    $rs     = $conn->execute($sql);
    
    return $rs->fields['total_requests'];
}

function insert_mails_count( $options )
{
    global $conn;
    
    $username   = $options['username'];
    $sql        = "SELECT COUNT(mail_id) AS total_mails FROM mail
                   WHERE receiver = " .$conn->qStr($username). " AND status = '1' AND readed = '0'";
    $rs     = $conn->execute($sql);
    
    return $rs->fields['total_mails'];
}

function insert_is_blocked( $options )
{
    global $conn;
    
    $uid    = intval($options['UID']);
    $bid    = intval($options['BID']);
    $sql    = "SELECT UID FROM users_blocks WHERE UID = " .$uid. " AND BID = " .$bid. " LIMIT 1";
    $conn->execute($sql);    
    if ( $conn->Affected_Rows() == 1 ) {
        return true;
    }
    
    return false;
}

function insert_timer( $options )
{
    $timer  = VTimer::get($options['magic']);
    return 'Rendered in ' .$timer['time']. ', using ' .bytes($timer['memory']). ' memory!';
}

function bytes($bytes)
{
    $names  = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    $count  = 0;
    while($bytes >= 1024) {
        $bytes = $bytes/1024;
        ++$count;
    }

    return number_format($bytes, ($count ? 2 : 0), ',', '.'). ' ' .$names[$count];
}

function insert_load_plugin( $options )
{
	global $config;

	$page		= $options['page'];
	$plugin		= $options['plugin'];
	
	if ( isset($config['plugin_' .$plugin]) && $config['plugin_' .$plugin] == '1' ) {
		$plugin_file = $config['BASE_DIR']. '/plugins/'. $page. '_' .$plugin. '/' .$plugin. '.php';
		if ( file_exists($plugin_file) ) {
			$plugin_call = 'plugin_' .$page. '_' .$plugin;
			if ( !function_exists($plugin_call) ) {
				require $plugin_file;
			}
			
			$plugin_call();
		}
	}
}

function insert_thumb($options)
{
	global $config;
	
	$vid 	= $options['vid'];
	$thumb	= $options['thumb'];
	$thumbs = ($options['thumbs'] === 0) ? 20 : (int) $options['thumbs'];

	$index = intval( ($vid - 1) / $config['max_thumb_folders'] );
	$tmb_folder = 'tmb';
	if ($index !== 0) {
		$tmb_folder = 'tmb'.$index;
	}	

	$path = $config['BASE_URL'].'/media/videos/'.$tmb_folder.'/'.$vid;
	$path_dir = $config['BASE_DIR'].'/media/videos/'.$tmb_folder.'/'.$vid;
	
	$output = array();
	$output[] = '<div class="row">';	
	for ($i=1; $i<=$thumbs; $i++) {
		$tmb = $path_dir.'/'.$i.'.jpg';
		if (file_exists($tmb) && is_file($tmb)) {
			$class    = ($thumb == $i) ? 'tmb-active img-responsive' : 'tmb img-responsive';
			$output[] = '<div class="col-xs-6 col-sm-3  m-b-10">';
			$output[] = '<img src="'.$path.'/'.$i.'.jpg" id="select_tmb_' .$vid. '_' .$i. '" class="' .$class. '">';
			$output[] = '</div>';
		}
	}
	$output[] = '</div>';	
	return implode("\n", $output);
}

function insert_thumb_path($options)
{
	global $config;
	
	$vid   = $options['vid'];
	$index = intval( ($vid - 1) / $config['max_thumb_folders'] );
	$tmb_folder = 'tmb';
	if ($index !== 0) {
		$tmb_folder = 'tmb'.$index;
	}

	$output = $config['BASE_URL'].'/media/videos/'.$tmb_folder.'/'.$vid;

	return $output;
}

function insert_thumb_adm($options)
{
	global $config;
	
	$vid 	= $options['vid'];
	$thumb	= $options['thumb'];

	$index = intval( ($vid - 1) / $config['max_thumb_folders'] );
	$tmb_folder = 'tmb';
	if ($index !== 0) {
		$tmb_folder = 'tmb'.$index;
	}	

	$path = $config['BASE_URL'].'/media/videos/'.$tmb_folder.'/'.$vid;
	$path_dir = $config['BASE_DIR'].'/media/videos/'.$tmb_folder.'/'.$vid;
	
	$output = array();

	$tmb = $path_dir.'/'.$thumb.'.jpg';
	$tmb_url = $path.'/'.$thumb.'.jpg';
	$tmb_url_def = $config['BASE_URL'].'/media/videos/tmb/default.jpg';
	if (file_exists($tmb) && is_file($tmb)) {
		return $tmb_url;	
	} else {
		return $tmb_url_def;
	}
}

function insert_comment_output ( $options )
{
	global $config, $conn;	
	$comment = $options['comment'];
	
	if (preg_match_all('/\[photo=(.*?)\]/', $comment, $matches_photo)) {	
		foreach($matches_photo[0] as $k => $v) {
			$sql        = "SELECT PID FROM photos WHERE PID = " .intval($matches_photo[1][$k]). " AND status = '1' LIMIT 1";
			$rs         = $conn->execute($sql);
			if ( $conn->Affected_Rows() == 1 ) {
				$comment = str_replace($v, '<div class="row justify-content-center"><div class="col-md-6"><img src="' .$config['BASE_URL']. '/media/photos/'.intval($matches_photo[1][$k]).'.jpg" alt="" /></div></div>', $comment);
			} else {
				$comment = str_replace($v, '<div class="row"><i class="fas fa-exclamation-circle"></i></div>', $comment);
			}
		}
	}
	unset($matches_photo);	
	
	if (preg_match_all('/\[video=(.*?)\]/', $comment, $matches_video)) {	
		foreach($matches_video[0] as $k => $v) {
			$sql        = "SELECT VID FROM video WHERE VID = " .intval($matches_video[1][$k]). " AND active = '1' AND type='public' LIMIT 1";
			$rs         = $conn->execute($sql);
			if ( $conn->Affected_Rows() == 1 ) {			
				$comment = str_replace($v, '<div class="row justify-content-center"><div class="col-md-6"><div><iframe src="' .$config['BASE_URL'].'/view.php?VID='.intval($matches_video[1][$k]).'" frameborder="0" allowfullscreen></iframe></div></div></div>', $comment);
			} else {
				$comment = str_replace($v, '<div class="row"><i class="fas fa-exclamation-circle"></i></div>', $comment);
			}
		}
	}
	unset($matches_video);	
	
	return $comment;
}

function insert_total_replies ( $options )
{
	global $conn;	
	$CID  			= $options['cid'];
	$type 			= $options['type'];	
	$prefix			= substr(ucfirst($type),0,1);	
	$sql            = "SELECT COUNT(CID) AS total_replies FROM ".$type."_comments WHERE PARENT_ID = " .$CID. " AND status = '1'";
	$rsc            = $conn->execute($sql);
	$total_replies 	= $rsc->fields['total_replies'];		
	return $total_replies;
}

?>

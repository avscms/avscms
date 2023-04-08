<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['video_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

//$conn->debug = true;

function construct_vote( $likes, $dislikes )
{
	$output     = array();
    $output[]   = '<div class="pull-left">';
    $output[]   = '<i class="glyphicon glyphicon-thumbs-up"></i> <span id="video_likes" class="text-white">' .$likes. '</span>';
    $output[]   = '</div>';
    $output[]   = '<div class="pull-right">';
    $output[]   = '<i class="glyphicon glyphicon-thumbs-down"></i> <span id="video_dislikes" class="text-white">' .$dislikes. '</span>';
    $output[]   = '</div>';
    $output[]   = '<div class="clearfix"></div>';
    
    return implode("\n", $output);
}

$data           = array('msg' => '', 'rate' => 0, 'likes' => 0, 'dislikes' => 0, 'debug' => '');
if ( isset($_POST['item_id']) && isset($_POST['vote']) ) {
    $allowed        = false;
    $filter         = new VFilter();
    $video_id       = $filter->get('item_id', 'INTEGER');
    $vote           = $filter->get('vote', 'STRING');
    
    $sql            = "SELECT rate, likes, dislikes FROM video WHERE VID = " .$video_id. " LIMIT 1";
	
    $rs             = $conn->execute($sql);
    $rate           = $rs->fields['rate'];
    $likes          = $rs->fields['likes'];
    $dislikes       = $rs->fields['dislikes'];

    
    if ( $config['video_rate'] == 'user' ) {
        if ( isset($_SESSION['uid']) ) {
            $uid        = intval($_SESSION['uid']);
            $allowed    = true;
        }
    } else {
        $allowed        = true;
    }
    

    if ( $allowed ) {
        if ( $config['video_rate'] == 'user' ) {
            $sql    = "SELECT VID FROM video_vote_users WHERE VID = '" .$video_id. "' AND UID = '" .$uid. "' LIMIT 1";
            $data['debug'] = $sql;
        } else { 
            $user_ip = getUserIP();
            $ip     = ip2long($user_ip);
            $sql    = "SELECT VID FROM video_vote_ip WHERE VID = '" .$video_id. "' AND ip = '" .$ip. "' LIMIT 1";
        }
        
        $conn->execute($sql);
        
        if ( $conn->Affected_Rows() > 0 ) {
            $data['msg']    = $lang['ajax.rate_already'];
        } else {

			if ($vote == 'like') {
				$likes++;
				$rate = round(($likes * 100)/($likes + $dislikes));
			}
			else {
				$dislikes++;
				$rate = round(($likes * 100)/($likes + $dislikes));
			}
				
            $sql            = "UPDATE video SET rate = " .$rate. ", likes = " .$likes. ", dislikes = " .$dislikes. " WHERE VID = " .$video_id. " LIMIT 1";
			
            $data['debug'] = $sql;
            $conn->execute($sql);
			
            if ( $config['video_rate'] == 'user' ) {
                $sql    = "INSERT INTO video_vote_users VALUES ($video_id, $uid )";
            } else {
                $sql    = "INSERT INTO video_vote_ip VALUES ($video_id, $ip)";
            }
            $conn->execute($sql);
        }
    
    } else {
        $data['msg']            = '<a data-toggle="modal" href="#login-modal">'.$lang['ajax.rate_login'].'</a>';
    }

    $data['rate']        = $rate;
    $data['likes']       = $likes;
	$data['dislikes']    = $dislikes;	
	$data['construct']   = construct_vote($likes, $dislikes);
	//$data['user_ip'] = $user_ip;
}

function getUserIP() {
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = $_SERVER['REMOTE_ADDR'];

	if(filter_var($client, FILTER_VALIDATE_IP)) { $ip = $client; }
	elseif(filter_var($forward, FILTER_VALIDATE_IP)) { $ip = $forward; }
	else { $ip = $remote; }

	return $ip;
}
echo json_encode($data);
die();
?>

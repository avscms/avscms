<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['photo_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

function construct_vote( $likes, $dislikes )
{
	$output     = array();
    $output[]   = '<div class="pull-left">';
    $output[]   = '<i class="glyphicon glyphicon-thumbs-up"></i> <span id="photo_likes" class="text-white">' .$likes. '</span>';
    $output[]   = '</div>';
    $output[]   = '<div class="pull-right">';
    $output[]   = '<i class="glyphicon glyphicon-thumbs-down"></i> <span id="photo_dislikes" class="text-white">' .$dislikes. '</span>';
    $output[]   = '</div>';
    $output[]   = '<div class="clearfix"></div>';
    
    return implode("\n", $output);
}

$data           = array('msg' => '', 'rate' => 0, 'likes' => 0, 'dislikes' => 0, 'debug' => '');
if ( isset($_POST['item_id']) && isset($_POST['vote']) ) {
    $allowed        = false;
    $filter         = new VFilter();
    $photo_id       = $filter->get('item_id', 'INTEGER');
    $vote           = $filter->get('vote', 'STRING');
    
    $sql            = "SELECT p.rate, p.likes, p.dislikes, a.rate AS arate, a.likes AS alikes, a.dislikes AS adislikes FROM photos AS p, albums AS a
                       WHERE p.PID = " .$photo_id. " AND a.AID = p.AID LIMIT 1";
    $rs             = $conn->execute($sql);
    $rate           = $rs->fields['rate'];
    $likes          = $rs->fields['likes'];
    $dislikes       = $rs->fields['dislikes'];
    $arate          = $rs->fields['arate'];
    $alikes          = $rs->fields['alikes'];
    $adislikes       = $rs->fields['adislikes'];

    
    if ( $config['photo_rate'] == 'user' ) {
        if ( isset($_SESSION['uid']) ) {
            $uid        = intval($_SESSION['uid']);
            $allowed    = true;
        }
    } else {
        $allowed    = true;
    }
    
    if ( $allowed ) {
        if ( $config['photo_rate'] == 'user' ) {
            $sql    = "SELECT PID FROM photo_rating_id WHERE PID = " .$photo_id. " AND UID = " .$uid. " LIMIT 1";
        } else {
            $sql    = "SELECT PID FROM photo_rating_ip WHERE PID = " .$photo_id. " AND ip = " .ip2long($_SERVER['REMOTE_ADDR']). " LIMIT 1";
        }
        
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $data['msg']    = $lang['ajax.rate_already'];
        } else {

			if ($vote == 'like') {
				$likes++;
				$rate = round(($likes * 100)/($likes + $dislikes));
				
				$alikes++;
				$arate = round(($alikes * 100)/($alikes + $adislikes));
			}
			else {
				$dislikes++;
				$rate = round(($likes * 100)/($likes + $dislikes));
				
				$adislikes++;
				$arate = round(($alikes * 100)/($alikes + $adislikes));		
			}
				
            $sql            = "UPDATE photos AS p, albums AS a
                               SET p.rate = " .$rate. ", p.likes = " .$likes. ", p.dislikes = " .$dislikes. ", 
                                   a.rate = " .$arate. ", a.likes = " .$alikes. ", a.dislikes = " .$adislikes. " 
                               WHERE p.PID = " .$photo_id. " AND p.AID = a.AID";
            $data['debug'] = $sql;
            $conn->execute($sql);
            if ( $config['photo_rate'] == 'user' ) {
                $sql    = "INSERT INTO photo_rating_id SET PID = " .$photo_id. ", UID = " .$uid;
            } else {
                $sql    = "INSERT INTO photo_rating_ip SET PID = " .$photo_id. ", ip = " .ip2long($_SERVER['REMOTE_ADDR']);
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
}

echo json_encode($data);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['video_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data           = array('status' => 0, 'msg' => '', 'rate' => 0, 'likes' => 0, 'dislikes' => 0, 'debug' => '');

if ( isset($_POST['type']) && isset($_POST['id']) && isset($_POST['vote'])) {


    $filter   = new VFilter();
    $id      = $filter->get('id', 'INTEGER');
    $type     = $filter->get('type', 'STRING');	
    $vote     = $filter->get('vote', 'STRING');
	$prefix	  = substr(ucfirst($type),0,1);	    	

	switch ($type) {
		case 'user':
			$table   = 'signup';
			$prefix_r  = 'R';			
			break;
		case 'video':
			$table 	 = 'video';
			$prefix_r  = 'V';			
			break;
		case 'photo':
			$table   = 'photos';
			$prefix_r  = 'P';						
			break;		
	}

	$sql            = "SELECT rate, likes, dislikes FROM ".$table." WHERE ".$prefix."ID = " .$id. " LIMIT 1";
	$rs             = $conn->execute($sql);
    $rate           = $rs->fields['rate'];
    $likes          = $rs->fields['likes'];
    $dislikes       = $rs->fields['dislikes'];


    if ( $config[$type.'_rate'] == 'user' ) {
		if ( isset($_SESSION['uid']) ) {
			$uid = intval($_SESSION['uid']);
            $sql = "SELECT ".$prefix_r."ID FROM ".$type."_rating_id WHERE ".$prefix_r."ID = " .$id. " AND UID = " .$uid. " LIMIT 1";		
			$conn->execute($sql);
			if ( $conn->Affected_Rows() == 1 ) {
				$data['msg'] = $lang['ajax.rate_already'];
			} else {
				if ($vote == 'up') {
					$likes++;
					$rate = round(($likes * 100)/($likes + $dislikes));
				} else {
					$dislikes++;
					$rate = round(($likes * 100)/($likes + $dislikes));
				}
				$sql = "UPDATE ".$table." SET rate = " .$rate. ", likes = " .$likes. ", dislikes = " .$dislikes. " WHERE ".$prefix."ID = " .$id. " LIMIT 1";		
				$conn->execute($sql);
                $sql = "INSERT INTO ".$type."_rating_id SET ".$prefix_r."ID = " .$id. ", UID = " .$uid;
				$conn->execute($sql);				
				$data['status'] = 1;
				$data['vote'] = $vote;
				$data['rate'] = $rate;
			}				
		} else {
			$data['msg'] = $lang['ajax.rate_login'];			
		}
	} else {
		if ($prefix_r  == 'R') {
			$prefix_r = 'U';
		}
		
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
			$ip = ip2long(array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));		
		} else{
			//Otherwise, use REMOTE_ADDR.
			$ip = ip2long($_SERVER['REMOTE_ADDR']);
		}
		
		$sql = "SELECT ".$prefix_r."ID FROM ".$type."_rating_ip WHERE ".$prefix_r."ID = " .$id. " AND ip = " .$ip. " LIMIT 1";		
		$conn->execute($sql);
		if ( $conn->Affected_Rows() == 1 ) {
			$data['msg'] = $lang['ajax.rate_already'];
		} else {
			if ($vote == 'up') {
				$likes++;
				$rate = round(($likes * 100)/($likes + $dislikes));
			} else {
				$dislikes++;
				$rate = round(($likes * 100)/($likes + $dislikes));
			}
			$sql = "UPDATE ".$table." SET rate = " .$rate. ", likes = " .$likes. ", dislikes = " .$dislikes. " WHERE ".$prefix."ID = " .$id. " LIMIT 1";	
			$conn->execute($sql);
			$sql = "INSERT INTO ".$type."_rating_ip SET ".$prefix_r."ID = " .$id. ", ip = " .$ip;
			$conn->execute($sql);				
			$data['status'] = 2;
			$data['vote'] = $vote;
			$data['rate'] = $rate;
		}		
	}
}
$data['likes']	  = $likes;
$data['dislikes'] = $dislikes;			
echo json_encode($data);
die();
?>

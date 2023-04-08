<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['video_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data           = array('status' => 0, 'msg' => '', 'rate' => 0, 'debug' => '');

if ( isset($_POST['type']) && isset($_POST['id']) && isset($_POST['vote'])) {

    $filter   = new VFilter();
    $cid      = $filter->get('id', 'INTEGER');
    $type     = $filter->get('type', 'STRING');	
    $vote     = $filter->get('vote', 'STRING');
	$prefix	  = substr(ucfirst($type),0,1);	    
	
    $sql            = "SELECT rate FROM ".$type."_comments WHERE CID = " .$cid. " LIMIT 1";
    $rs             = $conn->execute($sql);
    $rate           = $rs->fields['rate'];


    if ( $config['comment_rate'] == 'user' ) {
		if ( isset($_SESSION['uid']) ) {
			$uid = intval($_SESSION['uid']);
            $sql = "SELECT CID FROM ".$type."_comments_vote_users WHERE CID = " .$cid. " AND UID = " .$uid. " LIMIT 1";		
			$conn->execute($sql);
			if ( $conn->Affected_Rows() == 1 ) {
				$data['msg'] = $lang['ajax.rate_already'];
			} else {
				if ($vote == 'up') {
					++$rate;
				} else {
					--$rate;
				}
				$sql = "UPDATE ".$type."_comments SET rate = " .$rate. " WHERE CID = " .$cid. " LIMIT 1";		
				$conn->execute($sql);
                $sql = "INSERT INTO ".$type."_comments_vote_users SET CID = " .$cid. ", UID = " .$uid;
				$conn->execute($sql);				
				$data['status'] = 1;
				$data['vote'] = $vote;
				$data['rate'] = $rate;
			}				
		} else {
			$data['msg'] = $lang['ajax.rate_login'];			
		}
	} else {
		$ip  = ip2long($_SERVER['REMOTE_ADDR']);
		$sql = "SELECT CID FROM ".$type."_comments_vote_ip WHERE CID = " .$cid. " AND ip = " .$ip. " LIMIT 1";		
		$conn->execute($sql);
		if ( $conn->Affected_Rows() == 1 ) {
			$data['msg'] = $lang['ajax.rate_already'];
		} else {
			if ($vote == 'up') {
				++$rate;
			} else {
				--$rate;
			}
			$sql = "UPDATE ".$type."_comments SET rate = " .$rate. " WHERE CID = " .$cid. " LIMIT 1";
			$conn->execute($sql);
			$sql = "INSERT INTO ".$type."_comments_vote_ip SET CID = " .$cid. ", ip = " .$ip;
			$conn->execute($sql);				
			$data['status'] = 2;
			$data['vote'] = $vote;
			$data['rate'] = $rate;
		}		
	}
}

echo json_encode($data);
die();
?>

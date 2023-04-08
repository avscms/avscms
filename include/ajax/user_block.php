<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data = array('status' => 0, 'msg' => '');
if ( isset($_POST['user_id']) && isset($_POST['action'])) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $uid        = intval($_SESSION['uid']);
        $user_id    = $filter->get('user_id', 'INTEGER');
        $action     = $filter->get('action', 'STRING');		
		if ($action == 'Block') {
			if ( $uid == $user_id ) {
				$data['msg'] = $lang['ajax.block_user_self'];
			} else {
				$sql        = "SELECT UID FROM users_blocks WHERE UID = " .$uid. " AND BID = " .$user_id. " LIMIT 1";
				$conn->execute($sql);
				if ( $conn->Affected_Rows() == 1 ) {
					$data['msg'] = 'This user is already blocked!';
				} else {
					$sql    = "INSERT INTO users_blocks (UID, BID) VALUES (" .$uid. ", " .$user_id. ")";
					$conn->execute($sql);
					$sql    = "UPDATE signup SET popularity = popularity-3 WHERE UID = " .$user_id. " LIMIT 1";
					$conn->execute($sql);
					$data['msg'] = $lang['ajax.block_user_success'];
					$data['status'] = 1;
				}
				$sql = "SELECT UID FROM friends WHERE ((UID = " .$uid. " AND FID = " .$user_id. ") OR (UID = " .$user_id. " AND FID = " .$uid. ")) AND status = 'Confirmed' LIMIT 1";
				$conn->execute($sql);
				if ( $conn->Affected_Rows() == 1 ) {
					$sql        = "DELETE FROM friends WHERE UID = " .$user_id. " AND FID = " .$uid. " LIMIT 1";
					$conn->execute($sql);
					$sql		= "DELETE FROM friends WHERE UID = ".$uid." AND FID = ".$user_id." LIMIT 1";
					$conn->execute($sql);
					$sql		= "UPDATE signup SET total_friends = total_friends-1 WHERE UID = ".$uid." LIMIT 1";
					$conn->execute($sql);
					$sql		= "UPDATE signup SET total_friends = total_friends-1 WHERE UID = ".$user_id." LIMIT 1";
					$conn->execute($sql);				
				} else {
					$sql        = "DELETE FROM friends WHERE UID = " .$user_id. " AND FID = " .$uid. " LIMIT 1";
					$conn->execute($sql);
					$sql		= "DELETE FROM friends WHERE UID = ".$uid." AND FID = ".$user_id." LIMIT 1";
					$conn->execute($sql);					
				}
			}
		} else {
			if ( $uid == $user_id ) {
				$data['msg']   = $lang['ajax.block_user_self'];
			} else {
				$sql        = "SELECT UID FROM users_blocks WHERE UID = " .$uid. " AND BID = " .$user_id. " LIMIT 1";
				$conn->execute($sql);
				if ( $conn->Affected_Rows() == 0 ) {
					$data['msg'] = $lang['user.already_unblocked'];
				} else {
					$sql        = "DELETE FROM users_blocks WHERE UID = " .$uid. " AND BID = " .$user_id. " LIMIT 1";
					$conn->execute($sql);
					$data['msg'] = $lang['ajax.unblock_user_success'];
					$data['status'] = 1;
				}
			}			
		}
    } else {
        $data['msg'] =  $lang['ajax.block_user_login'];
    }
}

echo json_encode($data);
die();
?>

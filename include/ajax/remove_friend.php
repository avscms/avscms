<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/compat/json.php';

$data = array('status' => 0, 'msg' => '');
if ( isset($_POST['user_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $uid        = intval($_SESSION['uid']);
        $user_id    = $filter->get('user_id', 'INTEGER');
        if ( $uid == $user_id ) {
            $data['msg']   = show_err($lang['ajax.remove_friend_self']);
        } else {
            $sql        = "DELETE FROM friends WHERE UID = " .$user_id. " AND FID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
			$sql		= "DELETE FROM friends WHERE UID = ".$uid." AND FID = ".$user_id." LIMIT 1";
			$conn->execute($sql);
			$sql		= "UPDATE signup SET total_friends = total_friends-1 WHERE UID = ".$uid." LIMIT 1";
			$conn->execute($sql);
			$sql		= "UPDATE signup SET total_friends = total_friends-1 WHERE UID = ".$user_id." LIMIT 1";
			$conn->execute($sql);			
			$data['status'] = 1;
			$data['msg'] = show_msg($lang['ajax.remove_friend_success']);
        }
    } else {
        $data['msg'] = show_err($lang['ajax.remove_friend_login']);
    }
} else {
	$data['msg'] = show_err('Invalid request!?');
}

echo json_encode($data);
die();
?>

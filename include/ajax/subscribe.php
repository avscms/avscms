<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/compat/json.php';

$data = array('status' => 0, 'msg' => '');
if ( isset($_POST['user_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $uid        = intval($_SESSION['uid']);
        $filter     = new VFilter();
        $user_id    = $filter->get('user_id', 'INTEGER');
        if ( $uid == $user_id ) {
			$data['msg'] = 
            $message    = show_err($lang['ajax.subscribe_self']);
        } else {
            $sql        = "SELECT UID FROM video_subscribe WHERE UID = " .$user_id. " AND SUID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $message    = $lang['ajax.subscribe_exists'];
            } else {
                $sql        = "INSERT INTO video_subscribe (UID, SUID, subscribe_date)  VALUES (" .$user_id. "," .$uid. ", '" .date('Y-m-d'). "')";
                $conn->execute($sql);
                $sql        = "UPDATE signup SET popularity = popularity+1 WHERE UID = " .$user_id. " LIMIT 1";
                $conn->execute($sql);
                $sql        = "UPDATE signup SET points = points+1 WHERE UID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
				$data['status'] = 1;
				$data['msg'] = show_msg($lang['ajax.subscribe_success']);
			}
        }
    } else {
        $data['msg'] = show_err($lang['ajax.subscribe_login']);
    }
} else {
	$data['msg'] = show_err('Invalid request!?');
}

echo json_encode($data);
die();
?>

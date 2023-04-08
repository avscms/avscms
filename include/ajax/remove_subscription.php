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
            $data['msg']    = 'Invalid request!?';
        } else {
            $sql        = "SELECT UID FROM video_subscribe WHERE UID = " .$user_id. " AND SUID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() != 1 ) {
                $data['msg']    = $lang['ajax.remove_subs_exists'];
            } else {
                $sql        = "DELETE FROM video_subscribe WHERE UID = " .$user_id. " AND SUID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
                $sql        = "UPDATE signup SET popularity = popularity-1, points = points-2 WHERE UID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
				$data['status'] = 1;
				$data['msg'] = show_msg($lang['ajax.remove_subs_success']);
            }
        }
    } else {
        $data['msg'] = show_err($lang['ajax.remove_subs_login']);
    }
} else {
	$data['msg'] = show_err('Invalid request!');
}

echo json_encode($data);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data = array('status' => 0, 'msg' => '', 'debug' => '');
if ( isset($_POST['user_id']) && isset($_POST['other']) && isset($_POST['reason']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $uid        = intval($_SESSION['uid']);
        $user_id    = $filter->get('user_id', 'INTEGER');
        $reason     = $filter->get('reason');
        $other      = $filter->get('other');
        
        if ( $uid == $user_id ) {
            $data['msg']   = $lang['ajax.report_user_self'];
        } else {
            $sql        = "INSERT INTO users_flags (UID, RID, reason, message, addtime)
                           VALUES (" .$user_id. ", " .$uid. ", " .$conn->qStr($reason). ",
                                   " .$conn->qStr($other). ", '" .time(). "')";
            $conn->execute($sql);
            $data['status'] = 1;
			$data['msg'] = $lang['ajax.report_user_success'];
        }
    } else {
        $data['msg'] = $lang['ajax.report_user_login'];
    }
}

echo json_encode($data);
die();
?>

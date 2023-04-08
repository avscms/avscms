<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require_once $config['BASE_DIR']. '/include/config.local.php';

$data   = array('status' => 0, 'msg' => '', 'debug' => '');
if ( isset($_POST['item_id']) && isset($_POST['flag_id']) && isset($_POST['message']) ) {
    $filter         = new VFilter();
    $video_id       = $filter->get('item_id', 'INTEGER');
    $flag_id        = $filter->get('flag_id');
    $flag_message   = $filter->get('message');
    if ( isset($_SESSION['uid']) ) {
        $uid    = intval($_SESSION['uid']);
        if ( strlen($flag_id) > 14 ) {
            $data['msg'] = $lang['ajax.flag_invalid'];
        } else {
            $sql         = "SELECT VID FROM video_flags WHERE VID = " .$video_id. " AND UID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $data['msg'] = $lang['ajax.flag_video_exists'];
            } else {
                $sql     = "INSERT INTO video_flags (VID, UID, reason, message, add_date)
                            VALUES (" .$video_id. ", " .$uid. ", " .$conn->qStr($flag_id). ",
                                    " .$conn->qStr($flag_message). ", '" .date('Y-m-d'). "')";
                $conn->execute($sql);
                $data['status'] = 1;
                $data['msg']    = $lang['ajax.flag_video_success'];

		
            }
        }
    } else {
        $data['msg'] = $lang['ajax.flag_video_login'];
    }
}

echo json_encode($data);
die();
?>

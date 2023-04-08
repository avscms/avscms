<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['photo_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'msg' => '', 'debug' => '');
if ( isset($_POST['item_id']) && isset($_POST['flag_id']) && isset($_POST['message']) ) {
    $filter         = new VFilter();
    $photo_id       = $filter->get('item_id', 'INTEGER');
    $flag_id        = $filter->get('flag_id');
    $flag_message   = $filter->get('message');
    if ( isset($_SESSION['uid']) ) {
        $uid    = intval($_SESSION['uid']);
        if ( strlen($flag_id) > 14 ) {
            $data['msg'] = $lang['ajax.flag_invalid'];
        } else {
            $sql         = "SELECT PID FROM photo_flags WHERE PID = " .$photo_id. " AND UID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $data['msg'] = $lang['ajax.flag_photo_exists'];
            } else {
                $sql     = "INSERT INTO photo_flags (PID, UID, reason, message, add_date)
                            VALUES (" .$photo_id. ", " .$uid. ", " .$conn->qStr($flag_id). ",
                                    " .$conn->qStr($flag_message). ", '" .date('Y-m-d'). "')";
                $data['debug'] = $sql;
                $conn->execute($sql);
                $data['status'] = 1;
                $data['msg']    = $lang['ajax.flag_photo_success'];
            }
        }
    } else {
        $data['msg'] = $lang['ajax.flag_photo_login'];
    }
}

echo json_encode($data);
die();
?>

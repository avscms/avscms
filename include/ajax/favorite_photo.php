<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['photo_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'msg' => '');
if ( isset($_POST['photo_id']) && isset($_POST['album_id']) ) {
    $filter     = new VFilter();
    $photo_id   = $filter->get('photo_id', 'INTEGER');
    $album_id   = $filter->get('album_id', 'INTEGER');
    if ( isset($_SESSION['uid']) ) {
        $uid            = intval($_SESSION['uid']);
        $sql            = "SELECT PID FROM photo_favorites WHERE PID = " .$photo_id. " AND UID = " .$uid. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $data['msg']    = $lang['ajax.favorite_photo_exists'];
        } else {
            $sql        = "SELECT PID FROM photos WHERE PID = " .$photo_id. " AND UID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $data['msg']    = $lang['ajax.favorite_photo_self'];
            } else {
                $sql    = "INSERT INTO photo_favorites SET PID = " .$photo_id. ", UID = " .$uid;
                $conn->execute($sql);
                $sql    = "UPDATE photos SET total_favorites = total_favorites+1 WHERE PID = " .$photo_id. " LIMIT 1";
                $conn->execute($sql);
                $sql    = "UPDATE albums SET total_favorites = total_favorites+1 WHERE AID = " .$album_id. " LIMIT 1";
                $conn->execute($sql);
                $data['msg']    = $lang['ajax.favorite_photo_success'];
                $data['status'] = 1;
            }
        }
    } else {
        $data['msg']        = $lang['ajax.favorite_photo_login'];
    }
}

echo json_encode($data);
die();
?>

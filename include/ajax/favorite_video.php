<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'msg' => '');
if ( isset($_POST['video_id']) ) {
    $filter         = new VFilter();
    $video_id       = $filter->get('video_id', 'INTEGER');
    if ( isset($_SESSION['uid']) ) {
        $sql            = "SELECT VID FROM favourite WHERE VID = " .$video_id. " AND UID = " .intval($_SESSION['uid']). " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $data['msg']    = $lang['ajax.favorite_video_exists'];
        } else {
            $sql        = "SELECT VID FROM video WHERE VID = " .$video_id. " AND UID = " .intval($_SESSION['uid']). " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $data['msg']    = $lang['ajax.favorite_video_self'];
            } else {
                $sql    = "INSERT INTO favourite SET VID = " .$video_id. ", UID = " .intval($_SESSION['uid']);
                $conn->execute($sql);
                $sql    = "UPDATE video SET fav_num = fav_num+1 WHERE VID = " .$video_id. " LIMIT 1";
                $conn->execute($sql);
                $data['msg']    = $lang['ajax.favorite_video_success'];
                $data['status'] = 1;
            }
        }
    } else {
        $data['msg']    = $lang['ajax.favorite_video_login'];
    }
}

echo json_encode($data);
die();
?>

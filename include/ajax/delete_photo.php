<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['photo_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$response = array('status' => 0, 'msg' => '', 'debug' => '');
if ( isset($_POST['photo_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $pid        = $filter->get('photo_id', 'INTEGER');                
        $uid        = intval($_SESSION['uid']);
        $sql        = "SELECT a.AID, a.UID FROM photos AS p, albums AS a
                       WHERE p.PID = " .$pid. " AND p.AID = a.AID
                       LIMIT 1";
        $response['debug'] = $sql;
        $rs         = $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $album  = $rs->getrows();
            $album  = $album['0'];
            if ( $album['UID'] == $uid ) {
                $tables = array('photos', 'photo_favorites', 'photo_comment', 'photo_flags', 'photo_rating_id', 'photo_rating_ip');
                foreach ($tables as $table) {
                    $sql    = "DELETE FROM " .$table. " WHERE PID = " .$pid. " LIMIT 1";
                    $conn->execute($sql);
                }
				
				$file = $config['BASE_DIR'].'/media/photos/'.$pid.'.jpg';
				if ( file_exists($file) ) {
					@chmod($file, 0777);
					@unlink($file);
				}
				
				$file = $config['BASE_DIR'].'/media/photos/tmb/'.$pid.'.jpg';
				if ( file_exists($file) ) {
					@chmod($file, 0777);
					@unlink($file);
				}				
				
                $sql    = "UPDATE albums SET total_photos = total_photos-1 WHERE AID = " .$album['AID']. " LIMIT 1";
                $conn->execute($sql);
                $response['status'] = 1;
				$response['msg'] = $lang['ajax.delete_photo_success'];
            } else {
                $response['msg'] = $lang['ajax.delete_photo_failed'];
            }
        } else {
            $response['msg'] = $lang['ajax.delete_photo_failed'];
        }
        
        $sql        = "DELETE FROM photo_favorites WHERE UID = " .$uid. " AND PID = " .$pid. " LIMIT 1";
        $conn->execute($sql);
    } else {
        $response['msg']   = $lang['ajax.delete_photo_login'];
    }
}

echo json_encode($response);
die();
?>

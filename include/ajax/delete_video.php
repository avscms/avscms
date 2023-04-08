<?php

defined('_VALID') or die('Restricted Access!');

if ( $config['video_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/include/function_user.php';


$response = array('status' => 0, 'msg' => '', 'debug' => '');
if ( isset($_POST['video_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $vid        = $filter->get('video_id', 'INTEGER');

        $uid        = intval($_SESSION['uid']);
        $sql        = "SELECT UID FROM video WHERE VID = " .$vid. " LIMIT 1";
        $rs         = $conn->execute($sql);
	   
       if ( $conn->Affected_Rows() === 1 ) { 
           $video  = $rs->getrows();
			if ($uid == $video[0][0]) {
				deleteVideo( $vid );
				$response['status'] = 1;
				$response['msg'] = $lang['ajax.delete_video_success'];
           } else {
                $response['msg'] = $lang['ajax.delete_video_failed'];
           }
		} else {
			$response['msg'] = $lang['ajax.delete_video_failed'];
        } 
       
    } else {
		$response['msg']   = $lang['ajax.delete_video_login'];
    }
}

echo json_encode($response);
die();
?>

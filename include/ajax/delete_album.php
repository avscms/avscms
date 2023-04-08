<?php

defined('_VALID') or die('Restricted Access!');

if ( $config['album_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_user.php';


$response = array('status' => 0, 'msg' => '', 'debug' => '');
if ( isset($_POST['album_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $aid        = $filter->get('album_id', 'INTEGER');

        $uid        = intval($_SESSION['uid']);
        $sql        = "SELECT UID FROM albums WHERE AID = " .$aid. " LIMIT 1";
        $rs         = $conn->execute($sql);
	   
       if ( $conn->Affected_Rows() === 1 ) { 
           $album  = $rs->getrows();
			if ($uid == $album[0][0]) {
				deleteAlbum( $aid );
				$response['status'] = 1;
				$response['msg'] = $lang['ajax.delete_album_success'];
           } else {
                $response['msg'] = $lang['ajax.delete_album_failed'];
           }
		} else {
			$response['msg'] = $lang['ajax.delete_album_failed'];
        } 
       
    } else {
		$response['msg']   = $lang['ajax.delete_album_login'];
    }
}

echo json_encode($response);
die();
?>

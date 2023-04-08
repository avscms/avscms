<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['photo_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/compat/json.php';

$data = array('status' => 0, 'msg' => '');
if ( isset($_POST['photo_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $pid        = $filter->get('photo_id', 'INTEGER');
        $uid        = intval($_SESSION['uid']);
        $sql        = "DELETE FROM photo_favorites WHERE UID = " .$uid. " AND PID = " .$pid. " LIMIT 1";
        $conn->execute($sql);
		$data['status'] = 1;
		$data['msg'] = $lang['ajax.remove_fav_photo_success'];
    } else {
        $response   = $lang['ajax.remove_fav_photo_login'];
    }
} else {
	$data['msg'] = 'Invalid request!?';
}

echo json_encode($data);
die();
?>

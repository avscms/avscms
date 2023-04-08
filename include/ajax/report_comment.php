<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('msg' => '', 'status' => 0, 'debug' => '');
if ( isset($_POST['type']) && isset($_POST['parent_id']) && isset($_POST['comment_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $uid        = intval($_SESSION['uid']);
        $type       = $filter->get('type');
        $cid        = $filter->get('comment_id', 'INTEGER');
        $pid        = $filter->get('parent_id', 'INTEGER');
		$sql 		= "SELECT UID FROM spam WHERE UID = " .$uid. " AND type = " .$conn->qStr($type). " AND comment_id = " .$cid. " AND parent_id = " .$pid. " LIMIT 1";
		$conn->execute($sql);
		if ( $conn->Affected_Rows() == 1 ) {
			$data['msg'] = $lang['ajax.report_spam_already'];
		} else {
			$sql        = "INSERT INTO spam (UID, type, comment_id, parent_id, addtime)
						   VALUES (" .$uid. ", " .$conn->qStr($type). ", " .$cid. ", " .$pid. ", '" .time(). "')";
			$conn->execute($sql);	

			$data['debug'] = $sql;			
			if ( $conn->Affected_Rows() == 1 ) {
				$data['status'] = 1;
				$data['msg'] = $lang['ajax.report_spam_success'];
			} else {
				$data['msg'] = $lang['ajax.report_spam_failed'];
			}
		}
    } else {
		$data['msg'] = $lang['ajax.report_spam_login'];
    }
} else {
    $data['msg'] = 'Invalid request!?';
}

echo json_encode($data);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('msg' => '', 'status' => 0, 'total' => -1, 'debug' => '');
if ( isset($_POST['cid']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $uid        = intval($_SESSION['uid']);
        $cid        = $filter->get('cid', 'INTEGER');
        $type       = $filter->get('type', 'STRING');	
		$prefix		= substr(ucfirst($type),0,1);			
		$sql 		= "SELECT ".$prefix."ID, PARENT_ID FROM ".$type."_comments WHERE UID = " .$uid. " AND CID = " .$cid. " LIMIT 1";
		$rs  		= $conn->execute($sql);
		$id  		= $rs->fields[$prefix.'ID'];
		$parent_id 	= $rs->fields['PARENT_ID'];
		$sql = "DELETE FROM ".$type."_comments WHERE UID = " .$uid. " AND CID = " .$cid. " LIMIT 1";		
		$conn->execute($sql);
		if ( $conn->Affected_Rows() == 1 ) {
			if ($parent_id == 0) {
				$sql        = "DELETE FROM ".$type."_comments WHERE PARENT_ID = " .$cid. "";
				$conn->execute($sql);	
				$data['total'] = comments_total($type,$id);		
				switch ($type) {
					case 'user':
						break;
					case 'video':
						$sql = "UPDATE video SET com_num = com_num-1 WHERE VID = ".$id." LIMIT 1";
						$conn->execute($sql);
						break;
					case 'photo':
						$sql = "UPDATE photos SET total_comments = total_comments-1 WHERE PID = ".$id." LIMIT 1";
						$conn->execute($sql);				
						$sql 	= "SELECT AID from photos WHERE PID = " .$id. " LIMIT 1";
						$rs  	= $conn->execute($sql);
						$aid    = $rs->fields['AID'];				
						if ( $conn->Affected_Rows() === 1 ) {
							$sql            = "UPDATE albums SET total_comments = total_comments-1 WHERE AID = " .$aid. " LIMIT 1";
							$conn->execute($sql);	
						}
						break;
					case 'blog':
						$sql = "UPDATE blog SET total_comments = total_comments-1 WHERE BID = ".$id." LIMIT 1";
						$conn->execute($sql);
						break;				
				}					
			}
			$data['status'] = 1;
			$data['msg'] = $lang['ajax.comment_delete_success'];			
			
		} else { 
			$data['msg'] = $lang['ajax.comment_delete_failed'];
		}

    } else {
        $data['msg'] = $lang['ajax.comment_delete_login'];
    }
} else {
    $data['msg'] = 'Invalid request!?';
}

echo json_encode($data);
die();
?>

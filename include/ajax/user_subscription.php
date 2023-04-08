<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/compat/json.php';

$data = array('status' => 0, 'msg' => '');
if ( isset($_POST['user_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $uid        = intval($_SESSION['uid']);
        $filter     = new VFilter();
        $user_id    = $filter->get('user_id', 'INTEGER');
        if ( $uid == $user_id ) {
			$data['msg'] = $lang['ajax.subscribe_self'];
        } else {
            $sql = "SELECT UID FROM video_subscribe WHERE UID = " .$user_id. " AND SUID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $sql        = "DELETE FROM video_subscribe WHERE UID = " .$user_id. " AND SUID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
                $sql        = "UPDATE signup SET popularity = popularity-1, points = points-2 WHERE UID = " .$user_id. " LIMIT 1";
                $conn->execute($sql);							
				$data['status'] = 2;
                $data['msg'] = $lang['ajax.unsubscribe_success'];
                $data['btn'] = $lang['user.subscribe'];				
            } else {
                $sql        = "INSERT INTO video_subscribe (UID, SUID, subscribe_date)  VALUES (" .$user_id. "," .$uid. ", '" .date('Y-m-d'). "')";
                $conn->execute($sql);
                $sql        = "UPDATE signup SET popularity = popularity+1 WHERE UID = " .$user_id. " LIMIT 1";
                $conn->execute($sql);
                $sql        = "UPDATE signup SET points = points+1 WHERE UID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
				$data['status'] = 1;				
				$data['msg'] = $lang['ajax.subscribe_success'];
                $data['btn'] = $lang['user.subscribed'].' <i class="fas fa-check"></i>';						
			}
        }
    } else {
        $data['msg'] = $lang['ajax.subscribe_login'];
    }
	
	$sql     = "SELECT count(UID) AS total_subscribers FROM video_subscribe WHERE UID = " .$user_id. "";
	$rsc     = $conn->execute($sql);
	$total_s = $rsc->fields['total_subscribers'];

	$abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");
	foreach($abbrevs as $exponent => $abbrev) {
		if($total_s >= pow(10, $exponent)) {
			$display_num = $total_s / pow(10, $exponent);
			$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;		
			$result = number_format($display_num,$decimals);
			if ($result == (int)$result) {
				$result = (int)$result;
			}
			$data['total_s'] = '<span class="text-highlighted">' . $result . $abbrev. '</span> ' . $lang['user.subscribers'];
		}
	}
  	
	if ($total_s == 1) 
		$data['total_s'] = '<span class="text-highlighted">1</span>'. ' ' . $lang['user.subscriber'];	
	elseif ($total_s == 0) 
		$data['total_s'] = '<span class="text-highlighted">0</span>'. ' ' . $lang['user.subscribers'];		
	
} else {
	$data['msg'] = 'Invalid request!?';
}

echo json_encode($data);
die();
?>

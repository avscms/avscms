<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data = array('status' => 0, 'msg' => '');


if ( isset($_POST['user_id']) && isset($_POST['friendship'])) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $uid        = intval($_SESSION['uid']);
        $user_id    = $filter->get('user_id', 'INTEGER');
		$friendship = $filter->get('friendship', 'STRING');
        if ( $uid == $user_id ) {
             $data['msg'] = '???';
        } elseif ($friendship == 'Add') {
            $sql        = "SELECT friends_requests FROM users_prefs WHERE UID = " .$user_id. " LIMIT 1";
            $rs         = $conn->execute($sql);
            $auto       = $rs->fields['friends_requests'];
            $sql        = "SELECT status FROM friends WHERE UID = " .$user_id. " AND FID = " .$uid. " LIMIT 1";
            $rs         = $conn->execute($sql);
            $status     = NULL;
            if ( $conn->Affected_Rows() == 1 ) {
                $status = $rs->fields['status'];
            }
            
            if ( $status ) {
                if ( $status == 'Confirmed' ) {
                    $data['msg'] = $lang['ajax.invite_friend_exists'];
                } else if ( $status == 'Pending' ) {
                    if ( $auto == '1' ) {
                        $sql        = "UPDATE friends SET status = 'Confirmed' WHERE UID = " .$user_id. " AND FID = " .$uid. " LIMIT 1";
                        $conn->execute($sql);
          				$sql        = "INSERT INTO friends ( UID, FID, invite_date, status) 
                              		   VALUES (".$uid.", ".$user_id.", '".date('Y-m-d')."', 'Confirmed')";
          				$conn->execute($sql);
          				$sql        = "UPDATE signup SET total_friends = total_friends+1, popularity = popularity+3 WHERE UID = " .$user_id. " LIMIT 1";
          				$conn->execute($sql);
          				$sql        = "UPDATE signup SET total_friends = total_friends+1, points = points+2 WHERE UID = " .$uid. " LIMIT 1";
          				$conn->execute($sql);
          				$sql        = "SELECT u.username, u.email, p.friend_request FROM signup AS u, users_prefs AS p 
                              		   WHERE u.UID = " .$uid. " AND u.UID = p.UID LIMIT 1";
          				$rs         = $conn->execute($sql);
          				if ( $conn->Affected_Rows() === 1 && $rs->fields['friend_request'] == '1' ) {
              				$to         = $rs->fields['email'];
              				$receiver   = $rs->fields['username'];
              				$sql        = "SELECT username FROM signup WHERE UID = " .$user_id. " LIMIT 1";
              				$rs         = $conn->execute($sql);
              				if ( $conn->Affected_Rows() === 1 ) {
                  				$username = $rs->fields['username'];                  				
								require $config['BASE_DIR']. '/classes/email.class.php';
								$search		= array('{$site_title}', '{$username}', '{$baseurl}', '{$site_name}', '{$receiver}');
								$replace	= array($config['site_title'], $username, $config['BASE_URL'], $config['site_name'], $receiver);
								$mail       = new VMail();
                  				$mail->sendPredefined($to, 'request_approved', $search, $replace);
							}
						}
                    } else {
                        $data['msg'] = $lang['ajax.invite_friend_respond'];
                    }
                }            
            } else {
				if ($auto == '1') {
					$sql		= "INSERT INTO friends (UID, FID, invite_date, status)
					               VALUES (".$uid.", ".$user_id.", '".date('Y-m-d')."', 'Confirmed')";
					$conn->execute($sql);
					$sql		= "INSERT INTO friends (UID, FID, invite_date, status)
					               VALUES (".$user_id.", ".$uid.", '".date('Y-m-d')."', 'Confirmed')";
          			$conn->execute($sql);
          			$sql        = "UPDATE signup SET total_friends = total_friends+1, popularity = popularity+3 WHERE UID = " .$uid. " LIMIT 1";
          			$conn->execute($sql);
          			$sql        = "UPDATE signup SET total_friends = total_friends+1, points = points+2 WHERE UID = " .$user_id. " LIMIT 1";
          			$conn->execute($sql);
          			$sql        = "SELECT u.username, u.email, p.friend_request FROM signup AS u, users_prefs AS p 
                              	   WHERE u.UID = " .$uid. " AND u.UID = p.UID LIMIT 1";
          			$rs         = $conn->execute($sql);
          			if ( $conn->Affected_Rows() === 1 && $rs->fields['friend_request'] == '1' ) {
              			$to         = $rs->fields['email'];
              			$receiver   = $rs->fields['username'];
              			$sql        = "SELECT username FROM signup WHERE UID = " .$uid. " LIMIT 1";
              			$rs         = $conn->execute($sql);
              			if ( $conn->Affected_Rows() === 1 ) {
                  			$username   = $rs->fields['username'];
                  			require $config['BASE_DIR']. '/classes/email.class.php';
                  			$search     = array('{$site_title}', '{$username}', '{$baseurl}', '{$site_name}', '{$receiver}');
                  			$replace    = array($config['site_title'], $username, $config['BASE_URL'], $config['site_name'], $receiver);
							$mail 		= new VMail();
                  			$mail->sendPredefined($to, 'request_approved', $search, $replace);
              			}
						$data['msg'] = $lang['ajax.invite_friend_success'];
						$data['status'] = 1;						
          			}
				} else {			
              		$sql            = "INSERT INTO friends ( UID, FID, invite_date, status )
                                  	   VALUES (" .$user_id. ", " .$uid. ", '" .date('Y-m-d'). "', 'Pending')";
              		$conn->execute($sql);
              		$sql            = "SELECT p.friend_request, s.email, s.username FROM users_prefs AS p, signup AS s
                                  	   WHERE p.UID = " .$user_id. " AND p.UID = s.UID LIMIT 1";
              		$rs             = $conn->execute($sql);
              		$friend_request = $rs->fields['friend_request'];
              		$to             = $rs->fields['email'];
					$receiver		= $rs->fields['username'];					
              		if ( $friend_request == '1' ) {
                  		require $config['BASE_DIR']. '/classes/email.class.php';
						$search 	= array('{$username}', '{$site_name}', '{$baseurl}', '{$receiver}');
						$replace	= array($_SESSION['username'], $config['site_name'], $config['BASE_URL'], $receiver);
                		$mail		= new VMail();
						$mail->sendPredefined($to, 'friend_request', $search, $replace);  
              		}
					$data['msg'] = $lang['ajax.invite_friend_sent'];					
					$data['status'] = 2;									
          		}				
			}
        } elseif ($friendship == 'Accept') {
			$sql        = "SELECT UID FROM friends WHERE UID = " .$uid. " AND FID = " .$user_id. " AND status = 'Pending' LIMIT 1";
			$conn->execute($sql);
			if ( $conn->Affected_Rows() == 1 ) {
				$sql            = "UPDATE friends SET status = 'Confirmed' WHERE UID = " .$uid. " AND FID = " .$user_id. " LIMIT 1";
				$conn->execute($sql);
				$sql            = "INSERT INTO friends ( UID, FID, invite_date, status)
								   VALUES (".$user_id.", ".$uid.", '".date('Y-m-d')."', 'Confirmed')";
				$conn->execute($sql);
				$sql            = "UPDATE signup SET total_friends = total_friends+1, popularity = popularity+3 WHERE UID = " .$uid. " LIMIT 1";
				$conn->execute($sql);
				$sql            = "UPDATE signup SET total_friends = total_friends+1, points = points+2 WHERE UID = " .$user_id. " LIMIT 1";
				$conn->execute($sql);
				$sql            = "SELECT u.username, u.email, p.friend_request FROM signup AS u, users_prefs AS p
								   WHERE u.UID = " .$user_id. " AND u.UID = p.UID LIMIT 1";
				$rs             = $conn->execute($sql);
				$data['status'] = 1;
				$data['msg'] = $lang['ajax.accept_friend_success'];
				if ( $conn->Affected_Rows() === 1 && $rs->fields['friend_request'] == '1' ) {
					$to         = $rs->fields['email'];
					$receiver   = $rs->fields['username'];
					$sql        = "SELECT username FROM signup WHERE UID = " .$uid. " LIMIT 1";
					$rs         = $conn->execute($sql);
					if ( $conn->Affected_Rows() === 1 ) {
						$username 	= $rs->fields['username'];
						require $config['BASE_DIR']. '/classes/email.class.php';
						$search		= array('{$site_title}', '{$username}', '{$baseurl}', '{$site_name}', '{$receiver}');
						$replace	= array($config['site_title'], $username, $config['BASE_URL'], $config['site_name'], $receiver);
						$mail		= new VMail();
						$mail->sendPredefined($to, 'request_approved', $search, $replace);
					}
				}
			}
        } elseif ($friendship == 'Reject') {
			$sql        = "SELECT UID FROM friends WHERE UID = " .$uid. " AND FID = " .$user_id. " AND status = 'Pending' LIMIT 1";
			$conn->execute($sql);
			if ( $conn->Affected_Rows() == 1 ) {
				$sql            = "DELETE FROM friends WHERE UID = " .$uid. " AND FID = " .$user_id. " LIMIT 1";
				$conn->execute($sql);
				$sql            = "UPDATE signup SET total_friends = total_friends-1, popularity = popularity-2 WHERE UID = " .$uid. " LIMIT 1";
				$conn->execute($sql);
				$sql            = "UPDATE signup SET points = points-2 WHERE UID = " .$user_id. " LIMIT 1";
				$conn->execute($sql);
				$data['status'] = 1;
				$data['msg'] = $lang['ajax.reject_friend_success'];
				$sql            = "SELECT u.username, u.email, p.friend_request FROM signup AS u, users_prefs AS p 
								   WHERE u.UID = " .$user_id. " AND u.UID = p.UID LIMIT 1";
				$rs             = $conn->execute($sql);
				if ( $conn->Affected_Rows() === 1 && $rs->fields['friend_request'] == '1' ) {
					$to         = $rs->fields['email'];
					$receiver   = $rs->fields['username'];
					$sql        = "SELECT username FROM signup WHERE UID = " .$uid. " LIMIT 1";
					$rs         = $conn->execute($sql);
					if ( $conn->Affected_Rows() === 1 ) {
						$username 	= $rs->fields['username'];
						require $config['BASE_DIR']. '/classes/email.class.php';
						$mail		= new VMail();
						$search		= array('{$site_title}', '{$username}', '{$baseurl}', '{$site_name}', '{$receiver}');
						$replace	= array($config['site_title'], $username, $config['BASE_URL'], $config['site_name'], $receiver);
						$mail->sendPredefined($to, 'request_rejected', $search, $replace);
					}
				}
			} else {			
				$data['msg'] = $lang['ajax.reject_friend_missing'];
			}		

        } elseif ($friendship == 'Unfriend') {
            $sql        = "DELETE FROM friends WHERE UID = " .$user_id. " AND FID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
			$sql		= "DELETE FROM friends WHERE UID = ".$uid." AND FID = ".$user_id." LIMIT 1";
			$conn->execute($sql);
			$sql		= "UPDATE signup SET total_friends = total_friends-1 WHERE UID = ".$uid." LIMIT 1";
			$conn->execute($sql);
			$sql		= "UPDATE signup SET total_friends = total_friends-1 WHERE UID = ".$user_id." LIMIT 1";
			$conn->execute($sql);			
			$data['status'] = 1;
			$data['msg'] = $lang['ajax.remove_friend_success'];
        } elseif ($friendship == 'Cancel') {
            $sql        = "DELETE FROM friends WHERE UID = " .$user_id. " AND FID = " .$uid. " LIMIT 1";
            $conn->execute($sql);			
			$data['status'] = 1;
			$data['msg'] = $lang['user.friend_r_canceled'];
		}		
    } else {
        $data['msg'] = $lang['ajax.invite_friend_login'];
    }
}

echo json_encode($data);
die();
?>

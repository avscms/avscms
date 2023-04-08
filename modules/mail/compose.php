<?php
defined('_VALID') or die('Restricted Access!');

$access = true;
if ( $config['private_msgs'] == 'friends' ) {
    $sql    = "SELECT FID FROM friends WHERE UID = " .$uid. " LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() != 1 ) {
        $access = false;
        $_URL   = $config['BASE_URL']. '/notfound/private_messages_friends';
    }
} elseif ( $config['private_msgs'] == 'disabled' ) {
    $access = false;
    $_URL   = $config['BASE_URL']. '/notfound/private_messages_disabled';
}

if ( !$access ) {
    VRedirect::go($_URL);
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/validation.class.php';

$filter  = new VFilter();
$subject = $filter->get('s', 'STRING', 'GET');

$compose = array('receiver' => '', 'friend' => '', 'subject' => $subject, 'body' => '', 'save_outbox' => 1, 'send_self' => 0);
if ( isset($query['1']) && $query['1'] != '' ) {
    $valid  = new VValidation();
    if ( $valid->usernameExists($query['1']) ) {
        $compose['receiver'] = $query['1'];
    }
}

if ( isset($_POST['send_mail']) ) {
    $valid          = new VValidation();
    $receiver       = $filter->get('receiver');
    $friend         = $filter->get('receiver_friend');
  	$subject        = $filter->get('subject');
    $body           = $filter->process(trim($_POST['body']), array('a'), array('href'));
    
    if ( $receiver == '' ) {
        if ( $friend != '' ) {
            if ( !$valid->usernameExists($friend) ) {
                $errors[] = translate('mail.compose_user_invalid', $config['site_name']);
				$err['receiver'] = 1;
            } else {
                $sql    = "SELECT UID FROM signup WHERE username = " .$conn->qStr($friend). " LIMIT 1";
                $rs     = $conn->execute($sql);
                $fuid   = intval($rs->fields['UID']);
                $sql    = "SELECT UID FROM friends WHERE UID = " .$uid. " AND FID = " .$fuid. " AND status = 'Confirmed' LIMIT 1";
                $conn->execute($sql);
                if ( $conn->Affected_Rows() === 1 ) {
                    $receiver = $friend;
                    $compose['friend'] = $friend;
                } else {
					$errors[] = translate('mail.compose_user_missing', htmlspecialchars($friend, ENT_QUOTES, 'UTF-8'));
					$err['receiver'] = 1;
                }                
            }
        }
    }
    
    if ( $receiver == '' ) {
        $errors[]   = $lang['mail.receiver_empty'];
		$err['receiver'] = 1;
    } elseif ( !$valid->usernameExists($receiver) ) {
        $errors[]   = translate('mail.receiver_invalid', $config['site_name']);
		$err['receiver'] = 1;
    } else {
        $compose['receiver'] = $receiver;
    }
    
    if ( $subject == '' ) {
        $errors[]   = 'Subject field cannot be blank!';
		$err['subject'] = 1;
    } else {
		$subject_length = mb_strlen($subject);
		if ($subject_length < 3 OR $subject_length > 254) {
      		$errors[]   = translate('mail.subject_length', '3', '254');
			$err['subject'] = 1;
  		} else {
      		$compose['subject'] = $subject;
		}
    }
    
    if ( $body == '' ) {
        $errors[]   = $lang['mail.body_empty'];
		$err['body'] = 1;
    } elseif ( mb_strlen($body) < 3 ) {
        $errors[]   = translate('mail.body_empty', '3');
		$err['body'] = 1;
    } else {
        $compose['body'] = $body;
    }
    
    $compose['save_outbox'] = ( isset($_POST['save_outbox']) ) ? 1 : 0;
    $compose['send_self']   = ( isset($_POST['send_self']) ) ? 1 : 0;
    
    if ( !$errors ) {
        $sql    = "INSERT INTO mail ( sender, receiver, subject, body, inbox, outbox, send_date, status )
                   VALUES (" .$conn->qStr($username). ", " .$conn->qStr($receiver). ",
                           " .$conn->qStr($subject). ", " .$conn->qStr($body). ",
                           '1', " .$conn->qStr($compose['save_outbox']). ", '" .date('Y-m-d h:i:s'). "', '1')";
        $conn->execute($sql);
        $messages[] = translate('mail.msg_sent', $receiver);
        if ( $compose['send_self'] ) {
            $sql    = "INSERT INTO mail ( sender, receiver, subject, body, inbox, outbox, send_date, status )
                       VALUES (" .$conn->qStr($username). ", " .$conn->qStr($username). ",
                               " .$conn->qStr($subject). ", " .$conn->qStr($body). ",
                               '1', '0', '" .date('Y-m-d h:i:s'). "', '1')";
            $conn->execute($sql);            
        }
    }
}

$sql        = "SELECT u.username FROM signup AS u, friends AS f
               WHERE f.UID = " .$uid. " AND f.status = 'Confirmed' AND f.FID = u.UID";
$rs         = $conn->execute($sql);
$friends    = $rs->getrows();

$smarty->assign('compose', $compose);
$smarty->assign('friends', $friends);
?>

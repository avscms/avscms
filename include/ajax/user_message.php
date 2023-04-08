<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/validation.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data = array('status' => 1, 'msg' => '', 'debug' => '');
$filter  = new VFilter();
$subject = $filter->get('s', 'STRING', 'GET');
$compose = array('receiver' => '', 'friend' => '', 'subject' => $subject, 'body' => '', 'save_outbox' => 1, 'send_self' => 0);

if ( isset($_SESSION['uid']) ) {
    $valid          = new VValidation();
    $receiver       = $filter->get('receiver', 'INTEGER');
    $sender         = $filter->get('sender', 'INTEGER');	
  	$subject        = $filter->get('message_subject');
    $body           = $filter->process(trim($_POST['message_body']), array('a'), array('href'));


    $compose['receiver'] = $receiver;
	
    if ( $body == '' ) {
		$data['status'] = 0;
         $data['msg'] = $lang['mail.body_empty'];
    } elseif ( mb_strlen($body) < 2 ) {
		$data['status'] = 0;
        $data['msg'] = translate('mail.body_empty', '2');
    } else {
        $compose['body'] = $body;
    }

    if ( $subject == '' ) {
		$data['status'] = 0;
        $data['msg'] = $lang['mail.subject_empty'];
    } else {
		$subject_length = mb_strlen($subject);
		if ($subject_length < 2 OR $subject_length > 254) {
			$data['status'] = 0;
      		$data['msg'] = translate('mail.subject_length', '2', '254');
  		} else {
      		$compose['subject'] = $subject;
		}
    }
    
    if ( $data['status'] ) {
        $sql    = "INSERT INTO mail ( sender, receiver, subject, body, inbox, outbox, send_date, status )
                   VALUES (" .$conn->qStr($sender). ", " .$conn->qStr($receiver). ",
                           " .$conn->qStr($subject). ", " .$conn->qStr($body). ",
                           '1', " .$conn->qStr($compose['save_outbox']). ", '" .date('Y-m-d h:i:s'). "', '1')";
        $conn->execute($sql);
        $data['msg'] = translate('mail.msg_sent', $receiver);
    }
} else {
	$data['status'] = 0;	
	$data['msg'] = $lang['ajax.send_message_login'];
}

echo json_encode($data);
die();
?>

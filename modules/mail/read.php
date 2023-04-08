<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';

$filter     = new VFilter();
$mail_id    = $filter->get('id', 'INTEGER', 'GET');
$folder    = $filter->get('f', 'STRING', 'GET');
if ( !$mail_id ) {
    VRedirect::go($config['BASE_URL']. '/notfound/mail_missing');
}

$sql        = "SELECT m.mail_id, m.sender, m.receiver, m.subject, m.body, s.photo, s.gender
               FROM mail AS m, signup AS s
               WHERE ( m.sender = " .$conn->qStr($username). " OR m.receiver = " .$conn->qStr($username). " )
               AND m.mail_id = " .$mail_id. " AND m.sender = s.username AND m.status = '1'
               LIMIT 1";
$rs         = $conn->execute($sql);
if ( !$conn->Affected_Rows() ) {
    VRedirect::go($config['BASE_URL']. '/notfound/mail_missing');
}

$mail       = $rs->getrows();
$mail       = $mail['0'];
if ($mail['receiver'] == $username) {
	$sql        = "UPDATE mail SET readed = '1' WHERE mail_id = " .$mail_id. " LIMIT 1";
	$conn->execute($sql);
}

$smarty->assign('mail', $mail);
$smarty->assign('folder', $folder);
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/validation.class.php';
require $config['BASE_DIR']. '/classes/email.class.php';
require $config['BASE_DIR']. '/classes/file.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

disableRegisterGlobals();

function clean( $string )
{
    $string = preg_replace('/[^ 0-9a-zA-Z]/', ' ', $string);
    $string = preg_replace('/\s\s+/', ' ', $string);
    $string = trim($string);
    $string = str_replace(' ', '-', $string);

    return strtolower($string);
}

$data   = array('status' => 0, 'msg' => '', 'debug' => '');
if ( isset($_POST['item_id']) ) {
    $filter     = new VFilter();
    $video_id   = $filter->get('item_id', 'INTEGER');
    $from       = $filter->get('from');
    $to         = $filter->get('to');
    $message    = $filter->get('message');
    
    $from       = preg_replace('/[^ 0-9a-zA-Z,@.]/', '', $from);
    $to         = preg_replace('/[^ 0-9a-zA-Z,@.]/', '', $to);
    $to         = str_replace(',', '', $to);
    $to         = preg_replace('/\s\s+/', ' ', $to);
    $to         = str_replace("\r", '', $to);
    $to         = str_replace("\n", '', $to);
    $to         = explode(' ', $to);
    if ( !$to ) {
        $data['msg']    = show_err_mb($lang['ajax.share_recipient']);
    } else {
        $emails         = array();
        $users          = array();
        $valid          = new VValidation();
        foreach ( $to as $key => $value ) {
            if ( $valid->email($value) ) {
                $emails[]   = $value;
            } elseif ( $valid->usernameExists($value) ) {
                $users[]    = $value;
            }
        }
        
        if ( $users ) {
            $sql_add    = array();
            foreach ( $users as $user ) {
                $sql_add[] = "" .$conn->qStr($user). "";
            }
            $sql            = "SELECT email FROM signup WHERE username IN (" .implode(',', $sql_add). ")";
            $rs             = $conn->execute($sql);
            $users_emails   = $rs->getrows();
            foreach($users_emails as $user) {
                $emails[] = $user['email'];
            }
        }
        
        if ( !$emails ) {
            $data['msg']    = show_err_mb($lang['ajax.share_recipient_valid']);
        } else {
            $sql                = "SELECT title FROM video WHERE VID = " .$video_id. " LIMIT 1";
            $rs                 = $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $title          = $rs->fields['title'];
                $url            = $config['BASE_URL']. '/video/' .$video_id. '/' .clean($title);
                $sql            = "SELECT email_subject, email_path FROM emailinfo
                                   WHERE email_id = 'share_video' LIMIT 1";
                $rs             = $conn->execute($sql);
                $email_subject  = str_replace('{$sender_name}', $from, $rs->fields['email_subject']);
                $email_path     = $config['BASE_DIR']. '/templates/' .$rs->fields['email_path'];
                $body           = VFile::read($email_path);
                $body           = str_replace('{$site_name}', $config['site_name'], $body);
                $body           = str_replace('{$video_link}', $url, $body);
                $body           = str_replace('{$sender_name}', $from, $body);
                $body           = str_replace('{$message}', $message, $body);
                $mail           = new VMail();
                $mail->setNoReply();
                $mail->Subject  = $email_subject;
                $mail->AltBody  = $body;
                $mail->Body     = nl2br($body);
                foreach ( $emails as $email ) {
                    $mail->AddAddress($email);
                    $mail->Send();
                    $mail->ClearAddresses();
                }
                $data['status'] = 1;
                $data['msg']    = show_msg_mb($lang['ajax.share_success']);
            } else {
                $data['msg']    = show_err_mb($lang['ajax.share_video_failed']);
            }
        }
    }
}

echo json_encode($data);
die();
?>

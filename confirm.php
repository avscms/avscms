<?php
define('_VALID', true);
require 'include/config.php';
require 'classes/filter.class.php';
require 'classes/validation.class.php';
require 'include/function_smarty.php';

if ( isset($_GET['id']) && isset($_GET['code']) ) {
    $filter     = new VFilter();
    $uid        = $filter->get('id', 'INTEGER', 'GET');
    $code       = $filter->get('code', 'STRING', 'GET');
    $length     = strlen($code);
    
    if ( !$uid ) {
        $errors[]   = $lang['confirm.invalid'];
    }
        
    if ( $length != 10 ) {
        $errors[]   = $lang['confirm.invalid'];
    }
    
    if ( !$errors ) {
        $sql        = "SELECT emailverified FROM signup WHERE UID = " .$uid. " LIMIT 1";
        $rs         = $conn->execute($sql);
        $verified   = $rs->fields['emailverified'];
        if ( $verified == 'yes' ) {
            $sql            = "DELETE FROM confirm WHERE UID = " .$uid;
            $conn->execute($sql);
            $messages[] = $lang['confirm.already'];
        } else {
            $sql    = "SELECT UID FROM confirm WHERE UID = " .$uid. " AND code = " .$conn->qStr($code). " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {        
                $sql            = "DELETE FROM confirm WHERE UID = " .$uid;
                $conn->execute($sql);
                $sql    = "UPDATE signup SET emailverified = 'yes' WHERE UID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
                if ( isset($_SESSION['uid']) ) {
                    $_SESSION['emailverified'] = 'yes';
                }
                $messages[]     = $lang['confirm.msg'];
            } else {
                $errors[]       = $lang['confirm.err'];
            }
        }
    }
}

if ( isset($_POST['submit_confirm']) ) {
    $filter     = new VFilter();
    $valid      = new VValidation();
    $email      = $filter->get('email');

    if ( $email == '' ) {
        $errors[]   = $lang['confirm.email_empty'];
    } elseif ( !$valid->email($email) ) {
        $errors[]   = $lang['global.email_invalid'];
    } elseif ( !$valid->emailExists($email) ) {
        $errors[]   = $lang['confirm.email_invalid'];
    } else {
        require 'classes/random.class.php';
		require 'classes/email.class.php';
        
        $sql            = "SELECT UID, username FROM signup WHERE email = " .$conn->qStr($email). " LIMIT 1";
        $rs             = $conn->execute($sql);
        $uid            = $rs->fields['UID'];
        $username       = $rs->fields['username'];
        $code           = VRandom::generate(10, 'confirmation');
        $sql            = "DELETE FROM confirm WHERE UID = " .$uid;
        $conn->execute($sql);
        $sql            = "INSERT INTO confirm (UID, code) VALUES (" .$uid. "," .$conn->qStr($code). ")";
        $conn->execute($sql);
        $sql            = "SELECT email_subject, email_path FROM emailinfo 
                           WHERE email_id = 'verify_email' LIMIT 1";
        $rs             = $conn->execute($sql);
        $email_subject  = str_replace('{$site_name}', $config['site_name'], $rs->fields['email_subject']);
        $email_path     = $config['BASE_DIR']. '/templates/' .$rs->fields['email_path'];
        $smarty->assign('username', $username);
        $smarty->assign('uid', $uid);
        $smarty->assign('code', $code);
        $body           = $smarty->fetch($email_path);
        $mail           = new VMail();
        $mail->setNoReply();
        $mail->Subject  = $email_subject;
        $mail->AltBody  = $body;
        $mail->Body     = nl2br($body);
        $mail->AddAddress($email);
        $mail->Send();
        $messages[]     = $lang['confirm.success'];
    }
}

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('self_title', $seo['confirm_title']);
$smarty->assign('self_description', $seo['confirm_desc']);
$smarty->assign('self_keywords', $seo['confirm_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('confirm.tpl');
$smarty->display('footer.tpl');
?>

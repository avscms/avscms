<?php
define('_VALID', true);
require 'include/config.php';
require 'classes/filter.class.php';
require 'classes/validation.class.php';
require 'include/function_smarty.php';

if ( isset($_POST['submit_lost']) ) {
    $filter     = new VFilter();
    $valid      = new VValidation();
    $email      = $filter->get('email');
    
    if ( $email == '' ) {
        $errors[]   = $lang['confirm.expl'];
    } elseif ( !$valid->email($email) ) {
        $errors[]   = $lang['global.email_invalid'];
    } elseif ( !$valid->emailExists($email) ) {
        $errors[]   = $lang['confirm.email_invalid'];
    } else {
        require 'classes/random.class.php';
		require 'classes/email.class.php';
		
        $passwd     = VRandom::generate(8);
		$password	= md5($passwd);
        $sql        = "SELECT username FROM signup WHERE email = " .$conn->qStr($email). " LIMIT 1";
        $rs         = $conn->execute($sql);
        $username   = $rs->fields['username'];
        
        $sql        = "UPDATE signup SET pwd = " .$conn->qStr($password). "
                       WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $conn->execute($sql);

        $smarty->assign('receiver_name', $username);
        $smarty->assign('password', $passwd);
        
        $sql        = "SELECT * FROM emailinfo WHERE email_id = 'recover_password' LIMIT 1";
        $rs         = $conn->execute($sql);
        $subject    = str_replace('{$site_name}', $config['site_name'], $rs->fields['email_subject']);
        $email_path = $config['BASE_DIR']. '/templates/' .$rs->fields['email_path'];
        $body       = $smarty->fetch($email_path);
        
        $mail           = new VMail();
        $mail->set();
        $mail->Subject  = $subject;
        $mail->AltBody  = $body;
        $mail->Body     = nl2br($body);
        $mail->AddAddress($email);
        $mail->Send();
        
        $messages[]     = $lang['lost.msg'];      
    }
}

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('self_title', $seo['lost_title']);
$smarty->assign('self_description', $seo['lost_desc']);
$smarty->assign('self_keywords', $seo['lost_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('lost.tpl');
$smarty->display('footer.tpl');
?>

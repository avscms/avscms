<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_sessions']) ) {
    $filter             = new VFilter();
	$session_driver 	= $filter->get('session_driver');
	$session_lifetime   = $filter->get('session_lifetime', 'INTEGER');
    
    if ( $session_lifetime == '' ) {
        $errors[] = 'Session Lifetime field cannot be blank!';
		$err['session_lifetime'] = 1;
	}    elseif ( !is_numeric($session_lifetime) ) {
        $errors[] = 'Session Lifetime field must have a numeric value!';
		$err['session_lifetime'] = 1;
	}
	if ( !$errors ) {
        $config['session_driver']   = $session_driver;
        $config['session_lifetime'] = $session_lifetime;
        update_config($config);
        update_smarty();
	    $messages[] = 'Sessions Settings Updated Successfuly!';
    }
	$smarty->assign('err', $err);
	$smarty->assign('session_driver', $session_driver);
	$smarty->assign('session_lifetime', $session_lifetime);	
}
?>

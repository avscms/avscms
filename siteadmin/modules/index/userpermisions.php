<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if (isset($_POST['submit_permisions_users'])) {
	foreach ($_POST as $k=>$v) {
		if ($k != '' and $k != 'submit_permisions_users') {
			$config[$k] = $v;
			if ($k == 'visitors_bandwidth') {
				if (!is_numeric($v)) {
					$errors[] = 'Bandwidth Limit (Visitors) must be a numeric vlaue!';
					$err['visitors_bandwidth'] = 1;
					$v = '';
				}
			}	elseif ($k == 'free_bandwidth') {
				if (!is_numeric($v)) {
					$errors[] = 'Bandwidth Limit (Users) must be a numeric vlaue!';
					$err['free_bandwidth'] = 1;
					$v = '';
				}
			}	elseif ($k == 'premium_bandwidth') {
				if (!is_numeric($v)) {
					$errors[] = 'Bandwidth Limit (Premium Users) must be a numeric vlaue!';
					$err['premium_bandwidth'] = 1;
					$v = '';
				}
			}
			$smarty->assign($k, $v);
			
		}
	}
	
    if (!$errors) {
		update_config($config);
		update_smarty();
		$messages[] = 'User Permissions Updated Successfuly!';
	}
	$smarty->assign('err', $err);
}
?>
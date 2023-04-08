<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
$file = $config['BASE_DIR']. '/templates/backend/default/analytics/analytics.tpl';
$code = file_get_contents($file);
if ( isset($_POST['submit_analytics']) ) {
	$code = $_POST['analytics_code'];
	$code = str_replace('{literal}', '', $code);
	$code = str_replace('{/literal}', '', $code);
	$code = '{literal}'.$code.'{/literal}';
	
	file_put_contents($file, $code);
	$messages[] = 'Google Analytics Code Successfully Updated!';	
}
$smarty->assign('code', $code);
$smarty->assign('err', $err);
?>

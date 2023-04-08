<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/validation.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$response = array('status' => 0, 'valid' => 0, 'msg' => '');

$filter   = new VFilter();
$valid    = new VValidation();
$username    = $filter->get('username');

if ( $username == '' ) {
	$response['msg'] = $lang['socialsignup.user_format_error'];
} elseif ( strlen($username) > 15 or strlen($username) < 2) {
	$response['msg'] = $lang['socialsignup.user_format_error'];
} elseif ( !$valid->username($username) ) {
	$response['msg'] = $lang['socialsignup.user_format_error'];
} elseif ( $valid->usernameExists($username) ) {
	$response['msg'] = $lang['socialsignup.user_existing_error'];
} else {
	$response['msg'] = $lang['socialsignup.user_valid'];
	$response['valid'] = 1;
}

if ($response['valid']) {
	$response['msg'] = '<span class="text-success">'.$response['msg']."</span>";
} else {
	$response['msg'] = '<span class="text-danger">'.$response['msg']."</span>";
}

$response['status'] = 1;
echo json_encode($response);
die();
?>

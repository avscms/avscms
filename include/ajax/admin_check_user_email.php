<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_admin.php';
require $config['BASE_DIR']. '/classes/validation.class.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'valid' => 1);

$filter = new VFilter();
$valid  = new VValidation();
$uid    = $filter->get('uid', 'INTEGER');
$email  = $filter->get('email');

if ( !$valid->email($email) || $valid->emailExists($email, $uid)) {
	$response['valid'] = 0;
}

$response['status'] = 1;
echo json_encode($response);
die();
?>

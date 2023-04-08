<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_admin.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'msg' => '', 'debug' => '');

$filter     = new VFilter();
$username   = $filter->get('username', 'STRING');

$sql = "SELECT username FROM signup WHERE username LIKE '" . $username . "%' ORDER BY username ASC;";
$rs  = $conn->execute($sql);
$response['users'] = $rs->getrows();
$response['status'] = 1;

echo json_encode($response);
die();
?>

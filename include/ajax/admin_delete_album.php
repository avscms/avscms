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
$aid        = $filter->get('album_id', 'INTEGER');
deleteAlbum( $aid );
$response['status'] = 1;

echo json_encode($response);
die();
?>

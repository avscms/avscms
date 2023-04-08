<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'msg' => '', 'code' => '', 'total' => 0);
if ( isset($_POST['id']) && isset($_POST['type'])) {
	$data['total'] 	= replies_total($_POST['type'], $_POST['id']);
	$data['status'] = 1;
	
	if ($data['total'] == 1) {
		$data['code'] = $lang['comments.view_reply'].'<i class="fas fa-chevron-down"></i>';
	} else {
		$data['code'] = $lang['comments.view_replies'].'<span id="replies_total_'.$_POST['type'].'_'.$_POST['id'].'"> '.$data['total'].'</span><i class="fas fa-chevron-down"></i>';		
	}
}

echo json_encode($data);
die();
?>

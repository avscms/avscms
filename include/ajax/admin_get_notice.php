<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_editor.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0);

$filter  = new VFilter();
$nid     = $filter->get('notice_id', 'INTEGER');
$editor  = $filter->get('editor');

$sql = "SELECT * from notice WHERE NID = " .$conn->qStr($nid). " LIMIT 1";
$rs = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
	$notice = $rs->getrows();
	$notice = $notice[0];
	foreach ($notice as $key=>$value) {
		if ($key == 'status') {
			$key = 'active';
		}
		if ($key == 'content' && $editor) {
			$value = wysiwygCSSToColor($value);
		}			
		$response[$key] = $value;
	}		
	$response['status'] = 1;
}

echo json_encode($response);
die();
?>

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

$data = $_POST['data'];

$nid            = trim($data['id']);
$title          = trim($data['title']);
$content        = wysiwygColorToCSS(trim($data['content']));
$viewnumber     = trim($data['viewnumber']);
$active         = trim($data['active']);
$category       = trim($data['category']);

settype($nid, 'integer');
settype($viewnumber, 'integer');
settype($category, 'integer');

$sql = "UPDATE notice SET title = " .$conn->qStr($title). ", 
						content = ".$conn->qStr($content). ", 
						total_views = " .$conn->qStr($viewnumber). ", 
						status  = " .$conn->qStr($active). " 
		WHERE NID = " .$conn->qStr($nid). " LIMIT 1";
$conn->execute($sql);

$sql = "SELECT category FROM notice WHERE NID = " .$conn->qStr($nid). " LIMIT 1";
$rs = $conn->execute($sql);
$old_category = (int) $rs->fields['category'];

if ($old_category != $category) {
	$sql = "UPDATE notice SET category = " .$conn->qStr($category). " 						
			WHERE NID = " .$conn->qStr($nid). " LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE notice_categories SET total_notices = total_notices-1 WHERE category_id = " .$conn->qStr($old_category). " LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE notice_categories SET total_notices = total_notices+1 WHERE category_id = " .$conn->qStr($category). " LIMIT 1";
	$conn->execute($sql);	
}


$response['status'] = 1;

echo json_encode($response);
die();
?>

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

$response = array('status' => 0, 'aid' => null);

$filter  = new VFilter();
$id     = $filter->get('category_id', 'INTEGER');
$type   = $filter->get('category_type', 'STRING');

switch ($type) {
    case 'Video':
			$sql = "DELETE FROM channel WHERE CHID = " .$conn->qStr($id). " LIMIT 1";
			$conn->execute($sql);
			if ( $conn->Affected_Rows() ) {
				$response['status'] = 1;
				$thumb = $config['BASE_DIR'].'/media/categories/video/' . $id . '.jpg';
				@chmod($thumb, 0777);
				@unlink($thumb);				
			}
        break;	
    case 'Album':
			$sql = "DELETE FROM album_categories WHERE CID = " .$conn->qStr($id). " LIMIT 1";
			$conn->execute($sql);
			if ( $conn->Affected_Rows() ) {
				$response['status'] = 1;
				$thumb = $config['BASE_DIR'].'/media/categories/album/' . $id . '.jpg';
				@chmod($thumb, 0777);
				@unlink($thumb);				
			}	
        break;
    case 'Game':
			$sql = "DELETE FROM game_categories WHERE category_id = " .$conn->qStr($id). " LIMIT 1";
			$conn->execute($sql);
			if ( $conn->Affected_Rows() ) {
				$response['status'] = 1;
				$thumb = $config['BASE_DIR'].'/media/categories/game/' . $id . '.jpg';
				@chmod($thumb, 0777);
				@unlink($thumb);				
			}	
        break;
    case 'Notice':
			$sql = "DELETE FROM notice_categories WHERE category_id = " .$conn->qStr($id). " LIMIT 1";
			$conn->execute($sql);
			if ( $conn->Affected_Rows() ) {
				$response['status'] = 1;				
			}	
        break;			
}

echo json_encode($response);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_admin.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'aid' => null);

$filter  = new VFilter();
$id     = $filter->get('id', 'INTEGER');
$type   = $filter->get('type', 'STRING');

switch ($type) {
    case 'Video':
			if ( delete_video_comment($id) ) {
				$response['status'] = 1;
			}		
        break;	
    case 'Photo':
			$aid = delete_photo_comment($id);
			if ( $aid ) {
				$response['status'] = 1;
				$response['aid'] = $aid;
			}		
        break;
    case 'Game':
		if ( delete_game_comment($id) ) {
				$response['status'] = 1;
			}
        break;
    case 'Blog':
		if ( delete_blog_comment($id) ) {
				$response['status'] = 1;
			}
        break;
    case 'Notice':
		if ( delete_notice_comment($id) ) {
				$response['status'] = 1;
			}
        break;		
    case 'User':
		if ( delete_user_comment($id) ) {
				$response['status'] = 1;
			}
        break;		
}

echo json_encode($response);
die();
?>

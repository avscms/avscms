<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'comments' => array(), 'count' => 0);

$filter  = new VFilter();
$id     = $filter->get('id', 'INTEGER');
$type   = $filter->get('type', 'STRING');

switch ($type) {
    case 'Video':
		$sql = "SELECT c.*, u.username FROM video_comments AS c, signup AS u
			   WHERE c.VID = " .$id. " AND c.UID = u.UID";
		$rs  = $conn->execute($sql);
		$response['comments'] = $rs->getrows();
		$response['status'] = 1;
        break;	
    case 'Photo':
		$sql = "SELECT c.*, u.username FROM photo_comments AS c, signup AS u
			   WHERE c.PID = " .$id. " AND c.UID = u.UID";
		$rs  = $conn->execute($sql);
		$response['comments'] = $rs->getrows();
		$response['status'] = 1;
        break;
    case 'Game':
		$sql = "SELECT c.*, u.username FROM game_comments AS c, signup AS u
			   WHERE c.GID = " .$id. " AND c.UID = u.UID";
		$rs  = $conn->execute($sql);
		$response['comments'] = $rs->getrows();
		$response['status'] = 1;	
        break;
    case 'Blog':
		$sql = "SELECT c.*, u.username FROM blog_comments AS c, signup AS u
			   WHERE c.BID = " .$id. " AND c.UID = u.UID";
		$rs  = $conn->execute($sql);
		$response['comments'] = $rs->getrows();
		$response['status'] = 1;	
        break;
    case 'Notice':
		$sql = "SELECT c.*, u.username FROM notice_comments AS c, signup AS u
			   WHERE c.NID = " .$id. " AND c.UID = u.UID";
		$rs  = $conn->execute($sql);
		$response['comments'] = $rs->getrows();
		$response['status'] = 1;	
        break;		
    case 'User':
		$sql = "SELECT c.*, u.username FROM wall AS c, signup AS u
			   WHERE c.OID = " .$id. " AND c.UID = u.UID";
		$rs  = $conn->execute($sql);
		$response['comments'] = $rs->getrows();
		foreach ($response['comments'] as $key => $value) {
			$comment = $response['comments'][$key]['message'];
            $comment        = preg_replace('/<img src="(.*?)\/media\/photos\/tmb\/(.*?)\.jpg" alt="" class="blog_image" \/>/ms', '[photo=\2]', $comment);
            $comment        = preg_replace('/<div class="row"><div class="col-md-8 col-md-offset-2"><div class="blog_video"><div id="blog_video_(.*?)"><iframe (.*?)<\/div><\/div><\/div><\/div>/ms', '[video=\1]', $comment);											 			
			$response['comments'][$key]['comment'] = $comment;		
			$response['comments'][$key]['CID'] = $response['comments'][$key]['wall_id'];
		}
		$response['status'] = 1;	
        break;		
}

echo json_encode($response);
die();
?>

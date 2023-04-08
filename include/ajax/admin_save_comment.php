<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'comment' => '');

$data = (array) $_POST['data'];

$id            = trim($data['id']);
$type          = trim($data['type']);
$comment       = trim($data['comment']);

settype($id, 'integer');
settype($type, 'string');
settype($comment, 'string');

switch ($type) {
    case 'Video':
			$sql = "UPDATE video_comments SET message = " .$conn->qStr($comment). "
				   WHERE CID = " .$id. " LIMIT 1";
			$conn->execute($sql);	
			$sql = "SELECT message from video_comments 
				   WHERE CID = " .$id. " LIMIT 1";
			$rs = $conn->execute($sql);
			$response['message'] = $rs->fields['message'];
			$response['status'] = 1;			
        break;	
    case 'Photo':
			$sql = "UPDATE photo_comments SET message = " .$conn->qStr($comment). "
				   WHERE CID = " .$id. " LIMIT 1";
			$conn->execute($sql);	
			$sql = "SELECT message from photo_comments 
				   WHERE CID = " .$id. " LIMIT 1";
			$rs = $conn->execute($sql);
			$response['message'] = $rs->fields['message'];
			$response['status'] = 1;		
        break;
    case 'Game':
			$sql = "UPDATE game_comments SET message = " .$conn->qStr($comment). "
				   WHERE CID = " .$id. " LIMIT 1";
			$conn->execute($sql);	
			$sql = "SELECT message from game_comments 
				   WHERE CID = " .$id. " LIMIT 1";
			$rs = $conn->execute($sql);
			$response['message'] = $rs->fields['message'];
			$response['status'] = 1;	
        break;
    case 'Blog':
			$sql = "UPDATE blog_comments SET message = " .$conn->qStr($comment). "
				   WHERE CID = " .$id. " LIMIT 1";
			$conn->execute($sql);	
			$sql = "SELECT message from blog_comments 
				   WHERE CID = " .$id. " LIMIT 1";
			$rs = $conn->execute($sql);
			$response['message'] = $rs->fields['message'];
			$response['status'] = 1;	
        break;
    case 'Notice':
			$sql = "UPDATE notice_comments SET message = " .$conn->qStr($comment). "
				   WHERE CID = " .$id. " LIMIT 1";
			$conn->execute($sql);	
			$sql = "SELECT message from notice_comments 
				   WHERE CID = " .$id. " LIMIT 1";
			$rs = $conn->execute($sql);
			$response['message'] = $rs->fields['message'];
			$response['status'] = 1;	
        break;		
    case 'User':
            $comment        = preg_replace('/\[photo=(.*?)\]/ms', '<img src="' .$config['BASE_URL']. '/media/photos/tmb/\1.jpg" alt="" class="blog_image" />', $comment);
			$comment        = preg_replace('/\[video=(.*?)\]/ms', '<div class="row"><div class="col-md-8 col-md-offset-2"><div class="blog_video"><div id="blog_video_\1"><iframe src="' .$config['BASE_URL'].'/view.php?VID=\1" frameborder="0" allowfullscreen></iframe></div></div></div></div>', $comment);			
			$sql = "UPDATE wall SET message = " .$conn->qStr($comment). "
				   WHERE wall_id = " .$id. " LIMIT 1";
			$conn->execute($sql);	
			$sql = "SELECT message from wall 
				   WHERE wall_id = " .$id. " LIMIT 1";
			$rs = $conn->execute($sql);
			$response['comment'] = $rs->fields['message'];
            $response['comment'] = preg_replace('/<img src="(.*?)\/media\/photos\/tmb\/(.*?)\.jpg" alt="" class="blog_image" \/>/ms', '[photo=\2]', $response['comment']);
            $response['comment'] = preg_replace('/<div class="row"><div class="col-md-8 col-md-offset-2"><div class="blog_video"><div id="blog_video_(.*?)"><iframe (.*?)<\/div><\/div><\/div><\/div>/ms', '[video=\1]', $response['comment']);											 						
			$response['status'] = 1;	
        break;		
}

echo json_encode($response);
die();
?>

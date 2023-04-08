<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/include/function_smarty.php';

$video  = array();
$VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? trim($_GET['VID']) : NULL;
settype($VID, 'integer');
if ( !$VID ) {
    $errors[] = 'Invalid video ID. This video does not exist!';
}

if ( !$errors ) {
    if ( isset($_GET['a'])) {
		$action = $_GET['a'];
		if ($action == 'approve' OR $action == 'activate' OR $action == 'suspend') {
			$action = ($action == 'activate' OR $action == 'approve') ? 'activate' : 'suspend';
			$status = ($action == 'activate' ) ? 1 : 0;
			$msg	= ($action == 'activate' ) ? 'activated' : 'suspended';
      		$sql = "UPDATE video SET active = '".$status."' WHERE VID = '" .$VID. "' LIMIT 1";
      		$conn->execute($sql);
			if ($action == 'activate') {
      			send_video_approve_email($VID);
			}
      		$messages[] = 'Video '.$msg.' successfuly!';
		}
    }

	$sql = "SELECT * FROM video WHERE VID = '".$VID."' LIMIT 1";
    $rs  = $conn->execute($sql);
	if ($conn->Affected_Rows()) {
        $video = $rs->getrows();
    } else {
        $errors[] = 'Invalid video ID. This video does not exist!';
	}
}

$sql        = "SELECT name FROM channel WHERE CHID = '" .$video['0']['channel']. "' LIMIT 1";
$rs         = $conn->execute($sql);
$channels   = $rs->getrows();

$video['0']['channel_name'] = $channels['0']['name'];

$smarty->assign('video', $video);
$smarty->assign('categories', get_categories());
?>

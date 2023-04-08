<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/auth.class.php';
require 'classes/filter.class.php';

if ( $config['video_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

if ($config['edit_videos'] == '0') {
	VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

Auth::check_();

$vid = get_request_arg('edit');
if ( !$vid ) {
    VRedirect::go($config['BASE_URL']. '/notfound/video_missing');
}

$uid = (int) $_SESSION['uid'];
$sql = "SELECT VID FROM video WHERE VID = ".$vid." AND UID = ".$uid." AND active = '1' LIMIT 1";
$conn->execute($sql);
if ($conn->Affected_Rows()) {
	$err['title'] = 0;
	$err['tags'] = 0;
	$err['category'] = 0;
	
	$categories = get_categories();
	if (isset($_POST['edit_submit'])) {
		$filter 	= new VFilter();
		$title		= $filter->get('title');
		$description = $filter->get('description');		
		$keyword	= $filter->get('keyword');
		$channel	= $filter->get('channel', 'INTEGER');
		$type		= $filter->get('type');
		$thumb		= $filter->get('thumb', 'INTEGER');
		
		if ( $title == '' ) {
      		$errors[] = $lang['upload.video_title_empty'];
      		$err['title'] = 1;
		}
		
		if ( $keyword == '' ) {
      		$errors[] = $lang['upload.video_tags_empty'];
			$err['tags'] = 1;
  		} else {
      		$keyword  = prepare_tags($keyword);
  		}

  		if ( $channel == '0' ) {
      		$errors[] = $lang['global.category_empty'];
			$err['category'] = 1;
  		}

		if (!$errors) {
			update_tags($vid, $keyword);
			$type  = ($type == 'public') ? 'public' : 'private';
			$thumb = ($thumb === 0) ? 1 : $thumb;
			$sql   = "UPDATE video
			          SET title = ".$conn->qStr($title).", 
						 description = ".$conn->qStr($description).", 
					     keyword = ".$conn->qStr($keyword).",
						 type = '".$type."',
						 channel = '".$channel."',
						 thumb = '".$thumb."'
					  WHERE VID = ".$vid."
					  AND UID = ".$uid."
					  AND active = '1'
					  LIMIT 1";
			$conn->execute($sql);
			$messages[] = $lang['edit.success'];
		}	
	}
	
	$sql   		= "SELECT * FROM video WHERE VID = ".$vid." AND UID = ".$uid." AND active = '1' LIMIT 1";
	$rs    		= $conn->execute($sql);
	$video 		= $rs->getrows();
	$video 		= $video['0'];
} else {
    VRedirect::go($config['BASE_URL']. '/notfound/video_missing');
}

$sql        = "SELECT * FROM signup WHERE UID = '" .$uid. "' LIMIT 1";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/user_missing');
}
$user       = $rs->getrows();
$user       = $user['0'];
$username   = $user['username'];

$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'videos');
$smarty->assign('submenu', '');
$smarty->assign('user', $user);
$smarty->assign('username', $username);
$smarty->assign('video', $video);
$smarty->assign('categories', $categories);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('edit.tpl');
$smarty->display('footer.tpl');
?>

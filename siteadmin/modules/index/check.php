<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$s = (isset($_GET['s'])) ? $_GET['s'] : '';

$err['directory'] = 0;
$err['file'] = 0;
$err['php'] = 0;
$err['support'] = 0;
$err['requirements'] = 0;

//Directory
$directory[]['path'] = '/cache/backend';
$directory[]['path'] = '/cache/frontend';
$directory[]['path'] = '/images/logo';
$directory[]['path'] = '/images/notice_images';
$directory[]['path'] = '/images/notice_images/thumbs';
$directory[]['path'] = '/media/albums';
$directory[]['path'] = '/media/categories/album';
$directory[]['path'] = '/media/categories/video';
$directory[]['path'] = '/media/csv';
$directory[]['path'] = '/media/photos';
$directory[]['path'] = '/media/photos/tmb';
$directory[]['path'] = '/media/player/logo';
$directory[]['path'] = '/media/users';
$directory[]['path'] = '/media/users/orig';
$directory[]['path'] = '/media/videos/tmb';
$directory[]['path'] = '/media/videos/vid';
$directory[]['path'] = '/media/videos/h264';
$directory[]['path'] = '/templates/emails';
$directory[]['path'] = '/tmp/albums';
$directory[]['path'] = '/tmp/avatars';
$directory[]['path'] = '/tmp/downloads';
$directory[]['path'] = '/tmp/logs';
$directory[]['path'] = '/tmp/sessions';
$directory[]['path'] = '/tmp/thumbs';
$directory[]['path'] = '/tmp/uploader';

//Files
$file[]['path'] = '/aembed.sh';
$file[]['path'] = '/include/config.local.php';
$file[]['path'] = '/templates/backend/default/analytics/analytics.tpl';
$file[]['path'] = '/templates/emails/blog_comment.tpl';
$file[]['path'] = '/templates/emails/friend_request.tpl';
$file[]['path'] = '/templates/emails/invite.tpl';
$file[]['path'] = '/templates/emails/photo_approve.tpl';
$file[]['path'] = '/templates/emails/photo_comment.tpl';
$file[]['path'] = '/templates/emails/photo_upload.tpl';
$file[]['path'] = '/templates/emails/player_email.tpl';
$file[]['path'] = '/templates/emails/recover_password.tpl';
$file[]['path'] = '/templates/emails/request_approved.tpl';
$file[]['path'] = '/templates/emails/request_rejected.tpl';
$file[]['path'] = '/templates/emails/share_photo.tpl';
$file[]['path'] = '/templates/emails/share_video.tpl';
$file[]['path'] = '/templates/emails/subscribe_email.tpl';
$file[]['path'] = '/templates/emails/verify_email.tpl';
$file[]['path'] = '/templates/emails/video_approve.tpl';
$file[]['path'] = '/templates/emails/video_comment.tpl';
$file[]['path'] = '/templates/emails/video_upload.tpl';
$file[]['path'] = '/templates/emails/wall_comment.tpl';
$file[]['path'] = '/templates/emails/welcome.tpl';		

require $config['BASE_DIR']. '/include/config.template.php';		
foreach ($templates as $key => $value)	{
	$file[]['path'] = '/templates/frontend/'.$key.'/static/2257.tpl';
	$file[]['path'] = '/templates/frontend/'.$key.'/static/advertise.tpl';
	$file[]['path'] = '/templates/frontend/'.$key.'/static/dmca.tpl';
	$file[]['path'] = '/templates/frontend/'.$key.'/static/faq.tpl';
	$file[]['path'] = '/templates/frontend/'.$key.'/static/privacy.tpl';
	$file[]['path'] = '/templates/frontend/'.$key.'/static/terms.tpl';
	$file[]['path'] = '/templates/frontend/'.$key.'/static/webmasters.tpl';
	$file[]['path'] = '/templates/frontend/'.$key.'/static/whatis.tpl';
}		

//Requirements

$requirements[0]['dp2'] = '/usr/local/bin/php';
$requirements[1]['dp2'] = '/usr/local/bin/ffmpeg';
$requirements[2]['dp2'] = '/usr/local/bin/ffprobe';

$requirements[0]['dp1'] = '/usr/bin/php';
$requirements[1]['dp1'] = '/usr/bin/ffmpeg';
$requirements[2]['dp1'] = '/usr/bin/ffprobe';

$requirements[0]['path'] = $config['phppath'];
$requirements[1]['path'] = $config['ffmpeg'];
$requirements[2]['path'] = $config['ffprobe'];

$requirements[0]['cname'] = 'phppath';
$requirements[1]['cname'] = 'ffmpeg';
$requirements[2]['cname'] = 'ffprobe';

$requirements[0]['name'] = 'PhpName';
$requirements[1]['name'] = 'FFMpeg';
$requirements[2]['name'] = 'FFProbe';



if ( isset($_POST['directory_fix']) ) {
	foreach ($directory as $key => $value) {
		if ( file_exists($config['BASE_DIR']. $value['path']) && is_dir($config['BASE_DIR']. $value['path'])) {
			chmod($config['BASE_DIR']. $value['path'], 0777);
		} else {
			mkdir($config['BASE_DIR']. $value['path'], 0777);
			chmod($config['BASE_DIR']. $value['path'], 0777);			
		}
	}
}
foreach ($directory as $key => $value) {
	if ( file_exists($config['BASE_DIR']. $value['path']) && is_dir($config['BASE_DIR']. $value['path'])) {
		if ( is_writable($config['BASE_DIR']. $value['path']) ) {
			$directory[$key]['result'] 	   = 'writable';			
		} else {
			$directory[$key]['result'] 	   = 'not writable';
		}
		$directory[$key]['permission'] = substr(sprintf('%o', fileperms($config['BASE_DIR']. $value['path'])), -4);				
	} else {
		$directory[$key]['result'] 	   = 'doesn\'t exist';
		$directory[$key]['permission'] = 'n/a';
	}
	if ($directory[$key]['permission'] != '0777') {
		$err['directory'] = 1;
	}
}
if ( isset($_POST['directory_fix']) ) {
	if (!$err['directory']) {
		$messages[] = 'Directory permissions successfully fixed!';
	} else {
		$errors[] = 'Failed to fix directory permissions!';		
	}
}

if ( isset($_POST['file_fix']) ) {
	foreach ($file as $key => $value) {
		if ( file_exists($config['BASE_DIR']. $value['path'])) {
			chmod($config['BASE_DIR']. $value['path'], 0777);
		}
	}
}
foreach ($file as $key => $value) {
	if ( file_exists($config['BASE_DIR']. $value['path']) ) {
		if ( is_writable($config['BASE_DIR']. $value['path']) ) {
			$file[$key]['result'] 	   = 'writable';			
		} else {
			$file[$key]['result'] 	   = 'not writable';
		}
		$file[$key]['permission'] = substr(sprintf('%o', fileperms($config['BASE_DIR']. $value['path'])), -4);				
	} else {
		$file[$key]['result'] 	   = 'doesn\'t exist';
		$file[$key]['permission'] = 'n/a';
	}
	if ($file[$key]['permission'] != '0777') {
		$err['file'] = 1;
	}
}
if ( isset($_POST['file_fix']) ) {
	if (!$err['file']) {
		$messages[] = 'File permissions successfully fixed!';
	} else {
		$errors[] = 'Failed to fix file permissions!';		
	}
}

$restrictions	= array('safe_mode' => '', 'open_basedir' => '');
$upload		    = array('max_upload_size' => '', 'max_post_size' => '');
$binaries  	    = array('php' => '<b>missing</b>', 'mencoder' => '<b>missing</b>', 'mplayer' => '<b>missing</b>', 'ffmpeg' => '<b>missing</b>', 'metainject' => '<b>missing</b>', 'metainject2' => '<b>missing</b>', 'mediainfo' => '<b>missing</b>', 'MP4Box' => '<b>missing</b>', 'neroAacEnc' => '<b>missing</b>');

$formats 	    = array('h264' => 'missing', 'faac' => 'missing', 'lame' => 'missing', 'xvid' => 'missing', 'theora' => 'missing', 'jpeg' => 'missing');
$formats_paths 	= array('h264' => '', 'faac' => '', 'lame' => '', 'xvid' => '', 'theora' => '', 'jpeg' => '');


$upload['max_upload_size'] 	= ini_get('upload_max_filesize');
$upload['max_post_size']	= ini_get('post_max_size');

$restrictions['safe_mode']	= ini_get('safe_mode');
$restrictions['open_basedir']	= ini_get('open_basedir');

if ($restrictions['safe_mode'] != '' || $restrictions['open_basedir'] != '') {
	$err['php'] = 1;
}


if ( isset($_POST['autofind_paths']) ) {
	foreach ($requirements as $key => $value) {
		if ( file_exists($value['path']) && is_file($value['path']) && is_executable($value['path']) )	{
			$requirements[$key]['result'] = 'found';
		} else {
			if ( file_exists($value['dp1']) && is_file($value['dp1']) && is_executable($value['dp1']) )	{
				$config[$value['cname']] = $value['dp1'];
				$messages[] = '<b>'.$value['name'].'</b> path found: <b>'.$value['dp1'].'</b>!';					
				if ( file_exists($value['dp2']) && is_file($value['dp2']) && is_executable($value['dp2']) ) {
					$warnings[] = '<b>'.$value['name'].'</b> path also found: <b>'.$value['dp2'].'</b>!';
				}				
			} elseif ( file_exists($value['dp2']) && is_file($value['dp2']) && is_executable($value['dp2']) ) {
				$config[$value['cname']] = $value['dp2'];
				$messages[] = '<b>'.$value['name'].'</b> path found: <b>'.$value['dp2'].'</b>!';					
			} else {
				$errors[] = '<b>'.$value['name'].'</b> is missing. The path couldn\'t be found!';
			}	

			$requirements[$key]['path'] = $config[$value['cname']];
		}
	}
	update_config($config);
	update_smarty();
	if ($warnings) {
		$warnings[] = 'Please visit <a href="'.$config['BASE_URL'].'/siteadmin/index.php?m=media"><b>Conversion Configuration</b></a> for advanced setup.';
	}
}

foreach ($requirements as $key => $value) {
	if ( file_exists($value['path']) && is_file($value['path']) && is_executable($value['path']) )	{
		$requirements[$key]['result'] = 'found';
	} else {
		$requirements[$key]['result'] = 'missing';
		$err['requirements'] = 1;
	}
}

$smarty->assign('requirements', $requirements);
$smarty->assign('directory', $directory);
$smarty->assign('file', $file);
$smarty->assign('restrictions', $restrictions);
$smarty->assign('upload', $upload);
$smarty->assign('s', $s);
?>

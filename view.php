<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'include/function_thumbs.php';

if (isset($_GET['VID']) && $_GET['VID'] != '') {
	$vid = intval($_GET['VID']);
} else {
	die();
}

$video_root = '';

$sql = "SELECT * from video WHERE VID = " .$conn->qStr($vid). " LIMIT 1";
$rs = $conn->execute($sql);

if ( $conn->Affected_Rows() == 1 ) {
	$video = $rs->getrows();
	$video = $video[0];
} else {
	die();
}

if ($video['embed_code'] == '') {
	$length = 8;
	$mykey = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	$iv = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);
	$secret = $mykey.".".$iv;	
	$formats = explode(',', $video['formats']);
	
	if ($video['server'] != '') {
		$sql = "SELECT * FROM video v, servers s WHERE v.VID = ".$vid." AND v.server = s.video_url LIMIT 1";
		$rs  = $conn->execute($sql); 
		$video_root = $rs->fields['video_url']; 
	}
	if (!$video_root) {
		$video_root = $config['BASE_URL']."/media/videos";
	}	
	
	foreach ($formats as $key => $value) {
		 unset($f);
		 $f = explode('.', $value);
		 $vf[$key]['height'] = $f[0];
		 $vf[$key]['label']  = $f[1]; 
		 $vf[$key]['format'] = $f[2];
		 $vf[$key]['file']   = $video['VID']."_".$vf[$key]['label'].".".$vf[$key]['format'];	
		 $vurl = $video_root.'/h264/'.$video['VID']."_".$vf[$key]['label'].".".$vf[$key]['format'];
		 $vf[$key]['url']   = encryptPhp($vurl, $mykey, $iv);		 
	}
	$video['files'] = $vf;



	//---- VJS
	$sql    = "SELECT * from player WHERE profile = 'Embed' LIMIT 1";
	$rs     = $conn->execute($sql);
	$player = $rs->getrows();
	$player = $player['0'];

	if ($player['timeline_preview'] == 1) {
		require_once 'classes/sprite.class.php';	
		$sprite = new images_to_sprite(get_thumb_dir($vid),get_thumb_dir($vid).'/sprite',$config['img_max_width'],$config['img_max_height']);
		$sprite->create_sprite();
		$player['sprite'] = get_thumb_url($vid).'/sprite.jpg';
	}
	$smarty->assign('player', $player);

	require_once 'classes/Mobile_Detect.php';

	$detect = new Mobile_Detect;
	if ( $detect->isMobile() ) {
		$device = 'm';
	} else {
		$device = 'd';
	}

	$sql = "SELECT channel FROM video WHERE VID = '". $vid ."' LIMIT 1";
	$rs = $conn->execute($sql);
	$category = $rs->fields['channel'];

	$sql = "SELECT id FROM adv_pause WHERE categories LIKE '%-".$category."-%' AND device LIKE '%".$device."%' AND status = '1' ORDER BY rand() LIMIT 1";
	$rs  = $conn->execute($sql);

	if ( $conn->Affected_Rows() != 1 ) {
		$smarty->assign('aid', false);
	} else {
		$ad  = $rs->getrows();
		$ad = $ad['0'];		
		$smarty->assign('aid', $ad['id']);	
	}
	
	$sql = "SELECT * FROM adv_vast_vpaid WHERE categories LIKE '%-".$category."-%' AND device LIKE '%".$device."%' AND status = '1' ORDER BY rand() LIMIT 1";
	$rs  = $conn->execute($sql);

	if ( $conn->Affected_Rows() != 1 ) {
		$smarty->assign('vast_vpaid', false);
	} else {
		$vast_vpaid  = $rs->getrows();
		$vast_vpaid = $vast_vpaid['0'];		
		$smarty->assign('vast_vpaid', $vast_vpaid);	
	}
	//---- VJS END
}

$sql        = "UPDATE video SET viewnumber = viewnumber+1, viewtime='" .date('Y-m-d H:i:s'). "' WHERE VID = " .$video['VID']. " LIMIT 1";
$conn->execute($sql);

$smarty->assign('video', $video);
$smarty->assign('video_root', $video_root);
$smarty->assign('vitem', $secret);
$smarty->display('view.tpl');
?>
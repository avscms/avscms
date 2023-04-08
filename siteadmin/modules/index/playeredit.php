<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$profile_id = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? intval($_GET['PID']) : NULL;
if ( !$profile_id ) {
    $errors[] = 'Player profile id not valid or not set!';
}
$player = array();

$sql    = "SELECT * FROM player WHERE id = " .$profile_id. " LIMIT 1";
$rs     = $conn->execute($sql);

if ( $conn->Affected_Rows() == '1' ) {
    $player = $rs->getrows();
    $player = $player['0'];		
} else {
    $errors[]    = 'Failed to load player profile!';
}

if ( isset($_POST['submit_settings']) && !$errors ) {

	//General Settings
	$autoplay 			= intval($_POST['autoplay']);
	$resolution 		= trim($_POST['resolution']);
	$timeline_preview   = intval($_POST['timeline_preview']);
	
	//Logo Settings
    $logo               = intval($_POST['logo']);
    $logo_redirect      = intval($_POST['logo_redirect']);	
    $logo_link          = trim($_POST['logo_link']);
    $logo_position      = trim($_POST['logo_position']);
    $logo_opacity       = intval($_POST['logo_opacity']);

	//Advertising Settings
	$pause_adv 			= intval($_POST['pause_adv']);
	$vast_vpaid_adv     = intval($_POST['vast_vpaid_adv']);	
	$timeline_adv 		= intval($_POST['timeline_adv']);	

	$sql   = "UPDATE player SET autoplay = " .$conn->qStr($autoplay). ", 
								resolution = " .$conn->qStr($resolution). ", 
								timeline_preview = " .$conn->qStr($timeline_preview). ", 
								logo = " .$conn->qStr($logo). ", 
								logo_redirect = " .$conn->qStr($logo_redirect). ", 								
								logo_link = " .$conn->qStr($logo_link). ", 
								logo_position = " .$conn->qStr($logo_position). ", 
								logo_opacity = " .$conn->qStr($logo_opacity). ", 
								pause_adv = " .$conn->qStr($pause_adv). ", 
								vast_vpaid_adv = " .$conn->qStr($vast_vpaid_adv). ", 								
								timeline_adv = " .$conn->qStr($timeline_adv). "								
			   WHERE id = '".$profile_id."' LIMIT 1";
	$conn->execute($sql);
	$messages[] = $player['profile'].' video player profile successfully updated!';
	
	$sql    = "SELECT * FROM player WHERE id = " .$profile_id. " LIMIT 1";
	$rs     = $conn->execute($sql);

	if ( $conn->Affected_Rows() == '1' ) {
		$player = $rs->getrows();
		$player = $player['0'];		
	} else {
		$errors[]    = 'Failed to load player profile!';
	}	
}

$smarty->assign('err', $err);
$smarty->assign('player', $player);
?>

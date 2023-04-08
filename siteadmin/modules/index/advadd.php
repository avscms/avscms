<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$adv    = array('name' => '', 'group' => 0, 'text' => '', 'status' => '1');
if ( isset($_POST['adv_add']) ) {
    $adv_name   = trim($_POST['adv_name']);
    $adv_group  = trim($_POST['adv_group']);
    $adv_text   = trim($_POST['adv_text']);
    $adv_status = trim($_POST['adv_status']);
    
    if ( $adv_name == '' ) {
        $errors[]       = 'Advertise name field cannot be left blank!';
		$err['adv_name'] = 1;
    }
    $adv['name']    = $adv_name;

    
    if ( $adv_group == '0' ) {
        $errors[]       = 'Please select an advertise group!';
		$err['adv_group'] = 1;		
    }
    $adv['group']   = intval($adv_group);

    
    if ( $adv_text == '' ) {
        $errors[]       = 'Advertise code textarea cannot be blank!';
		$err['adv_text'] = 1;			
    }
    $adv['text']    = $adv_text;

	$adv['status']      = ( $adv_status == '1' ) ? '1' : '0';
    
    if ( !$errors ) {
        $sql            = "INSERT INTO adv (adv_name, adv_group, adv_text, adv_addtime, adv_status)
                           VALUES (" .$conn->qStr($adv_name). ", " .intval($adv_group). ",
                                   " .$conn->qStr($adv_text). ", " .time(). ", " .$conn->qStr($adv_status). ")";                                   
        $conn->execute($sql);
        $messages[]     = 'Advertising banner successfully added!';
    }
}

$sql        = "SELECT advgrp_id, advgrp_name FROM adv_group ORDER BY advgrp_name ASC";
$rs         = $conn->execute($sql);
$advgroups  = $rs->getrows();

$smarty->assign('adv', $adv);
$smarty->assign('advgroups', $advgroups);
?>

<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$adv        = array('adv_id' => 0, 'adv_name' => '', 'adv_group' => 0, 'adv_text' => '', 'adv_status' => '0');

$AID    = ( isset($_GET['AID']) && advExists($_GET['AID']) ) ? intval($_GET['AID']) : NULL;
if ( !$AID ) {
    $errors[]    = 'Invalid advertise id!';
}

$adv['adv_id'] = $AID;

if ( isset($_POST['adv_edit']) && !$errors ) {
    $adv_name   = trim($_POST['adv_name']);
    $adv_group  = trim($_POST['adv_group']);
    $adv_text   = trim($_POST['adv_text']);
    $adv_status = trim($_POST['adv_status']);
    
    if ( $adv_name == '' ) {
        $errors[]       = 'Advertise name field cannot be left blank!';
		$err['adv_name'] = 1;		
    }
    $adv['adv_name']    = $adv_name;

    
    if ( $adv_group == '0' ) {
        $errors[]       = 'Please select an advertise group!';
		$err['adv_group'] = 1;			
    }
    $adv['adv_group']   = intval($adv_group);

    
    if ( $adv_text == '' ) {
        $errors[]       = 'Advertise code textarea cannot be blank!';
		$err['adv_text'] = 1;			
    }
    $adv['adv_text']    = $adv_text;

    
    $adv['adv_status']      = ( $adv_status == '1' ) ? '1' : '0';
    
    if ( !$errors ) {
        $sql            = "UPDATE adv SET adv_name = " .$conn->qStr($adv_name). ", adv_group = " .intval($adv_group). ",
                                          adv_text = " .$conn->qStr($adv_text). ", adv_status = " .$conn->qStr($adv_status). "
                           WHERE adv_id = " .intval($AID). " LIMIT 1";
        $conn->execute($sql);
        $messages[]     = 'Advertising banner successfully updated!';
    }
}

if ( !$errors ) {
    $sql    = "SELECT * FROM adv WHERE adv_id = " .intval($AID). " LIMIT 1";
    $rs     = $conn->execute($sql);
    $adv    = $rs->getrows();
    $adv    = $adv['0'];
}

$sql        = "SELECT advgrp_id, advgrp_name FROM adv_group ORDER BY advgrp_name ASC";
$rs         = $conn->execute($sql);
$advgroups  = $rs->getrows();

function advExists( $adv_id ) {
    global $conn;
    
    $sql    = "SELECT adv_id FROM adv WHERE adv_id = " .intval($adv_id). " LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

$smarty->assign('adv', $adv);
$smarty->assign('advgroups', $advgroups);
?>

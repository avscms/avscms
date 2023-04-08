<?php
defined('_VALID') or die('Restricted Access!');
require '../include/function_global.php';
Auth::checkAdmin();

$adv    = array('name' => '', 'adtagurl' => '', 'adscanceltimeout'=> '5000', 'status' => '1', 'device' => 'dm', 'categories' => '');


if ( isset($_POST['adv_add']) ) {
    $adv['name']   = trim($_POST['adv_name']);
    $adv['adtagurl']   = $_POST['adv_adtagurl'];
    $adv['status'] = trim($_POST['adv_status']);
    $adv['device'] = trim($_POST['adv_device']);	
    $adv['adscanceltimeout'] = trim($_POST['adv_adscanceltimeout']);	
	 
    if (  $adv['name'] == '' ) {
        $errors[]       = 'Advertise name field cannot be left blank!';
		$err['name'] = 1;
    }
 
    if ( $adv['adtagurl'] == '' ) {
        $errors[]       = 'Advertise adtagurl textarea cannot be blank!';
		$err['adtagurl'] = 1;			
    }
	
	$adv['categories'] = '-';	
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_categories' && substr($key, 0, 9) == 'category_') {        
            if ( $value == '1' ) {
                $cid = intval(str_replace('category_', '', $key));
				$adv['categories'] = $adv['categories'].$cid.'-';
            }
        }
    }	
	if ($adv['categories'] == '-') {
        $errors[]       = 'Please select at least one video category!';
		$err['category'] = 1;
	}

    if ( !$errors ) {
        $sql            = "INSERT INTO adv_vast_vpaid (name, adtagurl, adscanceltimeout, device, categories, status)
                           VALUES (" .$conn->qStr($adv['name']). ", 
                                   " .$conn->qStr($adv['adtagurl']). ", 
                                   " .$conn->qStr($adv['adscanceltimeout']). ", 								   
                                   " .$conn->qStr($adv['device']). ", 
                                   " .$conn->qStr($adv['categories']). ", 
								   " .$conn->qStr($adv['status']). ")";                          
        $conn->execute($sql);
        $messages[]     = 'Vast-Vpaid ad successfully added!';
    }
}

$categories = get_categories();

if ($adv['categories'] == '') {
	foreach ($categories as $k => $v) {
		$categories[$k]['checked'] = 1;
	}
} else {
	foreach ($categories as $k => $v) {
		if (strpos($adv['categories'],'-'.$categories[$k]['CHID'].'-') !== false) {
			$categories[$k]['checked'] = 1;
		} else {
			$categories[$k]['checked'] = 0;
		}
	}
}
$smarty->assign('adv', $adv);
$smarty->assign('categories', $categories);
?>

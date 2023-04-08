<?php
defined('_VALID') or die('Restricted Access!');
require '../include/function_global.php';
Auth::checkAdmin();

$adv    = array('name' => '', 'code' => '', 'status' => '1', 'device' => 'dm', 'categories' => '');

$AID = ( isset($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
$sql = "SELECT * FROM adv_pause WHERE id = " .$AID. " LIMIT 1";
$rs  = $conn->execute($sql);
if ( !$conn->Affected_Rows() === 1 ) {
    $errors[] = 'Invalid pause ad ID! Are you sure this ad exists?!';
} else {
    $adv = $rs->getrows();
    $adv = $adv['0'];
}


if ( isset($_POST['adv_edit']) && !$errors ) {
    $adv['name']   = trim($_POST['adv_name']);
    $adv['code']   = $_POST['adv_code'];
    $adv['status'] = trim($_POST['adv_status']);
    $adv['device'] = trim($_POST['adv_device']);	
    
    if (  $adv['name'] == '' ) {
        $errors[]       = 'Advertise name field cannot be left blank!';
		$err['name'] = 1;
    }
 
    if ( $adv['code'] == '' ) {
        $errors[]       = 'Advertise code textarea cannot be blank!';
		$err['code'] = 1;			
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
        $sql            = "UPDATE adv_pause SET
								  name = " .$conn->qStr($adv['name']). ", 
								  code = " .$conn->qStr($adv['code']). ", 
                                  device = " .$conn->qStr($adv['device']). ", 
                                  categories = " .$conn->qStr($adv['categories']). ", 
								  status = " .$conn->qStr($adv['status']). " 
								  WHERE id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        $messages[]     = 'Pause ad successfully updated!';
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

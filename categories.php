<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_smarty.php';

$s      = ( isset($_GET['s']) && ($_GET['s'] == 'a' or $_GET['s'] == 'g') ) ? $_GET['s'] : '';

if ($s == "a") {
	$sql            = "SELECT CID, name, slug FROM album_categories ORDER BY name ASC";
	$rs             = $conn->execute($sql);
	$categories     = $rs->getrows();

	$sql = "SELECT category FROM albums WHERE status = '1'";
	$rs             = $conn->execute($sql);
	$alb		    = $rs->getrows();

	$cat = array();

	foreach ( $alb as $album ) {
		$cat[$album['category']]++;
	}
	foreach ($categories as $k => $v) {
		$categories[$k]['total'] = 0;
		foreach ($cat as $key => $cat_val) {
			if ($key == $v['CID']) {
				$categories[$k]['total'] = $cat_val;
			}
		}
		$sql            = "UPDATE `album_categories` SET `total_albums`=".$categories[$k]['total']." WHERE CID = ".$categories[$k]['CID']."";
		$rs             = $conn->execute($sql);		
	}
	
} else {
	$sql            = "SELECT CHID, name, slug FROM channel ORDER BY name ASC";
	$rs             = $conn->execute($sql);
	$categories     = $rs->getrows();

	$sql = "SELECT channel FROM video WHERE active = '1'";
	$rs             = $conn->execute($sql);
	$vid		    = $rs->getrows();

	$cat = array();

	foreach ( $vid as $video ) {
		$cat[$video['channel']]++;
	}
	foreach ($categories as $k => $v) {
		$categories[$k]['total'] = 0;		
		foreach ($cat as $key => $cat_val) {
			if ($key == $v['CHID']) {
				$categories[$k]['total'] = $cat_val;
			}
		}
		$sql            = "UPDATE `channel` SET `total_videos`=".$categories[$k]['total']." WHERE CHID = ".$categories[$k]['CHID']."";
		$rs             = $conn->execute($sql);		
	}
}

if ($s == "a") {
	$smarty->assign('section', "a");
} else {
	$smarty->assign('section', "v");
}

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'categories');
$smarty->assign('catgy', true);
$smarty->assign('categories', $categories);
$smarty->assign('self_title', $seo['categories_title']);
$smarty->assign('self_description', $seo['categories_desc']);
$smarty->assign('self_keywords', $seo['categories_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('categories.tpl');
$smarty->display('footer.tpl');
?>

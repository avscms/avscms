<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/image.class.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'src' => '');

$filter = new VFilter();
$aid    = $filter->get('album_id', 'INTEGER');
$pid    = $filter->get('photo_id', 'INTEGER');
$x1     = $filter->get('x1', 'INTEGER');
$y1     = $filter->get('y1', 'INTEGER');
$x2     = $filter->get('x2', 'INTEGER');
$y2     = $filter->get('y2', 'INTEGER');
$iw     = $filter->get('iw', 'INTEGER');
$ih     = $filter->get('ih', 'INTEGER');

$src    = $config['BASE_DIR']. '/media/photos/' .$pid. '.jpg';
$dst    = $config['BASE_DIR']. '/media/albums/' .$aid. '.jpg';
if ( file_exists($src) && is_file($src) ) {

	list($w, $h) = getimagesize($src);

	$p = $w / $iw;
	
	$x = floor($p * $x1);
	$y = floor($p * $y1);
	
	$width  = floor($p * ($x2 - $x1));
	$height = floor($p * ($y2 - $y1));
	
	$image  = new VImageConv();
	$image->process($src, $dst, 'EXACT', $w, $h);
	$image->resize(true, true);
	$image->process($dst, $dst, 'EXACT', $width, $height);
	$image->crop($x, $y, $width, $height, true);
	$image->process($dst, $dst, 'EXACT', 400, 400);
	$image->resize(true, true);
	$response['status'] = 1;
}

$response['src'] = $config['BASE_URL']. '/media/albums/' .$aid. '.jpg';

echo json_encode($response);
die();
?>

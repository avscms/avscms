<?php
defined('_VALID') or die('Restricted Access!');

$preview    = array();
$preview[]  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
$preview[]  = '<html xmlns="http://www.w3.org/1999/xhtml">';
$preview[]  = '<head>';
$preview[]  = '<title>Static Preview</title>';
$preview[]  = '<link rel = "stylesheet" href = "' .$config['BASE_URL']. '/css/style_static_preview.css" type = "text/css" />';
$preview[]  = '<script type="text/javascript" src="' .$config['BASE_URL']. '/js/jquery-1.2.6.pack.js"></script>';
$preview[]  = '<script type="text/javascript" src="' .$config['BASE_URL']. '/js/flashembed.min.js"></script>';
$preview[]  = '</head>';
$preview[]  = '<body>';

$html       = NULL;
if ( isset($_POST['data']) ) {
    $html       = trim($_POST['data']);
}

$preview[]  = $html;
$preview[]  = '</body>';
$preview[]  = '</html>';

echo implode("\n", $preview);
die();
?>

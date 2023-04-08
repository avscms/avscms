<?php
defined('_VALID') or die('Restricted Access!');

$preview    = array();
$preview[]  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
$preview[]  = '<html xmlns="http://www.w3.org/1999/xhtml">';
$preview[]  = '<head>';
$preview[]  = '<title>Static Preview</title>';
$preview[]  = '<link rel = "stylesheet" href = "' .$config['BASE_URL']. '/css/style_notice_preview.css" type = "text/css" />';
$preview[]  = '<script type="text/javascript" src="' .$config['BASE_URL']. '/js/jquery-1.2.6.pack.js"></script>';
$preview[]  = '<script type="text/javascript" src="' .$config['BASE_URL']. '/js/flashembed.min.js"></script>';
$preview[]  = '</head>';
$preview[]  = '<body>';
$preview[]  = '<div id="content">';
$preview[]  = '<div class="box span-100">';
$preview[]  = '<div class="bsub">&nbsp;</div>';
$preview[]  = '<div class="btitle"><h2>NOTICE TITLE HERE</h2></div>';
$preview[]  = '<div class="blink">';
$preview[]  = '<div class="blinkl">Addtime Here</div>';
$preview[]  = '<div class="blinkr">by: <a href="">username here</a></div>';
$preview[]  = '<div class="clear"></div>';
$preview[]  = '</div>';
$preview[]  = '<div class="notice_content">';

$html       = NULL;
if ( isset($_POST['data']) ) {
    $html       = trim($_POST['data']);
}

$preview[]  = $html;
$preview[]  = '</div>';
$preview[]  = '</div>';
$preview[]  = '</div>';
$preview[]  = '</body>';
$preview[]  = '</html>';

echo implode("\n", $preview);
die();
?>

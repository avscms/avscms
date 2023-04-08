<?php
defined('_VALID') or die('Restricted Access!');
$config = array();
$config['BASE_URL'] = 'http://www.yourdomain.com';
$config['RELATIVE'] = '';
$config['BASE_DIR'] = dirname(dirname(__FILE__));
$config['TMP_DIR'] = $config['BASE_DIR']. '/tmp';
$config['TMP_URL'] = $config['BASE_URL']. '/tmp';
$config['LOG_DIR'] = $config['BASE_DIR']. '/tmp/logs';
$config['IMG_DIR'] = $config['BASE_DIR']. '/images';
$config['IMG_URL'] = $config['BASE_URL']. '/images';
$config['PHO_DIR'] = $config['BASE_DIR']. '/media/users';
$config['PHO_URL'] = $config['BASE_URL']. '/media/users';
$config['VDO_DIR'] = $config['BASE_DIR']. '/media/videos/vid';
$config['VDO_URL'] = $config['BASE_URL']. '/media/videos/vid';
$config['FLVDO_DIR'] = $config['BASE_DIR']. '/media/videos/flv';
$config['FLVDO_URL'] = $config['BASE_URL']. '/media/videos/flv';
$config['TMB_DIR'] = $config['BASE_DIR']. '/media/videos/tmb';
$config['TMB_URL'] = $config['BASE_URL']. '/media/videos/tmb';

$config['HD_DIR'] = $config['BASE_DIR'].'/media/videos/hd';
$config['HD_URL'] = $config['BASE_URL'].'/media/videos/hd';
$config['IPHONE_DIR'] = $config['BASE_DIR'].'/media/videos/iphone';
$config['IPHONE_URL'] = $config['BASE_URL'].'/media/videos/iphone';
$config['H264_DIR'] = $config['BASE_DIR'].'/media/videos/h264';
$config['H264_URL'] = $config['BASE_URL'].'/media/videos/h264';		
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/classes/image.class.php';

$data   = array('status' => false, 'width' => 0, 'height' => 0);
if ( isset($_POST['PID']) && isset($_POST['random']) ) {
    $filter = new VFilter();
    $PID    = $filter->get('PID', 'INTEGER');
    $random = $filter->get('random');
    $src    = $config['BASE_DIR']. '/media/photos/' .$PID. '.jpg';
    if ( file_exists($src) && is_file($src) ) {
        $dst    = $config['BASE_DIR']. '/tmp/albums/' .$PID. '_' .$random. '.jpg';
        $image  = new VImageConv();
        $image->process($src, $dst, 'MAX_WIDTH', 580, 580);
        $image->resize(true, true);
        $image  = getimagesize($dst);
        $data['status'] = true;
        $data['width']  = $image['0'];
        $data['height'] = $image['1'];
    }
}
echo json_encode($data);
die();
?>

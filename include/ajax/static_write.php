<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/auth.class.php';

Auth::checkAdmin();

$response   = 0;
if ( isset($_POST['page']) && isset($_POST['html']) ) {
    $filter         = new VFilter();
    $page           = $filter->get('page');
    $html           = trim($_POST['html']);
    $pages_allowed  = array('terms', 'privacy', 'dmca', '2257', 'advertise', 'faq', 'webmasters', 'whatis');
    if ( in_array($page, $pages_allowed) ) {
        $static_path    = $config['BASE_DIR']. '/templates/frontend/' .$config['template']. '/static/' .$page. '.tpl';
        file_put_contents($static_path, $html);
        $response = 1;
    }
}

echo $response;
die();
?>

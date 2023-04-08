<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/file.class.php';
require $config['BASE_DIR']. '/classes/auth.class.php';

Auth::checkAdmin();

$html   = NULL;
if ( isset($_POST['page']) ) {
    $filter         = new VFilter();
    $page           = $filter->get('page');
    $pages_allowed  = array('terms', 'privacy', 'dmca', '2257', 'advertise', 'faq', 'webmasters', 'whatis');
    if ( in_array($page, $pages_allowed) ) {
        $static_path    = $config['BASE_DIR']. '/templates/frontend/' .$config['template']. '/static/' .$page. '.tpl';
        if ( file_exists($static_path) && is_file($static_path) ) {
            $html   = VFile::read($static_path);
        }
    }
}

echo $html;
die();
?>
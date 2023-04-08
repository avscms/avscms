<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_bandwidth']) ) {
    $filter                     = new VFilter();
    $guest_limit                = $filter->get('guest_limit');
    $guest_bandwidth            = $filter->get('guest_bandwidth', 'INTEGER');
    
    $config['guest_limit']      = ( $guest_limit == '1' ) ? '1' : '0';
    $config['guest_bandwidth']  = $guest_bandwidth;
    
    update_config($config);
    update_smarty();
    $messages[] = 'Guest bandwidth settings successfuly updated!';
}
?>

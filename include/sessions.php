<?php
defined('_VALID') or die('Restricted Access!');

ini_set('session.name', 'AVS');
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 0);
ini_set('session.gc_maxlifetime', intval($config['session_lifetime']));
//session_set_cookie_params( 0, '/', '.yourdomain.com');
if ( $config['session_driver'] == 'database' ) {
    require $config['BASE_DIR']. '/classes/session.class.php';
	if (version_compare(PHP_VERSION, '7.2.0') >= 0) {	
		// PHP 7.2.0+
	} else {
		ini_set('session.save_handler', 'user');
	}
    session_set_save_handler(array('Session', 'open'),
                             array('Session', 'close'),
                             array('Session', 'read'),
                             array('Session', 'write'),
                             array('Session', 'destroy'),
                             array('Session', 'gc'));
} else {
	if (version_compare(PHP_VERSION, '7.2.0') >= 0) {	
		// PHP 7.2.0+
	} else {
		ini_set('session.save_handler', 'files');
	}    
    ini_set('session.save_path', $config['BASE_DIR']. '/tmp/sessions');
}
session_start();
?>

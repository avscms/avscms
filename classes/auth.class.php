<?php
class Auth
{
    public function check()
    {
        if ( isset($_SESSION['uid']) && isset($_SESSION['email']) ) {
            if ( $_SESSION['uid'] != '' && $_SESSION['email'] != '' ) {
                return true;
            }
        }
        
        global $config;
        $_SESSION['redirect'] = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : $config['BASE_URL'];
        VRedirect::go($config['BASE_URL']. '/login');
    }
	
    public static function check_()
    {
        if ( isset($_SESSION['uid']) && isset($_SESSION['email']) ) {
            if ( $_SESSION['uid'] != '' && $_SESSION['email'] != '' ) {
                return true;
            }
        }
        
        global $config;
        $_SESSION['redirect'] = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : $config['BASE_URL'];
        VRedirect::go($config['BASE_URL']. '/login');
    }	
    
    public static function checkAdmin()
    {
        global $config;
    
        $access = false;
        if ( isset($_SESSION['AUID']) && isset($_SESSION['APASSWORD']) ) {
            if ( $_SESSION['AUID'] == $config['admin_name'] && $_SESSION['APASSWORD'] == $config['admin_pass'] ) {
                $access = true;
            }
        }
        
        if ( !$access ) {
            VRedirect::go($config['BASE_URL']. '/siteadmin/login.php');
        }
    }
    
    public function confirm()
    {
        global $config;
    
        if ( $config['email_verification'] == '0' ) {
            return true;
        }
    
        if ( isset($_SESSION['uid']) && isset($_SESSION['email']) ) {
            if ( isset($_SESSION['emailverified']) && $_SESSION['emailverified'] == 'yes' ) {
                return true;
            }
        }
        
        $_SESSION['redirect'] = ( isset($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : $config['BASE_URL'];
        VRedirect::go($config['BASE_URL']. '/confirm');
    }
}
?>

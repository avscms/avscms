<?php
defined('_VALID') or die('Restricted Access!');

if ( get_magic_quotes_gpc() ) {
    $in = array(&$_GET, &$_POST, &$_COOKIE);
    while ( list($k,$v) = each($in) ) {
        foreach ($v as $key => $val) {
            if (!is_array($val)) {
                $in[$k][$key] = stripslashes($val);
                continue;
            }
            $in[] =& $in[$k][$key];
        }
    }
    unset($in);
}

function disableRegisterGlobals()
{
    if( (bool)@ini_get('register_globals') ) {
        $noUnset    = array('GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');                                                                   
        $input      = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());
    
        foreach ($input as $k => $v) {
            if (!in_array($k, $noUnset) && isset($GLOBALS[$k])) {
                unset($GLOBALS[$k]);
            }
        }
    }
}
?>

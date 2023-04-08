<?php
defined('_VALID') or die('Restricted Access!');

function getServerURL()
{
    $serverName = NULL;
    if ( isset($_SERVER['SERVER_NAME']) ) {
        $serverName = $_SERVER['SERVER_NAME'];
    } elseif ( isset($_SERVER['HTTP_HOST']) ) {
        $serverName = $_SERVER['HTTP_HOST'];
    } elseif ( isset($_SERVER['SERVER_ADDR']) ) {
        $serverName = $_SERVER['SERVER_ADDR'];
    } else {
        $serverName = 'localhost';
    }

    $serverProtocol = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https' : 'http';
    $serverPort     = NULL;
    if ( isset($_SERVER['SERVER_PORT']) && !strpos($serverName, ':') &&
       ( ($serverProtocol == 'http' && $_SERVER['SERVER_PORT'] != 80) ||
       ($serverProtocol == 'https' && $_SERVER['SERVER_PORT'] != 443) )) {
        $serverPort = $_SERVER['SERVER_PORT'];
    }
    
    return $serverProtocol. '://' .$serverName;
}
    
function getBaseURL()
{
    $serverURL      = getServerURL();
    $scriptPath     = NULL;
    if ( isset($_SERVER['SCRIPT_NAME']) ) {
        $scriptPath = $_SERVER['SCRIPT_NAME'];
        $scriptPath = ( $scriptPath == '/' ) ? '' : dirname($scriptPath);
    }
      
    $baseURL = $serverURL . $scriptPath;
    
    return $baseURL;
}
    
function getRequestURL()
{
    $serverURL      = getServerURL();
    $requestURL     = $_SERVER['REQUEST_URI'];
      
    return $serverURL . $requestURL;
}
?>

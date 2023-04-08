<?php
defined('_VALID') or die('Restricted Access!');

class VRedirect
{
    public static function go( $url ) 
    {
        session_write_close();
        if ( headers_sent() ) {
            echo "<script>document.location.href='" .$url. "';</script>\n";
        } else {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '. $url);
        }
        die();
    }
}
?>
<?php
defined('_VALID') or die('Restricted Access!');

class VFile
{
    static function getExtension( $file )
    {
        return strtolower(substr($file, strrpos($file, '.')+1));
    }
    
    static function getFilename( $file )
    {
        return substr($file, strrpos($file, DIRECTORY_SEPARATOR)+1);
    }
    
    static function read( $path, $amount=0, $chunksize=8192, $offset=0 )
    {
        $data   = NULL;
        if ( $amount && $chunksize > $amount ) {
            $chunksize = $amount;
        }
        
        if ( false === $handle = fopen($path, 'rb') ) {
            return false;
        }
        
        clearstatcache();
        
        if ( $offset ) {
            fseek($handle, $offset);
        }
        
        if ( $fsize = @filesize($path)) {
            if($amount && $fsize > $amount) {
                $data = fread($handle, $amount);
            } else {
                $data = fread($handle, $fsize);
            }
        } else {
            $data   = '';
            $x      = 0;
            while ( !feof($handle) && (!$amount || strlen($data) < $amount) ) {
                $data .= fread($handle, $chunksize);
            }
        }
        
        fclose($handle);
        
        return $data;
    }
        
    static function write( $path, $data )
    {
        if ( !file_exists($path) ) {
            $dir = dirname($path);
            if ( !file_exists($dir) || !is_dir($dir) || !is_writable($dir) ) {
                return false;
            }
        } else {
            if ( !is_file($path) || !is_writable($path) ) {
                return false;
            }

            $mode = 'a';
        }
        
        if ( !$handle = fopen($path, $mode) ) {
            return false;
        }
        
        if ( fwrite($handle, $data) == FALSE ) {
            return false;
        }
        
        fclose($handle);
    }

    static function delete( $path )
    {
        if ( file_exists($path) && is_file($path) ) {
            @unlink($path);
        }
    }
}
?>

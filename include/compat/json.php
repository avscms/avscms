<?php
defined('_VALID') or die('Restricted Access!');

if ( !function_exists('json_encode') ) {
    function json_encode( $data=false )
    {
        if ( is_null($data) ) { return 'null'; }        
        if ( $data === false ) { return 'false'; }
        if ( $data === true ) { return 'true'; }
        if ( is_scalar($data) ) {
            if ( is_float($data) ) {
                return floatval(str_replace(',', '.', strval($data)));
            }
            
            if ( is_string($data) ) {
                static $replace = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($replace['0'], $replace['1'], $data) . '"';
            }
            
            return $data;
        }
        
        $valid  = true;
        $count  = count($data);
        for ( $i = 0, reset($data); $i < $count; $i++, next($data) ) {
            if ( key($data) !== $i ) {
                $valid = false;
                break;
            }
        }
        
        $result = array();
        if ( $valid ) {
            foreach ( $data as $v ) { 
                $result[] = json_encode($v);
            }
            
            return '[' . join(',', $result) . ']';
        } else {
            foreach ( $data as $k => $v ) {
                $result[] = json_encode($k).':'.json_encode($v);
            }
            
            return '{' . join(',', $result) . '}';
        }
    }
}
?>

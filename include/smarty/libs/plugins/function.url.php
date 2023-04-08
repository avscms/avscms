<?php
function smarty_function_url($params, &$smarty)
{
    global $config;
    
    $base       = $params['base'];
    $strip      = $params['strip'];
    $arg        = ( isset($params['value']) ) ? $params['value'] : NULL;
    $query      = NULL;
    
    foreach ( $_GET as $key => $value ) {
        if ( $key != $strip ) {
			if ( $key != 'page' )
            $query .= '&' .$key. '=' .$value;
        }
    }
    
    if ( $arg ) {
        $query .= '&' .$strip. '=' .$arg;
    }
    
    if ( $query ) {
        $query = '?' .substr($query, 1);
    }
    
    return str_replace('&', '&', $config['RELATIVE']. '/' .$base . htmlspecialchars($query, ENT_QUOTES, 'UTF-8'));
}
?>

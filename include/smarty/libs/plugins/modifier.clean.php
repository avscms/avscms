<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty clean modifier plugin
 *
 * Type:     modifier<br>
 * Name:     clean<br>
 * Purpose:  remove all characters except 0-9a-zA-Z and replace spaces with -
 * @param string
 * @return string
 */
function smarty_modifier_clean($string)
{
    if (preg_match('/^.$/u', 'ñ')) {
        $string = preg_replace('/[^\pL\pN\pZ]/u', ' ', $string);
        $string = preg_replace('/\s\s+/', ' ', $string);
    } else {
        $string = preg_replace('/[^ 0-9a-zA-Z]/', ' ', $string);
        $string = preg_replace('/\s\s+/', ' ', $string);
    }
    $string = trim($string);
    $string = str_replace(' ', '-', $string);
    
    return mb_strtolower($string);
}

?>

<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty translate function plugin
 *
 * Type:     function<br>
 * Name:     translate<br>
 * Purpose:  translate a string which has more then one argument<br>
 * @author Adrian Teodor (adrian.teodor@gmail.com)
 * @param array
 * @param Smarty
 */
function smarty_function_translate($params, &$smarty)
{
    global $lang;
	
	$args = array();
	foreach ($params as $key => $value) {
		$args[] = $value;
	}
	
    if (!is_array($args)) {
        $args = func_get_args();
    }

    $code           = $args['0'];
    $translation    = FALSE;
    if (isset($lang[$code])) {
        $translation = $lang[$code];
    }

    if (isset($args['1']) && $translation) {
        $args   = array_slice($args, 1);
        return vsprintf($translation, $args);
    } else {
        return $translation;
    }

    return '';
}
?>

<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty escape modifier plugin
 *
 * Type:     modifier<br>
 * Name:     escape<br>
 * Purpose:  Escape the string according to escapement type
 * @link http://smarty.php.net/manual/en/language.modifier.escape.php
 *          escape (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param html|htmlall|url|quotes|hex|hexentity|javascript
 * @return string
 */
function smarty_modifier_queue($start )
{
	if($start>0) {
		$diff= time() - $start;
		if($diff>3600) {
			$diff = date('h:i:s',$diff);
		} else {
			$diff = date('i:s',$diff);
		}
		return $diff;

	} else return '';
}

/* vim: set expandtab: */

?>

<?php
defined('_VALID') or die('Restricted Access!');

if (extension_loaded('mbstring')) {
    if (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING) {
        die('The <a href="http://php.net/mbstring">mbstring</a> extension is overloading PHP\'s native string functions. '.
            'Disable this by setting mbstring.func_overload to 0, 1, 4 or 5 in php.ini or a .htaccess file.'.
            'This application cannot be run without UTF-8 support.');
    } else {
        @ini_set('mbstring.internal_encoding', 'UTF-8');
        @ini_set('mbstring.http_input', 'UTF-8');
        @ini_set('mbstring.http_output', 'UTF-8');
        define('MB_STRING', TRUE);
    }
} else {
    define('MB_STRING', FALSE);
}

if ($config['force_utf8'] == '1') {
	if (!preg_match('/^.$/u', 'ñ')) {
  		die('<a href="http://php.net/pcre">PCRE</a> has not been compiled with UTF-8 support. '.
      		'See <a href="http://php.net/manual/reference.pcre.pattern.modifiers.php">PCRE Pattern Modifiers</a> '.
      		'for more information. This application cannot be run without UTF-8 support.');
	}
}

if (!MB_STRING) {
	function mb_strlen($string)
	{
		return strlen($string);
	}
	
	function mb_strpos($string, $needle, $offset=NULL)
	{
		return strpos($string, $needle, $offset);
	}
	
	function mb_strtolower($string)
	{
		return strtolower($string);
	}
	
	function mb_strtoupper($string)
	{
		return strtoupper($string);
	}
	
	function mb_substr($string, $start, $length=NULL)
	{
		return substr($string, $start, $length);
	}
}

function insert_language($options)
{
	global $languages;
	return $languages[$_SESSION['language']]['flag'];
}
?>

<?php
defined('_VALID') or die('Restricted Access!');

define('DEBUG', false);
ini_set('display_errors', 0);
if ( DEBUG ) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
?>

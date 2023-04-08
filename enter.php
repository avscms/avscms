<?php
define('_VALID', true);
define('_ENTER', true);
require 'include/config.php';

setcookie('splash', true, time()+(3600*12*7*52));

$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('enter.tpl');
?>

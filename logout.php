<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
if ( $config['user_remember'] == '1' ) {
    Remember::del();
}

unset($_SESSION['uid']);
unset($_SESSION['uid_premium']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['emailverified']);
unset($_SESSION['photo']);
unset($_SESSION['fname']);
unset($_SESSION['gender']);

$_SESSION['message'] = $lang['logout.msg'];
session_write_close();
header('Location: ' .$config['BASE_URL']);
die();
?>

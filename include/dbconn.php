<?php
defined('_VALID') or die('Restricted Access!');

$conn = ADONewConnection($config['db_type']);
if ( !$conn->Connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']) ) {
    echo 'Could not connect to mysql! Please check your database settings!';
    die();
}
$conn->execute("SET NAMES 'utf8'");
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

disableRegisterGlobals();

if ( isset($_POST['username']) ) {
    $filter     = new VFilter();
    $username   = $filter->get('username');
    $response   = '<span class="text-danger">'.$lang['ajax.username_empty'].'</span>';
    if ( $username != '' ) {
        $sql = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $response = '<span class="text-danger">'.$lang['ajax.username_used'].'</span>';
        } else {
            $response = '<span class="text-success">'.$lang['ajax.username_available'].'</span>';
        }
    }
    
    echo $response;
}
?>

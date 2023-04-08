<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$notice = array();
$NID    = ( isset($_GET['NID']) && is_numeric($_GET['NID']) ) ? intval($_GET['NID']) : NULL;
if ( $NID ) {
    $sql    = "SELECT * FROM notice WHERE NID = " .$NID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() === 1 ) {
        $notice = $rs->getrows();
    } else {
        $errors[] = 'Invalid notice id. Are you sure this notice exists?!';
    }
} else {
    $errors[] = 'Invalid notice id or not set?!';
}

$smarty->assign('notice', $notice);
?>

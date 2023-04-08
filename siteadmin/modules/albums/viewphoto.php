<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$AID    = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? intval($_GET['AID']) : NULL;
$PID    = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? intval($_GET['PID']) : NULL;
if ( isset($_GET['a']) ) {
    $action = trim($_GET['a']);
    switch ( $action ) {
        case 'delete':
            $tables = array('photos', 'photo_favorites', 'photo_comment', 'photo_flags', 'photo_rating_id', 'photo_rating_ip');
            foreach ($tables as $table) {
                $sql    = "DELETE FROM " .$table. " WHERE PID = " .$PID. " LIMIT 1";
                $conn->execute($sql);
            }
            $sql    = "UPDATE albums SET total_photos = total_photos-1 WHERE AID = " .$AID. " LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'Successfully deleted photo!';
            break;
        case 'activate':
        case 'suspend':
            $status = ( $action == 'activate' ) ? 1 : 0;
            $sql    = "UPDATE photos SET status = '" .$status. "' WHERE PID = " .$PID. " LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $messages[] = 'Successfully ' .$action. 'ed photo!';
            } else {
                $errors[]   = 'Failed to ' .$action. ' photo! Are you sure this photo exists!?';
            }
            break;
    }
}

$photo  = array();
if ( $PID ) {
    $sql    = "SELECT * FROM photos WHERE PID = " .$PID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() === 1 ) {    
        $photo  = $rs->getrows();
        $photo  = $photo['0'];
    } else {
        $errors[] = 'Invalid photo id! Are you sure this photo exists!?';
    }
} else {
    $errors[] = 'Invalid photo id or not set!';
}

$smarty->assign('photo', $photo);
?>

<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$exists = true;
$AID    = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
if ( !$AID ) {
    $exists     = false;
    $errors[]   = 'Invalid album identifier. Are you sure this album exists!?';
}

if ( isset($_GET['a']) ) {
    $action = trim($_GET['a']);
    $PID    = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? intval(trim($_GET['PID'])) : NULL;
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
        case 'suspend':        
        case 'activate':
		case 'approve':
			$action = ( $action == 'activate' OR $action == 'approve') ? 'activate' : 'suspend';
            $status = ( $action == 'activate' ) ? 1 : 0;
            if ( $PID ) {
                $sql    = "UPDATE photos SET status = '" .$status. "' WHERE PID = " .$PID. " LIMIT 1";
                $conn->execute($sql);
                if ( $conn->Affected_Rows() == 1 ) {
                    $messages[] = 'Successfully ' .$action. 'ed photo!';
                } else {
                    $errors[]   = 'Failed to ' .$action. ' photo! Are you sure this photo exists!?';
                }
            } else {
                $sql    = "UPDATE albums SET status = '" .$status. "' WHERE AID = " .$AID. " LIMIT 1";
                $conn->execute($sql);
                if ( $conn->Affected_Rows() == 1 ) {
					if ($action == 'activate') {
						send_album_approve_email($AID);
					}
                    $messages[] = 'Successfully ' .$action. 'ed album!';
                } else {
                    $errors[]   = 'Failed to ' .$action. ' album! Are you sure this album exists!?';
                }
            }
            break;
    }
}

$album  = array();
$photos = array();
if ( $exists ) {
    $sql    = "SELECT a.*, c.name, c.CHID, s.username FROM albums AS a, channel AS c, signup AS s
               WHERE a.AID = " .$AID. " AND a.category = c.CHID AND a.UID = s.UID LIMIT 1";
    $rs     = $conn->execute($sql);
	if (!$conn->Affected_rows()) {
		$errors[] = 'Failed to load album information! Are you sure this album exists!?';
	}
	
	if (!$errors) {
  		$album  = $rs->getrows();
  		$album  = $album['0'];
  		$sql    = "SELECT * FROM photos WHERE AID = " .$AID;
  		$rs     = $conn->execute($sql);
  		$photos = $rs->getrows();
	}
}

$smarty->assign('crop', true);
$smarty->assign('album', $album);
$smarty->assign('photos', $photos);
?>

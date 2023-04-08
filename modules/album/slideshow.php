<?php
defined('_VALID') or die('Restricted Access!');

$is_friend      = true;
if ( $album['type'] == 'private' ) {
    $UID = ( isset($_SESSION['uid']) ) ? intval($_SESSION['uid']) : NULL;
    if ( $UID ) {
        if ( $UID != $album['UID'] ) {
            $sql = "SELECT FID FROM friends 
                    WHERE ((UID = " .$uid. " AND FID = " .$UID. ")
                    OR (UID = " .$UID. " AND FID = " .$uid. "))
                    AND status = 'Confirmed'
                    LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 0 ) {
                $is_friend = false;
            }
        }
    } else {
        $is_friend = false;
    }
}

$ids        = array();
$sql        = "SELECT PID, caption FROM photos WHERE AID = " .$aid. " AND status = '1' ORDER BY PID ASC";
$rs         = $conn->execute($sql);
$photos     = $rs->getrows();
if ($conn->Affected_Rows() === 1) {
	VRedirect::go($config['BASE_URL'].'/photo/'.$photos['0']['PID']);
} else {
	foreach ( $photos as $photo ) {
  		$ids[]          = $photo['PID'];
	}
	$ids        = 'var ids = new Array(' .implode(',', $ids). ');';
}

$smarty->assign('slider', true);
$smarty->assign('photos', $photos);
$smarty->assign('ids', $ids);
$smarty->assign('is_friend', $is_friend);
?>

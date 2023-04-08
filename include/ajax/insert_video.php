<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/sessions.php';

disableRegisterGlobals();

$message            = 'Successfully added to your friends!';
if ( isset($_POST['friend_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $uid        = intval($_SESSION['uid']);
        $fid        = $filter->get('friend_id', 'INTEGER');
        $sql        = "SELECT UID FROM friends WHERE UID = " .$uid. " AND FID = " .$fid. " AND status = 'Pending' LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $sql    = "UPDATE friends SET status = 'Confirmed' WHERE UID = " .$uid. " AND FID = " .$fid. " LIMIT 1";
            $conn->execute($sql);
            $sql    = "UPDATE signup SET total_friends = total_friends+1 WHERE UID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
        }
    }
}
?>

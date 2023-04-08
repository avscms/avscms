<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
include $config['BASE_DIR'].'/include/function_smarty.php';
require_once ($config['BASE_DIR'].'/include/function_video.php');
require_once ($config['BASE_DIR'].'/include/function_admin.php');

if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $action = trim($_GET['a']);

    $VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID'])  ) ? trim($_GET['VID']) : NULL;
	$VID2    = ( isset($_GET['VID2']) && is_numeric($_GET['VID2'])  ) ? trim($_GET['VID2']) : NULL;
    if ( $VID ) {
        switch ( $action ) {
            case 'delete':
				$sql = "DELETE FROM conversion_queue_fp WHERE VID = ".intval($VID)." LIMIT 1";
				$conn->execute($sql);
                $messages[] = 'Video ID <b>' .$VID. '</b> successfully deleted from queue!';
                $remove = '&a=delete&VID=' .$VID;
                break;
            case 'vdelete':
				$sql = "DELETE FROM conversion_queue_fp WHERE VID = ".intval($VID)." LIMIT 1";
				$conn->execute($sql);
                $messages[] = 'Video ID <b>' .$VID. '</b> successfully deleted and removed from queue!';
                $remove = '&a=vdelete&VID=' .$VID;
				deleteVideo( $VID );
                break;				           
        }
    }
    if ( $VID2 ) {
        switch ( $action ) {
            case 'delete':
				$sql = "DELETE FROM conversion_queue_sp WHERE VID = ".intval($VID2)." LIMIT 1";
				$conn->execute($sql);
                $messages[] = 'Video ID <b>' .$VID2. '</b> successfully deleted from queue!';
                $remove = '&a=delete&VID2=' .$VID2;
                break;
            case 'vdelete':
				$sql = "DELETE FROM conversion_queue_sp WHERE VID = ".intval($VID2)." LIMIT 1";
				$conn->execute($sql);
                $messages[] = 'Video ID <b>' .$VID2. '</b> successfully deleted and removed from queue!';
                $remove = '&a=vdelete&VID2=' .$VID2;
				deleteVideo( $VID2 );
                break;
        }
    }
}

$sql          		= "SELECT * FROM conversion_queue_fp ORDER BY addtime ASC";
$rs             	= $conn->execute($sql);
$queue_videos_fp    = $rs->getrows();
$total_queue_fp  	= count($queue_videos_fp);

$sql   			    = "SELECT * FROM conversion_queue_sp ORDER BY addtime ASC";
$rs             	= $conn->execute($sql);
$queue_videos_sp   	= $rs->getrows();
$total_queue_sp 	= count($queue_videos_sp);

$smarty->assign('total_queue_fp', $total_queue_fp);
$smarty->assign('queue_fp', $queue_videos_fp);
$smarty->assign('total_queue_sp', $total_queue_sp);
$smarty->assign('queue_sp', $queue_videos_sp);
?>
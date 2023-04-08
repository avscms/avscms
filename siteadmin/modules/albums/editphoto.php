<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$exists = true;
$photo  = array();
$PID    = ( isset($_GET['PID']) && is_numeric($_GET['PID']) && photoExists($_GET['PID']) ) ? intval(trim($_GET['PID'])) : NULL;
if ( !$PID ) {
    $exists     = false;
    $errors[]   = 'Invalid photo identifier! Are you sure this photo exists!?';
}

if ( isset($_POST['submit_photo_edit']) && !$errors ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    $filter             = new VFilter();
    $caption            = $filter->get('caption');
    $rate               = $filter->get('rate', 'FLOAT');
    $ratedby            = $filter->get('ratedby', 'INTEGER');
    $total_views        = $filter->get('total_views', 'INTEGER');
    $total_comments     = $filter->get('total_comments', 'INTEGER');
    $total_favorites    = $filter->get('total_favorites', 'INTEGER');
    
    $sql = "UPDATE photos SET caption = " .$conn->qStr($caption). ", rate = " .$rate. ",
                              ratedby = " .$ratedby. ", total_views = " .$total_views. ",
                              total_comments = " .$total_comments. ", total_favorites = " .$total_favorites. "
            WHERE PID = " .$PID. " LIMIT 1";
    $conn->execute($sql);
    $messages[] = 'Photo was successfully updated!';
}

if ( $exists ) {
    $sql    = "SELECT p.*, a.name FROM photos AS p, albums AS a
               WHERE p.PID = " .$PID. " AND p.AID = a.AID LIMIT 1";
    $rs     = $conn->execute($sql);
    $photo  = $rs->getrows();
    $photo  = $photo['0'];
}

$smarty->assign('photo', $photo);
?>

<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$video  = array();
$VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? trim($_GET['VID']) : NULL;
settype($VID, 'integer');
$submit = 0;
if ( !$VID ) 
    $errors[] = 'Invalid video ID. This video does not exist!';

if ( !$errors ) {
    if ( isset($_POST['edit_video']) ) {
        $title          = trim($_POST['title']);
        $keyword        = trim($_POST['keyword']);
        $channel        = trim($_POST['channel']);
        $type           = trim($_POST['type']);
        $featured       = trim($_POST['featured']);
        $be_comment     = trim($_POST['be_comment']);
        $be_rated       = trim($_POST['be_rated']);
        $embed          = trim($_POST['embed']);
        $thumb          = trim($_POST['thumb']);        
		$likes          = trim($_POST['likes']);
		$dislikes       = trim($_POST['dislikes']);
        $viewnumber     = trim($_POST['viewnumber']);
        $active         = trim($_POST['active']);
		$server			= trim($_POST['server']);
        
        if ( strlen($title) < 3 ) {
            $errors[] = 'Video title field cannot be blank!';
			$err['title'] = 1;
		}
		if ( strlen($keyword) < 3 ) {
            $errors[] = 'Video keyword(tags) field cannot be blank!';
			$err['keyword'] = 1;
		}
		if ( $channel == '' ) {
            $errors[] = 'Please select a category!';
			$err['channel'] = 1;
		}
        
        if ( !$errors ) {
            settype($thumb, 'integer');
            settype($viewnumber, 'integer');
            settype($likes, 'likes');
            settype($dislikes, 'dislikes');
            settype($channel, 'integer');
			if ( $likes != 0 || $dislikes !=0)
				$rate = round(($likes * 100)/($likes + $dislikes));
			else
				$rate = 0;
        
            $sql = "UPDATE video SET title = " .$conn->qStr($title). ", keyword = " .$conn->qStr($keyword). ",
                                     channel = '" .$channel. "', type = " .$conn->qStr($type). ",
                                     featured = " .$conn->qStr($featured). ", be_comment = " .$conn->qStr($be_comment). ",
                                     be_rated = " .$conn->qStr($be_rated). ", embed = " .$conn->qStr($embed). ",
                                     thumb = " .$conn->qStr($thumb). ", likes = " .$conn->qStr($likes). ",
                                     dislikes = " .$conn->qStr($dislikes). ", rate = " .$conn->qStr($rate). ", 
									 viewnumber = " .$conn->qStr($viewnumber). ",                                     
                                     active  = " .$conn->qStr($active). ", server = " .$conn->qStr($server). "
					WHERE VID = " .$conn->qStr($VID). " LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'Video information updated successfuly!';
        } else {
			$submit = 1;
		}
    } 

	$sql    = "SELECT * FROM video WHERE VID = '" .$VID. "' LIMIT 1";
	$rs     = $conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 ) {
		$video                  = $rs->getrows();
	}		
	else
		$errors[]    = 'Invalid Video ID. This video does not exist!';

	if ($submit) {		
			$video['0']['title']       = $title;
			$video['0']['keyword']     = $keyword;
			$video['0']['channel']     = $channel;
			$video['0']['type']        = $type;
			$video['0']['featured']    = $featured;
			$video['0']['be_comment']  = $be_comment;
			$video['0']['be_rated']    = $be_rated;
			$video['0']['embed']       = $embed;
			$video['0']['thumb']       = $thumb;
			$video['0']['likes']       = $likes;
			$video['0']['dislikes']    = $dislikes;
			$video['0']['viewnumber']  = $viewnumber;
			$video['0']['active']      = $active;
			$video['0']['server']      = $server;		
	}
}

$sql        = "SELECT CHID, name FROM channel ORDER BY name ASC";
$rs         = $conn->execute($sql);
$channels   = $rs->getrows();

$smarty->assign('err', $err);
$smarty->assign('video', $video);
$smarty->assign('channels', $channels);
?>

<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$album  = array();
$photos = array();
$exists = true;
$AID    = ( isset($_GET['AID']) && is_numeric($_GET['AID']) && albumExists($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
if ( !$AID ) {
    $exists     = false;
    $errors[]   = 'Invalid album identifier. Are you sure this album exists!?';
}

if ( isset($_POST['submit_album_edit']) && !$errors ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    $filter             = new VFilter();
    $name               = $filter->get('name');
    $tags               = $filter->get('tags');
    $category           = $filter->get('category', 'INTEGER');
    $type               = $filter->get('type');
    $status             = $filter->get('status');
    $total_comments     = $filter->get('total_comments', 'INTEGER');
    $total_views        = $filter->get('total_views', 'INTEGER');
    $total_favorites    = $filter->get('total_favorites', 'INTEGER');
    $rate               = $filter->get('rate', 'FLOAT');
    $ratedby            = $filter->get('ratedby', 'INTEGER');
    $x                  = $filter->get('x1', 'INTEGER');
    $y                  = $filter->get('y1', 'INTEGER');
    $width              = $filter->get('width', 'INTEGER');
    $height             = $filter->get('height', 'INTEGER');
    $pid                = $filter->get('photo', 'INTEGER');
    $random             = $filter->get('random');

	if ($width < 50 || $width > 580 || $height != $width ) {
		$x          = $filter->get('x1-i', 'INTEGER');
		$y          = $filter->get('y1-i', 'INTEGER');
		$width      = $filter->get('width-i', 'INTEGER');
		$height     = $filter->get('height-i', 'INTEGER');
	}	
    
    if ( $name == '' ) {
        $errors[]       = 'Name field cannot be left blank!';
    }
    
    if ( $tags == '' ) {
        $errors[]       = 'Tags field cannot be left blank!';
    } elseif ( !preg_match('/^[a-zA-Z0-9_\-\s]+$/', $tags) ) {
        $errors[]       = 'Album tags can only be separated by spaces!';
    }
    
    $type               = ( $type == 'private' ) ? 'private' : 'public';
    
    if ( !$errors ) {
        require $config['BASE_DIR']. '/classes/image.class.php';
        $sql            = "UPDATE albums SET name = " .$conn->qStr($name). "' tags = " .$conn->qStr($tags). ",
                                             category = " .$category. ", type = " .$conn->qStr($type). ",
                                             status = '" .$status. "', total_views = " .$total_views. ", total_comments = " .$total_comments. ",
                                             total_favorites = " .$total_favorites. ", rate = " .$rate. ", ratedby = " .$ratedby. "
                           WHERE AID = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        $src    = $config['BASE_DIR']. '/tmp/albums/' .$pid. '_' .$random. '.jpg';
        $dst    = $config['BASE_DIR']. '/media/albums/' .$AID. '.jpg';
        if ( file_exists($src) && is_file($src) ) {
            $image  = new VImageConv();
			$image->process($src, $dst, 'EXACT', $width, $height);
			$image->crop($x, $y, $width, $height, true);
            unlink($src);
        }
        $messages[] = 'Album successfully updated!';
    }
}

if ( $exists ) {
    $sql    = "SELECT a.*, s.username FROM albums AS a, signup AS s
               WHERE a.AID = " .$AID. " AND a.UID = s.UID LIMIT 1";
    $rs     = $conn->execute($sql);
    $album  = $rs->getrows();
    $album  = $album['0'];
    
    $sql    = "SELECT PID FROM photos WHERE AID = " .$AID;
    $rs     = $conn->execute($sql);
    $photos = $rs->getrows();
}

$smarty->assign('crop', true);
$smarty->assign('album', $album);
$smarty->assign('photos', $photos);
$smarty->assign('categories', get_albums_categories());
?>

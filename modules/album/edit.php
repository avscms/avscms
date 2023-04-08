<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/auth.class.php';
$auth   = new Auth();
$auth->check();

// we dont cache anything here...needed for the album avatar update!
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

if ( isset($_SESSION['uid']) && $uid != $_SESSION['uid'] ) {
    VRedirect::go($config['BASE_URL']. '/notfound/album_permission');
}

if ( isset($_POST['submit_album_edit']) ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/image.class.php';
    $filter     = new VFilter();
    $name       = $filter->get('album_name');
    $category   = $filter->get('album_category');
    $tags       = $filter->get('album_tags');
    $type       = $filter->get('album_type');
    $x          = $filter->get('x1', 'INTEGER');
    $y          = $filter->get('y1', 'INTEGER');
    $width      = $filter->get('width', 'INTEGER');
    $height     = $filter->get('height', 'INTEGER');
    $pid        = $filter->get('photo', 'INTEGER');
    $random     = $filter->get('random');

	if ($width < 50 || $width > 580 || $height != $width ) {
		$x          = $filter->get('x1-i', 'INTEGER');
		$y          = $filter->get('y1-i', 'INTEGER');
		$width      = $filter->get('width-i', 'INTEGER');
		$height     = $filter->get('height-i', 'INTEGER');
	}
    
    if ( $name == '' ) {
        $errors[]   = $lang['album.name_empty'];
		$err['name'] = 1;
    }
    
    if ( $category == '0' ) {
        $errors[]   = $lang['album.category_empty'];
		$err['category'] = 1;		
    }
    
    if ( $tags == '' ) {
        $errors[]   = $lang['album.tags_empty'];
		$err['tags'] = 1;		
	} else {
		$tags = prepare_string($tags, false);
	}
    
    if ( $type == '' ) {
        $errors[]   = $lang['album.type_empty'];
		$err['type'] = 1;		
    }
    
    if ( !$errors ) {
        $src    = $config['BASE_DIR']. '/tmp/albums/' .$pid. '_' .$random. '.jpg';
        $dst    = $config['BASE_DIR']. '/media/albums/' .$aid. '.jpg';
        if ( file_exists($src) && is_file($src) ) {
            $image  = new VImageConv();
			$image->process($src, $dst, 'EXACT', $width, $height);
			$image->crop($x, $y, $width, $height, true);
            unlink($src);
        }
        
        $type   = ( $type == 'public' or $type == 'private' ) ? $type : 'public';
        $sql    = "UPDATE albums SET name = " .$conn->qStr($name). ", category = " .intval($category). ",
                                     tags = " .$conn->qStr($tags). ", type = '" .$type. "'
                   WHERE AID = " .$aid;
        $conn->execute($sql);
		$album['name'] = $name;
		$album['category'] = $category;
		$album['tags'] = $tags;
		$album['type'] = $type;
        $messages[] = $lang['album.edit_msg'];
		
		foreach($_POST['photo_caption'] as $key => $caption) {	
			$sql    = "UPDATE photos SET caption = " .$conn->qStr($caption). " WHERE PID = " .intval($_POST['photo_index'][$key]);
			$conn->execute($sql);			
		}

		$exts   = array('jpg', 'jpeg', 'png', 'gif');
		$photos = 0;
		
        $image      = new VImageConv();		
		if (count($_FILES)) {
			foreach ( $_FILES['album_file']['name'] as $key => $file_name ) {
				if ( $_FILES['album_file']['tmp_name'][$key] != '' ) {
					if ( is_uploaded_file($_FILES['album_file']['tmp_name'][$key]) ) {
						$filename	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
						$ext		= strtolower(substr($filename, strrpos($filename, '.')+1));
						if (in_array($ext, $exts)) {
							++$photos;
							$sql            = "INSERT INTO photos SET AID = " .$aid;
							$conn->execute($sql);
							$photo_id       = $conn->insert_Id();
							$src            = $_FILES['album_file']['tmp_name'][$key];
							$dst            = $config['BASE_DIR']. '/media/photos/tmb/' .$photo_id. '.jpg';

							list ($width, $height) = getimagesize($src);
							$crop_w = min ($width, $height);
							$crop_h = $crop_w;
							if ($width > $height) {
								$crop_x = floor (($width - $crop_w)/2);
								$crop_y = 0;
							}
							else {
								$crop_x = 0;
								$crop_y = floor (($height - $crop_h)/2);
							}			
							
							$image->process($src, $dst, 'EXACT', $crop_w, $crop_h);
							$image->crop($crop_x, $crop_y, $crop_w, $crop_h, true);
							$image->process($dst, $dst, 'MAX_WIDTH', 400, 0);
							$image->resize(true, true);
							
							$dst        = $config['BASE_DIR']. '/media/photos/' .$photo_id. '.jpg';
							$image->process($src, $dst, 'MAX_WIDTH', 960, 0);
							$image->resize(true, true);
							
							$added_photos[] = $photo_id;
						}
					}
				}
			}	
		}

        $sql        = "UPDATE albums SET total_photos = total_photos + " .intval($photos). ", status = '1' WHERE AID = " .$aid. " LIMIT 1";
        $conn->execute($sql);
		
    }
}

$sql        = "SELECT PID, caption FROM photos WHERE AID = " .$aid. " AND status = '1' ORDER BY PID ASC";
$rs         = $conn->execute($sql);
$photos     = $rs->getrows();

$smarty->assign('crop', true);
$smarty->assign('photos', $photos);
$smarty->assign('categories', get_albums_categories());
?>

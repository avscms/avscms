<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$album = array('username' => 'anonymous', 'name' => '', 'tags' => '', 'category' => 0,
               'type' => 'public');

$added_photos = array();			   
			   
if ( isset($_POST['add_album']) ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    $filter             = new VFilter();
    $username           = $filter->get('username');
    $name               = $filter->get('name');
    $tags               = $filter->get('tags');
    $category           = $filter->get('category', 'INTEGER');
    $type               = $filter->get('type');

    if ( $username == '' ) {
        $errors[]   = 'Please add a username for your album!';
		$err['username'] = 1;		
    } else {
        $sql        = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $rs         = $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $uid                = intval($rs->fields['UID']);
            $album['username']  = $username;
        } else {
            $errors[] = 'Invalid username. Are you sure this username exists?!';
			$err['username'] = 1;			
        }
    }

    if ( $name == '' ) {
        $errors[]   = 'Album name field cannot be blank!';
		$err['name'] = 1;
    } elseif ( strlen($name) < 3 ) {
        $errors[]   = 'Album name field must contain at least 3 characters and no more then 99!';
		$err['name'] = 1;
    } else {
        $album['name'] = $name;
    }

    if ( $tags == '' ) {
        $errors[]   = 'Album tags field cannot be blank!';
		$err['tags'] = 1;
    } elseif ( strlen($tags) < 3 || strlen($tags) > 299) {
        $error[]    = 'Album tags field must contain at least 3 characters and no more then 299!';
		$err['tags'] = 1;
    } else {
        $album['tags'] = $tags;
    }

    if ( $category === 0 ) {
        $errors[]   = 'Please select a category!';
    } else {
        $album['category'] = $category;
    }

	$album['type'] = $type;
	
	$exts   = array('jpg', 'jpeg', 'png', 'gif');	
	$uploaded_photos = FALSE;
	foreach ( $_FILES['photos']['name'] as $key => $file_name ) {
		if ( $_FILES['photos']['tmp_name'][$key] != '' ) {
			if ( is_uploaded_file($_FILES['photos']['tmp_name'][$key]) ) {
				$filename	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
				$ext		= strtolower(substr($filename, strrpos($filename, '.')+1));
				if (in_array($ext, $exts)) {				
					$uploaded_photos = TRUE;
				}
			}
		}
	}
    
    if ( !$uploaded_photos ) {
        $errors[]   = 'Please select at least one photo for your album!';
    }
    
    if ( !$errors ) {
		
        $album['type']  = ( $type == 'public' ) ? 'public' : 'private';
        $sql            = "INSERT INTO albums (UID, name, category, tags, type, addtime, adddate, status) 
                           VALUES (" .$uid. ", " .$conn->qStr($name). ", " .$category. ", 
                                   " .$conn->qStr($tags). ", '" .$type. "', " .time(). ", '" .date('Y-m-d'). "', '1')";
        $conn->execute($sql);
        $album_id   = $conn->insert_Id();
		
		$exts   = array('jpg', 'jpeg', 'png', 'gif');
		$photos = 0;
		require $config['BASE_DIR']. '/classes/image.class.php';
		$image   = new VImageConv();		
		foreach ( $_FILES['photos']['name'] as $key => $file_name ) {
			if ( $_FILES['photos']['tmp_name'][$key] != '' ) {
				if ( is_uploaded_file($_FILES['photos']['tmp_name'][$key]) ) {
					$filename	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
					$ext		= strtolower(substr($filename, strrpos($filename, '.')+1));
					if (in_array($ext, $exts)) {					
						++$photos;
						$sql            = "INSERT INTO photos SET AID = " .$album_id;
						$conn->execute($sql);
						$photo_id       = $conn->insert_Id();
						$src            = $_FILES['photos']['tmp_name'][$key];
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
		
        $src        = $config['BASE_DIR']. '/media/photos/tmb/' .$photo_id. '.jpg';
        $dst        = $config['BASE_DIR']. '/media/albums/' .$album_id. '.jpg';
        $image->process($src, $dst, 'MAX_WIDTH', 400, 0);
        $image->resize(true, true);
		
        $sql        = "UPDATE albums SET total_photos = " .intval($photos). ", status = '1' WHERE AID = " .$album_id. " LIMIT 1";
        $conn->execute($sql);
        $sql        = "UPDATE album_categories SET total_albums = total_albums+1 WHERE CID = " .$category. " LIMIT 1";
        $conn->execute($sql);
        $sql        = "UPDATE signup SET total_albums = total_albums+1 WHERE UID = " .$uid. " LIMIT 1";
        $conn->execute($sql);

        $messages[] = 'Album was successfully added!';
    }
} elseif ( isset($_POST['update_captions']) ) {
	foreach ( $_POST['caption'] as $key => $caption ) {
		$pid     = $key;
		$caption = trim($caption);
		settype($pid, 'integer');
		settype($caption, 'string');
		$sql = "UPDATE photos SET caption = " .$conn->qStr($caption). " 
				WHERE PID = " .$pid. " LIMIT 1";
		$conn->execute($sql);
	}
	$messages[] = 'Photo captions were successfully updated!';	
}

$smarty->assign('album', $album);
$smarty->assign('added_photos', $added_photos);
$smarty->assign('categories', get_albums_categories());
?>
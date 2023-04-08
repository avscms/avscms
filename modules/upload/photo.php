<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/filter.class.php';

if ( $config['photo_module'] == '0' ) {
	VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$album          = array('name' => '', 'category' => 0, 'tags' => '',
                        'anonymous' => 'no', 'type' => 'public');
if ( isset($_POST['album_upload_started']) ) {
    $step       = 'photo';
    $filter     = new VFilter();
    $name       = $filter->get('album_name');
    $category   = $filter->get('album_category', 'INTEGER');
    $tags       = $filter->get('album_tags');
    $type       = $filter->get('album_type');
    $anonymous  = $filter->get('album_anonymous');
	
    if ( $name == '' ) {
        $errors[]       = $lang['album.name_empty'];
    } else {
        $album['name']  = $name;
    }
    
    if ( $category == '0' ) {
        $errors[]       = $lang['album.category_empty'];
    } else {
        $album['category'] = $category;
    }
    
    if ( $tags == '' ) {
        $errors[]       = $lang['album.tags_empty'];
    } else {
        $tags           = prepare_string($tags, false);
        $album['tags']  = $tags;
    }
    
	$exts   = array('jpg', 'jpeg', 'png', 'gif');	
	$uploaded_photos = FALSE;
	foreach ( $_FILES['album_file']['name'] as $key => $file_name ) {
		if ( $_FILES['album_file']['tmp_name'][$key] != '' ) {
			if ( is_uploaded_file($_FILES['album_file']['tmp_name'][$key]) ) {
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
	
    $album['type']      = ( $type == 'private' ) ? 'private' : 'public';
    $album['anonymous'] = ( $anonymous == 'yes' ) ? 'yes' : 'no';
    $uid                = ( $anonymous == 'yes' ) ? getAnonymousUID() : intval($_SESSION['uid']);
    
    if ( !$errors ) {
        require $config['BASE_DIR']. '/classes/image.class.php';
        $type       = ( $type == 'public' ) ? 'public' : 'private';
        $status     = ( $config['approve_photos'] == '1' ) ? 0 : 1;
        $sql        = "INSERT INTO albums (UID, name, category, tags, type, addtime, adddate, status)
                       VALUES (" .$uid. ", " .$conn->qStr($name). ", " .$category. ",
                           " .$conn->qStr($tags). ", '" .$type. "', " .time(). ", '" .date('Y-m-d'). "', '" .$status. "')";
        $conn->execute($sql);
        $album_id   = $conn->insert_Id();
        
		$exts   = array('jpg', 'jpeg', 'png', 'gif');
		$photos = 0;
		
        $image      = new VImageConv();
		
		
		
		foreach ( $_FILES['album_file']['name'] as $key => $file_name ) {
			if ( $_FILES['album_file']['tmp_name'][$key] != '' ) {
				if ( is_uploaded_file($_FILES['album_file']['tmp_name'][$key]) ) {
					$filename	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
					$ext		= strtolower(substr($filename, strrpos($filename, '.')+1));
					if (in_array($ext, $exts)) {
						++$photos;
						$sql            = "INSERT INTO photos SET AID = " .$album_id;
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
        
        $src        = $config['BASE_DIR']. '/media/photos/tmb/' .$photo_id. '.jpg';
        $dst        = $config['BASE_DIR']. '/media/albums/' .$album_id. '.jpg';
        $image->process($src, $dst, 'MAX_WIDTH', 400, 0);
        $image->resize(true, true);
		
        $sql        = "UPDATE albums SET total_photos = " .intval($photos). " WHERE AID = " .$album_id. " LIMIT 1";
        $conn->execute($sql);
        $sql        = "UPDATE album_categories SET total_albums = total_albums+1 WHERE CID = " .$category. " LIMIT 1";
        $conn->execute($sql);
        $sql        = "UPDATE signup SET total_albums = total_albums+1 WHERE UID = " .$uid. " LIMIT 1";
        $conn->execute($sql);
		
		$album_url  = $config['BASE_URL']. '/album/' .$album_id. '/' .prepare_string($name);
        $album_link = '<a href="' .$album_url. '">' .$album_url. '</a>';
        $search     = array('{$site_title}', '{$site_name}', '{$username}', '{$album_link}', '{$baseurl}');
        $replace    = array($config['site_title'], $config['site_name'], $_SESSION['username'], $album_link, $config['BASE_URL']);
        $mail       = new VMail();
        if ( $config['approve'] == '0' ) {
            $mail->sendPredefined($_SESSION['email'], 'photo_approve', $search, $replace);
        } else {
            $mail->sendPredefined($_SESSION['email'], 'photo_upload', $search, $replace);
        }

        $album['name']      = '';
        $album['category']  = 0;
        $album['tags']      = '';
        $album['anonymous'] = 'no';
        $album['type']      = 'public';
        
        if ( $config['approve_photos'] == '1' ) {
			$messages[] = translate('upload.album_approve', $config['site_name']);
        } else {
			$messages[] = translate('upload.album_success', $config['site_name'], $album_url, htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
        }
    }
	if ($errors) {
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';				
			foreach ($errors as $error) {
				echo $error;
				echo '</br>';
			}
		echo'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	}
	if ($messages) {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
		foreach ($messages as $message) {
				echo $message;
				echo '</br>';
		}
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>';	
	}
	exit;	
	
}

$image_extensions  = '(' .str_replace(',', ' | ', $config['image_allowed_extensions']). ')';
$smarty->assign('image_extensions', $image_extensions);	

$smarty->assign('album', $album);
$smarty->assign('upload_photo', true);
$smarty->assign('categories', get_albums_categories());
?>

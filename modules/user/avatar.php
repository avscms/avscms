<?php
defined('_VALID') or die('Restricted Access!');

//we dont cache anything here
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' .gmdate('D, d M Y H:i:s'). ' GMT');
header('Cache-Control: no-store, no-cache, max-age=0, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

require $config['BASE_DIR']. '/classes/image.class.php';
require $config['BASE_DIR']. '/classes/filter.class.php';

$crop       = true;
$uploaded   = false;
if ( isset($_SESSION['uploaded']) or $user['photo'] != '' ) {
    $uploaded   = true;
    if ( isset($_SESSION['uploaded']) ) {
        unset($_SESSION['uploaded']);
    }
}

if ( $user['photo'] != '' ) {
    $uploaded = true;
}

if ( isset($_POST['avatar_submit']) ) {
    if ( $_FILES['avatar']['tmp_name'] == '' ) {
        $errors[] = $lang['global.file_empty'];
		$err['file'] = 1;
    } elseif ( !is_uploaded_file($_FILES['avatar']['tmp_name']) ) {
        $errors[] = $lang['user.avatar_invalid'];
    } else {
        $filename           = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], DIRECTORY_SEPARATOR)+1);
        $extension          = strtolower(substr($filename, strrpos($filename, '.')+1));
        $extensions_allowed = explode(',', $config['image_allowed_extensions']);
        $size               = filesize($_FILES['avatar']['tmp_name']);        
        if ( !in_array($extension, $extensions_allowed) ) {
            $errors[]       = translate('user.avatar_ext_invalid', $config['image_allowed_extensions']);
        } elseif ( $size > $config['image_max_size'] ) {
            $errors[]       = translate('user.avatar_size_invalid', round(($config['image_max_size']/1024)/1024));
        } elseif (!getimagesize($_FILES['avatar']['tmp_name'])) {
			$errors[]		= 'Invalid image format uploaded! Application error!';
		} elseif (!check_image($_FILES['avatar']['tmp_name'], $extension)) {
			$errors[]       = 'Invalid image format uploaded! Application error!';
		}
    }
    
    if ( !$errors ) {
        $image_name = $user['UID']. '.' ."jpg";
        $avatar_tmp = $config['BASE_DIR']. '/tmp/avatars/' .$image_name;
        if ( !move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_tmp) ) {
            $errors[]       = $lang['user.avatar_failed'];
        }
        
        if ( !$errors ) {
            $dst    = $config['BASE_DIR']. '/media/users/orig/' .$image_name;
            $image  = new VImageConv();
            $image->process($avatar_tmp, $dst, 'MAX_WIDTH', 500, 500);
            $image->resize(true);
        
            if ( file_exists($dst) && filesize($dst) > 100 ) {
                $_SESSION['message']    = $lang['user.avatar_upload_msg'];
                $_SESSION['uploaded']   = true;
                VRedirect::go($config['BASE_URL']. '/user/avatar');
            }
        }
    }
}

if ( isset($_POST['avatar_crop_submit']) ) {
    $filter = new VFilter();
    $x      = $filter->get('x1', 'INTEGER');
    $y      = $filter->get('y1', 'INTEGER');
    $width  = $filter->get('width', 'INTEGER');
    $height = $filter->get('height', 'INTEGER');
    $uid    = $user['UID'];
    $src    = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
    $dst    = $config['BASE_DIR']. '/media/users/' .$uid. '.jpg';
    $image  = new VImageConv();
    $image->process($src, $dst, 'EXACT', $width, $height);
    $image->crop($x, $y, $width, $height, true);
    
    if ( file_exists($dst) && filesize($dst) > 100 ) {
		$_SESSION['photo'] = $uid.'.jpg';
        $sql    = "UPDATE signup SET photo = '" .intval($user['UID']). ".jpg' WHERE UID = " .intval($uid). " LIMIT 1";
        $conn->execute($sql);
        $_SESSION['message'] = $lang['user.avatar_crop_msg'];
        VRedirect::go($config['BASE_URL']. '/user/avatar');
    }
}
$smarty->assign('err', $err);
$smarty->assign('crop', $crop);
$smarty->assign('uploaded', $uploaded);
?>

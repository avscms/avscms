<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$chimg = $config['BASE_DIR']. '/media/categories/video';
if ( !file_exists($chimg) or !is_dir($chimg) or !is_writable($chimg) ) {
    $errors[] = 'Category image directory \'' .$chimg. '\' is not writable!';
}

$channel = array('name' => '', 'desc' => '');
if ( isset($_POST['add_channel']) ) {
    $name   = trim($_POST['name']);
    $slug   = toAscii(trim($_POST['slug']));
    
    if ( $name == '' ) {
        $errors[] = 'Category name field cannot be blank!';
    } else {
        $sql        = "SELECT CHID FROM channel WHERE name = " .$conn->qStr($name). " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() > 0 ) {
            $errors[]   = 'Category name \'' .htmlspecialchars($name, ENT_QUOTES, 'UTF-8'). ' is already used. Please choose another name!';
        } else {
            $channel['name'] = $name;
        }
    }
    
	if ( $slug == '' ) {
		$slug = toAscii($name);		
	}
    
	if (channelSlugExists($slug, 0)) {
		$errors[]   = 'This slug already exists, please choose a different one!';
	} else {
       $channel['slug'] = $slug;		
	}	
	
    if ( $_FILES['picture']['tmp_name'] == '' )
        $errors[] = 'Please provide a category image!';
    
    if ( !$errors ) {
        $sql = "INSERT INTO channel (name, slug) VALUES (" .$conn->qStr($name). ", ".$conn->qStr($slug).")";
        $conn->execute($sql);
        $chid = $conn->Insert_ID();
        require $config['BASE_DIR']. '/classes/image.class.php';
        $image = new VImageConv();
        $image->process($_FILES['picture']['tmp_name'], $chimg. '/' .$chid. '.jpg', 'MAX_WIDTH', 384, 216);
        $image->canvas(384, 216, '000000', true);

        if ( $errors ) {
            $sql = "DELETE FROM channel WHERE CHID = " .$conn->qStr($chid). " LIMIT 1";
            $conn->execute($sql);
        }
    }
    
    if ( !$errors ) {
        $msg = 'Category Successfuly added!';
	VRedirect::go('channels.php?msg=' .$msg);
    }
}

$smarty->assign('channel', $channel);
?>

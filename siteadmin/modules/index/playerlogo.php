<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

if ( isset($_POST['upload_logo']) ) {
    
    if ( $_FILES['logo']['tmp_name'] == '' ) {
        $errors[] = 'Please select a logo file!';
    } elseif ( !is_uploaded_file($_FILES['logo']['tmp_name']) ) {
        $errors[] = 'Advertising media file is not a valid uploaded file!';
    } else {
        $filename = substr($_FILES['logo']['name'], strrpos($_FILES['logo']['name'], DIRECTORY_SEPARATOR)+1);
        $ext     = strtolower(substr($filename, strrpos($filename, '.')+1));
        if ( !in_array($ext, array('png')) ) {
            $errors[] = 'Logo file is not a valid supported format (allowed formats: png)!';
        }
    }    
    if ( !$errors ) {
        if ( !move_uploaded_file($_FILES['logo']['tmp_name'], $config['BASE_DIR']. '/media/player/logo/logo.png') ) {
            $errors[] = 'Failed to move uploaded file!';
        } else {
            $messages[] = 'Logo was successfully updated!';
        }        
    }
}

$rand = rand();
$smarty->assign('rand', $rand);

?>

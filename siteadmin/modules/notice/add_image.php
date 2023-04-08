<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/image.class.php';

$images     = 0;
if ( isset($_POST['submit_add_image']) ) {
    $image      = new VImageConv();
    foreach ( $_FILES as $key => $values ) {
        if ( $values['tmp_name'] != '' ) {                    
            if ( is_uploaded_file($values['tmp_name']) ) {
                $filename           = substr($values['name'], strrpos($values['name'], DIRECTORY_SEPARATOR)+1);
                $extension          = strtolower(substr($values['name'], strrpos($values['name'], '.')+1));
                $extensions_allowed = explode(',', trim($config['image_allowed_extensions']));
                if ( in_array($extension, $extensions_allowed) ) {                            
                    $sql        = "INSERT INTO notice_images (addtime, extension) VALUES (" .time(). ", '" .$extension. "')";
                    $conn->execute($sql);
                    $image_id   = $conn->insert_Id();
                    $dst_orig   = $config['BASE_DIR']. '/images/notice_images/' .$image_id. '.' .$extension;
                    if ( move_uploaded_file($values['tmp_name'], $dst_orig) ) {
                        $src    = $dst_orig;
                        $dst    = $config['BASE_DIR']. '/images/notice_images/thumbs/' .$image_id. '.jpg';
                        $image->process($src, $dst, 'MAX_WIDTH', 150, 0);
                        $image->resize(true, true);
                        ++$images;
                    } else {
                        $sql    = "DELETE FROM notice_images WHERE image_id = " .$image_id. " LIMIT 1";
                        $conn->execute($sql);
                    }
                }
            }
        }
    }
}

if ( $images > 0 ) {
    $_SESSION['message'] = 'Successfully added ' .$images. ' images!';
    VRedirect::go($config['BASE_URL']. '/siteadmin/notices.php?m=list_images');
}
?>
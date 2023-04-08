<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$AID    = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? intval($_GET['AID']) : NULL;
$album  = array();
if ( $AID ) {
    $sql    = "SELECT * FROM albums WHERE AID = " .$AID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() === 1 ) {
        $album  = $rs->getrows();
        $album  = $album['0'];
        if ( isset($_POST['add_photos']) ) {
            if ( $_FILES['photo_1']['tmp_name'] == '' ) {
                $errors[]   = 'Please select at least one photo for your album!';
            } elseif ( !is_uploaded_file($_FILES['photo_1']['tmp_name']) ) {
                $errors[]   = 'First album photo is not a valid uploaded file!';
            }
          
            if ( !$errors ) {
                require $config['BASE_DIR']. '/classes/image.class.php';
                require $config['BASE_DIR']. '/classes/filter.class.php';
                $photos     = 0;
                $filter     = new VFilter();
                $image      = new VImageConv();
                foreach ( $_FILES as $key => $values ) {
                    if ( $values['tmp_name'] != '' ) {
                        if ( is_uploaded_file($values['tmp_name']) ) {
                            ++$photos;
                            $photo_expl     = explode('_', $key);
                            $photo_nr       = $photo_expl['1'];
                            $caption        = $filter->get('caption_' .$photo_nr);
                            $sql_add        = NULL;
                            if ( $caption != '' ) {
                                $sql_add    = ", caption = " .$conn->qStr($caption). "";
                            }

                            $sql            = "INSERT INTO photos SET AID = " .$AID . $sql_add;
                            $conn->execute($sql);
                            $photo_id       = $conn->insert_Id();
                            $src            = $values['tmp_name'];
                            $dst            = $config['BASE_DIR']. '/media/photos/tmb/' .$photo_id. '.jpg';
                            $image->process($src, $dst, 'MAX_WIDTH', 150, 0);
                            $image->resize(true, true);
                            $dst            = $config['BASE_DIR']. '/media/photos/' .$photo_id. '.jpg';
                            $image->process($src, $dst, 'MAX_WIDTH', 575, 0);
                            $image->resize(true, true);
                        }
                    }
                }
                $sql = "UPDATE albums SET total_photos = total_photos+" .$photos. " WHERE AID = " .$AID. " LIMIT 1";
                $conn->execute($sql);
                $messages[] = 'Photos where successfully added!';
            }
        }        
    } else {
        $errors[] = 'Invalid album id! Are you sure this album exists!?';
    }
} else {
    $errors[] = 'Invalid album id or not set!';
}

$smarty->assign('AID', $AID);
$smarty->assign('album', $album);
?>
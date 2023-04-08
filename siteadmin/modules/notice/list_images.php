<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
require $config['BASE_DIR']. '/classes/pagination.class.php';

if ( isset($_POST['add_images']) ) {
	$width = 200;
	$height = 200;
	$images     = 0;
	require $config['BASE_DIR']. '/classes/image.class.php';	
    $image      = new VImageConv();
	
	foreach ($_FILES['images']['name'] as $key => $file_name) {

		if ( $_FILES['images']['tmp_name'][$key] != '' ) {                    
			if ( is_uploaded_file($_FILES['images']['tmp_name'][$key]) ) {
				$extension          = strtolower(substr($file_name, strrpos($file_name, '.')+1));
				$extensions_allowed = explode(',', trim($config['image_allowed_extensions']));
				if ( in_array($extension, $extensions_allowed) ) {                            
					$sql        = "INSERT INTO notice_images (addtime, extension) VALUES (" .time(). ", '" .$extension. "')";
					$conn->execute($sql);
					$image_id   = $conn->insert_Id();
					$dst_orig   = $config['BASE_DIR']. '/images/notice_images/' .$image_id. '.' .$extension;
					if ( move_uploaded_file($_FILES['images']['tmp_name'][$key], $dst_orig) ) {
						$src    = $dst_orig;
						$dst    = $config['BASE_DIR']. '/images/notice_images/thumbs/' .$image_id. '.jpg';
						
						if (copy($src, $dst)) {
							//-- Process Thumb - Aspect
							list($src_w, $src_h) = getimagesize($dst);
							$aspect     = $width / $height;
							$src_aspect = $src_w / $src_h;
							if ($aspect < $src_aspect) {
								$tmp_h = $height;
								$tmp_w = floor($tmp_h * $src_aspect);
								$image->process($dst, $dst, 'EXACT', $tmp_w, $tmp_h);
								$image->resize(true, true);
								$x = floor(($tmp_w - $width)/2);
								$y = 0;
							}
							else {
								$tmp_w = $width;
								$tmp_h = floor($tmp_w / $src_aspect);
								$image->process($dst, $dst, 'EXACT', $tmp_w, $tmp_h);
								$image->resize(true, true);
								$x = 0;
								$y = floor(($tmp_h - $height)/2);
							}
							$image->process($dst, $dst, 'EXACT', $width, $height);
							$image->crop($x, $y, $width, $height, true);				
							//-- Process Thumb - Aspect - END	
							++$images;
						} else {
							$sql    = "DELETE FROM notice_images WHERE image_id = " .$image_id. " LIMIT 1";
							$conn->execute($sql);							
						}
					} else {
						$sql    = "DELETE FROM notice_images WHERE image_id = " .$image_id. " LIMIT 1";
						$conn->execute($sql);
					}
				}
			}
		}

    }
	if ( $images > 0 ) {
		$messages[] = 'Successfully added ' .$images. ' image(s)!';
	} else {
		$errors[] = 'Failed adding notice image(s)!';
	}
}

$sql            = "SELECT COUNT(image_id) AS total_images FROM notice_images";
$rs             = $conn->execute($sql);
$images_total   = $rs->fields['total_images'];
$pagination     = new Pagination(20);
$limit          = $pagination->getLimit($images_total);
$paging         = $pagination->getAdminPagination();
$sql            = "SELECT * FROM notice_images ORDER BY addtime DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$images         = $rs->getrows();

$smarty->assign('images', $images);
$smarty->assign('images_total', $images_total);
$smarty->assign('paging', $paging);
?>
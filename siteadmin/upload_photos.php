<?php
define('_VALID', true);
define('_ADMIN', true);
require '../include/config.php';
require '../include/function_global.php';
require '../include/function_admin.php';
require '../classes/auth.class.php';
require '../classes/filter.class.php';

Auth::checkAdmin();

    $filter   = new VFilter();
	$AID = $filter->get('album-add-id', 'INT');
	
	$exts   = array('jpg', 'jpeg', 'png', 'gif');
	$addphotos = FALSE;

	$photos = 0;
	require $config['BASE_DIR']. '/classes/image.class.php';
	$image   = new VImageConv();		
	foreach ( $_FILES['addphotos']['name'] as $key => $file_name ) {
		if ( $_FILES['addphotos']['tmp_name'][$key] != '' ) {
			if ( is_uploaded_file($_FILES['addphotos']['tmp_name'][$key]) ) {
				$filename	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
				$ext		= strtolower(substr($filename, strrpos($filename, '.')+1));
				if (in_array($ext, $exts)) {					
					++$photos;
					$sql            = "INSERT INTO photos SET AID = " .$AID;
					$conn->execute($sql);
					$photo_id       = $conn->insert_Id();
					$src            = $_FILES['addphotos']['tmp_name'][$key];
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
					?>
						<script language="javascript" type="text/javascript">window.top.window.photoAdded(<?php echo $photo_id ?>);</script>
					<?php
				}
			}
		}
	}	
	if ($photos > 0 ) {
		$sql = "UPDATE albums SET total_photos = total_photos+" .$photos. " WHERE AID = " .$AID. " LIMIT 1";
		$conn->execute($sql);		
	}


?>
<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $AID ?>, <?php echo $photos ?>);</script>
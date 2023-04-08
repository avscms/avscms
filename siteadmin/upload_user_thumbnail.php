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
$UID      = $filter->get('user-thumbnail-id', 'INTEGER');
$remove   = $filter->get('user-thumbnail-remove');
$exts     = array('jpg', 'jpeg', 'png', 'gif');
$addthumb = 0;
$gender = 'Male';

if ($remove != '1') {
	$remove = 0;
} else {
	$remove = 1;
}

if ($remove == 0) {
	require $config['BASE_DIR']. '/classes/image.class.php';
	$image   = new VImageConv();		

	if ( $_FILES['addthumb']['tmp_name'] != '' ) {		
		if ( is_uploaded_file($_FILES['addthumb']['tmp_name']) ) {
			$file_name   = $_FILES['addthumb']['name'];
			$file_name	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
			$ext		= strtolower(substr($file_name, strrpos($file_name, '.')+1));
			if (in_array($ext, $exts)) {					
				$addthumb = 1;

				$width    = 500;
				$height   = 500;
				
				$src      = $_FILES['addthumb']['tmp_name'];
				$dst_orig = $config['BASE_DIR']. '/media/users/orig/'.$UID.'.jpg';
				$dst	  = $config['BASE_DIR']. '/media/users/'.$UID.'.jpg';
				$image    = new VImageConv();
				
				move_uploaded_file($src, $dst_orig);
				copy($dst_orig, $dst);
				
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

				$sql = "UPDATE signup SET photo = '" .trim($conn->qStr($UID), "'"). ".jpg' WHERE UID = " .$conn->qStr($UID). " LIMIT 1";
				$conn->execute($sql);
			}
		}
	}
} else {
	$sql = "UPDATE signup SET photo = '' WHERE UID = " .$conn->qStr($UID). " LIMIT 1";
	$conn->execute($sql);
    $sql    = "SELECT gender FROM signup WHERE UID = " .$conn->qStr($UID). " LIMIT 1";
    $rs     = $conn->execute($sql);
    $gender = $rs->fields('gender');
	if ($gender != 'Female') {
		$gender = 'Male';
	}
	$dst_orig = $config['BASE_DIR']. '/media/users/orig/'.$UID.'.jpg';
	$dst	  = $config['BASE_DIR']. '/media/users/'.$UID.'.jpg';
	@chmod($dst_orig, 0777);
	@unlink($dst_orig);	
	@chmod($dst, 0777);
	@unlink($dst);	
}
?>
<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $UID ?>, <?php echo $addthumb ?>, <?php echo $remove ?>, <?php echo "'".$gender."'" ?>);</script>
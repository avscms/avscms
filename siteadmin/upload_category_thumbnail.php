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
$CID = $filter->get('category-thumbnail-id', 'INT');
$type = $filter->get('category-thumbnail-type', 'STRING');

$exts   = array('jpg', 'jpeg', 'png', 'gif');
$addthumb = 0;


require $config['BASE_DIR']. '/classes/image.class.php';
$image   = new VImageConv();		

if ( $_FILES['addthumb']['tmp_name'] != '' ) {
	if ( is_uploaded_file($_FILES['addthumb']['tmp_name']) ) {
		$file_name   = $_FILES['addthumb']['name'];
		$file_name	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
		$ext		= strtolower(substr($file_name, strrpos($file_name, '.')+1));
		if (in_array($ext, $exts)) {					
			$addthumb = 1;

			$width = 384;
			$height = 216;
			
			$src    = $_FILES['addthumb']['tmp_name'];
			$dst    = $config['BASE_DIR']. '/media/categories/' .$type. '/' .$CID. '.jpg';
			$image  = new VImageConv();
			
			move_uploaded_file($src, $dst);
					
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
		}
	}
}
?>
<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $CID ?>, <?php echo $addthumb ?>);</script>
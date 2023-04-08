<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$chimg = $config['BASE_DIR']. '/media/categories/album';
if ( !file_exists($chimg) or !is_dir($chimg) or !is_writable($chimg) ) {
    $errors[] = 'Category image directory \'' .$chimg. '\' is not writable!';
}

$channel = array('name' => '', 'slug' => '');
$exts   = array('jpg', 'jpeg', 'png', 'gif');

if ( isset($_POST['add_channel']) ) {
    $name   = trim($_POST['name']);
    $slug   = toAscii(trim($_POST['slug']));
    
    if ( $name == '' ) {
        $errors[] = 'Category name field cannot be blank!';
		$err['name'] = 1;
    } else {
        $sql        = "SELECT CID FROM album_categories WHERE name = " .$conn->qStr($name). " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() > 0 ) {
            $errors[]   = 'Category name \'' .htmlspecialchars($name, ENT_QUOTES, 'UTF-8'). ' is already used. Please choose another name!';
        }
    }
    $channel['name'] = $name;
	
	if ( $slug == '' ) {
		$slug = toAscii($name);		
	}
    
	if (channelSlugExists($slug, 0, 'album')) {
		$errors[]   = 'This slug already exists, please choose a different one!';
		$err['slug'] = 1;
	}
    $channel['slug'] = $slug;		
	
    if ( $_FILES['picture']['tmp_name'] == '' )
        $errors[] = 'Please provide a category image!';
    
    if ( !$errors ) {
        $sql = "INSERT INTO album_categories (name, slug) VALUES (" .$conn->qStr($name). ", ".$conn->qStr($slug).")";
        $conn->execute($sql);
        $CID = $conn->Insert_ID();
        require $config['BASE_DIR']. '/classes/image.class.php';
		
		if ( is_uploaded_file($_FILES['picture']['tmp_name']) ) {
			$file_name   = $_FILES['picture']['name'];
			$file_name	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
			$ext		= strtolower(substr($file_name, strrpos($file_name, '.')+1));
			if (in_array($ext, $exts)) {					

				$width = 384;
				$height = 216;
				
				$src    = $_FILES['picture']['tmp_name'];
				$dst    = $config['BASE_DIR']. '/media/categories/album/' .$CID. '.jpg';
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
			} else {
				$errors[] = 'Please provide a valid category image!';
			}
		} else {
			$errors[] = 'Please provide a category image!';		
		}
		
        if ( $errors ) {
            $sql = "DELETE FROM album_categories WHERE CID = " .$conn->qStr($CID). " LIMIT 1";
            $conn->execute($sql);
        }
    }
    
    if ( !$errors ) {
        $messages[] = 'Category successfully added!';
		$channel['name'] = '';
		$channel['slug'] = '';		
    }
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$channels   = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT * FROM album_categories";
    $query_count        = "SELECT count(CID) AS total_channels FROM album_categories";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'CID', 'order' => 'DESC');
	
	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset($_SESSION['search_achannels_option']);
	}	
	
    $option             = ( isset($_SESSION['search_achannels_option']) ) ? $_SESSION['search_achannels_option'] : $option_orig;
    
    if ( isset($_POST['search_channels']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);      
        $_SESSION['search_achannels_option'] = $option;
    }
    $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('channels', $channels);
$smarty->assign('channel', $channel);
?>

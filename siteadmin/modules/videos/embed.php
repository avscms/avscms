<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

require_once ($config['BASE_DIR']. '/include/function_thumbs.php');

$video = array('username' => 'anonymous', 'title' => '', 'description' => '', 'category' => 0, 'tags' => '',
               'type' => 'public', 'duration' => '', 'embed_code' => '');
if (isset($_POST['embed_video'])) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter     	= new VFilter();
    $valid			= new VValidation();
	$username		= $filter->get('username');
	$title			= $filter->get('title');
	$description    = $filter->get('description');	
	$tags			= $filter->get('tags');
	$type			= $filter->get('type');
	$category		= $filter->get('category', 'INT');
	$embed_code		= trim($_POST['embed_code']);
	$duration		= $filter->get('duration');
	
    if ( $username == '' ) {
        $errors[]                = 'Please enter a username!';
    } else {
        $sql        = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $rs         = $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $uid                = intval($rs->fields['UID']);
            $video['username']  = $username;
        } else {
            $errors[]    = 'Username: ' .htmlspecialchars($username, ENT_QUOTES, 'UTF-8'). 'does not exist!';
        }
    }

    if ( $title == '' ) {
        $errors[]           = 'Please enter a video title!';
    } else {
        $video['title']     = $title;
    }

	$video['description']     = $description;
    if ( $category === 0 ) {
        $errors[]           = 'Please select a video category!';
    } else {
        $video['category']  = $category;
    }

    if ( $tags == '' ) {
        $errors[]           = 'Please enter video tags!';
    } else {
		$tags				= prepare_tags($tags);
        $video['tags']      = $tags;
    }
	
	if ($embed_code == '') {
		$errors[]			= 'Please enter video embed code!';
	} else {
		$video['embed_code'] = $embed_code;
	}
	
	if ($duration == '') {
		$errors[]			= 'Please enter video duration!';
	} else {
		$video['duration']	= $duration;
	}
	
	$video['type'] = ($type == 'public') ? 'public' : 'private';

	$exts  = array('jpg', 'jpeg', 'png', 'gif');
	$thumb = FALSE;

	foreach ($_FILES['thumb']['name'] as $key => $file_name) {
		if ($_FILES['thumb']['tmp_name'][$key] != '') {
			if (is_uploaded_file($_FILES['thumb']['tmp_name'][$key])) {
				$filename	= substr($file_name, strrpos($file_name, DIRECTORY_SEPARATOR)+1);
				$ext		= strtolower(substr($filename, strrpos($filename, '.')+1));
				$size		= filesize($_FILES['thumb']['tmp_name'][$key]);
				if (in_array($ext, $exts)) {
					if ($size < (2*1024*1024)) {
						$thumb = TRUE;
					}
				}
			}
		}
	}

	
	if (!$thumb) {
		$errors[]	= 'Please upload at least one video thumbnail!';
	}
	
	if (!$errors) {
		$sql = "INSERT INTO video
		                SET UID = " .$uid. ",
						    title = " .$conn->qStr($title). ",
							keyword = " .$conn->qStr($tags). ",
							description = " .$conn->qStr($description). ",							
							channel = '" .$category. "',
							type = '" .$video['type']. "',
							embed_code = " .$conn->qStr($embed_code). ",
							duration = " .duration_to_seconds($duration). ",
							vkey = '" .mt_rand(). "',
							addtime = " .time(). ",
							adddate = '" .date('Y-m-d'). "',
							active = '0'";
		$conn->execute($sql);
		$vid     = $conn->insert_Id();
		require $config['BASE_DIR']. '/classes/image.class.php';
		$image   = new VImageConv();
		$tmb_dir = get_thumb_dir($vid);

		@mkdir($tmb_dir);

		$width	 = (int) $config['img_max_width'];
		$height	 = (int) $config['img_max_height'];
		$i		 = 1;

		foreach ($_FILES['thumb']['tmp_name'] as $file_tmp) {			
			$tmb = $i.'.jpg';
			$dst 	 = $tmb_dir.'/'.$tmb;
			if (move_uploaded_file($file_tmp, $dst)) {
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
				++$i;						
			}
		}
		
		$vkey = substr(md5($vid),11,20);
		$conn->execute("UPDATE video SET vkey = '".$vkey."', thumbs = ".($i-1).", active = '1'
		                WHERE VID = ".$vid." LIMIT 1");
		add_tags($tags);
		$messages[] = 'Successfuly embedded video!';
	}

}

function duration_to_seconds($duration)
{
    $dur_arr  = explode(':', $duration);
    if (!isset($dur_arr['1'])) {
        return FALSE;
    }
                    
    $duration = 0;
    if (isset($dur_arr['2'])) {
        $duration = ((int) $dur_arr['2']*3600);
    }

    $duration = $duration + ((int)$dur_arr['0']*60);

    return ($duration + (int)$dur_arr['1']);
}

$smarty->assign('video', $video);
$smarty->assign('categories', get_categories());
?>

<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$phppath    = $config['phppath'];
$ffmpeg     = $config['ffmpeg'];
$ffprobe    = $config['ffprobe'];

if ( file_exists($phppath) && is_file($phppath) && is_executable($phppath) ) {
	$binaries['phppath'] = '1';
} else {
	if ( file_exists('/usr/local/bin/php') && is_file('/usr/local/bin/php') && is_executable('/usr/local/bin/php') ) {
		$binaries['phppath'] = '/usr/local/bin/php';
	} else {
		if ( file_exists('/usr/bin/php') && is_file('/usr/bin/php') && is_executable('/usr/bin/php') ) {
			$binaries['phppath'] = '/usr/bin/php';
		}
	}
}

if ( file_exists($ffmpeg) && is_file($ffmpeg) && is_executable($ffmpeg) ) {
	$binaries['ffmpeg'] = '1';
} else {
	if ( file_exists('/usr/local/bin/ffmpeg') && is_file('/usr/local/bin/ffmpeg') && is_executable('/usr/local/bin/ffmpeg') ) {
		$binaries['ffmpeg'] = '/usr/local/bin/ffmpeg';
	} else {
		if ( file_exists('/usr/bin/ffmpeg') && is_file('/usr/bin/ffmpeg') && is_executable('/usr/bin/ffmpeg') ) {
			$binaries['ffmpeg'] = '/usr/bin/ffmpeg';
		}
	}
}

if ( file_exists($ffprobe) && is_file($ffprobe) && is_executable($ffprobe) ) {
	$binaries['ffprobe'] = '1';
} else {
	if ( file_exists('/usr/local/bin/ffprobe') && is_file('/usr/local/bin/ffprobe') && is_executable('/usr/local/bin/ffprobe') ) {
		$binaries['ffprobe'] = '/usr/local/bin/ffprobe';
	} else {
		if ( file_exists('/usr/bin/ffprobe') && is_file('/usr/bin/ffprobe') && is_executable('/usr/bin/ffprobe') ) {
			$binaries['ffprobe'] = '/usr/bin/ffprobe';
		}
	}
}

if ( isset($_POST['submit_media']) ) {
    $filter                     = new VFilter();
    $phppath			        = $filter->get('phppath');
	$ffmpeg		   			    = $filter->get('ffmpeg');	
	$ffprobe				    = $filter->get('ffprobe');		

	$img_max_width			    = $filter->get('img_max_width', 'INTEGER');
	$img_max_height			    = $filter->get('img_max_height', 'INTEGER');
	$video_max_size			    = $filter->get('video_max_size', 'INTEGER');
	$video_allowed_extensions	= $filter->get('video_allowed_extensions');
    $video_allowed_extensions   = str_replace(' ', '', $video_allowed_extensions);
    $video_allowed_extensions   = str_replace("\r", '', $video_allowed_extensions);
    $video_allowed_extensions   = str_replace("\n", '', $video_allowed_extensions);
	$post_max_size			    = str_replace('M', '', ini_get('post_max_size'));
	$upload_max_filesize		= str_replace('M', '', ini_get('upload_max_filesize'));

	$thumbnail_player_width     = $filter->get('thumbnail_player_width', 'INTEGER');
	$thumbnail_player_height    = $filter->get('thumbnail_player_height', 'INTEGER');
	$thumbnail_remove_bb        = $filter->get('thumbnail_remove_bb');
	$thumbnail_keep_ar          = $filter->get('thumbnail_keep_ar');
	
	//Conversion Q
	$q_limit 		= intval($_POST['q_limit']);
	$q_timeout 		= intval($_POST['q_timeout']);	
	$conversion_q 	= intval($_POST['conversion_q']);

	if ($q_limit < 1) {
		$errors[] = 'Max Simultaneous Conversions minimum value is 1!';
		$err['q_limit'] = 1;			
	}
	if ($q_timeout < 1) {
		$errors[] = 'Conversion Timeout minimum value is 1!';
		$err['q_timeout'] = 1;			
	}	
	//--	
	
	if ($thumbnail_remove_bb != '1') {
		$thumbnail_remove_bb = 0;
	} else {
		$thumbnail_remove_bb = 1;
	}

	if ($thumbnail_keep_ar != '1') {
		$thumbnail_keep_ar = 0;
	} else {
		$thumbnail_keep_ar = 1;
	}
    
	if ( $phppath == '' ) {
		$errors[] = 'Path to PHP CLI binary cannot be left blank!';
		$err['phppath'] = 1;
	}
	if ( $ffmpeg == '' ) {
		$errors[] = 'Path to FFMpeg binary cannot be left blank!';
		$err['ffmpeg'] = 1;		
	}
	if ( $ffprobe == '' ) {
		$errors[] = 'Path to FFProbe binary cannot be left blank!';
		$err['ffprobe'] = 1;		
	}	

	if ( $img_max_width == '' ) {
		$errors[] = 'Max Thumbnail Width (in pixels) cannot be left blank!';
		$err['img_max_width'] = 1;		
	}
	elseif ( !is_numeric($img_max_width) ) {
		$errors[] = 'Max Thumbnail Width (in pixels) must have a numeric value!';		
		$err['img_max_width'] = 1;		
	}
	if ( $img_max_height == '' ) {
		$errors[] = 'Max Thumbnail Height (in pixels) cannot be left blank!';
		$err['img_max_height'] = 1;		
	}
	elseif ( !is_numeric($img_max_height) ) {
		$errors[] = 'Max Thumbnail Height (in pixels) must have a numeric value!';
		$err['img_max_height'] = 1;		
	}
	if ( $video_max_size == '' ) {
		$errors[] = 'Video Max Size field cannot be blank!';
		$err['video_max_size'] = 1;		
	} else {
		settype($video_max_size, 'integer');
		settype($post_max_size, 'integer');
		settype($upload_max_filesize, 'integer');
		if ( $video_max_size > $post_max_size || $video_max_size > $upload_max_filesize ) {
			$errors[] = 'Video Max Size cannot be bigger then the php values for \'post_max_size\' or \'upload_max_filesize\'.<br> Please edit php settings (php.ini) and increase the post_max_size and upload_max_filesize values!';
			$err['video_max_size'] = 1;			
		}
	}
	if ( $video_allowed_extensions == '' ) {
		$errors[] = 'Video Allowed Extensions field cannot be empty!';
		$err['video_allowed_extensions'] = 1;		
	}
	elseif ( !preg_match('/^[a-zA-Z0-9, ]*$/', $video_allowed_extensions) ) {
		$errors[] = 'Video Allowed Extensions field can only contain alpha-numeric characters, comas and spaces!';
		$err['video_allowed_extensions'] = 1;		
	}
	else {
		$video_allowed_extensions = str_replace(' ', '', $video_allowed_extensions);
	}

	if ( $thumbnail_player_width == '' ) {
		$errors[] = 'Thumbnail Player Width (in pixels) cannot be left blank!';
		$err['thumbnail_player_width'] = 1;		
	}
	elseif ( !is_numeric($thumbnail_player_width) ) {
		$errors[] = 'Thumbnail Player Width (in pixels) must have a numeric value!';		
		$err['thumbnail_player_width'] = 1;		
	}
	if ( $thumbnail_player_height == '' ) {
		$errors[] = 'Thumbnail Player Height (in pixels) cannot be left blank!';
		$err['thumbnail_player_height'] = 1;		
	}
	elseif ( !is_numeric($thumbnail_player_height) ) {
		$errors[] = 'Thumbnail Player Height (in pixels) must have a numeric value!';		
		$err['thumbnail_player_height'] = 1;		
	}	
	
	if ( !$errors ) {
        $config['phppath']                   = $phppath;
        $config['ffmpeg']                    = $ffmpeg;
        $config['ffprobe']                   = $ffprobe;	
        $config['img_max_width']             = $img_max_width;
        $config['img_max_height']            = $img_max_height;
        $config['video_max_size']            = $video_max_size;
        $config['video_allowed_extensions'] = $video_allowed_extensions;
		$config['thumbnail_player_width']   = $thumbnail_player_width;
		$config['thumbnail_player_height']  = $thumbnail_player_height;
		$config['thumbnail_remove_bb']      = $thumbnail_remove_bb;
		$config['thumbnail_keep_ar']        = $thumbnail_keep_ar;
		
		//Conversion Q
		$config['conversion_q'] = $conversion_q;
		$config['q_limit'] 		= $q_limit;
		$config['q_timeout'] 	= $q_timeout;		
		//--		
		
		update_config($config);
        update_smarty();
		$messages[] = 'Conversion settings updated successfully!';	
	}
	
	if ( file_exists($phppath) && is_file($phppath) && is_executable($phppath) ) {
		$binaries['phppath'] = '1';
	} else {
		if ( file_exists('/usr/local/bin/php') && is_file('/usr/local/bin/php') && is_executable('/usr/local/bin/php') ) {
			$binaries['phppath'] = '/usr/local/bin/php';
		} else {
			if ( file_exists('/usr/bin/php') && is_file('/usr/bin/php') && is_executable('/usr/bin/php') ) {
				$binaries['phppath'] = '/usr/bin/php';
			}
		}
	}

	if ( file_exists($ffmpeg) && is_file($ffmpeg) && is_executable($ffmpeg) ) {
		$binaries['ffmpeg'] = '1';
	} else {
		if ( file_exists('/usr/local/bin/ffmpeg') && is_file('/usr/local/bin/ffmpeg') && is_executable('/usr/local/bin/ffmpeg') ) {
			$binaries['ffmpeg'] = '/usr/local/bin/ffmpeg';
		} else {
			if ( file_exists('/usr/bin/ffmpeg') && is_file('/usr/bin/ffmpeg') && is_executable('/usr/bin/ffmpeg') ) {
				$binaries['ffmpeg'] = '/usr/bin/ffmpeg';
			}
		}
	}


	if ( file_exists($ffprobe) && is_file($ffprobe) && is_executable($ffprobe) ) {
		$binaries['ffprobe'] = '1';
	} else {
		if ( file_exists('/usr/local/bin/ffprobe') && is_file('/usr/local/bin/ffprobe') && is_executable('/usr/local/bin/ffprobe') ) {
			$binaries['ffprobe'] = '/usr/local/bin/ffprobe';
		} else {
			if ( file_exists('/usr/bin/ffprobe') && is_file('/usr/bin/ffprobe') && is_executable('/usr/bin/ffprobe') ) {
				$binaries['ffprobe'] = '/usr/bin/ffprobe';
			}
		}
	}	

	$smarty->assign('err', $err);	
	$smarty->assign('phppath', $phppath);
	$smarty->assign('ffmpeg', $ffmpeg);
	$smarty->assign('ffprobe', $ffprobe);

	$smarty->assign('img_max_width', $img_max_width);
	$smarty->assign('img_max_height', $img_max_height);
	$smarty->assign('video_max_size', $video_max_size);
	$smarty->assign('video_allowed_extensions', $video_allowed_extensions);	

}
$smarty->assign('binaries', $binaries);
?>

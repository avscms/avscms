<?php
defined('_VALID') or die('Restricted Access!');
require_once ($config['BASE_DIR']. '/include/function_thumbs.php');
require $config['BASE_DIR']. '/classes/image.class.php';

function file_url_exists($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}

function compareColors($colorA, $colorB, $threshold) {
    $deviation =  abs($colorA['red'] - $colorB['red']) + abs($colorA['green'] - $colorB['green']) + abs($colorA['blue'] - $colorB['blue']);
	if ($deviation <= $threshold) return true;
	else return false;
}

function video_files($vid, $all=false) {
	global $config, $conn;
	
	$sql     	 = "SELECT formats, hd_filename, ipod_filename, vdoname, flvdoname, server FROM video WHERE VID = " .$conn->qStr($vid). " LIMIT 1";
	$rs  	 	 = $conn->execute($sql);
	$formats 	 = $rs->fields['formats'];
	$sd_file 	 = $rs->fields['ipod_filename'];
	$hd_file 	 = $rs->fields['hd_filename'];
	$flv_file	 = $rs->fields['flvdoname'];	
	$video_name	 = $rs->fields['vdoname'];	
	$server  	 = $rs->fields['server'];
	
	if ($formats) {
		$formats_arr = explode(',', $formats);
	}	
	if ($server != '') {
		if ($formats) {
			foreach ($formats_arr as $format) {
				 unset($f);
				 $f    		   				= explode('.', $format);
				 $vf['url'][]  				= $server.'/h264/'.$vid."_".$f[1].".".$f[2];	//New Formats - Server
				 $vf['server_h264_fn'][]	= $vid."_".$f[1].".".$f[2];					//New Formats - Server - File Name
			}
		}
		if ($hd_file) {			
			$vf['url'][] 			= $server."/iphone/".$sd_file;							//HD File - Server
			$vf['server_hd_fn']     = $vid.".mp4";											//HD File - Server - File Name
		}
		if ($sd_file) {
			$vf['url'][] 			= $server."/hd/".$hd_file;								//SD File - Server
			$vf['server_sd_fn'] 	= $vid.".mp4";											//HD File - Server - File Name			
		}	
	} else {
		if ($formats) {		
			foreach ($formats_arr as $format) {
				 unset($f);
				 $f    		  = explode('.', $format);
				 $vf['dir'][] = $config['H264_DIR'].'/'.$vid."_".$f[1].".".$f[2]; 			//New Formats
			}
		}
		if ($hd_file) {		
			$vf['dir'][] = $config['HD_DIR']."/".$sd_file;									// HD File
		}
		if ($sd_file) {
			$vf['dir'][] = $config['IPHONE_DIR']."/".$hd_file;								// SD File	
		}
	}
	if ($all) {
		$vf['dir'][] = $config['VDO_DIR']."/".$video_name;									// Original Video	
		if ($flv_file) {
			$vf['dir'][] = $config['FLVDO_DIR']."/".$flv_file;								// FLV File
		}
	}
	return $vf;
}

function detect_black_bars($src, $coef) {

	$image_path = $src;

	$jpg = imagecreatefromjpeg($image_path);
	$black = array("red" => 0, "green" => 0, "blue" => 0, "alpha" => 0);

	$removeLeft = 0;
	for($x = 0; $x < (imagesx($jpg)*$coef); $x++) {
		for($y = 0; $y < imagesy($jpg); $y++) {
			$color = imagecolorsforindex($jpg, imagecolorat($jpg, $x, $y));
			if(!compareColors($color, $black, 30)){
				break 2;
			}
		}
		$removeLeft += 1;
	}

	$removeRight = 0;
	for($x = imagesx($jpg)-1; $x > (imagesx($jpg)*(1-$coef)); $x--) {
		for($y = 0; $y < imagesy($jpg); $y++) {
			$color = imagecolorsforindex($jpg, imagecolorat($jpg, $x, $y));
			if(!compareColors($color, $black, 30)){
				break 2;
			}
		}
		$removeRight += 1;
	}

	$removeTop = 0;
	for($y = 0; $y < (imagesy($jpg)*$coef); $y++) {
		for($x = 0; $x < imagesx($jpg); $x++) {
			$color = imagecolorsforindex($jpg, imagecolorat($jpg, $x, $y));
			if(!compareColors($color, $black, 30)){
				break 2;
			}
		}
		$removeTop += 1;
	}

	$removeBottom = 0;
	for($y = imagesy($jpg)-1; $y > (imagesy($jpg)*(1-$coef)); $y--) {
		for($x = 0; $x < imagesx($jpg); $x++) {
			$color = imagecolorsforindex($jpg, imagecolorat($jpg, $x, $y));
			if(!compareColors($color, $black, 30)){
				break 2;
			}
		}
		$removeBottom += 1;
	}

	$removeLeft += 5;
	$removeRight += 5;
	$removeTop += 7;
	$removeBottom += 7;
	imagedestroy($jpg);	
	
	return array('left' => $removeLeft, 'right' => $removeRight, 'top' => $removeTop, 'bottom' => $removeBottom);
	

}

function remove_black_bars($src, $removeLeft, $removeRight, $removeTop, $removeBottom) {
	$image_path = $src;
	$jpg = imagecreatefromjpeg($image_path);
	$cropped = imagecreatetruecolor(imagesx($jpg) - ($removeLeft + $removeRight), imagesy($jpg) - ($removeTop + $removeBottom));
	imagecopy($cropped, $jpg, 0, 0, $removeLeft, $removeTop, imagesx($cropped), imagesy($cropped));

	header("Content-type: image/jpeg");
	imagejpeg($cropped, $image_path);
	imagedestroy($cropped);
	imagedestroy($jpg);		
}


function process_thumb($src, $dst_w, $dst_h, $keep_ar = true) {

    $image      = new VImageConv();
	list ($width, $height) = getimagesize($src);
	
	if($keep_ar) {
		$aspect_src = $width/$height;
		$aspect_dst = $dst_w/$dst_h;
		
		if ($aspect_src < $aspect_dst) {
			$crop_w = $width;		
			$crop_h = floor(($dst_h*$width)/$dst_w);
			$crop_x = 0;
			$crop_y = floor (($height - $crop_h)/2);
		}
		else {
			$crop_w = floor(($dst_w*$height)/$dst_h);
			$crop_h = $height;
			$crop_x = floor (($width - $crop_w)/2);
			$crop_y = 0;		
		}
		$image->process($src, $src, 'EXACT', $crop_w, $crop_h);
		$image->crop($crop_x, $crop_y, $crop_w, $crop_h, true);
	}
	$image->process($src, $src, 'EXACT', $dst_w, $dst_h);
	$image->resize(true, true);

}

function get_video_duration($video_path, $video_id)
{
    global $config;
    $cmd = $config['ffprobe']. " -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " .$video_path;
    log_conversion($config['LOG_DIR']. '/' .$video_id. '.log', $cmd);
    exec($cmd, $output);
    log_conversion($config['LOG_DIR']. '/' .$video_id. '.log', implode("\n", $output));
	return floatval($output[0]);
}

function extract_video_thumbs ($video_path, $video_id, $target = 'all', $black_bars = false, $keep_ar = true, $admin = false) {

	global $config, $conn;
  
	// Logfile
	$logfile = $config['LOG_DIR'].'/'.$video_id.'.thumbs.log';
	@chmod($logfile,0777);
	@unlink($logfile);   
  
	// Get Duration of Video from Database
	$duration = get_video_duration($video_path, $video_id);

	// Only continue if source video exists
	if (file_exists($video_path) || file_url_exists($video_path)) {
  	
		// Temp & Final Thumbnails Directories
		$temp_thumbs_folder  = $config['TMP_DIR'].'/thumbs/'.$video_id;
		if ($admin) {
			$final_thumbs_folder = $config['TMP_DIR'].'/thumbs/'.$video_id.'_adm';
		} else {
			$final_thumbs_folder = get_thumb_dir($video_id);			
		}
		
		// Create Thumbs Directories
		if (!file_exists($temp_thumbs_folder)) {
			@mkdir($temp_thumbs_folder, 0777);
		}
		
		if (!file_exists($final_thumbs_folder)) {		
			@mkdir($final_thumbs_folder, 0777);
		}
		// Duration - set se = start/end
		if ($duration > 5) {
			$se = 2;
		} elseif ($duration > 3) {
			$se = 1;
		} elseif ($duration > 2) {
			$se = 0.5;
		} else {
			$se = 0;
		}

		$random = rand(0,floor($duration/10));

		$se = $se + $random;
		$seconds = $duration - (2*$se);
		
		// Divided by 20 thumbs
		$timeseg = $seconds/20;

		// Loop for 20 thumbs
		for ($i=0;$i<=20;$i++) {
			if ($target == 'main' && $i == 0) {
				continue;
			}
			if ($target == 'player' && $i > 0) {
				continue;
			}			
			if ($i==0) {
				// Destination
				$final_thumbnail = $final_thumbs_folder.'/default.jpg';
				// Get Seek Time
				$ss = (rand(0,$seconds)) + $se;
			} else {
				// Destination
				$final_thumbnail = $final_thumbs_folder.'/'.$i.'.jpg';
				// Get Seek Time
				$ss = ($i * $timeseg) + $se;
			}

			// Work out seconds to hh:mm:ss format
			$hms = "";
			$hours = intval($ss / 3600); 
			$hms .= str_pad($hours, 2, "0", STR_PAD_LEFT). ':';
			$minutes = intval(($ss / 60) % 60); 
			$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
			$secs = intval($ss % 60); 
			$hms .= str_pad($secs, 2, "0", STR_PAD_LEFT);	
			$seek = $hms;			

			// Temporary filename convention. used by ffmpeg only.
			$temp_thumbs = $temp_thumbs_folder.'/%08d.jpg'; 

			// Temporary Thumbnail File
			$temp_thumb_file = $temp_thumbs_folder.'/00000001.jpg'; 


			// Set Permission and Delete Temporary Thumbnail File
			@chmod($temp_thumb_file,0777);
			@unlink($temp_thumb_file);			

			// Thumbnails extraction commands
			if ( $config['thumbs_tool'] == 'ffmpeg' ) {
				// FFMPEG Command
				$cmd = $config['ffmpeg']." -ss ".$seek." -i '".$video_path."' -r 1 -vframes 1 -an -vcodec mjpeg -y ".$temp_thumbs;
			} else {      
				// Mplayer Command
				$cmd = $config['mplayer']." -zoom ".$video_path." -ss ".$seek." -nosound -frames 1 -vf scale=-1:-1 -vo jpeg:outdir=".$temp_thumbs_folder;
			}

			// Send data to logfile
			log_conversion($logfile, $cmd);

			// Execute Command
			exec($cmd, $output);

			// Send data to logfile
			log_conversion($logfile, implode("\n", $output));

			// Check if file exists
			if (file_exists($temp_thumb_file)) {
				copy($temp_thumb_file, $final_thumbnail);
				// Set permission
				@chmod($temp_thumb_file,0777);				
			}

		}

		// Delete Temporary Thumbnail
		delete_directory($temp_thumbs_folder);

	}
	
	if ($black_bars) {
		$left = 0;
		$right = 0;
		$top = 0;
		$bottom = 0;
		
		for ($i=0;$i<=20;$i++) {
			if ($target == 'main' && $i == 0) {
				continue;
			}
			if ($target == 'player' && $i > 0) {
				continue;
			}			
			if ($i==0) {
				$final_thumbnail = $final_thumbs_folder.'/default.jpg';
				$bb = detect_black_bars($final_thumbnail, 0.20);
				if ($left == 0) {
					$left = $bb['left'];
				} else {
					$left = min($left, $bb['left']);
				}
				if ($right == 0) {
					$right = $bb['right'];
				} else {
					$right = min($right, $bb['right']);
				}
				if ($top == 0) {
					$top = $bb['top'];
				} else {
					$top = min($top, $bb['top']);
				}
				if ($bottom == 0) {
					$bottom = $bb['bottom'];
				} else {
					$bottom = min($bottom, $bb['bottom']);
				}				
			} else {
				$final_thumbnail = $final_thumbs_folder.'/'.$i.'.jpg';
				$bb = detect_black_bars($final_thumbnail, 0.25);
				if ($left == 0) {
					$left = $bb['left'];
				} else {
					$left = min($left, $bb['left']);
				}
				if ($right == 0) {
					$right = $bb['right'];
				} else {
					$right = min($right, $bb['right']);
				}
				if ($top == 0) {
					$top = $bb['top'];
				} else {
					$top = min($top, $bb['top']);
				}
				if ($bottom == 0) {
					$bottom = $bb['bottom'];
				} else {
					$bottom = min($bottom, $bb['bottom']);
				}				
			}
		}
	}
	for ($i=0;$i<=20;$i++) {
		if ($target == 'main' && $i == 0) {
			continue;
		}
		if ($target == 'player' && $i > 0) {
			continue;
		}			
		if ($i==0) {
			$final_thumbnail = $final_thumbs_folder.'/default.jpg';
			if ($black_bars) {
				remove_black_bars($final_thumbnail, $left, $right, $top, $bottom);
			}
			process_thumb($final_thumbnail, $config['thumbnail_player_width'], $config['thumbnail_player_height'], $keep_ar);
		} else {
			$final_thumbnail = $final_thumbs_folder.'/'.$i.'.jpg';
			if ($black_bars) {
				remove_black_bars($final_thumbnail, $left, $right, $top, $bottom);			
			}
			process_thumb($final_thumbnail, $config['img_max_width'], $config['img_max_height'], $keep_ar);					
		}
	}	
  
	return;
}


function extract_video_vthumbs($video_path, $video_id, $img_thumbs = true) {
	
	global $config, $conn;

    $duration   = get_video_duration($video_path, $video_id);

	if ($duration == 0) {
		return false;
	}

	$full=false;
	
	if ( $duration > 30 ) {
		$step	= floor($duration/14);
		$ss 	= intval($step);
	} else {
		$full	= true;
		$ss		= intval($duration/2);
	}
	
	$final_thumbs_folder = get_thumb_dir($video_id);

	@mkdir($final_thumbs_folder, 0777);
	@chmod($final_thumbs_folder, 0777);
	$cmd_parts='';

	$width  = $config['img_max_width'];
	$height = $config['img_max_height'];
	$area = $width * $height;
	$default_width = 640;

	$copy_mp4 = $final_thumbs_folder.'/video_copy.mp4';	
	$copy_webm = $final_thumbs_folder.'/video_copy.webm';
	$copy_default = $final_thumbs_folder.'/default_copy.jpg';
	$copy_thumb = $final_thumbs_folder.'/thumb_copy.jpg';

	$dst_mp4 = $final_thumbs_folder.'/video.mp4';	
	$dst_webm = $final_thumbs_folder.'/video.webm';
	$dst_default = $final_thumbs_folder.'/default.jpg';
	$dst_thumb = $final_thumbs_folder.'/thumb.jpg';

	$default_command = $config['ffmpeg']. " -ss ".$ss." -i " .$video_path. " -f image2 -vf scale='min(".$default_width."\,iw)':-1 -vframes 1 -y " .$copy_default;
	$thumb_command = $config['ffmpeg']. ' -ss '.$ss.' -i ' .$video_path. ' -f image2 -s ' .$width. 'x' .$height. ' -vframes 1 -y ' .$copy_thumb;

	if ($full != false) {
		if($config['thumbexact']=='1') {
			$webm_command =  $config['ffmpeg'].' -i '.$video_path. ' -ss 3 -filter_complex crop='.$width.':'.$height.',scale=iw:ih -codec:v libvpx -an -y '.$copy_webm;
			$ffmpeg_command =  $config['ffmpeg'].' -i '.$video_path. ' -ss 3 -filter_complex crop='.$width.':'.$height.',scale=iw:ih -codec:v libx264 -an -y '.$copy_mp4;
		}	else {
			$webm_command =  $config['ffmpeg'].' -i '.$video_path. ' -ss 3 -filter_complex scale='.$width.':'.$height.' -codec:v libvpx -crf 22 -an -y '.$copy_webm;
			$ffmpeg_command =  $config['ffmpeg'].' -i '.$video_path. ' -ss 3 -filter_complex scale='.$width.':'.$height.' -codec:v libx264 -an -y '.$copy_mp4;	
		}
	} else {		
		$i = 0;
		while($i <= 12 ) {
			$t=2; 
			$cmd_parts.= ' -ss '.$ss.' -t '.$t.' -i '.$video_path;
			$ss = $ss+$step;
			if ( $ss > $duration ) {
				$ss = $ss-$step;
			}
			++$i;
		}
		if ($config['thumbexact']=='1') {		
			$webm_command =  $config['ffmpeg'].' '.$cmd_parts. ' -filter_complex "[0][1][2][3][4][5][6][7]concat=n=8:v=1:a=0",crop='.$width.':'.$height.',scale=iw:ih -codec:v libvpx -an -y '.$copy_webm;
			$ffmpeg_command =  $config['ffmpeg'].' '.$cmd_parts. ' -filter_complex "[0][1][2][3][4][5][6][7]concat=n=8:v=1:a=0",crop='.$width.':'.$height.',scale=iw:ih -codec:v libx264 -an -y '.$copy_mp4;
		} else {
			$webm_command =  $config['ffmpeg'].' '.$cmd_parts. ' -filter_complex "[0][1][2][3][4][5][6][7]concat=n=8:v=1:a=0",scale='.$width.':'.$height.' -codec:v libvpx -an -y '.$copy_webm;
			$ffmpeg_command =  $config['ffmpeg'].' '.$cmd_parts. ' -filter_complex "[0][1][2][3][4][5][6][7]concat=n=8:v=1:a=0",scale='.$width.':'.$height.' -codec:v libx264 -an -y '.$copy_mp4;
		}
	
	}

	@exec($ffmpeg_command);
	@exec($webm_command );

	if($img_thumbs != false) { 
		@exec($default_command);
	}
	@exec($thumb_command);

	if( file_exists($copy_webm) && filesize($copy_webm)>100 && file_exists($copy_mp4) && filesize($copy_mp4)>100  ) {			
		if(file_exists($dst_webm)) @chmod($dst_webm,0777);
		if(file_exists($dst_mp4)) @chmod($dst_mp4,0777);

		@copy($copy_webm,$dst_webm); @unlink($copy_webm); 
		@copy($copy_mp4,$dst_mp4); @unlink($copy_mp4);
		if(file_exists($copy_default) && filesize($copy_default) ) {
			if(file_exists($dst_default)) @chmod($dst_default,0777);
			@copy($copy_default,$dst_default); 
			sharp_image($dst_default);
			@chmod($copy_default,0777); @unlink($copy_default);
		}
		if(file_exists($copy_thumb) && filesize($copy_thumb) ) {
			if(file_exists($dst_thumb)) @chmod($dst_thumb,0777);
			@copy($copy_thumb,$dst_thumb); 
			sharp_image($dst_thumb);
			@chmod($copy_thumb,0777); @unlink($copy_thumb);
		}
		$sql = "UPDATE video SET vthumbs = '1' WHERE VID = '".(int)$video_id."'";
		$conn->execute($sql);		
		return true;
	}
	return false;
}       

function sharp_image($image) {
	if(file_exists($image)) {
		$img = imagecreatefromjpeg($image);
		$sharpen = array(
			array(-1, -1,  -1),
			array(-1, 24, -1),
			array(-1, -1,  -1),
		);
		$divisor = array_sum(array_map('array_sum', $sharpen));
		imageconvolution($img, $sharpen, $divisor, 0);
		imagejpeg($img, $image, 90);
	}
}

function log_conversion($file_path, $text)
{   
    $file_dir = dirname($file_path);
    if( !file_exists($file_dir) or !is_dir($file_dir) or !is_writable($file_dir) ) {
        return false;
    }
                    
    $write_mode = 'w';
    if( file_exists($file_path) && is_file($file_path) && is_writable($file_path) ) {
        $write_mode = 'a';
    }
                                
    if( !$handle = fopen($file_path, $write_mode) ) {
        return false;
    }
                                                
    if( fwrite($handle, $text. "\n") == false ) {
        return false;
    }
                                                            
    @fclose($handle);
}                                                        
?>
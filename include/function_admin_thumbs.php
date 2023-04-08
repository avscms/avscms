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
    $cmd = $config['mplayer']. ' -quiet -nolirc -vo null -ao null -frames 0 -identify "' .$video_path. '"';
    log_conversion($config['LOG_DIR']. '/' .$video_id. '.log', $cmd);
    exec($cmd, $output);
    log_conversion($config['LOG_DIR']. '/' .$video_id. '.log', implode("\n", $output));
    while ( list($k,$v) = each($output) ) {
        if ( $length = strstr($v, 'ID_LENGTH=') ) {
            break;
        }
    }
    
    if ( isset($length) ) {
        $lx = explode('=', $length);
        
        return $lx['1'];
    }
    
    return '0';
}

function extract_video_thumbs ($video_path, $video_id, $target = 'all', $black_bars = false, $keep_ar = true) {

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
		$final_thumbs_folder = $config['TMP_DIR'].'/thumbs/'.$video_id.'_adm';
		
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

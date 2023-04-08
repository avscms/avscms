<?php
/*|-------------------------------------------------
|*|	AVS Conversion Functions
|*| Convert H264
|*|-------------------------------------------------
|*/	

function scale ($iw, $ih, $rw, $rh) {
	if (($iw/$ih)<=($rw/$rh)) {
		$ow = $iw*$rh/$ih;
		$oh = $rh;
	} else {
		$oh = $ih*$rw/$iw;
		$ow = $rw;
	}
	$ow = floor($ow/2)*2;
	$oh = floor($oh/2)*2;
	$scale = "-vf scale=".$ow.":".$oh;
	return $scale;
}

function ratio($a, $b) {
    $gcd = function($a, $b) use (&$gcd) {
        return ($a % $b) ? $gcd($b, $a % $b) : $b;
    };
    $g = $gcd($a, $b);
    return $a/$g . ':' . $b/$g;
}

function get_mediainfo_data($videofile) {
	global $config;
	$varr = array();
	$output1 = array();
	$output2 = array();
	$media_general = $config['BASE_DIR']."/scripts/media_general.txt";
	$media_video = $config['BASE_DIR']."/scripts/media_video.txt";
	if (!preg_match("/mediainfo$/is", $config['mediainfo'])){
		$error = 'Mediainfo error';
	}else{
		$command1 = $config['mediainfo']." --Inform=file://".$media_general." ".$videofile;
		exec($command1,$output1);
		$command2 = $config['mediainfo']." --Inform=file://".$media_video." ".$videofile;
		exec($command2,$output2);
		$error = '';
	}
	$varr['error'] = $error;
	$varr['media_gen_cmd'] = $command1;
	$varr['media_vid_cmd'] = $command2;
	$varr['media_gen_out'] = $output1;
	$varr['media_vid_out'] = $output2;
	return $varr;
}

function videoInfo($vi) {
	foreach($vi['media_gen_out'] as $line){
		if (preg_match("/^(General_|Video_).+?\=.*/", $line)){
			$line_arr = explode("=", $line);
			$video_info[$line_arr[0]] = $line_arr[1];
		}
	}
	foreach($vi['media_vid_out'] as $line){
		if (preg_match("/^(General_|Video_).+?\=.*/", $line)){
			$line_arr = explode("=", $line);
			$video_info[$line_arr[0]] = $line_arr[1];
		}
	}	
	echo "\n".$nl."Media Descriptors Commands\n".$nl;
	echo "Comand 1: ".$vi['media_gen_cmd']."\n";
	echo "Comand 2: ".$vi['media_vid_cmd']."\n";
	echo "\n".$nl."Media Info\n".$nl;
	foreach ($video_info as $key => $val){
		echo "\$video_info['".$key."'] = '".$val."';\n";
	}
	return $video_info;
}

function get_ffprobe_data($videofile) {
	global $config;
	$varr = array();
	$output1 = array();
	$output2 = array();

	$command1 = $config['ffprobe']." -v error -select_streams v:0 -show_entries stream=codec_long_name,codec_name,width,height,display_aspect_ratio,duration -of default=noprint_wrappers=1 ".$videofile."";	
	exec($command1,$output1);

	$command2 = $config['ffprobe']." -v error -show_entries format=filename,format_name,duration,size -of default=noprint_wrappers=1 ".$videofile."";	
	exec($command2,$output2);

	$varr['stream'] = $output1;
	$varr['format'] = $output2;	
	$varr['ffp_cmd1'] = $command1;
	$varr['ffp_cmd2'] = $command2;	
	return $varr;
}

function ffpInfo($vi) {
	foreach($vi['stream'] as $line){
		$line_arr = explode("=", $line);
		switch ($line_arr[0]) {
			case 'width':
				$video_info[$line_arr[0]] = intval($line_arr[1]);
				break;
			case 'height':
				$video_info[$line_arr[0]] = intval($line_arr[1]);
				break;
			default:
				$video_info[$line_arr[0]] = $line_arr[1];
		}
		if ($video_info['display_aspect_ratio'] == '0:1') {
			$video_info['display_aspect_ratio'] = ratio($video_info['width'], $video_info['height']);
		}
		
	}
	foreach($vi['format'] as $line){
		$line_arr = explode("=", $line);
		switch ($line_arr[0]) {
			case 'duration':
				$video_info[$line_arr[0]] = floatval($line_arr[1]);
				break;
			case 'size':
				$video_info[$line_arr[0]] = intval($line_arr[1]);
				break;
			default:
				$video_info[$line_arr[0]] = $line_arr[1];
		}
		$filename_arr = explode(".",$video_info['filename']);
		$video_info['file_extension'] = end($filename_arr);
		
	}	
	echo "\n".$nl."FFProbe Command\n".$nl;
	echo "Comand 1: ".$vi['ffp_cmd1']."\n";
	echo "Comand 2: ".$vi['ffp_cmd2']."\n";	

	echo "\n".$nl."FFProbe Info\n".$nl;
	foreach ($video_info as $key => $val){
		echo "\$video_info['".$key."'] = '".$val."';\n";
	}
	return $video_info;
}

function print_log($txt) {
	global $config;
	if ($config['log_conversion']){
		print ($txt);
	}
}

function modproc($cmd) {
	$cmd = str_replace(" ;", " 2>&1 ;", $cmd)." 2>&1";
	$nl = "=========================================================\n";
	echo "\n".$nl."Command:\n".$nl.$cmd."\n\n";
	exec($cmd,$out);
	foreach($out as $outd){
		$outs .= $outd."\n";
	}
	echo "Output:\n".$outs."\n\n";
}

function getEncodings() {
	global $config, $conn;
	$sql = "SELECT * FROM encoding WHERE status = '1' ORDER BY height DESC";
	$rs = $conn->execute($sql);
    $encodings = $rs->getrows();
	end($encodings);
	$lastkey = key($encodings);
	$encodings[$lastkey]['lq'] = true;
	return $encodings;
}

function convert($e, $vid, $video_name, $video_info, $skip) {
	global $config;
	$nl = "=========================================================\n";

	// Output :: Vars
	echo "\n".$nl."Output - Conversion Config:\n".$nl;
	echo "Label: ".$e['label']."\n";
	echo "Resolution: ".$e['width'].'x'.$e['height']."\n";
	echo "Constant Rate Factor: ".$e['crf']."\n";
	echo "Preset: ".$e['preset']."\n";
	echo "iOS Compatability: ".$e['ios']."\n";
	echo "Fast Start: ".$e['faststart']."\n";	
	echo "Copy Only: ".$e['copyonly']."\n";

	if($skip  == $e['height']) {
		echo "\n"."SKIP CONVERSION: Output resolution already done!\n\n";
		return;
	}

	if (($e['height'] <= $video_info['height'] || $e['width'] <= $video_info['width']) || $e['lq'] ) {

		//Check cut intro
		$sql 	= "SELECT cut FROM video WHERE VID = '" .$vid. "' LIMIT 1";
		$rs		= selectQuery($sql);
		$cut	= $rs['cut'];
		if ($cut) {
			$add_cut = " -ss ".$cut;
		} else {
			$add_cut = "";
		}
		
		// Source Video Path info
		$src = $config['VDO_DIR']."/".$video_name;

		// HD Paths info		
		$output = $config['H264_DIR']."/".$vid."_".$e['label'].".".$e['format'];
		
		if ($e['faststart']) {
			$faststart = "-movflags +faststart";
		} else {
			$faststart = "";			
		}
		if ($e['copyonly'] && ($e['height'] == $video_info['height'] || $e['width'] == $video_info['width']) && $video_info['file_extension'] == "mp4" && strpos($video_info['format_name'], 'mp4') !== false && $video_info['codec_name'] == "h264" && strpos($video_info['codec_long_name'], 'MPEG-4') !== false && strpos($video_info['codec_long_name'], 'AVC') !== false) {
			if ($cut) {
				$cmd = $config['ffmpeg'].$add_cut." -i ".$src." -acodec copy ".$output."";	
				modproc($cmd);					
			} else {
				if (@copy($src,$output)) {
					echo "\n"."COPY ONLY: Output resolution/format is the same with the input resloution/format!\n\n";
				}
			}
		} else {
			if ($e[lq] && ($e['height'] > $video_info['height'] || $e['width'] > $video_info['width'])) {
				$scale ="";
				if ($e['height'] >= 480) {
					$e['label'] = 'HD';
				} else {
					$e['label'] = 'SD';
				}
			} else {
				$scale = "-vf scale=\"'if(gt(a,4/3),".$e['width'].",-1)':'if(gt(a,4/3),-1,".$e['height'].")'\"";
			}
			$output = $config['H264_DIR']."/".$vid."_".$e['label'].".".$e['format'];
			$cmd = $config['ffmpeg'].$add_cut." -i ".$src." -c:v libx264 -preset ".$e['preset']." -crf ".$e['crf']." ".$scale." ".$e['ios']." ".$faststart." ".$output."";	
			modproc($cmd);
		}
		if (file_exists($output) && filesize($output) > 100) {
			$sql = "UPDATE video SET formats = IF(formats IS NULL, '".$e['height'].".".$e['label'].".".$e['format']."', CONCAT(formats, ',".$e['height'].".".$e['label'].".".$e['format']."')) WHERE VID = '".(int)$vid."'";
			executeQuery($sql);
			echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";
			$sql = "UPDATE video SET lformats = IF(lformats IS NULL, '".$e['label']."', CONCAT(lformats, ', ".$e['label']."')) WHERE VID = '".(int)$vid."'";
			executeQuery($sql);
			echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";	
			$config['encode_height'] = $e['height'];

			
		} else {
			@chmod($output, 0777);
			@unlink($output);			
			$scale = scale($video_info['width'], $video_info['height'], $e['width'], $e['height']);
			echo "\n"."Retrying using fixed scale: ".$scale."\n";
			$cmd = $config['ffmpeg'].$add_cut." -i ".$src." -c:v libx264 -preset ".$e['preset']." -crf ".$e['crf']." ".$scale." ".$e['ios']." ".$faststart." -y ".$output."";
			modproc($cmd);
			if (file_exists($output) && filesize($output) > 100) {
				$sql = "UPDATE video SET formats = IF(formats IS NULL, '".$e['height'].".".$e['label'].".".$e['format']."', CONCAT(formats, ',".$e['height'].".".$e['label'].".".$e['format']."')) WHERE VID = '".(int)$vid."'";
				executeQuery($sql);
				$sql = "UPDATE video SET lformats = IF(lformats IS NULL, '".$e['label']."', CONCAT(lformats, ', ".$e['label']."')) WHERE VID = '".(int)$vid."'";
				executeQuery($sql);
				echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";	
				$config['encode_height'] = $e['height'];
			}
		}
	} else {
		echo "\n"."SKIP CONVERSION: Output resolution is higher than the input resloution!\n\n";
	}
}

function postConversion($vid,$src) {
	global $config;

	$nl = "=========================================================\n";
	
	$sql = "DELETE FROM conversion_queue_sp WHERE VID = '".$vid."' LIMIT 1";
	executeQuery($sql);
	echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";

	$sql  	     = "SELECT formats, active FROM video WHERE VID = '" .$vid. "' LIMIT 1";
	$rs 	     = selectQuery($sql);
    $formats     = explode(',', $rs['formats']);
    $status      = $rs['active'];	
	
	$hd          = 0;	
	if ($config['approve'] == '0' && $rs['formats']!='') {
		$active = 1;
	} else {
		$active = 0;
	}
	
	if ($status == '1') {
		$active = 1;
	}

	$sd_f        = explode('.', end($formats));
	$sd_vf       = $config['H264_DIR'].'/'.$vid."_".$sd_f[1].".".$sd_f[2];
	$sd_ffp_data = get_ffprobe_data($sd_vf);
	$sd_vi       = ffpInfo($sd_ffp_data);
	
	if (intval($sd_f[0]) > 480) {
		$hd = 1;
	}
	$sql = 	"UPDATE video SET 
			active = '".$active."', 
			width_sd = '".$sd_vi['width']."', 
			height_sd = '".$sd_vi['height']."', 
			aspect_sd = '".$sd_vi['display_aspect_ratio']."' 
			WHERE VID = '".(int)$vid."' LIMIT 1";
			
	if (count($formats)>1) {
		$hd_f    = explode('.', $formats[0]);
		$hd_vf = $config['H264_DIR'].'/'.$vid."_".$hd_f[1].".".$hd_f[2];
		$hd_ffp_data = get_ffprobe_data($hd_vf);
		$hd_vi = ffpInfo($hd_ffp_data);
		

		if (intval($hd_f[0]) > 480) {
			$hd = 1;
			$sql = 	"UPDATE video SET 
					active = '".$active."', 
					width_hd = '".$hd_vi['width']."', 
					height_hd = '".$hd_vi['height']."', 
					aspect_hd = '".$hd_vi['display_aspect_ratio']."', 
					width_sd = '".$sd_vi['width']."', 
					height_sd = '".$sd_vi['height']."', 
					aspect_sd = '".$sd_vi['display_aspect_ratio']."', 
					hd = '".$hd."' 
					WHERE VID = '".(int)$vid."' LIMIT 1";			
		}
	} else {
		if ($hd == 1) {
			$sql = 	"UPDATE video SET 
					active = '".$active."', 
					width_hd = '".$sd_vi['width']."', 
					height_hd = '".$sd_vi['height']."', 
					aspect_hd = '".$sd_vi['display_aspect_ratio']."', 
					width_sd = '".$sd_vi['width']."', 
					height_sd = '".$sd_vi['height']."', 
					aspect_sd = '".$sd_vi['display_aspect_ratio']."', 
					hd = '".$hd."' 
					WHERE VID = '".(int)$vid."' LIMIT 1";				
		}
	}
	
	executeQuery($sql);
	echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";
	
	if(file_exists($src.'.bak')) { 
		@rename($src.'.bak', $src);
	}		
		
	// Delete original video?
	if ($config['del_original_video'] == 1) {
		@chmod($src, 0777);
		@unlink($src);
	}

}

/*|*****************************************
|*| Function :: DB SELECTOR
|*|*****************************************
|*/ 
function executeQuery($query) {
	global $config;
	$link = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass']);
	if($link){	
		$dbs = mysqli_select_db($link, $config['db_name']);
		$result = mysqli_query($link, $query);
		if($result){
			$id = mysqli_insert_id($link);
		}
		$err = mysqli_error($link);
		mysqli_close($link);
	}else{
		$err = 'Could not connect to '.$dbs.': ' . mysqli_error($link);
	}
	$result = (intval($id) > 0) ? $id : $result;
	$result = ($err != "") ? "Sql Error :: ".$err."<br/>" : $result;
	return $result;
}
	
function selectQuery($query) {
	global $config;
	$link = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass']);
	if($link){	
		$dbs = mysqli_select_db($link, $config['db_name']);
		$result = mysqli_fetch_array(mysqli_query($link, $query), MYSQLI_BOTH);
		$err = mysqli_error($link);
		mysqli_close($link);
	} else {
		$err = 'Could not connect to '.$dbs.': ' . mysqli_close($link);
	}
	$result = ($err != "") ? "Sql Error :: ".$err."<br/>" : $result;
	return $result;
}	
?>
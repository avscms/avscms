<?php
define('_VALID', 1);
define('_ENTER', true);
define('_CLI', true);

// Argvs
$video_name = $_SERVER['argv'][1];
$vid = (int) $_SERVER['argv'][2];
$video_path = $_SERVER['argv'][3];

// Required
$basedir = dirname(dirname(__FILE__));
require $basedir. '/include/config.php';
require $basedir. '/include/function_video.php';
require $basedir. '/include/function_conversion_fp.php';


$vi = array();
$video_info = array();
$nl = "=========================================================\n";

echo "\n".$nl."Video Details:\n".$nl;
echo "\n".$nl."-----------------:\n".$nl;
echo "Parameters:\n";
echo "Video Name: $video_name\n";
echo "Vidoe ID: $vid\n";
echo "Video Path: $video_path\n\n";

// Error Checks
if (!preg_match("/^[0-9]{1,5}\.[a-z0-9]{2,4}$/i", $video_name)) {
	echo "Video Name: $video_name is invalid. Err #1. Exiting ..."; exit();
} else {
	$ffp_data = get_ffprobe_data($video_path);
	$video_info = ffpInfo($ffp_data);
}

$sql 						= "SELECT UID, title FROM video WHERE VID = '".intval($vid)."' LIMIT 1";
$rs							= $conn->execute($sql);
$video_info['UID'] 			= $rs->fields['UID'];
$video_info['title'] 		= $rs->fields['title'];
$video_info['video_name'] 	= $video_name;
$video_info['video_path'] 	= $video_path;

// Get Encoder
$encodings = getEncodings();
foreach($encodings as $encoding) {
	convert($encoding, $vid, $video_name, $video_info);
}
postThumbs($vid,$video_path);
postConversion($vid,$video_path);

// Display :: Encoder Core End
echo "\n<-- End of Script -->\n\n";
exit();
?>

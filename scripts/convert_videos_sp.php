<?php
define('_VALID', 1);
define('_ENTER', true);
define('_CLI', true);

// Argvs
$video_name = $_SERVER['argv'][1];
$vid = (int) $_SERVER['argv'][2];
$video_path = $_SERVER['argv'][3];
$skip = $_SERVER['argv'][4];

// Required
$basedir = dirname(dirname(__FILE__));
require $basedir. '/include/config.php';
require $basedir. '/include/function_video.php';
require $basedir. '/include/function_conversion_sp.php';
require $basedir. '/include/function_server.php';

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

// Get Encoder
$encodings = getEncodings();

foreach($encodings as $encoding) {
	convert($encoding, $vid, $video_name, $video_info, $skip);	
}

executeQuery("DELETE FROM conversion_queue_fp WHERE VID = '".$vid."' LIMIT 1");
executeQuery("DELETE FROM conversion_queue_sp WHERE VID = '".$vid."' LIMIT 1");

postConversion($vid, $video_path);

// Display :: Encoder Core End
echo "\n<-- End of Script -->\n\n";
exit();
?>

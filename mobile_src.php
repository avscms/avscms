<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';

$vid = intval($_GET['id']);

if (isset($vid)) {
    $sql    = "SELECT server, ipod_filename FROM video WHERE VID = " .$conn->qStr($vid). " AND active = '1' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
		$server		 = $rs->fields['server'];
		$mobile_filename = $rs->fields['ipod_filename'];
    }
}
if ($mobile_filename) {
	if ($config['multi_server'] == '1' && $server != '')
		$MOBILE_URL = $server.'/iphone/'.$mobile_filename;
	else
		$MOBILE_URL = $config['BASE_URL'].'/media/videos/iphone/'.$mobile_filename;
}
else {
	$MOBILE_URL = $config['BASE_URL'].'/media/videos/iphone/no-video.mp4';
}

VRedirect::go($MOBILE_URL);

die();
?>
<?php
define('_VALID', true);
include_once ('./config.php');
include_once('./editor_functions.php');
include_once ('./includes/common.php');
include_once ('./lang/'.$lang_include);
$arr = explode('/',$_GET['window']);
$length = count($arr);
$title = str_replace('.php', '', $arr[$length - 1]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $lang['titles'][$title]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css" type="text/css">
<style type="text/css">
body {
	padding: 0px 0px;
	margin: 0px 0px;
}
</style>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
</head>
<body>
<iframe src="<?php echo stripslashes($_GET['window'] . '?' . $_SERVER["QUERY_STRING"]); ?>" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
</body>
</html>

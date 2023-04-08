<?php
define('_VALID', true);
include_once ('./config.php');
include_once('./editor_functions.php');
include_once ('./includes/common.php');
include_once ('./lang/'.$lang_include);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo $lang['titles']['insert_bookmark']; ?></title>
<link rel="stylesheet" href="<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css" type="text/css">
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript">
<!--//
function initialize() {
	document.getElementById('name').focus();
}
function create_bookmark () {
	parentWindow.wp_create_bookmark(obj,document.getElementById('name').value)
	window.close();
	return false;
}
//-->
</script>
</head>
<body bgcolor="threedface" onLoad="initialize();hideLoadMessage();">
<?php include('./includes/load_message.php'); ?>
<div class="dialog_content" align="center"> 
	<form name="hyperlink_form" id="hyperlink_form" onSubmit="return create_bookmark();">
		<table border="0" cellspacing="0" cellpadding="2">
			<tr> 
				<td><?php echo $lang['bookmark_name']; ?><br> <input name="name" id="name" type="text" style="width: 286px" value="<?php echo stripslashes($_GET['bookmark']); ?>"> 
				</td>
			</tr>
		</table>
		<br>
		<div align="center"> 
			<button type="submit"><?php echo $lang['ok']; ?></button>
			&nbsp;&nbsp; 
			<button type="button" onClick="window.close();"><?php echo $lang['cancel']; ?></button>
		</div>
	</form>
</div>
</body>
</html>

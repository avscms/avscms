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
<title><?php echo $lang['titles']['insert_row']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css" type="text/css">
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript" language="JavaScript">
<!--//
function end() {
	if (document.getElementById('addabove').checked) {
		action="addabove"
	} else if (document.getElementById('addbelow').checked) {
		action="addbelow"
	}
	parentWindow.wp_processRow(obj, action);
	window.close();
	return false;
}
//-->
</script>
</head>
<body onLoad="hideLoadMessage();">
<?php include('./includes/load_message.php'); ?>
<div class="dialog_content" align="center"> 
	<form name="add_form" id="add_form" onSubmit="return end()">
		<fieldset>
		<legend><?php echo $lang['row_placement']; ?></legend>
		<table id="background" width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr> 
				<td><p> 
						<input id="addabove" type="radio" name="where" value="addabove" checked="checked">
						<?php echo $lang['above_selection']; ?></p>
					<p> 
						<input id="addbelow" type="radio" name="where" value="addbelow">
						<?php echo $lang['below_selection']; ?></p></td>
			</tr>
		</table>
		</fieldset>
		<br>
		<div align="center"> 
			<button type="submit" id="ok"><?php echo $lang['ok']; ?></button>
			&nbsp; 
			<button type="button" onClick="window.close();"><?php echo $lang['cancel']; ?></button>
		</div>
	</form>
</div>
</body>
</html>

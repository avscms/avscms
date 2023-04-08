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
<title><?php echo $lang['titles']['custom']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript" language="JavaScript">
<!--//
var CURRENT_HIGHLIGHT = null;
var current_index = null
var inserts = [];
function highlight(srcElement) {
	if (CURRENT_HIGHLIGHT) {
		CURRENT_HIGHLIGHT.style.backgroundColor='';
		CURRENT_HIGHLIGHT.style.color='#003399';
	}
	srcElement.style.backgroundColor = 'highlight';
	srcElement.style.color = 'highlighttext';
	CURRENT_HIGHLIGHT = srcElement;
}
function insert() {
	if (CURRENT_HIGHLIGHT != null) {
		var code = inserts[current_index]
		parentWindow.wp_insert_code(obj,code);
	}
	
	top.window.close();
	return false;
}
function preview (index) {
	if (wp_is_ie) {
		document.frames('preview').document.open();
		document.frames('preview').document.write(obj.baseURL + obj.styles + '<div id="code">'+inserts[index]+'</div>');
		document.frames('preview').document.close();
	} else {
		document.getElementById('preview').contentWindow.document.open();
		document.getElementById('preview').contentWindow.document.write(obj.baseURL + obj.styles + '<div id="code">'+inserts[index]+'</div>');
		document.getElementById('preview').contentWindow.document.close();
	}
	current_index = index
}
function initiate() {
	if (obj.custom_inserts != '') {
		var code = '';
		var num = obj.custom_inserts.length;
		for (var i=0; i < num; i++) {
			inserts[i] = obj.custom_inserts[i][1]
			code += '<a class="select" onclick="highlight(this);" href="javascript:preview('+i+')">'+ obj.custom_inserts[i][0] +'</a>'; 
		}
		document.getElementById('list').innerHTML = code;
	}
}
if (obj.styles == '') {
	obj.styles = parentWindow.wp_make_styles(obj)
}
// -->
</script>
<style type="text/css">
<!--
@import url(<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css);
.select {
	display:block;
	padding: 5px;
}
a.select:hover {
	display:block;
	padding: 5px;
	text-decoration: none;
	background-color: #eeeeee;
}
-->
</style>
</head>
<body onLoad="initiate();hideLoadMessage();">
<?php include('./includes/load_message.php'); ?>
<div><?php echo $lang['titles']['custom']; ?></div>
<form name="character_form" onSubmit="return insert();" style="display:inline">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="45%"><div class="inset" id="list" style="background-color:#ffffff; width:100%; height:322px; overflow:auto"></div></td>
    <td height="55%"><iframe id="preview" class="previewWindow" security="restricted" frameborder="0" width="100%" height="321" src="<?php echo WP_WEB_DIRECTORY; ?>blank.php?lang=<?php echo $lang_include; ?>"></iframe></td>
  </tr>
</table>
<div align="center"><br> 
	<input class="button" type="submit" value="<?php echo $lang['insert']; ?>">
	&nbsp;
	<input class="button" type="button" value="<?php echo $lang['cancel']; ?>" onClick="top.window.close();">
</div>
</form>
</body>
</html>
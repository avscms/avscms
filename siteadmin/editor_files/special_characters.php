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
<title><?php echo $lang['titles']['special_characters']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
@import url(<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css);
td {
	cursor: pointer; cursor: hand;
}
#characterspan {
	font-weight: bold;
	font-size: 13px;
}
#CharacterTable td {
	background-color: #ffffff;
}
-->
</style>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
var CURRENT_HIGHLIGHT = null;
function initiate() {
	var kids = document.getElementById('CharacterTable').getElementsByTagName('TD');
	for (var i=0; i < kids.length; i++) {
		kids[i].onmouseover = m_over;
		kids[i].onmouseout = m_out;
		kids[i].onclick = character;
	}
}
function m_over() {
	if (CURRENT_HIGHLIGHT == this) return
	this.style.backgroundColor = "highlight"
	this.style.color = "highlighttext"
}
function m_out() {
	if (CURRENT_HIGHLIGHT == this) return
	this.style.backgroundColor = "FFFFFF"
	this.style.color = "#000000"
}
function character() {
	this.style.backgroundColor = "highlight"
	document.getElementById('insert').value = this.title;
	document.getElementById('characterspan').innerHTML = document.getElementById('insert').value;
	if (CURRENT_HIGHLIGHT) {
			CURRENT_HIGHLIGHT.style.backgroundColor = "#FFFFFF";
			CURRENT_HIGHLIGHT.style.color = "#000000";
	}
	CURRENT_HIGHLIGHT = this
}
function man_character() {
	document.getElementById('characterspan').innerHTML = document.getElementById('insert').value;
	if (CURRENT_HIGHLIGHT) {
			CURRENT_HIGHLIGHT.style.backgroundColor = "#FFFFFF";
			CURRENT_HIGHLIGHT.style.color = "#000000";
	}
	CURRENT_HIGHLIGHT = null
}
function finish() {
	var code = document.getElementById('insert').value;
	parentWindow.wp_insert_code(obj,code);
	window.close();
	return false;
}
// -->
</script>
</head>
<body onLoad="initiate(); hideLoadMessage();">
<form name="foo" onSubmit="return finish()">
<?php include('./includes/load_message.php'); ?>
<div class="dialog_content" align="center"> 
	<table width="100%" border="0" cellpadding="0" cellspacing="4">
		<tr> 
			<td align="center" width="100%"><fieldset>
				<legend><?php echo $lang['special_characters2']; ?></legend>
				<?php echo $lang['insert2']; ?> 
				<input id="insert" name="insert" type="text" size="10" onChange="man_character()">
				&nbsp; <span id="characterspan"></span> &nbsp;&nbsp;&nbsp;&nbsp; 
				<br>
				<br>
				<table id="CharacterTable" border="0" cellspacing="1"  cellpadding="3" bgcolor="#000000" width="461">
					<tr> 
						<td width="25" title="&amp;iexcl;">&iexcl;</td>
						<td width="25" title="&amp;cent;">&cent;</td>
						<td width="25" title="&amp;pound;">&pound;</td>
						<td width="25" title="&amp;#8364;">&#8364;</td>
						<td width="25" title="&amp;yen;">&yen;</td>
						<td width="25" title="&amp;sect;">&sect;</td>
						<td width="25" title="&amp;uml;">&uml;</td>
						<td width="25" title="&amp;copy;">&copy;</td>
						<td width="25" title="&amp;laquo;">&laquo;</td>
						<td width="25" title="&amp;not;">&not;</td>
						<td width="25" title="&amp;reg;">&reg;</td>
						<td width="25" title="&amp;deg;">&deg;</td>
						<td width="25" title="&amp;plusmn;">&plusmn;</td>
						<td width="25" title="&amp;acute;">&acute;</td>
						<td width="25" title="&amp;micro;">&micro;</td>
						<td width="25" title="&amp;para;">&para;</td>
						<td width="25" title="&amp;middot;">&middot;</td>
					</tr>
					<tr> 
						<td width="25" title="&amp;cedil;">&cedil;</td>
						<td width="25" title="&amp;raquo;">&raquo;</td>
						<td width="25" title="&amp;iquest;">&iquest;</td>
						<td width="25" title="&amp;Agrave;">&Agrave;</td>
						<td width="25" title="&amp;Aacute;">&Aacute;</td>
						<td width="25" title="&amp;Acirc;">&Acirc;</td>
						<td width="25" title="&amp;Atilde;">&Atilde;</td>
						<td width="25" title="&amp;Auml;">&Auml;</td>
						<td width="25" title="&amp;Aring;">&Aring;</td>
						<td width="25" title="&amp;AElig;">&AElig;</td>
						<td width="25" title="&amp;Ccedil;">&Ccedil;</td>
						<td width="25" title="&amp;Egrave;">&Egrave;</td>
						<td width="25" title="&amp;Eacute;">&Eacute;</td>
						<td width="25" title="&amp;Ecirc;">&Ecirc;</td>
						<td width="25" title="&amp;Euml;">&Euml;</td>
						<td width="25" title="&amp;Igrave;">&Igrave;</td>
						<td width="25" title="&amp;Iacute;">&Iacute;</td>
					</tr>
					<tr> 
						<td width="25" title="&amp;Icirc;">&Icirc;</td>
						<td width="25" title="&amp;Iuml;">&Iuml;</td>
						<td width="25" title="&amp;Ntilde;">&Ntilde;</td>
						<td width="25" title="&amp;Ograve;">&Ograve;</td>
						<td width="25" title="&amp;Oacute;">&Oacute;</td>
						<td width="25" title="&amp;Ocirc;">&Ocirc;</td>
						<td width="25" title="&amp;Otilde;">&Otilde;</td>
						<td width="25" title="&amp;Ouml;">&Ouml;</td>
						<td width="25" title="&amp;Oslash;">&Oslash;</td>
						<td width="25" title="&amp;Ugrave;">&Ugrave;</td>
						<td width="25" title="&amp;Uacute;">&Uacute;</td>
						<td width="25" title="&amp;Ucirc;">&Ucirc;</td>
						<td width="25" title="&amp;Uuml;">&Uuml;</td>
						<td width="25" title="&amp;szlig;">&szlig;</td>
						<td width="25" title="&amp;agrave;">&agrave;</td>
						<td width="25" title="&amp;aacute;">&aacute;</td>
						<td width="25" title="&amp;acirc;">&acirc;</td>
					</tr>
					<tr> 
						<td width="25" title="&amp;atilde;">&atilde;</td>
						<td width="25" title="&amp;auml;">&auml;</td>
						<td width="25" title="&amp;aring;">&aring;</td>
						<td width="25" title="&amp;aelig;">&aelig;</td>
						<td width="25" title="&amp;ccedil;">&ccedil;</td>
						<td width="25" title="&amp;egrave;">&egrave;</td>
						<td width="25" title="&amp;eacute;">&eacute;</td>
						<td width="25" title="&amp;ecirc;">&ecirc;</td>
						<td width="25" title="&amp;euml;">&euml;</td>
						<td width="25" title="&amp;igrave;">&igrave;</td>
						<td width="25" title="&amp;iacute;">&iacute;</td>
						<td width="25" title="&amp;icirc;">&icirc;</td>
						<td width="25" title="&amp;iuml;">&iuml;</td>
						<td width="25" title="&amp;ntilde;">&ntilde;</td>
						<td width="25" title="&amp;ograve;">&ograve;</td>
						<td width="25" title="&amp;oacute;">&oacute;</td>
						<td width="25" title="&amp;ocirc;">&ocirc;</td>
					</tr>
					<tr> 
						<td width="25" title="&amp;otilde;">&otilde;</td>
						<td width="25" title="&amp;ouml;">&ouml;</td>
						<td width="25" title="&amp;divide;">&divide;</td>
						<td width="25" title="&amp;oslash;">&oslash;</td>
						<td width="25" title="&amp;ugrave;">&ugrave;</td>
						<td width="25" title="&amp;uacute;">&uacute;</td>
						<td width="25" title="&amp;ucirc;">&ucirc;</td>
						<td width="25" title="&amp;uuml;">&uuml;</td>
						<td width="25" title="&amp;yuml;">&yuml;</td>
						<td width="25" title="&amp;#8218;">&#8218;</td>
						<td width="25" title="&amp;#402;">&#402;</td>
						<td width="25" title="&amp;#8222;">&#8222;</td>
						<td width="25" title="&amp;#8230;">&#8230;</td>
						<td width="25" title="&amp;#8224;">&#8224;</td>
						<td width="25" title="&amp;#8225;">&#8225;</td>
						<td width="25" title="&amp;#710;">&#710;</td>
						<td style="font-size:9px" width="25" title="&amp;#8240;">&#8240;</td>
					</tr>
					<tr> 
						<td width="25" title="&amp;#8249;">&#8249;</td>
						<td width="25" title="&amp;#338;">&#338;</td>
						<td width="25" title="&amp;#8216;">&#8216;</td>
						<td width="25" title="&amp;#8217;">&#8217;</td>
						<td width="25" title="&amp;#8220;">&#8220;</td>
						<td width="25" title="&amp;#8221;">&#8221;</td>
						<td width="25" title="&amp;#8226;">&#8226;</td>
						<td width="25" title="&amp;#8211;">&#8211;</td>
						<td width="25" title="&amp;#8212;">&#8212;</td>
						<td width="25" title="&amp;#732;">&#732;</td>
						<td width="25" title="&amp;#8482;">&#8482;</td>
						<td width="25" title="&amp;#8250;">&#8250;</td>
						<td width="25" title="&amp;#339;">&#339;</td>
						<td width="25" title="&amp;#376;">&#376;</td>
						<td width="25" title="&amp;frac14;">&frac14;</td>
						<td width="25" title="&amp;frac12;">&frac12;</td>
						<td width="25" title="&amp;frac34;">&frac34;</td>
					</tr>
				</table>
				</fieldset>
				<br> <button type="submit" id="ok"><?php echo $lang['ok']; ?></button>
				&nbsp; <button type="button" onClick="window.close();"><?php echo $lang['cancel']; ?></button></td>
		</tr>
	</table>
</div></form>
</body>
</html>

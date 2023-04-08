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
<title><?php echo $lang['titles']['selcolor']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
@import url(<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css);
#tab_table {
	width: 286px;
	margin-top: 3px;
}
#tab_container {
	padding-top: 10px;
	border-left: 2px solid threedhighlight;
	border-right: 2px solid threeddarkshadow;
	border-bottom: 2px solid threeddarkshadow;
	height: 218px;
	width: 286px
}
-->
</style>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script language="JavaScript" type="text/javascript">
<!--//
var CURRENT_HIGHLIGHT = null
function initiate() {
	if (obj.color_swatches == '') {
		document.getElementById('web_color_container').style.display = 'block';
	} else {
		var color_swatches = obj.color_swatches
		var colors = color_swatches.split(',');
		var colorTable = '<table id="site_colortable" height="40" border="0" cellspacing="0" cellpadding="0" class="colortable">';
		var cellCount = 0
		for (var i=0; i < colors.length; i++) {
			if (cellCount == 0) {
				colorTable += '<tr>'
			}
			colorTable += '<td class="colorCell" bgcolor="'+colors[i]+'">&nbsp;&nbsp;&nbsp;</td>'
			if (cellCount == 18) {
				colorTable += '</tr>'
				cellCount = 0;
			} else {
				cellCount ++;
			}
		}
		if (cellCount != 0) {
			colorTable += '</tr>'
		}
		colorTable += '<tr><td height="14" class="colorCell" bgcolor="" colspan="19" align="center"><?php echo $lang['default']; ?></td></tr></table>';
		document.getElementById('site_color_container').innerHTML = colorTable ;
		document.getElementById('tbar1').className = 'tbuttonUpLeft';
		document.getElementById('tbar2').className = 'tbuttonRight';
		document.getElementById('site_color_container').style.display = 'block';
		document.getElementById('web_color_container').style.display = 'none';
	}
	kids = document.getElementsByTagName('TD');
	for (var i=0; i < kids.length; i++) {
		if (kids[i].className == "colorCell") {
			kids[i].onmouseover = m_over;
			kids[i].onmouseout = m_out;
			kids[i].onclick = m_click;
		}
	}
}
function m_click() {
	document.getElementById('selcolor').value = this.bgColor;
	document.getElementById('chosencolor').style.backgroundColor = this.bgColor;
	this.style.border = '1px solid #FFFFFF'
	if (CURRENT_HIGHLIGHT) {
		CURRENT_HIGHLIGHT.style.border = "1px solid #000000"
	}
	CURRENT_HIGHLIGHT = this
}
function m_over () {
	if (CURRENT_HIGHLIGHT == this) return
	document.getElementById('rgb').innerHTML = this.bgColor;
	document.getElementById('colordisplay').style.backgroundColor = this.bgColor;
	this.style.border = "1px dashed #FFFFFF";
}
function m_out() {
	if (CURRENT_HIGHLIGHT == this) return
	document.getElementById('rgb').innerText = " ";
	document.getElementById('colordisplay').bgcolor="threedface";
	this.style.border = "1px solid #000000"
}
function end() {
	parentWindow.wp_docolor(obj,'<?php echo stripslashes($_GET['action']); ?>',document.getElementById('selcolor').value)
	window.close();
	return false;
}
function on_enter_site() {
	if (document.getElementById('tbar1').className == 'noTab') {
		return
	}
	document.getElementById('tbar1').className = 'tbuttonUpLeft';
	document.getElementById('tbar2').className = 'tbuttonRight';
	document.getElementById('site_color_container').style.display = 'block';
	document.getElementById('web_color_container').style.display = 'none';
}
function on_enter_web() {
	if (document.getElementById('tbar2').className == 'noTab') {
		return
	}
	document.getElementById('tbar1').className = 'tbuttonLeft';
	document.getElementById('tbar2').className = 'tbuttonUpRight';
	document.getElementById('site_color_container').style.display = 'none';
	document.getElementById('web_color_container').style.display = 'block';
}

// -->
</script>
</head>
<body onLoad="initiate();document.getElementById('selcolor').focus(); hideLoadMessage();">
<form name="foo" onSubmit="return end()">
<?php include('./includes/load_message.php'); ?>
<div class="dialog_content" align="center"> 
	<table width="205" border="0" cellspacing="0" cellpadding="1">
		<tr> 
			<td width="55" valign="top"> <div class="selcolordisplay" style="height: 40px" id="colordisplay">&nbsp;</div></td>
			<td align="center" width="84"> <p><span id="rgb">&nbsp;</span></p></td>
			<td align="right" width="55"> <div class="selcolordisplay" style="height: 20px" id="chosencolor">&nbsp;</div>
				<input type="text" style="width:60px" id="selcolor" name="selcolor" onChange="document.getElementById('chosencolor').style.backgroundColor = this.value"> </td>
		</tr>
	</table>
	<table id="tab_table" border="0" cellspacing="0" cellpadding="2">
		<tr> 
			<td id="tbar1" class="noTab" align="center" onClick="on_enter_site()"><nobr>&nbsp; 
				<?php echo $lang['site_colors']; ?> &nbsp;</nobr></td>
			<td id="tbar2" class="noTab" align="center" onClick="on_enter_web()"><nobr>&nbsp; 
				<?php echo $lang['web_colors']; ?> &nbsp;</nobr></td>
			<td id="tbar3" width="100%" class="noTab" align="center">&nbsp;</td>
		</tr>
	</table>
	<div id="tab_container"> 
		<div id="site_color_container" style="display:none"> 
			<!-- Your custom color swatches will be generated here -->
		</div>
		<div id="web_color_container" style="display:none"> 
			<table id="web_colortable" width="100%" border="0" cellspacing="0" cellpadding="0" class="colortable">
				<tr> 
					<td class="colorCell" bgcolor="#000000">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#000000">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#003300">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#006600">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#009900">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00cc00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00ff00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#330000">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#333300">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#336600">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#339900">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33cc00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33ff00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#660000">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#663300">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#666600">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#669900">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66cc00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66ff00">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#333333">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#000033">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#003333">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#006633">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#009933">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00cc33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00ff33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#330033">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#333333">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#336633">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#339933">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33cc33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33ff33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#660033">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#663333">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#666633">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#669933">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66cc33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66ff33">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#666666">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#000066">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#003366">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#006666">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#009966">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00cc66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00ff66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#330066">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#333366">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#336666">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#339966">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33cc66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33ff66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#660066">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#663366">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#666666">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#669966">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66cc66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66ff66">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#999999">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#000099">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#003399">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#006699">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#009999">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00cc99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00ff99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#330099">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#333399">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#336699">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#339999">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33cc99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33ff99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#660099">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#663399">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#666699">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#669999">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66cc99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66ff99">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#cccccc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#0000cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#0033cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#0066cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#0099cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00cccc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00ffcc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#3300cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#3333cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#3366cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#3399cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33cccc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33ffcc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#6600cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#6633cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#6666cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#6699cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66cccc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66ffcc">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#ffffff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#0000ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#0033ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#0066ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#0099ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00ccff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#00ffff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#3300ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#3333ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#3366ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#3399ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33ccff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#33ffff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#6600ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#6633ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#6666ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#6699ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66ccff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#66ffff">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#ff0000">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#990000">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#993300">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#996600">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#999900">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99cc00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99ff00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc0000">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc3300">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc6600">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc9900">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cccc00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ccff00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff0000">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff3300">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff6600">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff9900">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffcc00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffff00">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#00ff00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#990033">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#993333">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#996633">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#999933">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99cc33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99ff33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc0033">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc3333">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc6633">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc9933">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cccc33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#CCFF33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff0033">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff3333">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff6633">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff9933">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffcc33">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffff33">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#0000ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#990066">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#993366">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#996666">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#999966">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99cc66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99ff66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc0066">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc3366">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc6666">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc9966">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cccc66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ccff66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff0066">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff3366">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff6666">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff9966">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffcc66">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffff66">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#ffff00">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#990099">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#993399">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#996699">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#999999">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99cc99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99ff99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc0099">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc3399">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc6699">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc9999">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cccc99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ccff99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff0099">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff3399">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff6699">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff9999">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffcc99">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffff99">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#00ffff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#9900cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#9933cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#9966cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#9999cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99cccc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99ffcc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc00cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc33cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc66cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc99cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cccccc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ccffcc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff00cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff33cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff66cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff99cc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffcccc">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffffcc">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="#ff00ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#9900ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#9933ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#9966ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#9999ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99ccff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#99ffff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc00ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc33ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc66ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#cc99ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ccccff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ccffff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff00ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff33ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff66ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ff99ff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffccff">&nbsp;&nbsp;&nbsp;</td>
					<td class="colorCell" bgcolor="#ffffff">&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr> 
					<td class="colorCell" bgcolor="" colspan="19" align="center"><?php echo $lang['default']; ?></td>
				</tr>
			</table>
		</div>
	</div>
	<br>
	<button id="ok" type="submit"><?php echo $lang['ok']; ?></button>
	&nbsp; 
	<button type="button" onClick="window.close();"><?php echo $lang['cancel']; ?></button>
</div></form>
</body>
</html>

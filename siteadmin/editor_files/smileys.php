<?php
/*
EMOTICON COPYRIGHT NOTICE:  The animated emoticons provided with WysiwygPro are included under an agreement with the copyright holder, Bruce Corkhill and WebWizGuide.com.  
Purchasing a WysiwygPro license allows you to use the animated emoticons ONLY as part of the WysiwygPro editor component. 
Emoticons may not be used, copied or redistributed outside of the WysiwygPro product, without explicit permission from Bruce Corkhill.
*/
define('_VALID', true);
include_once ('./config.php');
include_once('./editor_functions.php');
include_once ('./includes/common.php');
include_once ('./lang/'.$lang_include);
$load_from_dir = false;
if (defined('SMILEY_FILE_DIRECTORY') && defined('SMILEY_WEB_DIRECTORY')) {
	if (SMILEY_FILE_DIRECTORY && SMILEY_WEB_DIRECTORY) {
		$load_from_dir = true;
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $lang['titles']['smileys']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
@import url(<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css);
.text {
	 cursor: pointer; 
	 cursor: hand;
}
.st td.text {
	 background-color: #ffffff;	 
}
-->
</style>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script language="JavaScript" type="text/javascript">
<!-- //
var smiley = null;
function initiate() {
	document.getElementById('ok').blur();
	var kids = document.getElementsByTagName('TD');
	for (var i=0; i < kids.length; i++) {
		if (kids[i].className == "text") {
			kids[i].onmouseover = m_over;
			kids[i].onmouseout = m_out;
			kids[i].onclick = AddSmileyIcon;
		}
	}
}
function m_over() {
	if (smiley == this) return
	this.style.backgroundColor = "highlight"
	this.style.color = "highlighttext"
}
function m_out() {
	if (smiley == this) return
	this.style.backgroundColor = ""
	this.style.color = "black"
}
//Function to add smiley
function AddSmileyIcon(){
	this.style.backgroundColor = "highlight"
	this.style.color = "highlighttext"
	if (smiley) {
			smiley.style.backgroundColor = "";
			smiley.style.color = "black"
	}
	smiley = this

}
function insert() {
	if (smiley != null) {
		var images = smiley.getElementsByTagName('IMG');
		imagePath = images[0].getAttribute("SRC",2)
		parentWindow.wp_create_image_html(obj,imagePath, '17', '17', '', '', '', '');
	}
	window.close();
	return false;
}
// -->
</script>
</head>
<body onLoad="initiate(); hideLoadMessage();">
<form name="foo" onSubmit="return insert();">
<?php include('./includes/load_message.php'); ?>
<fieldset>
<legend><?php echo $lang['emoticon_smilies']; ?></legend>
<?php if ($load_from_dir) {
	echo '<div class="inset" style="height:211px; overflow:auto; background-color:#FFFFFF">
<table class="st" width="100%" border="0" cellpadding="4" cellspacing="1" align="center" bgcolor="#000000">';
	if (!file_exists (SMILEY_FILE_DIRECTORY)) {
		exit('<b>Warning: this directory does not exist: '.SMILEY_FILE_DIRECTORY.'. Check that you have set SMILEY_FILE_DIRECTORY correctly in config.php.</b>');
	}
	$file_directory = SMILEY_FILE_DIRECTORY;
	$web_directory = SMILEY_WEB_DIRECTORY;
	
	$handle=opendir($file_directory); 	
	$colCount = 0;
	$count = 0;
	while (false!==($filename = readdir($handle))) {
		if ((is_file($file_directory.$filename)) && ($filename != "." && $filename != "..") && wp_extension_ok(strrchr(strtolower($filename),'.'), '.png,.gif') ) { 
			list ($width, $height) = @getimagesize($file_directory.$filename);
			if ($width<=24 && $height<=24) {
				if ($colCount == 0) {
					echo '<tr>';
				}
				echo '<td class="text" align="center"><img src="'.$web_directory.$filename.'" width="'.$width.'" height="'.$height.'" border="0" align="absmiddle" alt=""></td>';
				if ($colCount == 3) {
					echo '</tr>';
				}
				$count ++;
				if ($colCount<3) {
					$colCount++;
				} else {
					$colCount=0;
				}
			}
		}     
	} 
	if ($count ==0) {
	 echo '<tr><td>'.$lang['no_files'].'</td></tr>';
	} else if ($colCount !=4) {
		while ($colCount !=4) {
			$colCount++;
			echo '<td style="background-color:#ffffff">&nbsp;</td>';
		}
		echo '</tr>';
	}
	closedir($handle); 
	echo '</table></div>';
} else { ?>
<div style="padding: 1px 0px 1px 0px">
<table width="100%" border="0" cellpadding="4" cellspacing="1" align="center">
	<tr> 
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley1.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['smile']; ?></td>
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley9.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['embarrassed']; ?></td>
	</tr>
	<tr> 
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley2.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['wink']; ?></td>
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley10.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['star']; ?></td>
	</tr>
	<tr> 
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley3.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['shocked']; ?></td>
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley11.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['dead']; ?></td>
	</tr>
	<tr> 
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley4.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['big_smile']; ?></td>
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley12.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['sleepy']; ?></td>
	</tr>
	<tr> 
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley5.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['confused']; ?></td>
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley13.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['disapprove']; ?></td>
	</tr>
	<tr> 
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley6.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['unhappy']; ?></td>
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley14.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['approve']; ?></td>
	</tr>
	<tr> 
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley7.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['angry']; ?></td>
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley15.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['evil_smile']; ?></td>
	</tr>
	<tr> 
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley8.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['clown']; ?></td>
		<td width="50%" class="text"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/smileys/smiley16.gif" width="17" height="17" border="0" align="absmiddle" alt=""> 
			<?php echo $lang['cool']; ?></td>
	</tr>
<?php } ?>
</table></div>
</fieldset>
<br>
<div align="center"> 
	<button type="submit" id="ok"><?php echo $lang['ok']; ?></button>
	&nbsp; 
	<button type="button" onClick="window.close();"><?php echo $lang['cancel']; ?></button>
</div></form>
</body>
</html>

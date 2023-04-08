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
<title><?php echo $lang['titles']['hyperlink']; ?></title>
<style type="text/css">
<!--
@import url(<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css);
p {
	margin:2px
}
.tbuttonUp {
	width: 88px;
	height: 68px;
	padding: 2px;
	border: 1px solid threedface;
	background-color: threedface;
	cursor: default;
	text-align:center;
	display: block;
}
.tbuttonDown {
	width: 88px;
	height: 68px;
	padding: 2px;
	border-top: 1px solid buttonshadow;
	border-left: 1px solid buttonshadow;
	border-bottom: 1px solid buttonhighlight;
	border-right: 1px solid buttonhighlight;
	background-color: #f7f7f7;
	cursor: default;
	text-align:center;
	display: block;
}
.tbuttonOver {
	width: 88px;
	height: 68px;
	padding: 2px;
	border-bottom: 1px solid buttonshadow;
	border-right: 1px solid buttonshadow;
	border-top: 1px solid buttonhighlight;
	border-left: 1px solid buttonhighlight;
	background-color: threedface;
	cursor: default;
	text-align:center;
	display: block;
}
#outlookbar {
	height:301; 
	border-top:1px solid threedshadow; 
	border-bottom: 1px solid threedhighlight; 
	border-left: 1px solid threedshadow; 
	border-right: 1px solid threedhighlight
}
-->
</style>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript">
<!--//
var CURRENT_HIGHLIGHT
function highlight(srcElement) {
	if (CURRENT_HIGHLIGHT) {
		CURRENT_HIGHLIGHT.style.backgroundColor='#ffffff';
		CURRENT_HIGHLIGHT.style.color ='#003399';
	}
	document.getElementById(srcElement).style.backgroundColor='highlight';
	document.getElementById(srcElement).style.color = 'highlighttext';
	CURRENT_HIGHLIGHT = document.getElementById(srcElement);
}
function initialize() {
	kids = document.getElementById('outlookbar').getElementsByTagName('div');
	for (var i=0; i < kids.length; i++) {
		if (kids[i].className == "tbuttonUp") {
			kids[i].onmouseover = m_over;
			kids[i].onmouseout = m_out;
			kids[i].onmousedown = m_down;
			kids[i].onclick = m_click;
		}
	}
	// show links
	if (obj.links != '') {
		var links = obj.links
		var depth = '';
		var indent = '';
		var str = '';
		var num = links.length;
		for (var i=0; i<num; i++) { 
			if (links[i][1] && links[i][2]) {
				if (links[i][0] >= 1) {
					depth = (links[i][0]-1)*23;
					indent = "<img src=\"" + parentWindow.wp_directory + "images/branch.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\">";
				} else {
					depth = 0;
					indent = '';
				}
				if (links[i][1] == 'folder') {
					str += "<nobr><p class=\"filelink\" style=\"height:22px;margin:2px 2px 2px "+(depth+2)+"px\">" + indent + "<img src=\"" + parentWindow.wp_directory + "images/folder.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\">" + (links[i][2].replace(/' '/gi, '&nbsp;')) + " </p></nobr>";
				} else {
					str += "<p><nobr><a class=\"filelink\" id=\"" + (links[i][1].replace(/"/gi, '&quote;')) + "\" style=\"height:22px; margin:0px 0px 0px " + depth + "px;\" href=\"javascript:highlight(\'" + (links[i][1].replace(/'/gi, "\'")) + "\');localLink(\'" + (links[i][1].replace(/'/gi, "\'")) + "\');\" title=\"URL: " + (links[i][1].replace(/"/gi, '&quote;')) + "\">" + indent + "<img src=\"" + parentWindow.wp_directory + "images/htm_icon.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\">" + (links[i][2].replace(/ /gi, '&nbsp;')) + " </a></nobr></p>";
				}
			}	
		}
		document.getElementById('links').innerHTML = str;
	}
	// show anchors
	var anchors = obj.edit_object.document.getElementsByTagName('IMG');
	var anchorLinks = '<p><a class="filelink" id="#" style="height:22px; margin:0px 0px 0px 0px;" href="javascript:highlight(\'#\');localLink(\'#\');" title="URL: #"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/spacer.gif" width="1" height="22" alt="" border="0" align="absmiddle"><?php echo $lang['top_of_document']; ?></a></p>\n';
	var l=anchors.length
	anchorLinks+='<p><b><img src="<?php echo WP_WEB_DIRECTORY; ?>images/spacer.gif" width="1" height="22" alt="" border="0" align="absmiddle"><?php echo $lang['bookmarks']; ?></b></p>';
	for (var i=0; i < l; i++) {
		if ((anchors[i].getAttribute('name')) && (anchors[i].src.search(parentWindow.wp_directory+"/images/bookmark_symbol.gif") != -1)) {
			var name = anchors[i].getAttribute('name')
			var nameSlashed = name.replace(/'/, "\\'")
			anchorLinks += '<p><a class="filelink" id="#'+name+'" style="height:22px; margin:0px 0px 0px 0px;" href="javascript:highlight(\'#'+nameSlashed+'\');localLink(\'#'+nameSlashed+'\');" title="URL: #'+name+'"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/bookmark.gif" width="22" height="22" alt="" border="0" align="absmiddle">'+name+'</a></p>\n'
		}
	}
	if (obj.showbookmarkmngr == true) {
		document.getElementById('page_button').style.display='block';
	}
	if (obj.links != '') {
		document.getElementById('site_button').style.display='block';
	}
	document.getElementById('anchors').innerHTML = anchorLinks;
	var current_href = parentWindow.wp_current_hyperlink;
	if ((current_href!="") && (current_href!=null)) {
		if (document.getElementById(current_href)) {
			document.getElementById(current_href).style.backgroundColor='highlight';
			document.getElementById(current_href).style.color = 'highlighttext';
			CURRENT_HIGHLIGHT = document.getElementById(current_href);
			if ((current_href.substring(0,1) == "#") && (obj.showbookmarkmngr == true)) {
				document.getElementById('page_address').value = current_href;
				document.getElementById('page_title').value = "<?php echo stripslashes($_GET['title']); ?>";
				showAnchors();
			} else {
				document.getElementById('site_target').value = "<?php echo stripslashes($_GET['target']); ?>"
				document.getElementById('site_target_list').value = "<?php echo stripslashes($_GET['target']); ?>"
				document.getElementById('site_title').value = "<?php echo stripslashes($_GET['title']); ?>"
				document.getElementById('site_address').value = current_href;
				showLinks();
				localLink(current_href);
			}
			document.getElementById(current_href).focus();
		} else if (current_href.substring(0,7) == "mailto:") {
			var email_array = current_href.split('?subject=');
			document.getElementById('email_address').value = email_array[0];
			if (email_array[1]) {
				document.getElementById('email_subject').value = email_array[1];
			}
			document.getElementById('email_title').value = "<?php echo stripslashes($_GET['title']); ?>"
			showEmail();
		} else {
			document.getElementById('web_target').value = "<?php echo stripslashes($_GET['target']); ?>"
			document.getElementById('web_target_list').value = "<?php echo stripslashes($_GET['target']); ?>"
			document.getElementById('web_address').value = current_href;
			document.getElementById('web_title').value = "<?php echo stripslashes($_GET['title']); ?>"
			showWeb();
		}	
	} else if (obj.links != '') {
		showLinks();
	} else {
		showWeb();
	}
}
function m_over () {
	if (this.className!='tbuttonDown') {
		this.className = 'tbuttonOver';
	}
}
function m_out() {
	if (this.className!='tbuttonDown') {
		this.className = 'tbuttonUp';
	}
}
function m_down() {
	if (this.className!='tbuttonDown') {
		this.className = 'tbuttonDown';
	}
}
function m_click() {
	kids = document.getElementById('outlookbar').getElementsByTagName('div');
	for (var i=0; i < kids.length; i++) {
		if (kids[i].className == "tbuttonDown") {
			if (kids[i] != this) {
				kids[i].className = "tbuttonUp";
			}
		}
	}
	if (this.id=='site_button') {
		showLinks();
	} else if (this.id=='page_button') {
		showAnchors();
	} else if (this.id=='email_button') {
		showEmail();
	} else if (this.id=='web_button') {
		showWeb();
	}
}
function linkit() {
	var address = '';
	var target = '';
	var title = '';
	if (document.getElementById('placeonthissite').style.display == 'block') {
		address = document.getElementById('site_address').value;
		target = document.getElementById('site_target').value;
		title = document.getElementById('site_title').value;
	} else if (document.getElementById('placeonthispage').style.display == 'block') {
		address = document.getElementById('page_address').value;
		title = document.getElementById('page_title').value;	
	} else if (document.getElementById('email').style.display == 'block') {
		if (document.getElementById('email_address').value.substring(0,7) == "mailto:") {
			address = document.getElementById('email_address').value
		} else {
			address = 'mailto:' + document.getElementById('email_address').value
		}
		if (document.getElementById('email_subject').value != '') {
			address = address + '?subject=' + document.getElementById('email_subject').value;
		}
		title = document.getElementById('email_title').value;
	} else if (document.getElementById('external').style.display == 'block') {
		address = document.getElementById('web_address').value;
		target = document.getElementById('web_target').value;
		title = document.getElementById('web_title').value;
	} else {
		window.close();
		return false;
	}
	parentWindow.wp_hyperlink(obj,address,target,title);
	top.window.close();
	return false;
}
function localLink(page) {
	if (document.getElementById('placeonthissite').style.display == 'block') {
		document.getElementById('site_address').value=page;
	} else if (document.getElementById('placeonthispage').style.display == 'block') {
		document.getElementById('page_address').value=page;
	}
	preview(page)
}
function preview(url) {
	if (document.getElementById('placeonthissite').style.display == 'block') {
		var previewPane = 'site_preview';
	} else if (document.getElementById('external').style.display == 'block') {
		var previewPane = 'web_preview';
	} else {
		return true;
	}
	if (url == "") {
		nopreview = true;
	} else if (url.substring(0,1) == "#") {
		nopreview = true;
	} else if (url.substring(0,5) == "file:") {
		nopreview = true;
	} else if (url.substring(0,4) == "ftp:") {
		nopreview = true;
	} else if (url.substring(0,7) == "gopher:") {
		nopreview = true;
	} else if (url.substring(0,7) == "mailto:") {
		nopreview = true;
	} else if (url.substring(0,5) == "news:") {
		nopreview = true;
	} else if (url.substring(0,5) == "wais:") {
		nopreview = true;
	} else if (url.substring(0,5) == "http:") {
		nopreview = false;
	} else if (url.substring(0,6) == "https:") {
		nopreview = false;
	} else {
		nopreview = false;
	} 
	url = make_url_with_base (url);
	if (nopreview) {
		if (wp_is_ie) {
			document.frames(previewPane).location.replace('<?php echo WP_WEB_DIRECTORY; ?>no_preview.php?lang=<?php echo $lang_include; ?>');
		} else {
			document.getElementById(previewPane).contentWindow.location.replace('<?php echo WP_WEB_DIRECTORY; ?>no_preview.php?lang=<?php echo $lang_include; ?>');
		}
	} else if (wp_is_ie) {
		document.frames(previewPane).location.replace(url);
	} else {
		document.getElementById(previewPane).contentWindow.location.replace(url);
	}
}
function showLinks() {
	document.getElementById('site_button').className = 'tbuttonDown';
	document.getElementById('placeonthissite').style.display = 'block';
	document.getElementById('placeonthispage').style.display = 'none';
	document.getElementById('email').style.display = 'none';
	document.getElementById('external').style.display = 'none';
}
function showAnchors() {
	document.getElementById('page_button').className = 'tbuttonDown';
	document.getElementById('placeonthissite').style.display = 'none';
	document.getElementById('placeonthispage').style.display = 'block';
	document.getElementById('email').style.display = 'none';
	document.getElementById('external').style.display = 'none';
}
function showEmail() {
	document.getElementById('email_button').className = 'tbuttonDown';
	document.getElementById('placeonthissite').style.display = 'none';
	document.getElementById('placeonthispage').style.display = 'none';
	document.getElementById('email').style.display = 'block';
	document.getElementById('external').style.display = 'none';
}
function showWeb() {
	document.getElementById('web_button').className = 'tbuttonDown';
	document.getElementById('placeonthissite').style.display = 'none';
	document.getElementById('placeonthispage').style.display = 'none';
	document.getElementById('email').style.display = 'none';
	document.getElementById('external').style.display = 'block';
}
//-->
</script>
</head>
<body scroll="no" onLoad="initialize(); hideLoadMessage();">
<?php include('./includes/load_message.php'); ?>
<form name="form1" id="form1" onSubmit="return linkit();">
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
		<tr> 
			<td valign="top" width="90" align="center"><p><?php echo $lang['link_to']; ?></p>
				<div id="outlookbar"> 
					<div class="tbuttonUp" id="site_button" style="display:none"> 
						<p><img src="<?php echo WP_WEB_DIRECTORY; ?>images/spacer.gif" width="1" height="3" alt=""><br>
							<img src="<?php echo WP_WEB_DIRECTORY; ?>images/file_on_this_site.gif" width="22" height="23" alt=""></p>
						<p><?php echo $lang['place_on_website']; ?></p>
					</div>
					<div class="tbuttonUp" id="page_button" style="display:none"> 
						<p><img src="<?php echo WP_WEB_DIRECTORY; ?>images/spacer.gif" width="1" height="3" alt=""><br>
							<img src="<?php echo WP_WEB_DIRECTORY; ?>images/place_on_this_page.gif" width="22" height="23" alt=""></p>
						<p><?php echo $lang['place_in_document']; ?></p>
					</div>
					<div class="tbuttonUp" id="email_button" style="display:block"> 
						<p><img src="<?php echo WP_WEB_DIRECTORY; ?>images/spacer.gif" width="1" height="3" alt=""><br>
							<img src="<?php echo WP_WEB_DIRECTORY; ?>images/email_address.gif" width="22" height="23" alt=""></p>
						<p><?php echo $lang['email_address']; ?></p>
					</div>
					<div class="tbuttonUp" id="web_button" style="display:block"> 
						<p><img src="<?php echo WP_WEB_DIRECTORY; ?>images/spacer.gif" width="1" height="3" alt=""><br>
							<img src="<?php echo WP_WEB_DIRECTORY; ?>images/external_link.gif" width="22" height="23" alt=""></p>
						<p><?php echo $lang['web_location']; ?></p>
					</div>
				</div></td>
			<td><div id="placeonthissite" style="display:none"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="4">
						<tr> 
							<td> <div id="links" style="width:250px; height:223px; background-color:#FFFFFF; border: 2px inset threedface; overflow:auto; padding:5px 5px"> 
									<!-- a list of links to pages on your site should be generated below: -->
								</div></td>
							<td> <iframe id="site_preview" class="previewWindow" security="restricted" frameborder="0" width="250" height="221" src="<?php echo WP_WEB_DIRECTORY; ?>blank.php?lang=<?php echo $lang_include; ?>"></iframe> 
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellspacing="3" cellpadding="1">
						<tr> 
							<td><?php echo $lang['address']; ?></td>
							<td><input type="text" size="50" name="site_address" id="site_address" value="" onChange="preview(this.value)" title="Example: /folder/document.html"></td>
						</tr>
						<tr> 
							<td width="60"><?php echo $lang['title']; ?></td>
							<td> <input type="text" size="50" name="site_title" id="site_title" value="" title="Creates a pop-up message like what you are reading now."> 
							</td>
						</tr>
						<tr> 
							<td width="60"><?php echo $lang['window']; ?></td>
							<td> <select name="site_target_list" id="site_target_list" onChange="document.getElementById('site_target').value=this.options[this.selectedIndex].value">
									<option value="" selected="selected"><?php echo $lang['default']; ?></option>
									<option value="_self"><?php echo $lang['same_window']; ?></option>
									<option value="_blank"><?php echo $lang['new_window']; ?></option>
									<option value="_parent"><?php echo $lang['parent_window']; ?></option>
									<option value="_top"><?php echo $lang['top_window']; ?></option>
								</select> <input type="text" size="23" name="site_target" id="site_target" value=""></td>
						</tr>
					</table>
				</div>
				<div id="placeonthispage" style="display:none"> 
					<table width="100%" border="0" cellspacing="0" cellpadding="4">
						<tr> 
							<td> <div id="anchors" style="width:500px; height:250px; background-color:#FFFFFF; border: 2px inset threedface; overflow:auto; padding:5px 5px"> 
									<!-- a list of bookmarks in this page will be generated below: -->
								</div></td>
						</tr>
					</table>
					<table width="100%" border="0" cellspacing="3" cellpadding="1">
						<tr> 
							<td><?php echo $lang['address']; ?></td>
							<td><input type="text" size="50" name="page_address" id="page_address" value="" onChange="preview(this.value)" title="<?php echo $lang['example']; ?> #bookmarkName"></td>
						</tr>
						<tr> 
							<td width="60"><?php echo $lang['title']; ?></td>
							<td> <input type="text" size="50" name="page_title" id="page_title" value="" title="<?php echo $lang['creates_popup_message']; ?>"> 
							</td>
						</tr>
					</table>
				</div>
				<div id="email" style="display:none"> 
					<table width="100%" border="0" cellspacing="3" cellpadding="1">
						<tr> 
							<td width="100"><?php echo $lang['email_address2']; ?></td>
							<td><input type="text" size="50" name="email_address" id="email_address" value="" onChange="preview(this.value)" title="<?php echo $lang['example']; ?> me@mycompany.com"></td>
						</tr>
						<tr> 
							<td width="100"><?php echo $lang['subject']; ?></td>
							<td><input type="text" size="50" name="email_subject" id="email_subject" value="" title="<?php echo $lang['type_a_subject']; ?>"></td>
						</tr>
						<tr> 
							<td width="100"><?php echo $lang['title']; ?></td>
							<td> <input type="text" size="50" name="email_title" id="email_title" value="" title="<?php echo $lang['creates_popup_message']; ?>"> 
							</td>
						</tr>
					</table>
				</div>
				<div id="external" style="display:none"> 
					<iframe id="web_preview" class="previewWindow" security="restricted" frameborder="0" width="500" height="228" src="<?php echo WP_WEB_DIRECTORY; ?>blank.php?lang=<?php echo $lang_include; ?>"></iframe>
					<table width="100%" border="0" cellspacing="3" cellpadding="1">
						<tr> 
							<td><?php echo $lang['address']; ?></td>
							<td><input type="text" size="50" name="web_address" id="web_address" value="" title="<?php echo $lang['example']; ?> http://www.website.com/about/index.html"><button class="chooseImage" type="button" onClick="preview(document.getElementById('web_address').value)" title="<?php echo $lang['preview']; ?>"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/view.gif" width="16" height="16" align="absmiddle" title="<?php echo $lang['preview']; ?>" alt="<?php echo $lang['preview']; ?>"></button>
						</tr>
						<tr> 
							<td width="60"><?php echo $lang['title']; ?></td>
							<td> <input type="text" size="50" name="web_title" id="web_title" value="" title="<?php echo $lang['creates_popup_message']; ?>"> 
							</td>
						</tr>
						<tr> 
							<td width="60"><?php echo $lang['window']; ?></td>
							<td> <select name="web_target_list" id="web_target_list" onChange="document.getElementById('web_target').value=this.options[this.selectedIndex].value">
									<option value="" selected="selected"><?php echo $lang['default']; ?></option>
									<option value="_self"><?php echo $lang['same_window']; ?></option>
									<option value="_blank"><?php echo $lang['new_window']; ?></option>
									<option value="_parent"><?php echo $lang['parent_window']; ?></option>
									<option value="_top"><?php echo $lang['top_window']; ?></option>
								</select> <input type="text" size="23" name="web_target" id="web_target" value=""></td>
						</tr>
					</table>
				</div></td>
		</tr>
	</table>
	<br>
	<div align="center"> 
		<button type="submit"><?php echo $lang['ok']; ?></button>
		&nbsp;&nbsp; 
		<button type="button" onClick="top.window.close();"><?php echo $lang['cancel']; ?></button>
	</div>
</form>
</body>
</html>

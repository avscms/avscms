<?php
define('_VALID', true);
include_once ('./config.php');
include_once('./editor_functions.php');
include_once ('./includes/common.php');
include_once ('./lang/'.$lang_include);
if (isset ($_REQUEST['return_function'])) {
	if (wp_return_function_ok($_REQUEST['return_function'])) {
		$return_function = $_REQUEST['return_function'];
	} else {
		$return_function = '';
	}
} else {
	$return_function = '';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo $lang['titles']['imageoptions']; ?></title>
<link rel="stylesheet" href="<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css" type="text/css">
<style type="text/css">
p {
	margin:2px
}
</style>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript">
<!--//
function insert_image() {
	parentWindow.<?php
	if (!empty($return_function)) {
		echo $return_function.'(';
	} else {
		echo 'wp_create_image_html(obj,';
	} ?>document.image_form.imagename.value, document.image_form.iwidth.value, document.image_form.iheight.value, document.image_form.ialign.value, document.image_form.alt.value, document.image_form.border.value, document.image_form.mtop.value + 'px ' + document.image_form.mright.value + 'px ' + document.image_form.mbottom.value + 'px ' + document.image_form.mleft.value + 'px ');
	top.window.close();
	return false;
}
function doConfirm(url,msg) {
        if (confirm(msg)){
           this.location.assign(url)
        }
}
function load_settings() {
	var align = '<?php echo stripslashes($_GET['align']); ?>'
	if (align != '') {
		document.image_form.ialign.value = align;
	}
	var img_url = '<?php echo stripslashes($_GET['image']); ?>'
	if (img_url != '') {
		document.getElementById('imagepreview').src = make_url_with_base (img_url);
	}
	updateStyle();
}
function changeSrc(url) {
	if (url =='') {
		url = parentWindow.wp_directory +'images/spacer.gif';
	}
	url = make_url_with_base (url);
	document.getElementById('imagepreview').src = url;
	document.getElementById('imagepreview').onLoad = resetDimensionsTimeout()
}
function sizeChange(dir) {
	var preview = document.getElementById('imagepreview')
	var width = document.image_form.iwidth.value
	var height = document.image_form.iheight.value
	if (width.search("%") != -1 || height.search("%") != -1 ) {
		if (width.search("%") != -1) {
			preview.style.width=width
		} else {
			preview.setAttribute('width', width)
			preview.style.width = '';
		}
		if (height.search("%") != -1) {
			preview.style.height = height
		} else {
			preview.setAttribute('height', height)
			preview.style.height = '';
		}
		return
	} else {
		preview.style.width = '';
		preview.style.height = '';
		if (dir == 'width') {
			var input = document.image_form.iwidth
			if (input.value!='') {
				preview.setAttribute('width', input.value)
				preview.removeAttribute('height')
				setTimeout("sizeChangeTimeout('width')", 200);
			} else { 
				preview.removeAttribute('width'); 
			}
		} else {
			var input = document.image_form.iheight
			if (input.value!='') {
				preview.setAttribute('height', input.value)
				preview.removeAttribute('width')
				setTimeout("sizeChangeTimeout('height')", 200);
			} else { 
				preview.removeAttribute('height'); 
			}
		}
	}
}
function sizeChangeTimeout(dir) {
	if (dir == 'width') {
		document.image_form.iheight.value = document.getElementById('imagepreview').height
	}
	if (dir == 'height') {
		document.image_form.iwidth.value = document.getElementById('imagepreview').width
	}
}
function resetDimensionsTimeout() {
	setTimeout("resetDimensions()", 200);
}
function resetDimensions() {
	document.getElementById('imagepreview').removeAttribute('width')
	document.getElementById('imagepreview').removeAttribute('height')
	document.image_form.iwidth.value = document.getElementById('imagepreview').width
	document.image_form.iheight.value = document.getElementById('imagepreview').height
}
function updateStyle() {

	document.getElementById('wrap').align = document.image_form.ialign.value;
	
	if (document.image_form.mtop.value == '') document.image_form.mtop.value = '0';
	if (document.image_form.mbottom.value == '') document.image_form.mbottom.value = '0';
	if (document.image_form.mleft.value == '') document.image_form.mleft.value = '0';
	if (document.image_form.mright.value == '') document.image_form.mright.value = '0';
	
	document.getElementById('wrap').style.marginTop = document.image_form.mtop.value
	document.getElementById('wrap').style.marginBottom = document.image_form.mbottom.value
	document.getElementById('wrap').style.marginLeft = document.image_form.mleft.value
	document.getElementById('wrap').style.marginRight = document.image_form.mright.value
	
	document.getElementById('imagepreview').alt = document.image_form.alt.value
}
//-->
</script>
</head>
<body scroll="no" bgcolor="threedface" onLoad="load_settings(); hideLoadMessage();">
<?php include('./includes/load_message.php'); ?>
<form name="image_form" id="image_form" style="display:inline" onSubmit="return insert_image()">
	<div class="dialog_content" align="center"> 
		<p>&nbsp;</p>
		<table border="0" cellpadding="1" cellspacing="3">
			<tr> 
				<td align="right" valign="top">
						<div id="preview" align="center" style="width:304px; height:192px; overflow:auto; background-color:#FFFFFF; padding:5px" class="previewWindow"><img id="imagepreview" src="<?php if (isset ($_GET['image']) ? $_GET['image'] : '') { echo stripslashes($_GET['image']); } else { echo 'images/spacer.gif'; } ?>"<?php if (isset ($_GET['width']) ? $_GET['width'] : '') echo ' width="'.$_GET['width'].'"'; ?><?php if (isset ($_GET['height']) ? $_GET['height'] : '') echo ' height="'.$_GET['height'].'"'; ?> border="<?php echo stripslashes($_GET['border']); ?>" title="<?php echo stripslashes($_GET['alt']); ?>" alt="<?php echo stripslashes($_GET['alt']); ?>"></div></td>
				<td valign="top">&nbsp;</td>
				<td rowspan="2" valign="top"><fieldset>
					<legend><?php echo $lang['positioning']; ?></legend>
					<table border="0" cellspacing="3" cellpadding="1">
						<tr> 
							<td><?php echo $lang['text_flow']; ?></td>
							<td><select name="ialign" id="ialign" class="seltext" onChange="updateStyle()">
									<option selected="selected" value=""><?php echo $lang['default']; ?></option>
									<option value="absmiddle"><?php echo $lang['absmiddle']; ?></option>
									<option value="middle"><?php echo $lang['middle']; ?></option>
									<option value="bottom"><?php echo $lang['bottom']; ?></option>
									<option value="top"><?php echo $lang['top']; ?></option>
									<option value="left"><?php echo $lang['left']; ?></option>
									<option value="right"><?php echo $lang['right']; ?></option>
									<option value="baseline"><?php echo $lang['base_line']; ?></option>
									<option value="texttop"><?php echo $lang['texttop']; ?></option>
									<option value="absbottom"><?php echo $lang['absbottom']; ?></option>
								</select></td>
						</tr>
						<tr> 
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr> 
							<td colspan="2"><?php echo $lang['distance_to_surrounding_text']; ?></td>
						</tr>
						<tr> 
							<td> <?php echo $lang['top2']; ?> </td>
							<td> <input type="text" name="mtop" id="mtop" size="4" value="<?php echo str_replace('px', '', $_GET['mtop']); ?>" onChange="updateStyle()"> 
								<?php echo $lang['pixels']; ?> </td>
						</tr>
						<tr> 
							<td><?php echo $lang['bottom2']; ?></td>
							<td><input type="text" name="mbottom" id="mbottom" size="4" value="<?php echo str_replace('px', '', $_GET['mbottom']); ?>" onChange="updateStyle()"> 
								<?php echo $lang['pixels']; ?> </td>
						</tr>
						<tr> 
							<td> <?php echo $lang['left2']; ?> </td>
							<td> <input type="text" name="mleft" id="mleft" size="4" value="<?php echo str_replace('px', '', $_GET['mleft']); ?>" onChange="updateStyle()"> 
								<?php echo $lang['pixels']; ?> </td>
						</tr>
						<tr> 
							<td><?php echo $lang['right2']; ?></td>
							<td><input type="text" name="mright" id="mright" size="4" value="<?php echo str_replace('px', '', $_GET['mright']); ?>" onChange="updateStyle()"> 
								<?php echo $lang['pixels']; ?> </td>
						</tr>
						<tr> 
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr> 
							<td colspan="2"><?php echo $lang['positioning_preview']; ?> <div id="stylepreview" style="padding:10px; width:340px; height:128px; overflow:hidden; background-color:#FFFFFF; font-size:8px" class="previewWindow"> 
									<p><img id="wrap" src="<?php echo WP_WEB_DIRECTORY; ?>images/wrap_preview.gif" width="48" height="48" align="" alt="">Lorem 
										ipsum, Dolor sit amet, consectetuer adipiscing loreum ipsum 
										edipiscing elit, sed diam nonummy nibh euismod tincidunt ut 
										laoreet dolore magna aliquam erat volutpat.Loreum ipsum edipiscing 
										elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore 
										magna aliquam erat volutpat. Ut wisi enim ad minim veniam, 
										quis nostrud exercitation ullamcorper suscipit. Lorem ipsum, 
										Dolor sit amet, consectetuer adipiscing loreum ipsum edipiscing 
										elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore 
										magna aliquam erat volutpat.</p>
									<p>Lorem ipsum, Dolor sit amet, consectetuer adipiscing loreum 
										ipsum edipiscing elit, sed diam nonummy nibh euismod tincidunt 
										ut laoreet dolore magna aliquam erat volutpat.Loreum ipsum 
										edipiscing elit, sed diam nonummy nibh euismod tincidunt ut 
										laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad 
										minim veniam, quis nostrud exercitation ullamcorper suscipit. 
										Lorem ipsum, Dolor sit amet, consectetuer adipiscing loreum 
										ipsum edipiscing elit, sed diam nonummy nibh euismod tincidunt 
										ut laoreet dolore magna aliquam erat volutpat.</p>
								</div></td>
						</tr>
					</table>
					</fieldset></td>
			</tr>
			<tr> 
				<td align="right" valign="top"><fieldset>
					<legend><?php echo $lang['image_information']; ?></legend>
					<table width="100%" border="0" cellspacing="3" cellpadding="1">
						<tr> 
							<td><span title="You can type an address to an external image here if you wish."><?php echo $lang['source']; ?></span></td>
							<td width="100%" colspan="2"><input style="width:200px" type="text" name="imagename" id="imagename" value="<?php if ($_GET['image'] != 'null') echo stripslashes($_GET['image']); ?>" size="34" onChange="changeSrc(this.value);" title="<?php echo $lang['type_image_address']; ?>"> 
							</td>
						</tr>
						<tr> 
							<td><?php echo $lang['border']; ?></td>
							<td colspan="2"><input type="text" name="border" id="border" value="<?php if ($_GET['border'] != 'null') echo stripslashes($_GET['border']); ?>" size="4" onChange="document.getElementById('imagepreview').border = this.value;"></td>
						</tr>
						<tr> 
							<td><?php echo $lang['width']; ?></td>
							<td><input type="text" name="iwidth" id="iwidth" size="4" value="<?php if ($_GET['width'] != 'null') echo stripslashes($_GET['width']); ?>" onChange="sizeChange('width')">
							</td>
							<td rowspan="2"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/brackets.gif" width="11" height="39" align="absmiddle" alt="">&nbsp;&nbsp;<a id="reset" href="javascript:resetDimensions()" onMouseUp="this.blur()"><?php echo $lang['reset_dimensions']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
						<tr> 
							<td><?php echo $lang['height']; ?></td>
							<td><input type="text" name="iheight" id="iheight" size="4" value="<?php if ($_GET['height'] != 'null') echo stripslashes($_GET['height']); ?>" onChange="sizeChange('height')"></td>
						</tr>
						<tr> 
							<td height="24"><?php echo $lang['title']; ?></td>
							<td colspan="2"> <input style="width:200px" type="text" name="alt" id="alt" value="<?php if ($_GET['alt'] != 'null') echo stripslashes($_GET['alt']); ?>" size="34" onChange="document.getElementById('imagepreview').alt = this.value;document.getElementById('imagepreview').title = this.value;" title="<?php echo $lang['creates_popup_message']; ?>"> 
							</td>
						</tr>
					</table>
					</fieldset></td>
				<td align="right" valign="top">&nbsp;</td>
			</tr>
			<tr> 
				<td colspan="3" align="right" valign="top">&nbsp;</td>
			</tr>
			<tr> 
				<td colspan="3" align="right" valign="top"><div align="center"> 
						<button type="submit"><?php echo $lang['ok']; ?></button>
						&nbsp; 
						<button type="button" onClick="top.window.close();"><?php echo $lang['cancel']; ?></button>
						<script language="JavaScript" type="text/javascript">
				<!--// 
					if (obj.imagewindow != 'imageoptions.php') {
						document.writeln("<a href=\"<?php echo WP_WEB_DIRECTORY; ?>image.php?instance_img_dir="+obj.instance_img_dir+"&lang="+obj.instance_lang +"&return_function=<?php echo $return_function; ?>\"><?php echo $lang['choose_different_image']; ?></a>");
					}
				//-->
				</script></div></td>
			</tr>
		</table>
	</div>
</form>
</body>
</html>
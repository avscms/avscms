<?php 
/* /////////////////////////////////////////////////////////////////////////
 *                             		 	image.php
 *                              -------------------
 *  author      : Chris Bolt
 *  copyright   : (C) Chris Bolt 2003-2004. All Rights Reserved
 *  version     : 2.2.4
 *	purpose			:	Directory manager for image file types
///////////////////////////////////////////////////////////////////////////*/

// You may alter any of the code in this file to suit your requirements.

// If you need to locate this file outside of the editor_files folder you will need to alter the include paths below:

// if you intend to locate this file on a different physical server make sure that a copy of 'config.php' and 'editor_functions.php' is available to this script.
define('_VALID', true);
include_once ('./config.php');
include_once('./editor_functions.php');
include_once ('./includes/common.php');
include_once ('./lang/'.$lang_include);

$instance_img_dir = '';
// SET DIRECTORY LOCATIONS:
// This routine sets the location of the image directory, you can change this routine if you wish.
// If you want to change the image directory based on a user add your user authentication scripts to the top of this script.
// Then change the routine below so that it sets the directories based on the user rather than setting them the same as config.php.
if (isset ($_GET['instance_img_dir']) ? $_GET['instance_img_dir'] : '') {
	$instance_img_dir = $_GET['instance_img_dir'];
} else if (isset ($_POST['instance_img_dir']) ? $_POST['instance_img_dir'] : '') {
	$instance_img_dir = $_POST['instance_img_dir'];
}
if (isset ($trusted_directories[$instance_img_dir]) ? $trusted_directories[$instance_img_dir] : '') {
	$file_directory = $trusted_directories[$instance_img_dir][0];
	$web_directory = $trusted_directories[$instance_img_dir][1];
} else {
	$file_directory = IMAGE_FILE_DIRECTORY;
	$web_directory = IMAGE_WEB_DIRECTORY;
}

if (isset ($_REQUEST['in_wp'])) {
	if ($_REQUEST['in_wp'] == 1) {
		$in_wp = true;
	} else {
		$in_wp = false;
	}
} else {
	$in_wp = true;
}

// sorting
if (isset ($_REQUEST['sort_by'])) {
	$sort_by = $_REQUEST['sort_by'];
} else {
	$sort_by = 'name';
}
if (isset ($_REQUEST['sort_dir'])) {
	$sort_dir = $_REQUEST['sort_dir'];
} else {
	$sort_dir = 'asc';
}
if ($sort_dir == 'asc') {
	$direction = 'up';
} else {
	$direction = 'down';
}
if ($sort_by == 'name') {
	if ($sort_dir == 'asc') {
		$name_sort_dir = 'desc';
	} else {
		$name_sort_dir = 'asc';
	}
	$type_sort_dir = 'asc';
	$name_arrow = '<img src="'.WP_WEB_DIRECTORY.'images/arrow_'.$direction.'.gif" width="8" height="7" alt="">';
	$type_arrow = '';
} else {
	if ($sort_dir == 'asc') {
		$type_sort_dir = 'desc';
	} else {
		$type_sort_dir = 'asc';
	}
	$name_sort_dir = 'asc';
	$name_arrow = '';
	$type_arrow = '<img src="'.WP_WEB_DIRECTORY.'images/arrow_'.$direction.'.gif" width="8" height="7" alt="">';
}

// make sure its not possible to put anything malicious in the return function
if (isset ($_REQUEST['return_function'])) {
	if (wp_return_function_ok($_REQUEST['return_function'])) {
		$return_function = $_REQUEST['return_function'];
	} else {
		$return_function = '';
	}
} else {
	$return_function = '';
}

// init variables

$message = '';
$name2 = '';
$width = '';
$height = '';
$fsize = '';

//get the folder for us to look inside, we'll also check that there are no ./ or ../ so that we are only ever looking at folders below the $web_directory, I'm sure there is a more secure way to do this?
if (isset ($_GET['folder']) ? $_GET['folder'] : '') {
	if (wp_dir_name_ok($_GET['folder'])) {
		$directory = $file_directory.$_GET['folder'];
		$folderpath = $_GET['folder'];
	} else {
		$directory = $file_directory;
		$folderpath = '';
	}
} elseif (isset ($_POST['folder']) ? $_POST['folder'] : '') {
	if (wp_dir_name_ok($_POST['folder'])) {
		$directory = $file_directory.$_POST['folder'];
		$folderpath = $_POST['folder'];
	} else {
		$directory = $file_directory;
		$folderpath = '';
	}
} else {
	$directory = $file_directory;
	$folderpath = '';
}
	
// check that it exists
if (!file_exists ($directory)) {
	image_exit('<b>Warning: this directory does not exist: '.$directory.'. Check that you have set IMAGE_FILE_DIRECTORY correctly in config.php. If you are using the set_img_dir function check that the you have set the $trusted_directories array correctly.</b>');
}
if ($folderpath != '') {
	if (substr ($folderpath, strlen ($folderpath) - 1) != '/') {
		$folderpath.='/';
	}
}
if (substr ($directory, strlen ($directory) - 1) != '/') {
	$directory.='/';
}

// query strings
$query_string = '?in_wp='.$in_wp.'&amp;return_function='.$return_function.'&amp;lang='.$lang_include.'&amp;folder='.$folderpath.'&amp;instance_img_dir='.$instance_img_dir.'&amp;sort_by='.$sort_by.'&amp;sort_dir='.$sort_dir;
$query_inputs = '<input type="hidden" name="lang" value="'.$lang_include.'">
	<input type="hidden" name="return_function" value="'.$return_function.'">
	<input type="hidden" name="folder" value="'.$folderpath.'">
	<input type="hidden" name="instance_img_dir" value="'.$instance_img_dir.'">
	<input type="hidden" name="in_wp" value="'.$in_wp.'">
	<input type="hidden" name="sort_by" value="'.$sort_by.'">
	<input type="hidden" name="sort_dir" value="'.$sort_dir.'">';

///////////////////
// Functions ... //
///////////////////

function image_exit($message) {
	global $lang;
	echo '<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>'.$lang['titles']['image'].'</title>
		<link rel="stylesheet" href="'.WP_WEB_DIRECTORY.'dialoge_theme.css" type="text/css">
		<script language="JavaScript" type="text/javascript" src="'.WP_WEB_DIRECTORY.'js/dialogShared.js"></script>
		</head>
		<body scroll="no" onload="hideLoadMessage();">'; ?><?php include('./includes/load_message.php'); ?>
		<?php
		echo ' <div align="center">'.$message.'</div>
		</body>
		</html>';
		exit;
}

function display_folders () {
	global $directory, $folderpath, $lang, $count, $query_string, $rename_directories, $delete_directories, $web_directory, $rename_files, $delete_files, $sort_by, $sort_dir;
	// build array of data, sort the array, loop through building the list
	$folderlist = wp_get_folders_in_directory($directory, $sort_by, $sort_dir);
	$str = '';
	$num = count($folderlist);
	for ($i=0; $i<$num; $i++) {
		$foldername = $folderlist[$i]['name'];	
		$count += 1;
		$str .= "
		<tr onmouseover=\"this.style.backgroundColor='#eeeeee'\" onmouseout=\"this.style.backgroundColor=''\">
			<td width=\"190\">
				<p><a class=\"filename\" href=\"".WP_WEB_DIRECTORY."image.php".str_replace('folder='.$folderpath, 'folder='.$folderpath.$foldername, $query_string)."\"><img src=\"".WP_WEB_DIRECTORY."images/folder.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\">$foldername </a></p>
			</td>
			<td width=\"100\">
			<p>".$lang['files']['folder']."</p>
			</td>
			<td>
				<p>";  if ($rename_directories) { $str .= "<a href=\"".WP_WEB_DIRECTORY."image.php$query_string&amp;action=rename&amp;file=$foldername\"><img src=\"".WP_WEB_DIRECTORY."images/rename.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\" title=\"".$lang['rename']."\" alt=\"".$lang['rename']."\"></a> ";} else { $str .= "&nbsp;"; } $str .= "</p>
			</td>
			<td>
				<p>";  if ($delete_directories) { $str .= "<a class=\"delete\" href=\"javascript:doConfirm('".WP_WEB_DIRECTORY."image.php$query_string&amp;action=delete&amp;file=$foldername','".$lang['folder_delete_warning']." ');\"><img src=\"".WP_WEB_DIRECTORY."images/delete.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\" title=\"".$lang['delete']."\" alt=\"".$lang['delete']."\"></a>";} else { $str .= "&nbsp;"; } $str .= "</p>
			</td>
		</tr>
		";
	}
	echo $str;
}

function display_files () {
	global $directory, $folderpath, $lang, $count, $query_string, $rename_directories, $delete_directories, $web_directory, $rename_files, $delete_files, $sort_by, $sort_dir;
	global $image_types;
	// build array of data, sort the array, loop through building the list
	
	$filelist = wp_get_files_in_directory($directory, $sort_by, $sort_dir, $image_types);
	
	$str = '';
	$num = count($filelist);
	for ($i=0; $i<$num; $i++) { 
		$filename = $filelist[$i]['name'];
		$fsize = wp_filesize($directory.$filename);
		$extension = strrchr(strtolower($filename),'.');
		$icon = $filelist[$i]['icon'];
		$filetype = $filelist[$i]['type'];
		$preview = $filelist[$i]['preview'];
		list ($width, $height) = @getimagesize($directory.$filename);
		
		$count += 1;
		$str .= "
		<tr onmouseover=\"this.style.backgroundColor='#eeeeee'\" onmouseout=\"this.style.backgroundColor=''\">
			<td width=\"190\">
				<p class=\"filename\"><a id=\"".$web_directory.$folderpath.$filename."\" class=\"filelink\" href=\"javascript:localImage('".$web_directory.$folderpath."$filename',$preview,'$width','$height', '$fsize')\" onclick=\"highlight(this)\" title=\"".$lang['dimensions']." $width x $height px  ".$lang['size']." $fsize\"><img src=\"".WP_WEB_DIRECTORY."images/$icon.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\">$filename </a></p>
			</td>
			<td width=\"100\">
				<p class=\"styled\">$filetype</p>
			</td>
			<td>
				<p class=\"styled\">"; if ($rename_files) { $str .= ("<a href=\"".WP_WEB_DIRECTORY."image.php$query_string&amp;action=rename&amp;file=$filename\"><img src=\"".WP_WEB_DIRECTORY."images/rename.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\" title=\"".$lang['rename']."\" alt=\"".$lang['rename']."\"></a> ");} else { $str .= "&nbsp;"; } $str .= "</p>
			</td>
			<td>
				<p class=\"styled\">"; if ($delete_files) { $str .= "<a class=\"delete\" href=\"javascript:doConfirm('".WP_WEB_DIRECTORY."image.php$query_string&amp;action=delete&amp;file=$filename','".$lang['file_delete_warning']." ');\"><img src=\"".WP_WEB_DIRECTORY."images/delete.gif\" width=\"23\" height=\"22\" alt=\"\" border=\"0\" align=\"absmiddle\" title=\"".$lang['delete']."\" alt=\"".$lang['delete']."\"></a>";} else { $str .= "&nbsp;"; } $str .= "</p>
			</td>
		</tr>
		";
	} 
	if ($count ==0) {
	 $str .= '<tr><td>'.$lang['no_files'].'</td></tr>';
	}
	echo $str;
}

////////////////
// actions... //
////////////////
if ((isset ($_GET['file']) ? $_GET['file'] : '') && (wp_file_name_ok($_GET['file']))) {
	if (isset ($_GET['action']) ? $_GET['action'] : '') {
		// delete file or directory
		if (($_GET['action']=='delete') && ($delete_files)) {
			if (@wp_delete_file($directory.$_GET['file'])) {
				$message='<div class="helpMessage"><p> '.wp_var_replace($lang['file_deleted'], array('file'=>$_GET['file'], 'folder' => $web_directory.$folderpath)).' </p></div>';
			} else {
				image_exit ('<p>&nbsp;</p>
				<div class="helpMessage">
				<form>
				<p> '.wp_var_replace($lang['cannot_delete'], array('file'=>$_GET['file'])).' '.$lang['check_directory_permission'].'</p>
				<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
				</form>
				</div>');
			}
		}
		// rename
		if (($_GET['action']=='rename') && ($rename_files || $rename_directories) && (!isset($_GET['name']))) {
			
			$filename = str_replace(strrchr($_GET['file'],'.'), '', $_GET['file']);
			
			image_exit ('<p>&nbsp;</p>
	<div align="center" style="width:300px">
	<fieldset>
	<form action="'.WP_WEB_DIRECTORY.'image.php" name="form1" method="get">
	<p>'.wp_var_replace($lang['enter_new_filename'],array('file'=>$_GET['file'])).'</p>
	<p><input type="text" name="name" value="'.$filename.'" size="36">'.strrchr($_GET['file'],'.').'</p>
	<script type="text/javascript">document.form1.name.focus();</script>
	'.$query_inputs.'	
	<input type="hidden" name="file" value="'.$_GET['file'].'">
	<input type="hidden" name="action" value="rename">
	<input class="button" type="submit" name="OK" value="'.$lang['ok'].'">
	&nbsp;
	<input class="button" type="button" name="Cancel" value="'.$lang['cancel'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
	</form><br>
	</fieldset>
	</div>');	
		}	
		if (($_GET['action']=='rename') && ($rename_files || $rename_directories) && (isset($_GET['name']) ? $_GET['name'] : '')) {
			if (!wp_file_name_ok($_GET['name'])) {
				image_exit ('<p>&nbsp;</p>
				<div class="helpMessage">
				<form>
				<p> '.$lang['bad_file_name'].'</p>
				<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'&amp;action=rename&amp;file='.$_GET['file'].'\')">
				</form>
				</div>');			
			} elseif (file_exists ($directory.$_GET['name'].strrchr($_GET['file'],'.'))) {
				image_exit ('<p>&nbsp;</p>
				<div class="helpMessage">
				<form>
				<p> '.$lang['file_already_exists'].'</p>
				<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'&amp;action=rename&amp;file='.$_GET['file'].'\')">
				</form>
				</div>');
			} elseif (@rename($directory.$_GET['file'], $directory.$_GET['name'].strrchr($_GET['file'],'.'))) {
				$message='<div class="helpMessage"><p> '.wp_var_replace($lang['file_renamed'],array('file'=>$_GET['file'],'name'=>$_GET['name'].strrchr($_GET['file'],'.'))).'</p></div>';
			} else {
				image_exit ('<p>&nbsp;</p>
				<div class="helpMessage">
				<form>
				<p> '.wp_var_replace($lang['could_not_rename'],array('file'=>$_GET['file'],'name'=>$_GET['name'].strrchr($_GET['file'],'.'))).' '.$lang['check_directory_permission'].'</p>
				<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
				</form>
				</div>');
			}
		}
	}
}
if (isset ($_GET['action']) ? $_GET['action'] : '') {
		// create directory
	if (($_GET['action']=='create_dir') && ($create_directories) && (!isset($_GET['dir_name']))) {
		image_exit('<p>&nbsp;</p>
<div align="center" style="width:300px">
<fieldset>
<form action="'.WP_WEB_DIRECTORY.'image.php" name="form1" method="get">
<p>'.$lang['enter_dirname_for_new_dir'].'</p>
<p><input type="text" name="dir_name" value="" size="36"></p>
<script type="text/javascript">document.form1.dir_name.focus();</script>
'.$query_inputs.'
<input type="hidden" name="action" value="create_dir">
<input class="button" type="submit" name="OK" value="'.$lang['ok'].'">
&nbsp;
<input class="button" type="button" name="Cancel" value="'.$lang['cancel'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
</form><br>
</fieldset>
</div>');
		
	}	
	if (($_GET['action']=='create_dir') && ($create_directories) && (isset($_GET['dir_name']) ? $_GET['dir_name'] : '')) {
		if (!wp_file_name_ok($_GET['dir_name'])) {
			image_exit ('<p>&nbsp;</p>
			<div class="helpMessage">
			<form>
			<p> '.$lang['bad_file_name'].'</p>
			<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'&amp;action=create_dir\')">
			</form>
			</div>');			
		} else if (file_exists($directory.$_GET['dir_name'])) {
			image_exit ('<p>&nbsp;</p>
			<div class="helpMessage">
			<form>
			<p> '.$lang['file_already_exists'].'</p>
			<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'&amp;action=create_dir\')">
			</form>
			</div>');
		} elseif (@wp_create_dir($directory.$_GET['dir_name'])) {
			$message='<div class="helpMessage"><p> '.wp_var_replace($lang['file_created'],array('file'=>$_GET['dir_name'],'folder'=>$web_directory.$folderpath)).' </p></div>';
		} else {
			image_exit ('<p>&nbsp;</p>
			<div class="helpMessage">
			<form>
			<p> '.$lang['dir_not_created'].' '.$lang['check_directory_permission'].'</p>
			<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
			</form>
			</div>');
		}
	}
}
if ((isset($_POST['ok_to_overwrite']) ? $_POST['ok_to_overwrite'] : '') && ($overwrite)) {
	if (($_POST['ok_to_overwrite'] == $lang['yes']) && (isset($_POST['image_field']) ? $_POST['image_field'] : '') && (wp_file_name_ok($_POST['image_field']))) {
		if (is_file($directory.$_POST['image_field'])) {
			wp_delete_file($directory.$_POST['image_field']);
			if (rename($directory.$_POST['image_field'].'.TEMP', $directory.$_POST['image_field'])) {
				$message= '<div class="helpMessage"><p> '.$lang['file_uploaded1'].'</p></div>';
			} else {
				wp_delete_file($directory.$_POST['image_field'].'.TEMP');
				image_exit ('<p>&nbsp;</p>
				<div class="helpMessage">
				<form>
				<p> '.$lang['upload_failed'].' '.$lang['check_directory_permission'].' </p>
				<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
				</form>
				</div>');
			}
		} else {
			wp_delete_file($directory.$_POST['image_field'].'.TEMP');
			image_exit ('<p>&nbsp;</p>
			<div class="helpMessage">
			<form>
			<p> '.$lang['dir_exists'].' </p>
			<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
			</form>
			</div>');
		}
	} elseif ($_POST['ok_to_overwrite'] == $lang['cancel']) {
		wp_delete_file($directory.$_POST['image_field'].'.TEMP');
	} else {
		$message.= '<div class="helpMessage"><p>'.$lang['copy_error'].'</p></div>';
	}
}
// upload files
if (isset($_FILES['image_field']) ? $_FILES['image_field'] : '') {
	if (is_uploaded_file($_FILES['image_field']['tmp_name'])) {
		$extension = strrchr(strtolower($_FILES['image_field']['name']),'.');
		// check filetype against accepted files
		if (!wp_extension_ok($extension, $image_types)) {
			image_exit ('<p>&nbsp;</p>
			<div class="helpMessage">
			<form>
			<p> '.wp_var_replace($lang['bad_filetype'],array('filetypes'=>$image_types)).' </p>
			<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
			</form>
			</div>');
			break;
		}
		if ($_FILES['image_field']['size'] >= $max_file_size) {
			image_exit ('<p>&nbsp;</p>
			<div class="helpMessage">
			<form>
			<p> '.wp_var_replace($lang['file_too_large'],array('max_size'=>($max_file_size/1000))).' </p>
			<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
			</form>
			</div>');
		} else {
			list ($width, $height) = @getimagesize($_FILES['image_field']['tmp_name']);
			if (($width > $max_image_width) || ($height > $max_image_height)) {
				image_exit ('<p>&nbsp;</p>
				<div class="helpMessage">
				<form>
				<p> '.wp_var_replace($lang['dimensions_too_large'],array('width'=>$max_image_width,'height'=>$max_image_height)).' </p>
				<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
				</form>
				</div>');
			} else {
				$name=$_FILES['image_field']['name'];
				// somepeople like to spit out an error if file have bad characters, I prefer to quetly rename their file.
				$name = str_replace( array('/','\\','?','&','%','#','~',':','<','>','*','+','@','"',"'",'|',"\r","\n","\t") , '', $name);
				$name = str_replace(' ', '_', $name);
			
				if (empty($name)) {
					$name = 'Untitled'.$extension;
				}					
				
				$just_file_name = $name;
				
				if ($name != $_FILES['image_field']['name']) {
					$extra_message = wp_var_replace($lang['but_was_renamed'],array('name'=>$name));
				} else {
					$extra_message = '';
				}
				
				//used later to populate the dialoge with the image they have just uploaded:
				$name2 = $folderpath.$name;
				$fsize = wp_convert_fsize($_FILES['image_field']['size']);
				
				$name=$directory.$name;
				if (file_exists($name)) {
					if ($overwrite) {
						@move_uploaded_file($_FILES['image_field']['tmp_name'], $name.'.TEMP');
						image_exit ('<p>&nbsp;</p>
						<div class="helpMessage">
						<form action="'.WP_WEB_DIRECTORY.'image.php" name="form1" method="post">
						<input name="image_field" type="hidden" value="'.$just_file_name.'">
						'.$query_inputs.'
						<p> '.$lang['should_i_overwrite'].' </p>
						<input class="button" type="submit" name="ok_to_overwrite" value="'.$lang['yes'].'">
						<input class="button" type="submit" name="ok_to_overwrite" value="'.$lang['cancel'].'">
						</form>
						</div>');
					} else {
						image_exit ('<p>&nbsp;</p>
						<div class="helpMessage">
						<form action="'.WP_WEB_DIRECTORY.'image.php" name="form1" method="post">
						<input name="image_field" type="hidden" value="'.$just_file_name.'">
						'.$query_inputs.'
						<p> '.$lang['no_overwrite_permission'].' </p>
						<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
						</form>
						</div>');
					}
				} elseif (@move_uploaded_file($_FILES['image_field']['tmp_name'], $name)) {
					// make sure we will be able to delete and re-name this file later
					$message= '<div class="helpMessage"><p> '.wp_var_replace($lang['file_uploaded2'],array('file'=>$_FILES['image_field']['name'])).' '.$extra_message.'</p></div>';
				} else {
					image_exit ('<p>&nbsp;</p>
					<div class="helpMessage">
					<form>
					<p> '.wp_var_replace($lang['upload_failed2'],array('file'=>$_FILES['image_field']['name'])).' '.$lang['check_directory_permission'].' </p>
					<input class="button" type="button" name="Continue" value="'.$lang['ok'].'" onClick="document.location.replace(\''.WP_WEB_DIRECTORY.'image.php'.$query_string.'\')">
					</form>
					</div>');
				}
			}
		}
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo $lang['titles']['image']; ?></title>
<link rel="stylesheet" href="<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css" type="text/css">
<style type="text/css">
p {
	margin:2px
}
.filename {
	width:180px;
	height:22px;
	overflow:hidden;
	white-space: nowrap;
}
.fileBar a {
	display: block;
	color: #000000;
	text-decoration: none;
}
.fileBar a:hover {
	display: block;
	color: #000000;
	text-decoration: none;
}
.fileBar a:active {
	display: block;
	color: #000000;
	background-color: transparent;
	text-decoration: none;
}
.fileBar a img {
	border-width: 0px;
}
</style>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript">
<!--//
var CURRENT_HIGHLIGHT
function highlight(srcElement) {
	if (CURRENT_HIGHLIGHT) {
		CURRENT_HIGHLIGHT.style.backgroundColor='';
		CURRENT_HIGHLIGHT.style.color='#003399';
	}
	srcElement.style.backgroundColor = 'highlight';
	srcElement.style.color = 'highlighttext';
	CURRENT_HIGHLIGHT = srcElement;
}
function insert_image() {
	parentWindow.<?php
	if (!empty($return_function)) {
		echo $return_function.'(';
	} else {
		echo 'wp_create_image_html(obj,';
	} ?>document.image_form.imagename.value, document.image_form.iwidth.value, document.image_form.iheight.value, '', '', '');
	top.window.close();
	return false;
}
function moreoptions() {
	if (document.getElementById('options').disabled == true) {
		return;
	}
	if (document.image_form.imagename.value == '') {
		alert('<?php echo $lang['select_image_first']; ?>');
		document.getElementById('options').disabled = true;
		return;
	} else {
		document.location.replace('<?php echo WP_WEB_DIRECTORY; ?>imageoptions.php?lang=<?php echo $lang_include; ?>&image=' + document.image_form.imagename.value + '&width=' + document.image_form.iwidth.value +'&height=' + document.image_form.iheight.value + '&alt=&align=&mtop=&mbottom=&mleft=&mright=&border=')
	}
}
function preview(url) {
	if (url!='') {
		url = make_url_with_base (url);
		if (wp_is_ie) {
			document.frames('preview').location.replace(url);
		} else {
			document.getElementById('preview').contentWindow.location.replace(url);
		}
	} else {
		if (wp_is_ie) {
			document.frames('preview').location.replace('<?php echo WP_WEB_DIRECTORY; ?>no_preview.php?lang=<?php echo $lang_include; ?>');
		} else {
			document.getElementById('preview').contentWindow.location.replace('<?php echo WP_WEB_DIRECTORY; ?>no_preview.php?lang=<?php echo $lang_include; ?>');
		}
	}
}
function localImage(image,do_preview,iwidth,iheight,isize) {
	document.image_form.imagename.value=image;
	document.image_form.imagename.value = image
	document.image_form.iwidth.value=iwidth;
	document.getElementById('width').innerHTML = '<?php echo $lang['width']; ?> ' + iwidth + 'px';
	document.image_form.iheight.value=iheight;
	document.getElementById('height').innerHTML = '<?php echo $lang['height']; ?> ' + iheight + 'px';
	document.getElementById('size').innerHTML = '<?php echo $lang['size']; ?> ' + isize;
	if (do_preview == 0) {
		if (wp_is_ie) {
			document.frames('preview').location.replace('<?php echo WP_WEB_DIRECTORY; ?>no_preview.php?lang=<?php echo $lang_include; ?>');
		} else {
			document.getElementById('preview').contentWindow.location.replace('<?php echo WP_WEB_DIRECTORY; ?>no_preview.php?lang=<?php echo $lang_include; ?>');
		}
	} else {
		preview(image);
	}
	if (document.getElementById('options')) {
		document.getElementById('options').disabled = false;
	}
	if (document.getElementById('ok')) {
		document.getElementById('ok').focus()
	}
	
}
function doConfirm(url,msg) {
	if (confirm(msg)){
		document.location.assign(url)
	}
}
function upload_check() {
	if (document.getElementById('image_field').value == '') {
		alert("<?php echo $lang['click_browse']; ?>")
		document.getElementById('image_field').focus();
		return false;
	} else {
		return true;
	}
}
function showUploadMessage() {
	document.getElementById('uploadMessage').style.display = 'block'
}
function hideUploadMessage() {
	document.getElementById('uploadMessage').style.display = 'none'
}
function cancelUpload() {
	if (wp_is_ie) {
		try {
			document.execCommand('stop');
		} catch (e) {
			document.location.reload();
		}
	} else {
		window.stop();
	}
	hideUploadMessage()
}
//-->
</script>
<?php
// script to make any uploaded images currently selected
if (!empty($name2)) {
	echo '<script type="text/javascript">
	<!--// Begin
	function uploadedimage() {
		localImage("'.$web_directory.$name2.'", 1, "'.$width.'", "'.$height.'", "'.$fsize.'");
		highlight(document.getElementById("'.$web_directory.$name2.'"));
		document.getElementById("'.$web_directory.$name2.'").focus();
	}
	// End -->
</script>
';
} else {
	echo '<script type="text/javascript">
	<!--// Begin
	function uploadedimage() {
		return true;
	}
	// End -->
</script>
';

}
?>
</head>
<body scroll="no" onLoad="uploadedimage(); hideLoadMessage();">
<?php include('./includes/load_message.php'); ?>
<div align="center" id="uploadMessage">
	<table width="100%" height="90%">
		<tr>
			<td align="center" valign="middle"><div id="uploadMessageText"><?php echo $lang['upload_in_progress']; ?> <?php echo $lang['please_wait']; ?><br><br>
	<img src="images/load_bar.gif" height="12" width="251" alt="" class="inset"><br><br>
	<input class="button" type="button" value="<?php echo $lang['cancel']; ?>" onClick="cancelUpload()"></div></td>
		</tr>
	</table>
</div>
<div class="dialog_content"> 
	<div style="height:22px"> 
		<?php
if ($message) {echo $message;} else {echo '&nbsp;';}
?>
	</div>
	<table border="0" cellpadding="1" cellspacing="3">
		<tr> 
			<td rowspan="10" valign="top"> <fieldset>
				<legend><?php echo $lang['select_image']; ?></legend>
				<div align="left"> <?php echo $lang['looking_in'] ; ?> <input class="disabledtextbox" type="text" name="imagename" value="<?php echo $web_directory.$folderpath; ?>" style="width:292px" readonly="readonly"> 
				</div>
				<table width="360" border="0" cellpadding="0" cellspacing="0" style="background-color:threedshadow;">
					<tr> 
						<td> <p> 
								<?php
		if ($folderpath != '') { 
		
			$array = explode ('/',$folderpath); 
			$array[sizeof($array)-1] = NULL; 
			$array[sizeof($array)-2] = NULL; 
			$foo = implode ('/', $array);
			while (substr ($foo, strlen ($foo) - 1) == '/') {
				$foo = substr ($foo, 0, strlen ($foo) - 1);
			}
		?>
								<a style="color:highlighttext" href="<?php echo WP_WEB_DIRECTORY; ?>image.php<?php echo str_replace('folder='.$folderpath, 'folder='.$foo, $query_string) ?>"> 
								<img src="<?php echo WP_WEB_DIRECTORY; ?>images/up.gif" width="23" height="22" alt="<?php echo $lang['up_one_level']; ?>" title="<?php echo $lang['up_one_level']; ?>" border="0" align="absmiddle"><?php echo $lang['parent_directory']; ?></a> 
								<?php 
		}  else {
		?>
								<img src="<?php echo WP_WEB_DIRECTORY; ?>images/spacer.gif" width="23" height="22" alt="" border="0" align="absmiddle"> 
								<?php
		}
	if ($create_directories) { ?>
							</p></td>
						<td align="right"> <p> <a style="color:highlighttext" href="<?php echo WP_WEB_DIRECTORY; ?>image.php<?php echo $query_string ?>&amp;action=create_dir"><img src="<?php echo WP_WEB_DIRECTORY; ?>images/newfolder.gif" width="23" height="22" alt="<?php echo $lang['new_folder']; ?>" title="<?php echo $lang['new_folder']; ?>" border="0" align="absmiddle"><?php echo $lang['new_folder']; ?></a> 
								<?php } ?>
								&nbsp;&nbsp;&nbsp;</p></td>
					</tr>
				</table>
				<table width="360px" border="0" cellspacing="0" cellpadding="0">
					<tr> 
						<td class="fileBar" width="190"><p><a href="<?php echo WP_WEB_DIRECTORY; ?>image.php<?php echo str_replace(array('sort_by='.$sort_by,'sort_dir='.$sort_dir), array('sort_by=name','sort_dir='.$name_sort_dir), $query_string) ?>"><?php echo $lang['name']; ?>&nbsp;<?php echo $name_arrow  ?></a></p></td>
						<td class="fileBar" width="100"><p><a href="<?php echo WP_WEB_DIRECTORY; ?>image.php<?php echo str_replace(array('sort_by='.$sort_by,'sort_dir='.$sort_dir), array('sort_by=type','sort_dir='.$type_sort_dir), $query_string) ?>"><?php echo $lang['type']; ?>&nbsp;<?php echo $type_arrow ?></a></p></td>
						<td class="fileBar" width="70" style="border-right: 1px solid threedshadow"><p><?php echo $lang['action']; ?></p>
							<p></p></td>
					</tr>
				</table>
				<div class="inset" style="height:315; width:100%; overflow:auto; background-color:#FFFFFF"> 
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<?php
display_folders();
display_files();

?>
					</table>
				</div>
				</fieldset></td>
			<td rowspan="3">&nbsp;</td>
			<td colspan="3" valign="top"> 
				<?php if ($upload_files) {?>
				<fieldset>
				<legend><?php echo $lang['upload_an_image']; ?></legend>
				<form style="display:inline" enctype="multipart/form-data" action="<?php echo WP_WEB_DIRECTORY; ?>image.php" method="post" onsubmit="showUploadMessage()">
					<input name="image_field" id="image_field" type="file" size="30" title="<?php echo $lang['click_browse']; ?>">
					<input type="submit" class="button" value="<?php echo $lang['upload_file']; ?>" onClick="return upload_check()">
					<?php echo $query_inputs; ?>
				</form>
				<p><?php echo wp_var_replace($lang['images_must_be'],array('max_size'=>$max_file_size/1000,'max_width'=>$max_image_width,'max_height'=>$max_image_height)) ?></p>
				</fieldset>
				<?php } else { echo '&nbsp;'; }?>
			</td>
		</tr>
		<tr> 
			<td colspan="3" align="right" valign="top"> <div align="center"> 
					<iframe id="preview" width="99%" height="170" frameborder="0" marginheight="0" marginwidth="0" class="previewWindow" src="<?php echo WP_WEB_DIRECTORY; ?>blank.php?lang=<?php echo $lang_include; ?>"></iframe>
				</div></td>
		</tr>
		<tr> 
			<td colspan="3" valign="top"> <form name="image_form" id="image_form" style="display:inline" onsubmit="return insert_image()">
					<fieldset>
					<legend><?php echo $lang['image_information']; ?></legend>
					<table height="60" border="0" cellspacing="3" cellpadding="1">
						<tr> 
							<td><?php echo $lang['source']; ?></td>
							<td width="100%"><input type="text" name="imagename" id="imagename" value="" style="width:220px" title="<?php echo $lang['type_image_address']; ?>"> 
							</td>
						</tr>
						<tr> 
							<td colspan="2"><span id="width"> </span> <input type="hidden" name="iwidth" size="4"> 
								&nbsp; <span id="height"> </span> <input type="hidden" name="iheight" id="iheight" size="4"> 
								&nbsp; <span id="size"> </span></td>
						</tr>
					</table>
					</fieldset>
					<div align="center"> 
						<?php
						if ($in_wp) {
						?>
						<p>&nbsp;</p>
						<button id="ok" type="submit"><?php echo $lang['ok']; ?></button>
						&nbsp; 
						<button type="button" onClick="parent.window.close();"><?php echo $lang['cancel']; ?></button>
						&nbsp; 
						<script type="text/javascript">
						<!--//
						if (!parentWindow.image_action) {
							document.write('<button disabled type="button" id="options" onClick="moreoptions()"><?php echo $lang['next']; ?></button>')
						}
						//-->
						</script>
						<?php } ?>
					</div>
				</form></td>
		</tr>
	</table>
</div>
</body>
</html>

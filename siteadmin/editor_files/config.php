<?php
defined('_VALID') or die('Restricted Access!');
require_once(dirname(dirname(dirname(__FILE__))). '/include/config.php');
$config['BASE_URL'] = ( strstr($config['BASE_URL'], '/siteadmin') ) ? dirname($config['BASE_URL']) : $config['BASE_URL'];
/* /////////////////////////////////////////////////////////////////////////
 *                                             config.php
 *                              -------------------
 *  author      : Chris Bolt
 *  copyright   : (C) Chris Bolt 2004. All Rights Reserved
 *  version     : 2.2.4
 *        purpose                 : WYSIWYG PRO PHP configuration file
///////////////////////////////////////////////////////////////////////////*/

// Installation of this software means that you agree to be bound by the terms of the enclosed license agreement.
// Make sure that you have read and understand the license before installing
// 
// EMOTICON COPYRIGHT NOTICE:  The animated emoticons provided with WysiwygPro are included under an agreement with the copyright holder, Bruce Corkhill and WebWizGuide.com.  
// Purchasing a WysiwygPro license allows you to use the animated emoticons ONLY as part of the WysiwygPro editor component. 
// Emoticons may not be used, copied or redistributed outside of the WysiwygPro product, without explicit permission from Bruce Corkhill.
// 
// Set the variables in this file to match your web-server setup.
// Variables marked with a ++ are essential and must be set before WysiwygPro can run (there is just one of these).
// Variables marked with a + are only needed to get the image and downloadable document managers running (there are 4 of these).
// All other variables can be left unchanged.
// 
// Need help setting up this file? email us: servie@wysiwygpro.om
// 
// You could also try pointing your web browser to [install location]editor_files/INSTALL_HELP.php


// -------------------------------------------------------------------------------
// WP_WEB_DIRECTORY ++
// Set this to the web address (URL) of your editor_files folder (the URL you'd type into a browser to get to this folder)
// This is the only variable that you MUST set to get WysiwygPro working!
// This variable should always end in a /
// 
// Examples:
// It could be a full web address like this:
// 
// define('WP_WEB_DIRECTORY', 'http://www.mysite.com/editor_files/');
// 
// Or it could be addressed from the document root like this:
// 
// define('WP_WEB_DIRECTORY', '/editor_files/');

define('WP_WEB_DIRECTORY', $config['BASE_URL']. '/siteadmin/editor_files/');


// -------------------------------------------------------------------------------
// Your Image directory
// The following two variables tell WysiwygPro where your directory for storing images is. 
// This enables WysiwygPro to manage your images. 
// Setting either of these variables to null will disable this feature.

// IMAGE_FILE_DIRECTORY +
// Set this to the file path path of your images folder.
// This value must end in a '/'
// 
// By default this variable is null, which means that this feature is disabled!
// 
// Examples: (actual file paths will vary between servers, check with you hosting company if unsure):
// 
// Windows:
// define('IMAGE_FILE_DIRECTORY', 'c:/html/users/mywebsite/html/images/');
// 
// Linux:
// define('IMAGE_FILE_DIRECTORY', '/var/httpd/htdocs/www.mywebsite.com/images/');


define('IMAGE_FILE_DIRECTORY', "$config[BASE_DIR]/images/");

// IMAGE_WEB_DIRECTORY +
// The web address of the folder specified above (the URL you'd type into a browser to get to your images folder).
// This variable should always end in a /
// 
// By default this variable is null, which means that this feature is disabled!
// 
// Examples:
// It could be a full web address like this:
// 
// define('IMAGE_WEB_DIRECTORY', 'http://www.mysite.com/images/');
// 
// Or it could be addressed from the document root like this:
// 
// define('IMAGE_WEB_DIRECTORY', '/images/');


define('IMAGE_WEB_DIRECTORY', "$config[BASE_URL]/images/");

// -------------------------------------------------------------------------------
// Your documents or downloads directory
// The following variables tell WysiwygPro where your directory of downloadable documents such as PDF and word files reside.
// This enables WysiwygPro to manage your downloadable documents.
// Setting either of these variables to null will disable this feature.

// DOCUMENT_FILE_DIRECTORY +
// Set this to the file path of your downloads folder.
// This value must end in a '/'
// 
// By default this variable is null, which means that this feature is disabled!
// 
// Examples: (actual file paths will vary between servers, check with you hosting company if unsure):
// 
// Windows:
// define('DOCUMENT_FILE_DIRECTORY', 'c:/html/users/mywebsite/html/downloads/');
// 
// Linux:
// define('DOCUMENT_FILE_DIRECTORY', '/var/httpd/htdocs/www.mywebsite.com/downloads/');


define('DOCUMENT_FILE_DIRECTORY', "$config[BASE_DIR]/tmp/downloads/");


// DOCUMENT_WEB_DIRECTORY +
// The web address of the folder specified above (the URL you'd type into a browser to get to your downloads folder).
// This variable should always end in a /
// 
// By default this variable is null, which means that this feature is disabled!
// 
// Examples:
// It could be a full web address like this:
// 
// define('DOCUMENT_WEB_DIRECTORY', 'http://www.mysite.com/downloads/');
// 
// Or it could be addressed from the document root like this:
// 
// define('DOCUMENT_WEB_DIRECTORY', '/downloads/');


define('DOCUMENT_WEB_DIRECTORY', "$config[BASE_URL]/tmp/downloads/");


// -------------------------------------------------------------------------------
// TRUSTED_DIRECTORIES
// You can override the file directories above at runtime using the set_image_dir and set_doc_dir API commands, but only if the directory is in the trusted directory array below!
// You could dynamically generating this array based on session variables.
// Or you could define the constants above based on session variables and then you wouldn't need to use this feature (see your manual for more!).


$trusted_directories = array(
        // Follow this format:
        // 'unique id' => array('file dir', 'web dir'),
        // Examples:
        // 'foo.com_images' => array('c:/html/users/foo.com/html/images/', 'http://www.foo.com/images/'), 
        // 'bar.com_images' => array($_SERVER['DOCUMENT_ROOT'].'/bar/', '/bar/'),
);


// -----------------------------------------------------
// Smilies
// If the following variables are set then WP will populate the insert smiley dialoge with smileys from the specified directory.
// Smiley images must be less than 32x32 in GIF or PNG format.
// Leave either of these variables null to use the default smiley set.

// SMILEY_FILE_DIRECTORY
// the full file path to the directory containing your smileys


define('SMILEY_FILE_DIRECTORY', null);


// SMILEY_WEB_DIRECTORY
// The web address of the directory you specified above


define('SMILEY_WEB_DIRECTORY', null);


// DEFAULT_LANG
// default language file to use.
// (You can change this in your scripts)


define('DEFAULT_LANG', 'en-us.php');                


// DOMAIN_ADDRESS
// The code below should set this automatically, there is no need to change this.
// If you do change it should be set to the address of your website e.g. http://www.mysite.com (no trailing /)


define('DOMAIN_ADDRESS', strtolower(substr($_SERVER['SERVER_PROTOCOL'],0,strpos($_SERVER['SERVER_PROTOCOL'],'/')) . (isset($_SERVER['HTTPS']) ? ($_SERVER['HTTPS'] == "on" ? 's://' : '://') : '://' ) . $_SERVER['SERVER_NAME'] ) );


// -----------------------------------------------------
// File types

// What types of images can be uploaded? Separate with a comma.
$image_types = '.jpg, .jpeg, .gif, .png';

// What types of documents can be uploaded? Separate with a comma.
$document_types = '.pdf, .doc, .rtf, .txt, .xl, .xls, .ppt, .pps, .zip, .tar, .swf, .wmv, .rm, .mov, .jpg, .jpeg, .gif, .png';

// -----------------------------------------------------
// File sizes

$max_image_width = 500;                         // maximum allowed width of uploaded images in pixels
$max_image_height = 500;                        // maximum allowed height of uploaded images in pixels
$max_file_size = 80000;                         // maximum allowed filesize for uploaded images upload in bytes
$max_documentfile_size = 2000000;               // maximum allowed filesize for uploaded documents in bytes

// -----------------------------------------------------
// File edting permissions
// Important Note: for security reasons these features are set to false by default 

$delete_files = false;                          // can users delete files? (be very careful with this one)
$delete_directories = false;                    // can users delete directories? (be even more careful with this one)
$create_directories = false;                    // can users create directories?
$rename_files = false;                          // can users re-name files?
$rename_directories = false;                    // can users rename directories?
$upload_files = false;                          // can users upload files??
$overwrite = false;                             // If users can upload and they upload a file with the same name as an existing file are they allowed to overwrite the existing file?


// -----------------------------------------------------
// Advanced variables, no need to change anything below unless something's not working!!! 

define('WP_FILE_DIRECTORY',  dirname(__FILE__) . '/');   // file path to this folder
define('SAVE_DIRECTORY', WP_FILE_DIRECTORY.'save/');     // where to store cached configurations
define('SAVE_LENGTH', 9000);                             // length of time to cache configurations for
define('NOCACHE', true);                                 // whether to send nocache headers to prevent proxy servers from sending the wrong content to browsers
define('CHMOD_MODE', 0);                                 // chmod settings for new directories, you shouldn't need to set this as settings should be inherited from the parent directory
 
//-----------------------------------------------------
// do not change anything below here!
define('WP_CONFIG', true);   
global $wp_has_been_previous;
$wp_has_been_previous = false;
?>

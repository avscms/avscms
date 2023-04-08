<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['blog_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';

$preview    = array();
$preview[]  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
$preview[]  = '<html xmlns="http://www.w3.org/1999/xhtml">';
$preview[]  = '<head>';
$preview[]  = '<title>Blog Preview</title>';
$preview[]  = '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>';
$preview[]  = '<link rel = "stylesheet" href = "' .$config['BASE_URL']. '/templates/frontend/' .$config['template']. '/css/bootstrap.css" rel="stylesheet" />';
$preview[]  = '<link rel = "stylesheet" href = "' .$config['BASE_URL']. '/templates/frontend/' .$config['template']. '/css/style.css" rel="stylesheet" />';
$preview[]  = '<link rel = "stylesheet" href = "' .$config['BASE_URL']. '/templates/frontend/' .$config['template']. '/css/responsive.css" rel="stylesheet" />';
$preview[]  = '</head>';
$preview[]  = '<body style="min-height: 0; padding-top: 10px; padding: 10px; overflow-x: hidden; overflow-y: auto;"';
$preview[]  = '<div class="blog_header"><span class="text-white">'.$lang['blog.title_here'].'</span></div>';
$preview[]  = '<div class="blog_content">';

$html       = NULL;
if ( isset($_POST['data']) ) {
    $filter     = new VFilter();
    $html       = $filter->get('data');
    
    $search     = array('/\[b\](.*?)\[\/b\]/ms', '/\[i\](.*?)\[\/i\]/ms', '/\[u\](.*?)\[\/u\]/ms',
                        '/\[img\](.*?)\[\/img\]/ms', '/\[email\](.*?)\[\/email\]/ms', '/\[url\="?(.*?)"?\](.*?)\[\/url\]/ms',
                        '/\[size\="?(.*?)"?\](.*?)\[\/size\]/ms', '/\[color\="?(.*?)"?\](.*?)\[\/color\]/ms', '/\[quote](.*?)\[\/quote\]/ms',
                        '/\[list\=(.*?)\](.*?)\[\/list\]/ms', '/\[list\](.*?)\[\/list\]/ms', '/\[\*\]\s?(.*?)\n/ms');
    $replace    = array('<strong>\1</strong>', '<em>\1</em>', '<u>\1</u>', '<img src="\1" alt="\1" />',
                        '<a href="mailto:\1">\1</a>', '<a href="\1">\2</a>', '<span style="font-size:\1%">\2</span>',
                        '<span style="color:\1">\2</span>', '<blockquote>\1</blockquote>', '<ol start="\1">\2</ol>',
                        '<ul>\1</ul>', '<li>\1</li>');
    $html    = preg_replace($search, $replace, $html);
    $html    = preg_replace('/\[photo=(.*?)\]/ms', '<div class="row"><div class="col-md-8 col-md-offset-2"><center><img src="' .$config['BASE_URL']. '/media/photos/tmb/\1.jpg" alt="" class="blog_image" /></center></div></div>', $html);
	$html    = preg_replace('/\[video=(.*?)\]/ms', '<div class="row"><div class="col-md-8 col-md-offset-2"><div class="blog_video"><div id="blog_video_\1"> <object type="application/x-shockwave-flash" data="' .$config['BASE_URL'].'/media/player/player.swf?f='.$config['BASE_URL']. '/media/player/config_blog.php?vkey=\1" width="100%" height="100%"> <video controls poster="' .$config['BASE_URL']. '/media/videos/tmb/\1/default.jpg" width="100%" height="100%"><source src="' .$config['BASE_URL']. '/mobile_src.php?id=\1" type="video/mp4">This video is not available on this platform.</video> <param name="movie" value="' .$config['BASE_URL'].'/media/player/player.swf?f='.$config['BASE_URL']. '/media/player/config_blog.php?vkey=\1" /> <param name="quality" value="high"/> <param name="allowFullScreen" value="true"/> <param name="allowScriptAccess" value="sameDomain"/> </object></div></div></div></div>', $html);
    $html    = str_replace("\r", "", $html);
    $html    = "<p>".preg_replace("/(\n)/", "</p><p>", $html)."</p>";
}

$preview[]  = $html;
$preview[]  = '</div>';
$preview[]  = '</body>';
$preview[]  = '</html>';

echo implode("\n", $preview);
die();
?>

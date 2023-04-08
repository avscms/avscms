<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/filter.class.php';

Auth::checkAdmin();

$exists = true;
$BID    = ( isset($_GET['BID']) && is_numeric($_GET['BID']) && blogExists($_GET['BID']) ) ? intval(trim($_GET['BID'])) : NULL;
if ( !$BID ) {
    $exists     = false;
    $errors[]   = 'Invalid blog identifier. Are you sure this blog exists!?';
}

if ( isset($_POST['submit_blog_edit']) && $exists ) {
    $filter         = new VFilter();
    $title          = $filter->get('title');
    $content        = $filter->get('content');
    $total_views    = $filter->get('total_views', 'INTEGER');
    $total_comments = $filter->get('total_comments', 'INTEGER');
    $total_links    = $filter->get('total_links', 'INTEGER');

    if ( $title == '' ) {
        $errors[]   = 'Blog title field cannot be blank!';
    } elseif ( strlen($title) > 99 ) {
        $errors[]   = 'Blot title cannot contain more then 99 characters!';
    }

    if ( $content == '' ) {
        $errors[]       = 'Blog content textarea cannot be blank!';
    } elseif ( strlen($content) > 999 ) {
        $errors[]       = 'Blog content cannot contain more then 999 characters!';
    }
    
    if ( !$errors ) {
        $search     = array('/\[b\](.*?)\[\/b\]/ms', '/\[i\](.*?)\[\/i\]/ms', '/\[u\](.*?)\[\/u\]/ms',
                            '/\[img\](.*?)\[\/img\]/ms', '/\[email\](.*?)\[\/email\]/ms', '/\[url\="?(.*?)"?\](.*?)\[\/url\]/ms',
                            '/\[size\="?(.*?)"?\](.*?)\[\/size\]/ms', '/\[color\="?(.*?)"?\](.*?)\[\/color\]/ms', '/\[quote](.*?)\[\/quote\]/ms',
                            '/\[list\=(.*?)\](.*?)\[\/list\]/ms', '/\[list\](.*?)\[\/list\]/ms', '/\[\*\]\s?(.*?)\n/ms');
        $replace    = array('<strong>\1</strong>', '<em>\1</em>', '<u>\1</u>', '<img src="\1" alt="\1" />',
                            '<a href="mailto:\1">\1</a>', '<a href="\1">\2</a>', '<span style="font-size:\1%">\2</span>',
                            '<span style="color:\1">\2</span>', '<blockquote>\1</blockquote>', '<ol start="\1">\2</ol>',
                            '<ul>\1</ul>', '<li>\1</li>');
        $content    = preg_replace($search, $replace, $content);
        $content    = preg_replace('/\[photo=(.*?)\]/ms', '<img src="' .$config['BASE_URL']. '/media/photos/tmb/\1.jpg" alt="" class="blog_image" />', $content);
		$content    = preg_replace('/\[video=(.*?)\]/ms', '<div class="blog_video"><div id="blog_video_\1"><embed src="' .$config['BASE_URL'].'/media/player/player.swf?f='.$config['BASE_URL']. '/media/player/config_blog.php?vkey=\1" quality="high" wmode="transparent" width="510" height="390" name="/AVS_video/avs" align="middle" allowFullScreen="true" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></div></div>', $content);
        $content    = str_replace("\r", "", $content);
        $content    = "<p>".preg_replace("/(\n)/", "</p><p>", $content)."</p>";
        $sql        = "UPDATE blog SET title = " .$conn->qStr($title). ", content = " .$conn->qStr($content). ",
                                       total_views = " .$total_views. ", total_comments = " .$total_comments. ", total_links = " .$total_links. "
                       WHERE BID = " .$BID. " LIMIT 1";
        $conn->execute($sql);
        $messages[] = 'Blog was successfully updated!';  
    }
}

if ( $exists ) {
    $sql        = "SELECT b.*, s.username FROM blog AS b, signup AS s
                   WHERE b.BID = " .$BID. " AND b.UID = s.UID LIMIT 1";
    $rs         = $conn->execute($sql);
    $blog       = $rs->getrows();
    $blog       = $blog['0'];
    
    $search     = array('/<strong>(.*?)<\/strong>/ms', '/<em>(.*?)<\/em>/ms', '/<u>(.*?)<\/u>/ms', '/<img src="(.*?)" alt="(.*?)" \/>/ms',
                    '/<a href="mailto:(.*?)">(.*?)<\/a>/ms', '/<a href="(.*?)">(.*?)<\/a>/ms', '/<span style="font-size:(.*?)%">(.*?)<\/span>/ms',
                    '/<span style="color:(.*?)">(.*?)<\/span>/ms', '/<blockquote>(.*?)<\/blockquote>/ms', '/<ol start="(.*?)">(.*?)<\/ol>/ms',
                    '/<ul>(.*?)<\/ul>/ms', '/<li>(.*?)<\/li>/ms');
    $replace    = array('[b]\1[/b]', '[i]\1[/i]', '[u]\1[/u]', '[img]\1[/img]', '[email]\1[/email]', '[url=\1]\2[/url]',
                    '[size=\1]\2[/size]', '[color=\1]\2[/color]', '[quote]\1[/quote]', '[list=\1]\2[/list]', '[list]\1[/list]', "[*] \1\n");
    $blog_base_url  = str_replace('/', '\/', $config['BASE_URL']);
    $blog['content'] = preg_replace('/<img src="' .$blog_base_url.'\/media\/photos\/tmb\/(.*?).jpg" alt="" class="blog_image" \/>/', '[photo=\1]', $blog['content']);
	$blog['content'] = preg_replace('/<div class="blog_video"><div id="blog_video_(.*?)"><embed src="' .$blog_base_url.'\/media\/player\/player.swf\?f='.$blog_base_url. '\/media\/player\/config_blog.php\?vkey=(.*?)" quality="high" wmode="transparent" width="510" height="390" name="\/AVS_video\/avs" align="middle" allowFullScreen="true" allowScriptAccess="sameDomain" type="application\/x-shockwave-flash" pluginspage="http:\/\/www.macromedia.com\/go\/getflashplayer" \/><\/div><\/div>/', '[video=\1]', $blog['content']);
    $blog['content'] = preg_replace($search, $replace, $blog['content']);
    $blog['content'] = preg_replace('/<p><\/p><p>(.*?)<\/p>/ms', "\n\n\1", $blog['content']);
    $blog['content'] = str_replace('<p>', '', $blog['content']);
    $blog['content'] = str_replace('</p>', '', $blog['content']);
}

$smarty->assign('editor', true);
$smarty->assign('editor_set', 'bbcode');
$smarty->assign('editor_skin', 'jtageditor');
$smarty->assign('blog', $blog);
?>

<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/auth.class.php';
require $config['BASE_DIR']. '/classes/filter.class.php';

if ( $config['blog_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$auth       = new Auth();
$auth->check();

$uid            = intval($_SESSION['uid']);
$username       = $_SESSION['username'];
$blog_title     = NULL;
$blog_content   = NULL;
if ( isset($_POST['blog_edit_submit']) ) {
    $filter     = new VFilter();
    $title      = $filter->get('blog_title');
    $content    = $_POST['blog_content'];
    
    if ( $title == '' ) {
        $errors[]   = $lang['blog.edit_title_empty'];
		$err['title'] = 1;
    } elseif ( strlen($title) > 100 ) {
        $errors[]   = $lang['blog.edit_title_big'];
		$err['title'] = 1;
    } else {
        $blog_title = $title;
    }
    
    if ( $content == '' ) {
        $errors[]       = $lang['blog.edit_content_empty'];
		$err['content'] = 1;
    } elseif ( strlen($content) > 10000 ) {
        $errors[]       = $lang['blog.edit_content_big'];
		$err['title'] = 1;
    } else {
        $blog_content   = $content;
    }
    
    if ( !$errors ) {
		//$content = strip_tags($content);
        $sql        = "UPDATE blog SET title = " .$conn->qStr($blog_title). ", 
                                       content = " .$conn->qStr($content). "
                       WHERE BID = " .$bid. " AND UID = " .$uid. " LIMIT 1";
        $conn->execute($sql);
        $_SESSION['message']    = 'Blog was sucessfully updated!';
        VRedirect::go($config['BASE_URL']. '/blog/' .$bid);
    }                                                                                                                                       
}

$sql            = "SELECT title, content FROM blog WHERE BID = " .$bid. " LIMIT 1";
$rs             = $conn->execute($sql);
$blog_title     = $rs->fields['title'];
$blog_base_url  = str_replace('/', '\/', $config['BASE_URL']);
$blog_content   = $rs->fields['content'];

$sql            = "SELECT * FROM signup WHERE UID = " .$uid. " LIMIT 1";
$rs             = $conn->execute($sql);
$user           = $rs->getrows();
$user           = $user['0'];

$smarty->assign('editor', true);
$smarty->assign('bid', $bid);
$smarty->assign('blog_title', $blog_title);
$smarty->assign('blog_content', $blog_content);
?>

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
$err['title'] 	= 0;

if ( isset($_POST['blog_add_submit']) ) {
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
		$status     = ($config['approve_blogs'] == '1') ? 0 : 1;
		//$content = strip_tags($content);
        $sql        = "INSERT INTO blog (UID, title, content, addtime, adddate, status)
                       VALUES (" .$uid. ", " .$conn->qStr($title). ", " .$conn->qStr($content). ",
                               " .time(). ", '" .date('Y-m-d'). "', '".$status."')";
        $conn->execute($sql);
        $bid        = $conn->insert_Id();
        $sql        = "UPDATE signup SET total_blogs = total_blogs+1, points = points+2 WHERE UID = " .$uid. " LIMIT 1";
        $conn->execute($sql);
        
        if ($config['approve_blogs'] == '1') {
    	    $messages[] = 'Created! Thank you for contributing ' .$config['site_name']. '. You will receive an email once your blog is published!';
        } else {
    	    $messages[] = 'Created! Thank you for contributing ' .$config['site_name']. '.
	    Check out your blog at <a href="' .$config['BASE_URL']. '/blog/'.$bid.'">' .htmlspecialchars($title, ENT_QUOTES, 'UTF-8'). '</a> in a minute!';    	                  
        }
        $blog_title = '';
        $blog_content = '';
    }                                                                                                                                       
}

$sql        = "SELECT * FROM signup WHERE UID = " .$uid. " LIMIT 1";
$rs         = $conn->execute($sql);
$user       = $rs->getrows();
$user       = $user['0'];

$smarty->assign('editor', true);
$smarty->assign('blog_title', $blog_title);
$smarty->assign('blog_content', $blog_content);
?>

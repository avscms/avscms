<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';

$sql_add	= NULL;
$sql_delim	= ' WHERE';
if ( $config['show_private_videos'] == '0' ) {
    $sql_add   .= $sql_delim. " type = 'public'";
    $sql_delim	= ' AND';
}

$sql_add       .= $sql_delim. " active = '1'";  

$sql            = "SELECT VID, title, duration, addtime, thumb, thumbs, vthumbs, viewnumber, rate, likes, dislikes, type, hd
                   FROM video" .$sql_add. " ORDER BY viewtime DESC LIMIT " .$config['watched_per_page'];
$rs             = $conn->execute($sql);
$viewed_videos  = $rs->getrows();
$viewed_total   = count($viewed_videos);
$sql            = "SELECT VID, title, duration, addtime, thumb, thumbs, vthumbs, viewnumber, rate, likes, dislikes, type, hd
                   FROM video" .$sql_add. " ORDER BY addtime DESC LIMIT " .$config['recent_per_page'];
$rs             = $conn->execute($sql);
$recent_videos  = $rs->getrows();

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('index', true);
$smarty->assign('viewed_total', $viewed_total);
$smarty->assign('viewed_videos', $viewed_videos);
$smarty->assign('recent_videos', $recent_videos);
$smarty->assign('self_title', $seo['index_title']);
$smarty->assign('self_description', $seo['index_desc']);
$smarty->assign('self_keywords', $seo['index_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('index.tpl');
$smarty->display('footer.tpl');
?>

<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';

$sql = "SELECT * FROM tags WHERE LENGTH(tag) > 2 AND counter >= 1 ORDER BY SUBSTR( tag, 1, 1 ) ASC, counter DESC";

$rs  = $conn->execute($sql);
$tags = $rs->getrows();
foreach ($tags as $k => $v) {
	$tags[$k]['name'] = str_replace(' ', '-', trim($v['tag']));
}

$self_title         = 'Most Popular Tags - ' .$config['site_name'];
$self_description   = 'Most Popular Tags - ' .$config['site_name'];
$title 				= 'Most Popular Tags - ' .$config['site_name'];	

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'tags');
$smarty->assign('tags', $tags);

$smarty->assign('title', $title);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_description', $self_description);
$smarty->assign('self_keywords', $self_keywords);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('tags.tpl');
$smarty->display('footer.tpl');

?>

<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/filter.class.php';
require 'classes/pagination.class.php';

$filter             = new VFilter();
$search_type        = get_request_arg('search', 'STRING');
$search_query       = get_request_arg($search_type, 'STRING');




$search_types       = array('videos', 'photos', 'users', 'tags');
if ( !in_array($search_type, $search_types) ) {
    VRedirect::go($config['BASE_URL']. '/notfound/invalid_search_type');
}
if ( !$search_query && isset($_POST['search_query']))  {
	$search_query  = $filter->get('search_query');
	$search_query_f = str_replace(' ', '-', $search_query);
    VRedirect::go($config['BASE_URL']. '/search/'.$search_type.'/'.$search_query_f);	
} else {
	$search_query  = $filter->xss_filter($search_query);
	$search_query_f = str_replace(' ', '-', $search_query);
}

if($search_type != "tags"){
$search_query_f = (str_replace('-', ' ', $search_query));
} else {
$search_query_f = $search_query;
}

$module             = 'modules/search/' .$search_type. '.php';
$module_template    = 'search_' .$search_type. '.tpl';

require $module;

$self_title         = strtoupper($search_type) . " - " . str_replace('{#search_query#}', $search_query, $seo['search_title']);

switch ($search_type) {
    case 'tags':
        $active_menu = 'tags';
        break;    
    case 'videos':
        $active_menu = 'videos';
        break;
    case 'photos':
        $active_menu = 'albums';
        break;
    case 'users':
        $active_menu = 'community';
        break;
}

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', $active_menu);
$smarty->assign('search_query', $search_query);
$smarty->assign('search_query_f', $search_query_f);
$smarty->assign('search_type', $search_type);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_description', $seo['search_desc']);
$smarty->assign('self_keywords', $seo['search_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display($module_template);
$smarty->display('footer.tpl');
?>

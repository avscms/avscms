<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/filter.class.php';

$page           = NULL;
$pages_allowed  = array('terms', 'privacy', 'dmca', '_2257', 'webmasters', 'advertise', 'faq');
$page           = get_request_arg('static', 'STRING');
$template   	= 'static/' .$page;
switch ( $page ) {
    case 'faq':
        $self_title = 'Freqvently Asked Questions';
        $break;
    case 'terms':
        $self_title = 'Terms & Conditions';
        break;
    case 'privacy':
        $self_title = 'Privacy Policy';
        break;
    case 'dmca':
        $self_title = 'DMCA';
        break;
    case '_2257':
        $self_title = NULL;
        $template   = 'static/2257';
        break;
    case 'webmasters':
        $self_title = 'Embed Videos';
        break;
    case 'advertise':
        $self_title = 'Advertise';
        break;
    default:
        VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');    
}

$self_title = ( isset($self_title) ) ? $self_title. ' - ' .$config['site_name'] : $config['site_name'];

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'home');
$smarty->assign('self_title', $self_title);
$smarty->assign('template', $template.'.tpl');
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('static.tpl');
$smarty->display('footer.tpl');
?>
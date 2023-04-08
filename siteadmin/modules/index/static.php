<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$allowed_pages  = array('2257.tpl', 'advertise.tpl', 'dmca.tpl', 'faq.tpl', 'privacy.tpl', 'terms.tpl', 'webmasters.tpl', 'whatis.tpl');
$page           = ( isset($_GET['page']) ) ? $_GET['page'] : '2257.tpl';
if ( !in_array($page, $allowed_pages) ) {
    $page     = NULL;
    $errors[] = 'Invalid page name!';
}

$file  = $config['BASE_DIR']. '/templates/frontend/'.$config['template'].'/static/'.$page;
$spage = file_get_contents($file);

if ( isset($_POST['submit_static']) && $page ) {
	
    $content = $_POST['page-content'];
    if ( file_exists($file) && is_file($file) && is_writable($file) ) {
		file_put_contents($file, $content);
        $messages[] = 'Static page was successfully updated!';
    } else {
		$errors[] = 'Static page not found or not writable (' .$file. ')!';
    }
	$spage = file_get_contents($file);
}

if ($page == 'whatis.tpl') {
	$warnings[] = 'It is not recommended to edit this page (whatis.tpl) using this editor! It contains html tags that are not editable here.';
}
$warnings[] = 'Please do not modify variable names or smarty tags - {example} (unless you really know what you\'re doing).';
$warnings[] = 'Editing file: <b>'.$page.'</b> from <b>'.$config['template'].'</b> template';	
	
$smarty->assign('warnings', $warnings);
$smarty->assign('page', $page);
$smarty->assign('spage', $spage);
$smarty->assign('editor', true);

?>

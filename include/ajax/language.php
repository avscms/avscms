<?php
defined('_VALID') or die('Restricted Access!');

if ($config['multi_language'] == '0') {
	die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/config.language.php';

$code 	= array();
$code[] = '<div class="btitle"><h2>'.$lang['global.SELECT_LANG'].'</h2></div>';
foreach ($languages as $key => $value) {
	$code[] = '<div class="language"><a href="#" id="'.$key.'" class="change_language"><img src="'.$config['BASE_URL'].'/templates/frontend/'.$config['template'].'/images/flags/'.$value['flag'].'" alt="'.$value['name'].'">'.$value['name'].'</a></div>';
}
$code[] = '<div class="clear_left"></div>';
$code[]	= '<form name="languageSelect" id="languageSelect" method="post" action="">';
$code[] = '<input name="language" id="language" type="hidden" value="" />';
$code[] = '</form>';

echo implode("\n", $code);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_admin.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'name' => 0, 'slug' => 0);

$filter = new VFilter();
$id     = $filter->get('id', 'INTEGER');
$type   = $filter->get('type', 'STRING');
$name   = trim($filter->get('name', 'STRING'));
$slug   = toAscii(trim($filter->get('slug', 'STRING')));
if ($slug == '') {
	$slug   = toAscii($name);	
}

switch ($type) {
    case 'Video':
			if (channelNameExists($name, $id)) {
				$response['name'] = 1;
			}
			if (channelSlugExists($slug, $id)) {
				$response['slug'] = 1;
			}
			$response['status'] = 1;
        break;	
    case 'Album':
			if (channelNameExists($name, $id, 'album')) {
				$response['name'] = 1;
			}
			if (channelSlugExists($slug, $id, 'album')) {
				$response['slug'] = 1;
			}
			$response['status'] = 1;	
        break;
    case 'Game':
			if (channelNameExists($name, $id, 'game')) {
				$response['name'] = 1;
			}
			if (channelSlugExists($slug, $id, 'game')) {
				$response['slug'] = 1;
			}
			$response['status'] = 1;
        break;
    case 'Notice':
			if (channelNameExists($name, $id, 'notice')) {
				$response['name'] = 1;
			}
			$response['status'] = 1;
        break;		
}

echo json_encode($response);
die();
?>

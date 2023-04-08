<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_admin.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'name' => '', 'slug' => '', 'errors' => '');

$data = (array) $_POST['data'];

$id      = trim($data['id']);
$type    = trim($data['type']);
$name    = trim($data['name']);
$slug    = toAscii(trim($data['slug']));
$counter = $data['counter'];
$querry_add = '';
$total = NULL;

if ($slug == '') {
	$slug = toAscii($name);	
}

settype($id, 'integer');

switch ($type) {
    case 'Video':
		if (!channelNameExists($name, $id) && !channelSlugExists($slug, $id)) {			
			if ($counter) {
				$total = channelCountItems($id);
				$querry_add = ", total_videos = " .$conn->qStr($total). "";
			}			
			$sql = "UPDATE channel SET name = " .$conn->qStr($name). ", slug = " .$conn->qStr($slug). "" .$querry_add. " WHERE CHID = " .$conn->qStr($id). " LIMIT 1";
			$conn->execute($sql);

			$response['status'] = 1;			
		}
        break;	
    case 'Album':
		if (!channelNameExists($name, $id, 'album') && !channelSlugExists($slug, $id, 'album')) {			
			if ($counter) {
				$total = channelCountItems($id, 'album');
				$querry_add = ", total_albums = " .$conn->qStr($total). "";
			}			
			$sql = "UPDATE album_categories SET name = " .$conn->qStr($name). ", slug = " .$conn->qStr($slug). "" .$querry_add. " WHERE CID = " .$conn->qStr($id). " LIMIT 1";
			$conn->execute($sql);

			$response['status'] = 1;			
		}	
        break;
    case 'Game':
		if (!channelNameExists($name, $id, 'game') && !channelSlugExists($slug, $id, 'game')) {			
			if ($counter) {
				$total = channelCountItems($id, 'game');
				$querry_add = ", total_games = '" .$conn->qStr($total). "'";
			}			
			$sql = "UPDATE game_categories SET category_name = " .$conn->qStr($name). ", slug = " .$conn->qStr($slug). "" .$querry_add. " WHERE category_id = " .$conn->qStr($id). " LIMIT 1";
			$conn->execute($sql);

			$response['status'] = 1;			
		}	
        break;
    case 'Notice':
		if (!channelNameExists($name, $id, 'notice')) {			
			$status = trim($data['active']);
			if ($counter) {
				$total = channelCountItems($id, 'notice');
				$querry_add = ", total_notices = '" .$conn->qStr($total). "'";
			}			
			$sql = "UPDATE notice_categories SET name = " .$conn->qStr($name). ", status = " .$conn->qStr($status). "" .$querry_add. " WHERE category_id = " .$conn->qStr($id). " LIMIT 1";
			$conn->execute($sql);

			$response['status'] = 1;			
		}	
        break;			
}

$response['name'] = $name;
$response['slug'] = $slug;
$response['total'] = $total;

echo json_encode($response);
die();
?>

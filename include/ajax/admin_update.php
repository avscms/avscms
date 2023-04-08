<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/function_update.php';

require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

$response = array('status' => 0, 'msg'=> '');
$filter  = new VFilter();
$action     = $filter->get('action');
$filename     = $filter->get('filename');
$filename = preg_replace('/\b(?:https?|ftp):\/\/\S+/', '', $filename);
$filename = preg_replace('/[^\w.-]/', '', $filename);

if ($action == "download_update") {

	if (strtolower(substr($filename, -4)) !== '.zip') {
		$response['status'] = -1;
		$response['msg'] = "Invalid update files";
	} else {
		$download_status = download_update($filename);
		if ($download_status) {
			$response['status'] = 1;
			$response['msg'] = $filename." saved to ".$config['BASE_DIR']."/tmp/update/ - [OK]"; 
		} else {
			$response['status'] = -1;
			$response['msg'] = "Failed to save files to server.";			
		}
	}
} else if ($action == "extract_update") {
	if (strtolower(substr($filename, -4)) !== '.zip') {
		$response['status'] = -1;
		$response['msg'] = "Invalid update files";
	} else {
		if (!extension_loaded('zip')) {
			$response['status'] = -1;
			$response['msg'] = "Zip extention is not installed on php, please install it first.";		
		} else {
			$unzip_status = extract_update($filename);
			if ($unzip_status) {
				$response['status'] = 1;
				$response['msg'] = $filename." successfully unzipped to ".$config['BASE_DIR']."/ - [OK]"; 
			} else {
				$response['status'] = -1;
				$response['msg'] = "Failed to unzip update file :".$filename;			
			}			
		}		
	}		
} else if ($action == "check_sql") {
	$isExsit = check_sql_update_exist();
	if ($isExsit)
	{
		$response['status'] = 1;
		$response['msg'] = "update_sql.php are exist on path:".$config['BASE_DIR']."/tmp/update/ - [OK]";		
	} else {
		$response['status'] = 2;
		$response['msg'] = "update_sql.php does not exist on path:".$config['BASE_DIR']."/tmp/update/ - [Skipping]";			
	}
} else if ($action == "update_sql") {
	$myArr = run_sql_update();
	$response['status'] = 1;
	foreach ($myArr as $val) {
		$response['msg'] .= $val[0].$val[1].'<br>';
	}
}

echo json_encode($response);
die();
?>
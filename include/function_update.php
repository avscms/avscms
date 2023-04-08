<?php
defined('_VALID') or die('Restricted Access!');

require_once ($config['BASE_DIR']. '/classes/curl.class.php');

function getversion()
{
    $curl = new VCurl();
	$rand = mt_rand();
	$update_url = base64_decode("aHR0cHM6Ly91cGRhdGUuYXZzY21zLmNvbQ==")."/version.txt?r=".$rand;
	$version = $curl->get_update_version($update_url);
	return $version;    
}

function download_update($filename)
{
	global $config;
    $curl = new VCurl();
	$rand = mt_rand();
	$download_status = false;
	$file_url = base64_decode("aHR0cHM6Ly91cGRhdGUuYXZzY21zLmNvbQ==")."/files/".$filename."?r=".$rand;
	$save_path = $config['BASE_DIR'].'/tmp/update/';

	if(!$curl->get_update_file($file_url, $save_path, $filename)) {
		$download_status = false;
	} else {
		$download_status = true;
	}
	return $download_status;    
}

function extract_update($filename)
{
	global $config;
	$save_path = $config['BASE_DIR'].'/tmp/update/';
	$unzip_to_path = $config['BASE_DIR'].'/';
	$zip_fullpath = $save_path.$filename;
	$unzip_status = false;
	
	$zip = new ZipArchive;
	$res = $zip->open($zip_fullpath);
	if ($res === TRUE) {
		$zip->extractTo($unzip_to_path);
		$zip->close();
		$unzip_status = true;
		@unlink($zip_fullpath);
	} else {
		$unzip_status = false;
	}

	return $unzip_status;
}

function remove_previous_update_sql()
{
	global $config;
	$save_path = $config['BASE_DIR'].'/tmp/update/';
	$db_updater_file = 'update_sql.php';
	$db_updater_fullpath = $save_path.$db_updater_file;

	if (is_file($db_updater_fullpath)) {
		@unlink($db_updater_fullpath);
	} 	
}

function check_sql_update_exist()
{
	global $config;
	$save_path = $config['BASE_DIR'].'/tmp/update/';
	$db_updater_file = 'update_sql.php';
	$db_updater_fullpath = $save_path.$db_updater_file;

	$isExist = false;
	if (is_file($db_updater_fullpath)) {
		$isExist = true;
	} else {
		$isExist = false;
	}
	return $isExist;
}

function run_sql_update()
{

	global $config;
	$save_path = $config['BASE_DIR'].'/tmp/update/';
	$db_updater_file = 'update_sql.php';
	$db_updater_fullpath = $save_path.$db_updater_file;

	$sql_task = array(); 	
	if (is_file($db_updater_fullpath)) {

		require_once($config['BASE_DIR']. '/include/adodb/adodb.inc.php');
		require_once($config['BASE_DIR']. '/include/dbconn.php');		
		require_once($db_updater_fullpath);
		
		foreach ($sql_update as $val) {
			$result = $conn->execute($val[1]);
			if ($result) {
				$sql_task[] =array($val[0], " - [OK]");
			} else {
				$sql_task[] =array($val[0], " - [Failed]");
			}				
		}		
		@unlink($db_updater_fullpath);
	} 

	return $sql_task;
}

?>
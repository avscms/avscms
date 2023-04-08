<?php
defined('_VALID') or die('Restricted Access!');
function get_server()
{
    global $conn;

	$sql = "SELECT * FROM servers WHERE status = '1' ORDER BY last_used ASC";
	$rs  = $conn->execute($sql);
	if ($conn->Affected_Rows()) {
		$servers = $rs->getrows();
		foreach ($servers as $server) {
			if ($server['current_used'] = '1') {
				continue;
			} else {
				return $server;
			}
		}
		
		return $servers['0'];
	} else {
		die('Failed to find a active server! Please check your settings!');
	}
}

function update_server_used($server)
{
	global $conn;
	$conn->execute("UPDATE servers SET current_used = '1' WHERE server_id = ".$server['server_id']." LIMIT 1");
}

function update_server($server)
{
	global $conn;
	$conn->execute("UPDATE servers SET last_used = '".date('Y-m-d h:i:is')."', current_used = '0'
	                WHERE server_id = ".$server['server_id']." LIMIT 1");
}

function upload_video($flv, $ip, $username, $password, $ftp_root)
{
	$conn_id    = ftp_connect($ip);
	$ftp_login  = ftp_login($conn_id, $username, $password);
	if ( !$conn_id or !$ftp_login ) {
        die('Failed to connect to FTP server!');
    }

	ftp_pasv($conn_id, 1);
    if ( !ftp_chdir($conn_id, $ftp_root) ) {
        die('Failed to change directory to: ' .$ftp_root);
    }
	
	if (file_exists($flv)) {
		$filename = basename($flv);
		ftp_delete($conn_id, $filename);
		ftp_put($conn_id, $filename, $flv, FTP_BINARY);
		ftp_site($conn_id, sprintf('CHMOD %u %s', 777, $filename));
	}
	
	ftp_close($conn_id);
}
?>

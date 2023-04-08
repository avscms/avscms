<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/validation.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$response = array('status' => 0, 'connected' => 0, 'existing' => 0, 'username' => '');

$filter   = new VFilter();
$valid    = new VValidation();
$email    = $filter->get('email');
$id       = $filter->get('id');
$fname    = $filter->get('fname');
$lname    = $filter->get('lname');

unset($_SESSION['fb_signup_email']);

$sql  = "SELECT * FROM signup WHERE FBID = " .$conn->qStr($id). " LIMIT 1";
$rs   = $conn->execute($sql);
$FBID = $rs->fields['FBID'];
if ($id == $FBID) {	
	$response['connected'] = 1;

	//Login User
	$user   = $rs->getrows();
	$yesterday  = time() - 86400;
	if ( intval($user['0']['logintime']) < $yesterday ) {
		$sql_add = ", points = points+5";
	}
	$sql    = "UPDATE signup SET logintime = '" .time(). "' WHERE FBID = " .$conn->qStr($FBID). " LIMIT 1";
	$conn->execute($sql);
	$_SESSION['uid']            = $user['0']['UID'];
	if ($user['0']['premium'] == '1') {
		$_SESSION['uid_premium'] = 1;
	}
	$_SESSION['username']       = $user['0']['username'];
	$_SESSION['email']          = $user['0']['email'];
	$_SESSION['emailverified']  = $user['0']['emailverified'];
	$_SESSION['photo']          = $user['0']['photo'];
	$_SESSION['fname']          = $user['0']['fname'];
	$_SESSION['gender']         = $user['0']['gender'];
	if ($user['0']['fname']) {
		$_SESSION['message']        = 'Welcome, ' .$user['0']['fname']. '!';
	} else {
		$_SESSION['message']        = 'Welcome, ' .$user['0']['username']. '!';
	}
} else {
	if ( $valid->emailExists($email) ) {
		$response['existing'] = 1;
		$sql = "SELECT * FROM signup WHERE email = " .$conn->qStr($email). " LIMIT 1";
		$rs = $conn->execute($sql);
		if ($conn->Affected_Rows()) {
			$response['username'] = $rs->fields['username'];
		}	
	} else {
		$response['existing'] = 0;	
		$fname = explode(' ',trim($fname));
		$username = trim(strtolower($fname[0]));
		$username = preg_replace("/[^A-Za-z0-9 ]/", '', $username);
		if (!ctype_alnum($username) || strlen($username) < 2) {
			$username = implode('@', explode('@', $email, -1));
			$username = preg_replace("/[^A-Za-z0-9 ]/", '', $username);	
		}
		if (strlen($username) > 10) {
			$username = substr($username, 0, 10);
		}
		if ($valid->usernameExists($username)) {
			$lname = trim(strtolower($lname));
			$lname = preg_replace("/[^A-Za-z0-9 ]/", '', $lname);	
			$lname = substr($lname, 0, 1);
			if (ctype_alnum($lname)) {
				$username = $username.$lname;
				if(!$valid->usernameExists($username)) {			
					$response['username'] = $username;
				} else {
					$i = 0;
					$found = false;
					while (!$found) {
						$i++;			
						$username = $username.$i;
						if(!$valid->usernameExists($username)) {
							$found = true;
							$response['username'] = $username;
						}
					}
				}
			}
		} else {
			$response['username'] = $username;		
		}
	}
	$_SESSION['fb_signup_email'] = $email;
}

$response['status'] = 1;
echo json_encode($response);
die();
?>

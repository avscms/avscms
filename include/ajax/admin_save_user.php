<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/auth.class.php';
Auth::checkAdmin();

function nl2br2($string) { 
	$string = str_replace(array("\\r\\n", "\\r", "\\n"), "\n", $string);
	return $string; 
} 

$response = array('status' => 0);

$data = (array) $_POST['data'];

//Acount
$uid              = trim($data['id']);
$email            = trim($data['email']);
$emailverified    = trim($data['emailverified']);
$premium          = trim($data['premium']);
$account_status   = trim($data['account_status']);
$likes            = trim($data['likes']);
$dislikes         = trim($data['dislikes']);
$profile_viewed   = trim($data['viewnumber']);
$video_viewed     = trim($data['video_viewed']);
$watched_video    = trim($data['watched_video']);
$password         = trim($data['password']);
$password_confirm = trim($data['password_confirm']);
//Personal
$fname           = trim($data['fname']);
$lname           = trim($data['lname']);      
$gender          = trim($data['gender']);      
$relation        = trim($data['relationship']);      
$interested      = trim($data['interested']); 
//Location
$town            = trim($data['town']);     
$city            = trim($data['city']);     
$country         = trim($data['country']); 
//Profile    
$website         = trim($data['website']);     
$aboutme         = trim($data['aboutme']);     
$occupation      = trim($data['occupation']);     
$company         = trim($data['company']);     
$school          = trim($data['school']);
$interest_hobby  = trim($data['interest_hobby']);
$fav_movie_show  = trim($data['fav_movie_show']);
$fav_music       = trim($data['fav_music']);
$fav_book        = trim($data['fav_book']);
$turnon          = trim($data['turnon']);
$turnoff         = trim($data['turnoff']);

settype($uid, 'integer');
settype($profile_viewed, 'integer');
settype($video_viewed, 'integer');
settype($watched_video, 'integer');
settype($likes, 'integer');
settype($dislikes, 'integer');

if ( $likes != 0 || $dislikes !=0)
	$rate = round(($likes * 100)/($likes + $dislikes));
else
	$rate = 0;

$sql_add = NULL;  
if ( $password != '' ) {
	$passwd 	= md5($password);
	$sql_add 	= " ,pwd = '" .$passwd. "'";
}

$sql = "UPDATE signup SET fname = " .$conn->qStr($fname). ", lname = " .$conn->qStr($lname). ", 
						  premium = ".$conn->qStr($premium).", email = " .$conn->qStr($email). ", 
						  gender = " .$conn->qStr($gender). ", relation = " .$conn->qStr($relation). ",
					      interested = " .$conn->qStr($interested). ", 
						  aboutme = " .nl2br2($conn->qStr($aboutme)). ", town = " .$conn->qStr($town). ", 
						  city = " .$conn->qStr($city). ", country = " .$conn->qStr($country). ", 
						  occupation = " .nl2br2($conn->qStr($occupation)). ", company = " .nl2br2($conn->qStr($company)). ",
						  school = " .nl2br2($conn->qStr($school)). ", interest_hobby = " .nl2br2($conn->qStr($interest_hobby)). ",
						  fav_movie_show = " .nl2br2($conn->qStr($fav_movie_show)). ", fav_music = " .nl2br2($conn->qStr($fav_music)). ", 
						  turnon = " .nl2br2($conn->qStr($turnon)). ", turnoff = " .nl2br2($conn->qStr($turnoff)). ",
						  fav_book = " .nl2br2($conn->qStr($fav_book)). ", website = " .$conn->qStr($website). ",
						  video_viewed = " .$conn->qStr($video_viewed). ", profile_viewed = " .$conn->qStr($profile_viewed). ",
						  watched_video = " .$conn->qStr($watched_video). ", emailverified = " .$conn->qStr($emailverified). ",
						  likes = " .$conn->qStr($likes). ", dislikes = " .$conn->qStr($dislikes). ", 
						  rate = " .$conn->qStr($rate). ", account_status = " .$conn->qStr($account_status). "" 
						  .$sql_add. " WHERE UID = " .$conn->qStr($uid). " LIMIT 1";

$conn->execute($sql);
$response['status'] = 1;
echo json_encode($response);
die();
?>

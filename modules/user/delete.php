<?php
defined('_VALID') or die('Restricted Access!');

if ( isset($_POST['delete_yes']) && isset($_POST['confirm_delete']) ) {
    $uid = intval($_SESSION['uid']);	
    $sql        = "SELECT UID FROM signup WHERE account_status = 'Active' AND UID <> '".$uid."' ORDER BY UID ASC LIMIT 1";
    $rs         = $conn->execute($sql);
    $anon_uid   = intval($rs->fields['UID']);
    

	//REMOVE TOTAL COMMENTS
		//update total comments - blogs
		$sql = "SELECT BID FROM blog_comments WHERE UID = " .$uid;
		$rs = $conn->execute($sql);
		foreach ($rs as $value) {
			$sql        = "UPDATE blog SET total_comments = total_comments-1 WHERE BID = " .$value['BID'];
			$conn->execute($sql);
		}
		
		//update total comments - photos / albums
		$sql = "SELECT PID FROM photo_comments WHERE UID = " .$uid;
		$rs = $conn->execute($sql);
		foreach ($rs as $value) {
			$sql        = "UPDATE photos SET total_comments = total_comments-1 WHERE PID = " .$value['PID'];
			$conn->execute($sql);
			$sql = "SELECT AID FROM photos WHERE PID = " .$value['PID']. " LIMIT 1";
			$rsa = $conn->execute($sql);
			$a_id   = intval($rsa->fields['AID']);
			$sql        = "UPDATE albums SET total_comments = total_comments-1 WHERE AID = " .$a_id;
			$conn->execute($sql);			
		}

		//update total comments - videos
		$sql = "SELECT VID FROM video_comments WHERE UID = " .$uid;
		$rs = $conn->execute($sql);
		foreach ($rs as $value) {
			$sql        = "UPDATE video SET total_comments = total_comments-1 WHERE VID = " .$value['VID'];
			$conn->execute($sql);
		}		
	//END REMOVE TOTAL COMMENTS
	

    if ($anon_uid > 0) {		
    $sql        = "UPDATE video SET UID = " .$anon_uid. " WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "UPDATE albums SET UID = " .$anon_uid. " WHERE UID = " .$uid;
    $conn->execute($sql);
    } else { //delete all if no user exist on the system

	//REMOVE VIDEO TAGS
		$sql = "SELECT keyword FROM video WHERE UID = " .$uid;
		$rs = $conn->execute($sql);
		foreach ($rs as $value) {
			$keyword = $value['keyword'];
			if ($keyword !== '') {	
				$searchForValue = ',';
				$stringValue = $keyword;

				if( strpos($stringValue, $searchForValue) !== false ) {
				   $var=explode(',',$keyword);
				   foreach($var as $value)
				    {
				    remove_tags($value);
				    }
				     	
				} else {
					remove_tags($keyword);
				}
			}
		}
	//END OF REMOVE VIDEO TAGS
	
	//remove photo from albums
	$sql = "SELECT AID FROM albums WHERE UID = ".$uid;
	$result = $conn->execute($sql);
	foreach ($result as $value) {
		$sql = "DELETE FROM photos where AID = ".$value['AID'];
		$conn->execute($sql);
	}
	//END of remove photo
	    //delete master table	
	    $sql        = "DELETE FROM video WHERE UID = " .$uid;
	    $conn->execute($sql);	
	    $sql        = "DELETE FROM albums WHERE UID = " .$uid;
	    $conn->execute($sql);
    }
    
    $sql        = "DELETE FROM blog WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM signup WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM users_prefs WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM blog_comments WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM notice_comments WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM photo_comments WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM video_comments WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM wall WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM confirm WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM favourite WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM friends WHERE UID = " .$uid;
    $conn->execute($sql);		
    $sql        = "DELETE FROM notice WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM photo_favorites WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM photo_flags WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM photo_rating_id WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM playlist WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM spam WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM users_blocks WHERE UID = " .$uid;
    $conn->execute($sql);
    $sql        = "DELETE FROM users_flags WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM users_online WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM users_rating_id WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM video_comments WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM video_flags WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM video_subscribe WHERE UID = " .$uid;
    $conn->execute($sql);	
    $sql        = "DELETE FROM video_vote_users WHERE UID = " .$uid;
    $conn->execute($sql);

	//delete avatar
	$file = $config['BASE_DIR'].'/media/users/'.$uid.'.jpg';
	if ( file_exists($file) ) {
		@chmod($file, 0777);
		@unlink($file);
	}	

	$file = $config['BASE_DIR'].'/media/users/orig/'.$uid.'.jpg';
	if ( file_exists($file) ) {
		@chmod($file, 0777);
		@unlink($file);
	}		
	
    unset($_SESSION['uid']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['emailverified']);
    unset($_SESSION['photo']);
    unset($_SESSION['fname']);
    unset($_SESSION['gender']);
    $_SESSION['message'] = $lang['user.delete_success'];
    VRedirect::go($config['BASE_URL']);
}

if ( isset($_POST['delete_no']) ) {
    $_SESSION['message'] = $lang['user.delete_keep'];
    VRedirect::go($config['BASE_URL']. '/user');
}

$self_title = $lang['user.delete_self'];
?>

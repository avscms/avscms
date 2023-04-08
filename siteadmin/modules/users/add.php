<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/validation.class.php';
require $config['BASE_DIR']. '/classes/email.class.php';	

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function process_thumb($src, $dst_w, $dst_h, $keep_ar = true) {

    $image      = new VImageConv();
	list ($width, $height) = getimagesize($src);
	
	if($keep_ar) {
		$aspect_src = $width/$height;
		$aspect_dst = $dst_w/$dst_h;
		
		if ($aspect_src < $aspect_dst) {
			$crop_w = $width;		
			$crop_h = floor(($dst_h*$width)/$dst_w);
			$crop_x = 0;
			$crop_y = floor (($height - $crop_h)/2);
		}
		else {
			$crop_w = floor(($dst_w*$height)/$dst_h);
			$crop_h = $height;
			$crop_x = floor (($width - $crop_w)/2);
			$crop_y = 0;		
		}
		$image->process($src, $src, 'EXACT', $crop_w, $crop_h);
		$image->crop($crop_x, $crop_y, $crop_w, $crop_h, true);
	}
	$image->process($src, $src, 'EXACT', $dst_w, $dst_h);
	$image->resize(true, true);

}

$user = array('username' => '', 'email' => '', 'emailverified' => 'yes', 'account_status' => 'Active',
              'fname' => '', 'lname' => '', 'gender' => 'Male');
if ( isset($_POST['add_user']) ) {
	
	$avatar             = false;
    $filter             = new VFilter();
    $valid              = new VValidation();
	$username			= $filter->get('username');
    $email              = $filter->get('email');
    $fname              = $filter->get('fname');
    $lname              = $filter->get('lname');
    $gender             = $filter->get('gender');
    $relation           = $filter->get('relation');
	$password           = $filter->get('password');
    $password_confirm   = $filter->get('password_confirm');
	$account_status		= $filter->get('account_status');
    $emailverified      = $filter->get('emailverified');	
	
	if ( $username == '' ) {		
		$errors[] = 'Username field cannot be blank!';
		$err['username'] = 1;
	} elseif ( !$valid->username($username) ) {
		$errors[] = 'Username field is not a valid username!';
		$err['username'] = 1;		
	} elseif ( $valid->usernameExists($username) ) {
		$errors[] = 'Username is already used by another user!';
		$err['username'] = 1;		
	}
	$user['username'] = $username;

	
	if ( $email == '' ) {
  		$errors[] = 'Email field cannot be blank!';
		$err['email'] = 1;		
    } elseif ( !$valid->email($email) ) {		
        $errors[] = 'Email is not a valid email address!';
		$err['email'] = 1;	
    } elseif ( $valid->emailExists($email) ) {
        $errors[] = 'Email is already used by another user!';
		$err['email'] = 1;			
    }
	$user['email'] = $email;

	
	if ( $password != '' && $password != $password_confirm ) {
  		$errors[] = 'Password and confirmation password are not the same!';
		$err['password'] = 1;
		$err['password_confirm'] = 1;		
    }
	
	$user['fname']			= $fname;
	$user['lname']			= $lname;
	$user['gender']			= $gender;
	$user['account_status']	= $account_status;
	$user['emailverified']  = $emailverified;
	
	if ( !$errors ) {

        if ( $_FILES['user_thumb']['tmp_name'] != '' ) {
            $avatar = true;
			if ( !is_uploaded_file($_FILES['user_thumb']['tmp_name']) ) {
				$errors[]   = 'User avatar is not a valid uploaded file!';
			} else {
				$tmb_filename           = substr($_FILES['user_thumb']['name'], strrpos($_FILES['user_thumb']['name'], DIRECTORY_SEPARATOR)+1);
				$tmb_extension          = strtolower(substr($tmb_filename, strrpos($tmb_filename, '.')+1));
				$tmb_allowed_extensions = explode(',', $config['image_allowed_extensions']);
				if ( !in_array($tmb_extension, $tmb_allowed_extensions) ) {
					$errors[]           = 'Invalid avatar image extension!';
				}
			}
		}
		
		if ($password == '') {
			$password_clear     = generateRandomString();
		} else {
			$password_clear = $password;
		}
		$password           = md5($password_clear);			

		$smarty->assign('username', $username);
		$smarty->assign('password', $password_clear);		
		
		$sql	= "INSERT INTO signup SET username = " .$conn->qStr($username). ", email = " .$conn->qStr($email). ",
		                                  pwd = '" .$password. "', fname = " .$conn->qStr($fname). ",
										  lname = " .$conn->qStr($lname). ", gender = " .$conn->qStr($gender). ", 
										  emailverified = " .$conn->qStr($emailverified). ", account_status = " .$conn->qStr($account_status). ", 
										  addtime = '" .time(). "', logintime = '" .time(). "'";
		$conn->execute($sql);

        $uid            = $conn->insert_Id();
		
        $sql            = "INSERT INTO users_prefs (UID) VALUES (" .$uid. ")";
        $conn->execute($sql);
        $sql            = "INSERT INTO users_online (UID, online) VALUES (" .$uid. ", " .time(). ")";
        $conn->execute($sql);		

		if ($avatar) {
			$orig    = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
			if ( !move_uploaded_file($_FILES['user_thumb']['tmp_name'], $orig) ) {
				$errors[] = 'Failed to move uploaded avatar file!';
			} else {
				require $config['BASE_DIR']. '/classes/image.class.php';				
				$dst    = $config['BASE_DIR']. '/media/users/' .$uid. '.jpg';
				if(copy($orig, $dst)) {
					process_thumb($dst, 500, 500);
					if ( file_exists($dst) && filesize($dst) > 100 ) {
						$sql    = "UPDATE signup SET photo = '" .$uid. ".jpg' WHERE UID = " .$uid. " LIMIT 1";
						$conn->execute($sql);
					}
				}				
			}
		}	
		
		$sql            = "SELECT email_subject, email_path FROM emailinfo
						   WHERE email_id = 'welcome' LIMIT 1";
		$rs             = $conn->execute($sql);		
		$email_subject  = str_replace('{$site_title}', $config['site_title'], $rs->fields['email_subject']);
		$email_path     = $rs->fields['email_path'];
		$body           = $smarty->fetch($config['BASE_DIR'].'/templates/'.$email_path);		

		$mail           = new VMail();
		$mail->setNoReply();		
		$mail->Subject  = $email_subject;
		$mail->AltBody  = $body;
		$mail->Body     = nl2br($body);
		$mail->AddAddress($email);
		$mail->Send();
			
		$messages[] = 'User was successfully added!';
		
	}
}

$smarty->assign('user', $user);
?>

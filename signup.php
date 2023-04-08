<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'classes/filter.class.php';
require 'classes/validation.class.php';
require 'include/function_smarty.php';
require 'classes/email.class.php';
require 'classes/curl.class.php';
require 'classes/image.class.php';

if ( $config['user_registration'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/registration_disabled');
}

if ( isset($_POST['fb-signup-submit-new']) ) {
	
	//FB new user
	$filter             = new VFilter();
	$valid              = new VValidation();
	$id                 = $filter->get('fb-signup-id');	
	$username           = $filter->get('fb-signup-username');
	$password_clear     = generateRandomString();
	$password           = md5($password_clear);
	$email              = $filter->get('fb-signup-email');
	$fname              = $filter->get('fb-signup-first-name');
	$lname              = $filter->get('fb-signup-last-name');
	$age_min            = $filter->get('fb-signup-age-min', 'INTEGER');
	$gender             = ucfirst($filter->get('fb-signup-gender'));
	$use_pp             = $filter->get('fb-signup-usepp');
	
	if ($use_pp != '') {
		$picture = $_POST['fb-signup-picture'];
	}
	if ($email != $_SESSION['fb_signup_email']) {
		$errors[] = $lang['signup.email_invalid'];
	}	
	if ( $username == '' ) {
		$errors[] = $lang['socialsignup.user_format_error'];
	} elseif ( strlen($username) > 15 or strlen($username) < 2) {
		$errors[] = $lang['socialsignup.user_format_error'];
	} elseif ( !$valid->username($username) ) {
		$errors[] = $lang['socialsignup.user_format_error'];
	} elseif ( $valid->usernameExists($username) ) {
		$errors[] = $lang['socialsignup.user_existing_error'];
	}	
	/*
	if ($age_min < 18) {
		$errors[] = $lang['signup.age_err'];
	}
	*/
	if ($gender != 'Female') {
		$gender = 'Male';
	}
	if (!$errors) {

		$sql = "INSERT INTO signup SET 
				email = " .$conn->qStr($email). ", 
				username = " .$conn->qStr($username). ",
				fname = " .$conn->qStr($fname). ", 
				lname = " .$conn->qStr($lname). ", 				
				pwd = " .$conn->qStr($password). ", 
				gender = " .$conn->qStr($gender). ", 
				addtime = '" .time(). "', 
				logintime = '" .time(). "', 
				emailverified = 'yes', 
				FBID = " .$conn->qStr($id). " 
				"; 
		
		$conn->execute($sql);
		$uid            = $conn->insert_Id();
		$sql            = "INSERT INTO users_prefs (UID) VALUES (" .$uid. ")";
		$conn->execute($sql);
		$sql            = "INSERT INTO users_online (UID, online) VALUES (" .$uid. ", " .time(). ")";
		$conn->execute($sql);

		if ($picture) {
			$curl = new VCurl();
			$local = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
			if ($curl->saveToFile( $picture, $local)) {
				$src    = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
				$dst    = $config['BASE_DIR']. '/media/users/' .$uid. '.jpg';
				if(copy($src, $dst)) {
					process_thumb($dst, 300, 300);
					if ( file_exists($dst) && filesize($dst) > 100 ) {
						$_SESSION['photo'] = $uid.'.jpg';
						$sql    = "UPDATE signup SET photo = '" .$uid. ".jpg' WHERE UID = " .$uid. " LIMIT 1";
						$conn->execute($sql);
					}
				}
			}
		}


		$sql            = "SELECT email_subject, email_path FROM emailinfo
						   WHERE email_id = 'welcome' LIMIT 1";
		$rs             = $conn->execute($sql);		
		$mail           = new VMail();
		$mail->ClearAddresses();
		$smarty->assign('username', $username);
		$smarty->assign('password', $password_clear);		
		$email_subject  = str_replace('{$site_title}', $config['site_title'], $rs->fields['email_subject']);
		$email_path     = $rs->fields['email_path'];
		$body           = $smarty->fetch($config['BASE_DIR'].'/templates/'.$email_path);
		$mail->setNoReply();
		$mail->Subject  = $email_subject;
		$mail->AltBody  = $body;
		$mail->Body     = nl2br($body);
		$mail->AddAddress($email);
		$mail->CharSet="UTF-8"; 
		$mail->Send();
						
		$_SESSION['message']   = $lang['socialsignup.welcome'].$fname. "! " .$lang['socialsignup.signup_successfully'];

		//Login User:
        $sql    = "SELECT * FROM signup WHERE UID = " .$conn->qStr($uid). " LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $user   = $rs->getrows();

			$_SESSION['uid']            = $user['0']['UID'];
			if ($user['0']['premium'] == '1') {
				$_SESSION['uid_premium'] = 1;
			}
			$_SESSION['username']       = $username;
			$_SESSION['email']          = $user['0']['email'];
			$_SESSION['emailverified']  = $user['0']['emailverified'];
			$_SESSION['photo']          = $user['0']['photo'];
			$_SESSION['fname']          = $user['0']['fname'];
			$_SESSION['gender']         = $user['0']['gender'];

			$_URL                       = $config['BASE_URL'];
			VRedirect::go($_URL);

        } else {
            $errors[] = $lang['login.invalid'];
        }		
	}
} elseif (isset($_POST['fb-signup-submit-existing'])) {
	
	//FB link account
	$filter             = new VFilter();
	$valid              = new VValidation();
	$id                 = $filter->get('fb-signup-id');	
	$email              = $filter->get('fb-signup-email');
	$fname              = $filter->get('fb-signup-first-name');
	$lname              = $filter->get('fb-signup-last-name');
	$use_pp             = $filter->get('fb-signup-usepp');
	if ($use_pp != '') {
		$picture = $_POST['fb-signup-picture'];
	}	
	$username           = $filter->get('fb-signup-existing-username-locked');
	
	if ($username != '') {
		//link to existing account //same email
		$username = $filter->get('fb-signup-existing-username-locked');
		$password = $filter->get('fb-signup-existing-password-locked');	
	} else {
		//link to existing account //different email
		$username = $filter->get('fb-signup-existing-username');
		$password = $filter->get('fb-signup-existing-password');		
	}	
	if ($email != $_SESSION['fb_signup_email']) {
		$errors[] = $lang['signup.email_invalid'];
	}
	if (!$errors) {
        $sql    = "SELECT * FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {		
			$user = $rs->getrows();	
			$uid  = $user['0']['UID'];		
			$password = md5($password);
			if ( $password == $user['0']['pwd'] ) {
				$sql = "UPDATE signup SET 
						fname = " .$conn->qStr($fname). ", 
						lname = " .$conn->qStr($lname). ", 
						logintime = '" .time(). "',	
						emailverified = 'yes', 
						FBID = " .$conn->qStr($id). " 
						WHERE UID = " .$conn->qStr($uid). " LIMIT 1";
				$conn->execute($sql);

				//Update Picture
				if ($picture) {
					$curl = new VCurl();
					$local = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
					if ($curl->saveToFile( $picture, $local)) {
						$src    = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
						$dst    = $config['BASE_DIR']. '/media/users/' .$uid. '.jpg';
						if(copy($src, $dst)) {
							process_thumb($dst, 300, 300);
							if ( file_exists($dst) && filesize($dst) > 100 ) {
								$_SESSION['photo'] = $uid.'.jpg';
								$sql    = "UPDATE signup SET photo = '" .$uid. ".jpg' WHERE UID = " .$uid. " LIMIT 1";
								$conn->execute($sql);
							}
						}
					}
				}
				
				//Login User
				$sql    = "SELECT * FROM signup WHERE UID = " .$conn->qStr($uid). " LIMIT 1";
				$rs     = $conn->execute($sql);				
				$user   = $rs->getrows();
				$yesterday  = time() - 86400;
				if ( intval($user['0']['logintime']) < $yesterday ) {
					$sql_add = ", points = points+5";
				}
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
					$_SESSION['message']    = $lang['socialsignup.welcome'].$user['0']['fname']. "! " .$lang['socialsignup.link_fb_successfully'];
				} else {
					$_SESSION['message']    = $lang['socialsignup.welcome'].$user['0']['username']. "! " .$lang['socialsignup.link_fb_successfully'];
				}
				$_URL                       = $config['BASE_URL'];
				VRedirect::go($_URL);
			} else {
                $errors[] = $lang['login.invalid'];
            }
        } else {
            $errors[] = $lang['login.invalid'];
        }
	}
} elseif ( isset($_POST['g-signup-submit-new']) ) {

	//G new user
	$filter             = new VFilter();
	$valid              = new VValidation();
	$id                 = $filter->get('g-signup-id');	
	$username           = $filter->get('g-signup-username');
	$password_clear     = generateRandomString();
	$password           = md5($password_clear);
	$email              = $filter->get('g-signup-email');
	$fname              = $filter->get('g-signup-first-name');
	$lname              = $filter->get('g-signup-last-name');
	$age_min            = $filter->get('g-signup-age-min', 'INTEGER');
	$gender             = ucfirst($filter->get('g-signup-gender'));
	$use_pp             = $filter->get('g-signup-usepp');
	
	if ($use_pp != '') {
		$picture = $_POST['g-signup-picture'];
	}
	if ($email != $_SESSION['g_signup_email']) {
		$errors[] = $lang['signup.email_invalid'];
	}	
	if ( $username == '' ) {
		$errors[] = $lang['socialsignup.user_format_error'];
	} elseif ( strlen($username) > 15 or strlen($username) < 2) {
		$errors[] = $lang['socialsignup.user_format_error'];
	} elseif ( !$valid->username($username) ) {
		$errors[] = $lang['socialsignup.user_format_error'];
	} elseif ( $valid->usernameExists($username) ) {
		$errors[] = $lang['socialsignup.user_existing_error'];
	}	
	/*
	if ($age_min < 18) {
		$errors[] = $lang['signup.age_err'];
	}
	*/
	if ($gender != 'Female') {
		$gender = 'Male';
	}
	if (!$errors) {

		$sql = "INSERT INTO signup SET 
				email = " .$conn->qStr($email). ", 
				username = " .$conn->qStr($username). ",
				fname = " .$conn->qStr($fname). ", 
				lname = " .$conn->qStr($lname). ", 				
				pwd = " .$conn->qStr($password). ", 
				gender = " .$conn->qStr($gender). ", 
				addtime = '" .time(). "', 
				logintime = '" .time(). "', 
				emailverified = 'yes', 
				GID = " .$conn->qStr($id). " 
				"; 
		
		$conn->execute($sql);
		$uid            = $conn->insert_Id();
		$sql            = "INSERT INTO users_prefs (UID) VALUES (" .$uid. ")";
		$conn->execute($sql);
		$sql            = "INSERT INTO users_online (UID, online) VALUES (" .$uid. ", " .time(). ")";
		$conn->execute($sql);

		if ($picture) {
			$curl = new VCurl();
			$local = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
			if ($curl->saveToFile( $picture, $local)) {
				$src    = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
				$dst    = $config['BASE_DIR']. '/media/users/' .$uid. '.jpg';
				if(copy($src, $dst)) {
					process_thumb($dst, 300, 300);
					if ( file_exists($dst) && filesize($dst) > 100 ) {
						$_SESSION['photo'] = $uid.'.jpg';
						$sql    = "UPDATE signup SET photo = '" .$uid. ".jpg' WHERE UID = " .$uid. " LIMIT 1";
						$conn->execute($sql);
					}
				}
			}
		}

		$sql            = "SELECT email_subject, email_path FROM emailinfo
						   WHERE email_id = 'welcome' LIMIT 1";
		$rs             = $conn->execute($sql);		
		$mail           = new VMail();
		$smarty->assign('username', $username);
		$smarty->assign('password', $password_clear);		
		$email_subject  = str_replace('{$site_title}', $config['site_title'], $rs->fields['email_subject']);
		$email_path     = $rs->fields['email_path'];
		$body           = $smarty->fetch($config['BASE_DIR'].'/templates/'.$email_path);
		$mail->setNoReply();
		$mail->Subject  = $email_subject;
		$mail->AltBody  = $body;
		$mail->Body     = nl2br($body);
		$mail->AddAddress($email);
		$mail->CharSet="UTF-8"; 
		$mail->Send();

		if (strlen($fname) > 1) {
			$_SESSION['message']   = $lang['socialsignup.welcome'].$fname. "! " .$lang['socialsignup.signup_successfully'];
		} else {
			$_SESSION['message']   = $lang['socialsignup.welcome'].$username. "! " .$lang['socialsignup.signup_successfully'];			
		}

		//Login User:
        $sql    = "SELECT * FROM signup WHERE UID = " .$conn->qStr($uid). " LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $user   = $rs->getrows();

			$_SESSION['uid']            = $user['0']['UID'];
			if ($user['0']['premium'] == '1') {
				$_SESSION['uid_premium'] = 1;
			}
			$_SESSION['username']       = $username;
			$_SESSION['email']          = $user['0']['email'];
			$_SESSION['emailverified']  = $user['0']['emailverified'];
			$_SESSION['photo']          = $user['0']['photo'];
			$_SESSION['fname']          = $user['0']['fname'];
			$_SESSION['gender']         = $user['0']['gender'];

			$_URL                       = $config['BASE_URL'];
			VRedirect::go($_URL);

        } else {
            $errors[] = $lang['login.invalid'];
        }		
	}
} elseif (isset($_POST['g-signup-submit-existing'])) {
	
	//G link account
	$filter             = new VFilter();
	$valid              = new VValidation();
	$id                 = $filter->get('g-signup-id');	
	$email              = $filter->get('g-signup-email');
	$fname              = $filter->get('g-signup-first-name');
	$lname              = $filter->get('g-signup-last-name');
	$use_pp             = $filter->get('g-signup-usepp');
	if ($use_pp != '') {
		$picture = $_POST['g-signup-picture'];
	}	
	$username           = $filter->get('g-signup-existing-username-locked');
	
	if ($username != '') {
		//link to existing account //same email
		$username = $filter->get('g-signup-existing-username-locked');
		$password = $filter->get('g-signup-existing-password-locked');	
	} else {
		//link to existing account //different email
		$username = $filter->get('g-signup-existing-username');
		$password = $filter->get('g-signup-existing-password');		
	}	
	if ($email != $_SESSION['g_signup_email']) {
		$errors[] = $lang['signup.email_invalid'];
	}
	if (!$errors) {
        $sql    = "SELECT * FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {		
			$user = $rs->getrows();	
			$uid  = $user['0']['UID'];		
			$password = md5($password);
			if ( $password == $user['0']['pwd'] ) {
				$sql = "UPDATE signup SET 
						fname = " .$conn->qStr($fname). ", 
						lname = " .$conn->qStr($lname). ", 
						logintime = '" .time(). "',	
						emailverified = 'yes', 
						GID = " .$conn->qStr($id). " 
						WHERE UID = " .$conn->qStr($uid). " LIMIT 1";
				$conn->execute($sql);

				//Update Picture
				if ($picture) {
					$curl = new VCurl();
					$local = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
					if ($curl->saveToFile( $picture, $local)) {
						$src    = $config['BASE_DIR']. '/media/users/orig/' .$uid. '.jpg';
						$dst    = $config['BASE_DIR']. '/media/users/' .$uid. '.jpg';
						if(copy($src, $dst)) {
							process_thumb($dst, 300, 300);
							if ( file_exists($dst) && filesize($dst) > 100 ) {
								$_SESSION['photo'] = $uid.'.jpg';
								$sql    = "UPDATE signup SET photo = '" .$uid. ".jpg' WHERE UID = " .$uid. " LIMIT 1";
								$conn->execute($sql);
							}
						}
					}
				}
				
				//Login User
				$sql    = "SELECT * FROM signup WHERE UID = " .$conn->qStr($uid). " LIMIT 1";
				$rs     = $conn->execute($sql);				
				$user   = $rs->getrows();
				$yesterday  = time() - 86400;
				if ( intval($user['0']['logintime']) < $yesterday ) {
					$sql_add = ", points = points+5";
				}
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
				if (strlen($user['0']['fname']) > 0) {
					$_SESSION['message']    = $lang['socialsignup.welcome'].$user['0']['fname']. "! " .$lang['socialsignup.link_g_successfully'];
				} else {
					$_SESSION['message']    = $lang['socialsignup.welcome'].$user['0']['username']. "! ".$lang['socialsignup.link_g_successfully'];
				}
				$_URL                       = $config['BASE_URL'];
				VRedirect::go($_URL);
			} else {
                $errors[] = $lang['login.invalid'];
            }
        } else {
            $errors[] = $lang['login.invalid'];
        }
	}	
} else {
	$signup     = array('username' => '', 'email' => '', 'age' => '', 'terms' => '', 'gender' => '');
	if ( isset($_POST['submit_signup']) ) {
		
		$filter             = new VFilter();
		$valid              = new VValidation();
		$username           = $filter->get('username');
		$password           = $filter->get('password');
		$password_confirm   = $filter->get('password_confirm');
		$email              = $filter->get('email');
		$vcode              = $filter->get('verification');
		$age                = $filter->get('age');
		$terms              = $filter->get('terms');
		$gender             = $filter->get('gender');

		if ( $username == '' ) {
			$errors[]               = $lang['signup.username_empty'];
			$err['username']		=  1;
		} elseif ( strlen($username) > 15 ) {
			$errors[]               = $lang['signup.username_length'];
			$err['username']		= 1;
		} elseif ( !$valid->username($username) ) {
			$errors[]               = $lang['signup.username_invalid'];
			$err['username']		= 1;
		} elseif ( $valid->usernameExists($username) ) {
			$errors[]               = $lang['signup.username_exists'];
			$err['username']		= 1;
		}
		$signup['username']     = $username;

		
		if ( $email == '' ) {
			$errors[]               = $lang['signup.email_empty'];
			$err['email']			= 1;
		} elseif ( !$valid->email($email) ) {
			$errors[]               = $lang['signup.email_invalid'];
			$err['email']			= 1;
		} elseif ( $valid->emailExists($email) ) {
			$errors[]               = $lang['signup.email_exists'];
			$err['email']			= 1;
		}
		$signup['email']        = $email;

		
		if ( $password == '' ) {
			$errors[]               = $lang['signup.password_empty'];
			$err['password']		= 1;
			$err['password_confirm']= 1;
		} elseif ( $password_confirm == '' ) {
			$errors[]               = $lang['signup.passwordc_empty'];
			$err['password']		= 1;
			$err['password_confirm']= 1;
		} elseif ( $password != $password_confirm ) {
			$errors[]               = $lang['signup.password_mismatch'];
			$err['password']		= 1;
			$err['password_confirm']= 1;
		}
		
		/*
		if ( $age == '' ) {
			$errors[]               = $lang['signup.age_err'];
			$err['age']				= 1;
		} else {
			$signup['age']          = 'on';
		}
		
		if ( $terms == '' ) {
			$errors[]               = $lang['signup.terms_err'];
			$err['terms']			= 1;
		} else {
			$signup['terms']        = 'on';
		}
		*/
		
		if ( $gender == '' ) {
			$errors[]               = $lang['signup.gender_err'];
			$err['gender']			= 1;
		} else {
			$gender                 = ( $gender == 'Male' ) ? 'Male' : 'Female';
			$signup['gender']       = $gender;
		}	
		
		if ( $config['captcha'] == '1' ) {

			$secret = $config['recaptcha_secret_key'];
			require('modules/captcha/recaptchalib.php');
			$response = null;
			$reCaptcha = new ReCaptcha($secret);	
			$response = $reCaptcha->verifyResponse(
							$_SERVER["REMOTE_ADDR"],
							$_POST["g-recaptcha-response"]
						);
			if ($response != null && $response->success) {
				// verified!
			} else {
				$errors[] = $lang['signup.captcha'];
			}		
		}
		
		if ( !$errors ) {
			require 'classes/random.class.php';
			$password_clear = $password;
			$password       = md5($password);
			$sql            = "INSERT INTO signup SET email = " .$conn->qStr($email). ", username = " .$conn->qStr($username). ",
							  pwd = " .$conn->qStr($password). ", gender = '" .$gender. "',
							  addtime = '" .time(). "', logintime = '" .time(). "'";  
			$conn->execute($sql);
			$uid            = $conn->insert_Id();
			$sql            = "INSERT INTO users_prefs (UID) VALUES (" .$uid. ")";
			$conn->execute($sql);
			$sql            = "INSERT INTO users_online (UID, online) VALUES (" .$uid. ", " .time(). ")";
			$conn->execute($sql);
			$code           = VRandom::generate(10, 'confirmation');
			$sql            = "INSERT INTO confirm (UID, code) VALUES (" .$uid. "," .$conn->qStr($code). ")";
			$conn->execute($sql);
			$sql            = "SELECT email_subject, email_path FROM emailinfo
							   WHERE email_id = 'verify_email' LIMIT 1";
			$rs             = $conn->execute($sql);
			$email_subject  = str_replace('{$site_name}', $config['site_name'], $rs->fields['email_subject']);
			$email_path     = $config['BASE_DIR'].'/templates/'.$rs->fields['email_path'];
			$smarty->assign('username', $username);
			$smarty->assign('password', $password_clear);
			$smarty->assign('uid', $uid);
			$smarty->assign('code', $code);
			$body           = $smarty->fetch($email_path);
			$mail           = new VMail();
			$mail->setNoReply();
			$mail->Subject  = $email_subject;
			$mail->AltBody  = $body;
			$mail->Body     = nl2br($body);
			$mail->AddAddress($email);
			$mail->CharSet="UTF-8"; 
			$mail->Send();
			
			$mail->ClearAddresses();
			$sql            = "SELECT email_subject, email_path FROM emailinfo
							   WHERE email_id = 'welcome' LIMIT 1";
			$rs             = $conn->execute($sql);
			$email_subject  = str_replace('{$site_title}', $config['site_title'], $rs->fields['email_subject']);
			$email_path     = $rs->fields['email_path'];
			$body           = $smarty->fetch($config['BASE_DIR'].'/templates/'.$email_path);
			$mail->Subject  = $email_subject;
			$mail->AltBody  = $body;
			$mail->Body     = nl2br($body);
			$mail->AddAddress($email);
			$mail->CharSet="UTF-8"; 
			$mail->Send();
							
			$_SESSION['message']   = $lang['signup.msg'];
			VRedirect::go($config['BASE_URL']);
		}
	}
}

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

$captcha_language = substr($_SESSION['language'], 0, 2);

switch ($_SESSION['language']) {
    case 'sa_SA':
        $captcha_language = 'ar';
        break;
    case 'he_IL':
        $captcha_language = 'iw';
        break;
    case 'jp_JP':
        $captcha_language = 'ja';
        break;
    case 'cn_CS':
        $captcha_language = 'zh-CN';
        break;
    case 'cn_CT':
        $captcha_language = 'zh-TW';
        break;
    case 'dk_DK':
        $captcha_language = 'da';
        break;
    case 'cz_CZ':
        $captcha_language = 'cs';
        break;
    case 'rs_RS':
        $captcha_language = 'sr';
        break;
    case 'si_SI':
        $captcha_language = 'sl';
        break;
    case 'ba_BA':
        $captcha_language = 'sl';
        break;			
}

unset($_SESSION['fb_signup_email']);
$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('captcha_language',$captcha_language);
$smarty->assign('menu', 'home');
$smarty->assign('signup', $signup);
$smarty->assign('self_title', $seo['signup_title']);
$smarty->assign('self_description', $seo['signup_desc']);
$smarty->assign('self_keywords', $seo['signup_keywords']);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('signup.tpl');
$smarty->display('footer.tpl');
?>

<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require '../classes/country.class.php';
$country            = new I18N_ISO_3166();
$countries_twocode  = $country->twocountry;
$countries          = array();
foreach ( $countries_twocode as $code => $value )
    $countries[] = $value;

$user  = array();
$UID   = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? intval(trim($_GET['UID'])) : NULL;
if ( !$UID ) {
    $errors[] = 'Invalid user ID!';
}

if ( !$errors ) {
    if ( isset($_POST['edit_user']) ) {
        require $config['BASE_DIR']. '/classes/filter.class.php';
        require $config['BASE_DIR']. '/classes/validation.class.php';
        $filter             = new VFilter();
        $valid              = new VValidation();
        $email              = $filter->get('email');
        $fname              = $filter->get('fname');
        $lname              = $filter->get('lname');
        $town               = $filter->get('town');
        $city               = $filter->get('city');
        $zip                = $filter->get('zip');
        $aboutme            = $filter->get('aboutme');
        $fav_movies         = $filter->get('fav_movie_show');
        $fav_music          = $filter->get('fav_music');
        $fav_books          = $filter->get('fav_book');
        $occupation         = $filter->get('occupation');
        $interests          = $filter->get('interest_hobby');
        $company            = $filter->get('company');
        $school             = $filter->get('school');
        $website            = $filter->get('website');
        $country            = $filter->get('country');
        $gender             = $filter->get('gender');
        $relation           = $filter->get('relation');
        $website            = $filter->get('website');
        $password           = $filter->get('password');
        $password_confirm   = $filter->get('password_confirm');
        $video_viewed       = $filter->get('video_viewed', 'INTEGER');
        $profile_viewed     = $filter->get('profile_viewed', 'INTEGER');
        $watched_video      = $filter->get('watched_video', 'INTEGER');
        $account_status     = $filter->get('account_status');
        $emailverified      = $filter->get('emailverified');
        
        if ( $email == '' ) {
            $errors[] = 'Email field cannot be blank!';
        } elseif ( !$valid->email($email) ) {
            $errors[] = 'Email is not a valid email address!';
        } elseif ( $valid->emailExists($email, $UID) ) {
            $errors[] = 'Email is already used by another user!';
        }
        
        if ( $password != '' && $password != $password_confirm ) {
            $errors[] = 'Password and confirmation password are not the same!';
        }
        
        if ( $_FILES['avatar']['tmp_name'] != '' && !$errors ) {
			$imagesize 	= getimagesize($_FILES['avatar']['tmp_name']);
			if (!$imagesize) {
				$errors[] = 'Invalid image uploaded!';
			}
			
			if (!$errors ) {
				$ext = '';
          		if ($imagesize['2'] == 1) {
					$ext = 'gif';
          		} elseif ($imagesize['2'] == 2) {
					$ext = 'jpg';
          		} elseif ($imagesize['2'] == 3) {
					$ext = 'png';
				}
				
				if ($ext == '') {
					$errors[] = 'Invalid image format uploaded. Allowed formats: jpg, gif and png!';
				}
			}  
			
			if (!$errors) {
				$src		= $_FILES['avatar']['tmp_name'];
				$dst_tmp	= $config['BASE_DIR']. '/tmp/avatars/'.$UID.'.'.$ext;
				if (move_uploaded_file($src, $dst_tmp)) {
					require $config['BASE_DIR']. '/classes/image.class.php';
					$dst_orig	= $config['BASE_DIR']. '/media/users/orig/'.$UID.'.jpg';
					$image  = new VImageConv();
					
					$image->process($dst_tmp, $dst_orig, 'MAX_WIDTH', 500, 0);
					$image->resize(true, true);

					list ($width, $height) = getimagesize($dst_orig);
					$crop_w = min ($width, $height);
					$crop_h = $crop_w;
					if ($width > $height) {
						$crop_x = floor (($width - $crop_w)/2);
						$crop_y = 0;
					}
					else {
						$crop_x = 0;
						$crop_y = floor (($height - $crop_h)/2);
					}				
					
					$dst	= $config['BASE_DIR']. '/media/users/'.$UID.'.jpg';				
					$image->process($dst_orig, $dst, 'EXACT', $crop_w, $crop_h);
					$image->crop($crop_x, $crop_y, $crop_w, $crop_h, true);
					

					$photo_new = TRUE;
				} else {
					$errors[] = 'Failed to move uploaded file (invalid permissions?)!';
				}
			}
		}
        
        if ( !$errors ) {
            $sql_add = NULL;  
            if ( $password != '' ) {
				$passwd 	= md5($password);
                $sql_add 	= " ,pwd = '" .$passwd. "'";
            }
            
            if ( isset($_POST['delete_avatar']) && $_POST['delete_avatar'] == 'on' ) {
                $sql_add .= " ,photo = ''";
            }
            
            if ( isset($photo_new) ) {
                $sql_add .= " ,photo = " .$conn->qStr($UID.'.jpg'). "";
            }
            
            $sql = "UPDATE signup SET premium = " .$conn->qStr($_POST['premium']). " and email = " .$conn->qStr($email). ", fname = " .$conn->qStr($fname). ",
                                      lname = " .$conn->qStr($lname). ", gender = " .$conn->qStr($gender). ",
                                      relation = " .$conn->qStr($relation). ", aboutme = " .$conn->qStr($aboutme). ",
                                      town = " .$conn->qStr($town). ", city = " .$conn->qStr($city). ",
                                      zip = " .$conn->qStr($zip) .", country = " .$conn->qStr($country). ",
                                      occupation = " .$conn->qStr($occupation). ", company = " .$conn->qStr($company). ",
                                      school = " .$conn->qStr($school). ", interest_hobby = " .$conn->qStr($interests). ",
                                      fav_movie_show = " .$conn->qStr($fav_movies). ", fav_music = " .$conn->qStr($fav_music). ",
                                      fav_book = " .$conn->qStr($fav_books). ", website = " .$conn->qStr($website). ",
                                      video_viewed = " .$conn->qStr($video_viewed). ", profile_viewed = " .$conn->qStr($profile_viewed). ",
                                      watched_video = " .$conn->qStr($watched_video). ", emailverified = " .$conn->qStr($emailverified). ",
                                      account_status = " .$conn->qStr($account_status). "" .$sql_add. " WHERE UID = " .$conn->qStr($UID). " LIMIT 1";
            $conn->execute($sql); 
            if ( $conn->Affected_Rows() == 1 || $photo_new ) {
                $messages[] = 'User information updated successfuly!';
            } else {
                $errors[]   = 'Failed to update user or nothing changed!';
            }
        }
    }

    $sql    = "SELECT * FROM signup WHERE UID = " .$UID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $user = $rs->getrows();
    } else {
        $errors[] = 'This user does not exist! Invalid user ID?';
    }
}

$smarty->assign('user', $user);
$smarty->assign('countries', $countries);
?>

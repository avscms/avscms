<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';

require $config['BASE_DIR']. '/classes/country.class.php';
$country            = new I18N_ISO_3166();
$countries_twocode  = $country->twocountry;
$countries          = array();
foreach ( $countries_twocode as $code => $value )
    $countries[] = $value;

if ( isset($_POST['profile_submit']) ) {
    $filter             = new VFilter();
    $password           = $filter->get('password');
    $password_confirm   = $filter->get('password_confirm');
    $fname              = $filter->get('fname');
    $lname              = $filter->get('lname');
    $gender             = $filter->get('gender');
	$bday				= $filter->get('bday');
    //$birth_month        = $filter->get('Date_Month', 'INTEGER');
    //$birth_day          = $filter->get('Date_Day', 'INTEGER');
    //$birth_year         = $filter->get('Date_Year', 'INTEGER');
    $relation           = $filter->get('relation');
    $interested         = $filter->get('interested');
    $website            = $filter->get('website');
    $town               = $filter->get('town');
    $city               = $filter->get('city');
    $country            = $filter->get('country');
    $occupation         = $filter->get('occupation');
    $company            = $filter->get('company');
    $school             = $filter->get('school');
    $aboutme            = $filter->get('aboutme');
    $interest_hobby     = $filter->get('interest_hobby');
    $fav_movie_show     = $filter->get('fav_movie_show');
    $fav_music          = $filter->get('fav_music');
    $fav_book           = $filter->get('fav_book');    
    $turnon             = $filter->get('turnon');
    $turnoff            = $filter->get('turnoff');

	$birth_month = date("m", strtotime($bday));
	$birth_day   = date("d", strtotime($bday));
	$birth_year  = date("Y", strtotime($bday));
    
    $sql_add            = NULL;
    if ( $password != '' ) {
        if ( $password != $password_confirm ) {
            $errors[]   = $lang['signup.password_mismatch'];
			$err['password'] = 1;
        } else {
			$password	= md5($password);
            $sql_add   .= ", pwd = " .$conn->qStr($password). "";
        }
    }
    
    if ( $birth_month !='' && $birth_day != '' && $birth_year != '' ) {
        require $config['BASE_DIR']. '/classes/validation.class.php';
        $valid  = new VValidation();
        if ( !$valid->date($birth_month, $birth_day, $birth_year) ) {
            $errors[]   = $lang['user.birthdate_invalid'];
			$err['bday'] = 1;
        } else {
            $birth_date = $birth_year. '-' .$birth_month. '-' .$birth_day;
            $sql_add   .= ", bdate = " .$conn->qStr($birth_date). "";
        }
    }
    
    if ( !$errors ) {
        $sql            = "UPDATE signup SET fname = " .$conn->qStr($fname). ", lname = " .$conn->qStr($lname). ",
                                             gender = " .$conn->qStr($gender). ", relation = " .$conn->qStr($relation). ",
                                             interested = " .$conn->qStr($interested). ", website = " .$conn->qStr($website). ",
                                             town = " .$conn->qStr($town). ", city = " .$conn->qStr($city). ",
                                             country = " .$conn->qStr($country). ", aboutme = " .$conn->qStr($aboutme). ",
                                             fav_movie_show = " .$conn->qStr($fav_movie_show). ", fav_music = " .$conn->qStr($fav_music). ",
                                             fav_book = " .$conn->qStr($fav_book). ", turnon = " .$conn->qStr($turnon). ",
                                             turnoff = " .$conn->qStr($turnoff). ", occupation = " .$conn->qStr($occupation). ",
                                             company = " .$conn->qStr($company). ", school = " .$conn->qStr($school). ",
                                             interest_hobby = " .$conn->qStr($interest_hobby). "" .$sql_add. "
                          WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $conn->execute($sql);
        $messages[]     = 'Profile was successfully updated!';
    }
}

$sql            = "SELECT fname, lname, bdate, relation, interested, town, city, country, occupation, company, school,
                          aboutme, interest_hobby, fav_movie_show, fav_music, fav_book, turnon, turnoff, website
                   FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
$rs             = $conn->execute($sql);
$profile        = $rs->getrows();
$profile        = $profile['0'];
$user           = array_merge($user, $profile);
$bdate          = explode('-', $user['bdate']);
$byear          = $bdate['0'];
$bmonth         = $bdate['1'];
$bday           = $bdate['2'];
//$user['bdate']  = mktime(0, 0, 0, $bmonth, $bday, $byear);1
$smarty->assign('countries', $countries);
?>

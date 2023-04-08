<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

require '../classes/country.class.php';
$country            = new I18N_ISO_3166();
$countries_twocode  = $country->twocountry;
$countries          = array();
foreach ( $countries_twocode as $code => $value )
    $countries[] = $value;

if (isset($_POST['delete_selected_users'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_users' && substr($key, 0, 17) == 'user_id_checkbox_') {
            if ( $value == 'on' ) {
                deleteUser(str_replace('user_id_checkbox_', '', $key));
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select users to be deleted!';
    } else {
        $messages[] = 'Successfully deleted ' .$index. ' (selected) users!';
    }
}

if (isset($_POST['suspend_selected_users']) || isset($_POST['approve_selected_users']) ) {
    $act        = 'Active';
    $act_name   = 'activated';
    $index      = 0;
    if ( isset($_POST['suspend_selected_users']) ) {
        $act        = 'Inactive';
        $act_name   = 'suspended';
    }

    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_users' && substr($key, 0, 17) == 'user_id_checkbox_') {
            if ( $value == 'on' ) {
                $uid = intval(str_replace('user_id_checkbox_', '', $key));
                $sql = "UPDATE signup SET account_status = '" .$act. "' WHERE UID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select users to be ' .$act_name. '!';
    } else {
        $messages[] = 'Successfully ' .$act_name. ' ' .$index. ' (selected) users!';
    }
}

$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

$query          = constructQuery($module_keep);
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_users    = $rs->fields['total_users'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_users);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$users          = $rs->getrows();

function constructQuery($module)
{
    global $smarty, $conn;

    $query_module = '';

    $query              = array();
    $query_select       = "SELECT * FROM signup" .$query_module;
    $query_count        = "SELECT count(*) AS total_users FROM signup" .$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $option_orig        = array('username' => '', 'email' => '', 'country' => '', 'name' => '', 'gender' => '', 'emailverified' => '', 'premium' => '', 
                                'sort' => 'UID', 'order' => 'DESC', 'display' => 100);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_users_option']);
	}
	
    $option             = ( isset($_SESSION['search_users_option']) ) ? $_SESSION['search_users_option'] : $option_orig;
	
	if ( isset($_GET['UID'] ) ) {
		$UID = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? $_GET['UID'] : 0;
		$query_option[] = $query_add. " UID = " .$conn->qStr($UID). "";
        $query_add      = " AND";		
	}	

	if ( isset($_GET['status'] ) ) {
		unset ($_SESSION['search_users_option']);
		$status = ( isset($_GET['status']) && is_numeric($_GET['status']) ) ? $_GET['status'] : 0;
		if ($status == '1') {
			$status = 'Active';
		} elseif ($status == '0') {
			$status = 'Inactive';
		}
		if ($status == 'Active' || $status == 'Inactive') {
			$query_option[] = $query_add. " account_status = '" .$status. "'";
			$query_add      = " AND";		
			$option['status'] = $status;
		}
	}		
    
    if ( isset($_POST['search_users']) ) {
        $option['username']     = trim($_POST['username']);
        $option['email']        = null;
        $option['country']      = trim($_POST['country']);
        $option['name']         = trim($_POST['name']);
        $option['gender']       = trim($_POST['gender']);
        $option['emailverified']= trim($_POST['emailverified']);
        $option['status']       = trim($_POST['status']);
        $option['premium']      = trim($_POST['premium']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
        
        if ( $option['username'] != '' ) {
            $query_option[] = $query_add. " username LIKE '%" .trim($conn->qStr($option['username']), "'"). "%'";
            $query_add      = " AND";
        }

        if ( $option['email'] != '' ) {
            $query_option[] = $query_add. " email LIKE '%" .trim($conn->qStr($option['email']), "'"). "%'";
            $query_add      = " AND";
        }

        if ( $option['country'] != '' ) {
            $query_option[] = $query_add. " country LIKE '%" .trim($conn->qStr($option['country']), "'"). "%'";
            $query_add      = " AND";
        }
        
        if ( $option['name'] != '' ) {
            $query_option[] = $query_add. " ( fname LIKE '%" .trim($conn->qStr($option['name']), "'"). "%' OR lname LIKE '%" .trim($conn->qStr($option['name']), "'"). "%' )";
            $query_add      = " AND";
        }
        
        if ( $option['gender'] != '' ) {
            $query_option[] = $query_add. " gender = " .$conn->qStr($option['gender']). "";
            $query_add      = " AND";
        }
        
        if ( $option['emailverified'] != '' ) {
            $query_option[] = $query_add. " emailverified = " .$conn->qStr($option['emailverified']). "";
            $query_add      = " AND";            
        }

		if ( $option['status'] == 'Active' || $option['status'] == 'Inactive' ) {
            $query_option[] = $query_add. " account_status = " .$conn->qStr($option['status']). "";
            $query_add      = " AND";   			
		}		

        if ( $option['premium'] != '' ) {
            $query_option[] = $query_add. " premium = " .$conn->qStr($option['premium']). "";
            $query_add      = " AND";            
        }		
		
        $_SESSION['search_users_option'] = $option;
		
    } elseif (isset($_SESSION['search_users_option'])) {
		
		$option = $_SESSION['search_users_option'];
		
        if ( $option['username'] != '' ) {
            $query_option[] = $query_add. " username LIKE '%" .trim($conn->qStr($option['username']), "'"). "%'";
            $query_add      = " AND";
        }

        if ( $option['email'] != '' ) {
            $query_option[] = $query_add. " email LIKE '%" .trim($conn->qStr($option['email']), "'"). "%'";
            $query_add      = " AND";
        }

        if ( $option['country'] != '' ) {
            $query_option[] = $query_add. " country LIKE '%" .trim($conn->qStr($option['country']), "'"). "%'";
            $query_add      = " AND";
        }
        
        if ( $option['name'] != '' ) {
            $query_option[] = $query_add. " ( fname LIKE '%" .trim($conn->qStr($option['name']), "'"). "%' OR lname LIKE '%" .trim($conn->qStr($option['name']), "'"). "%'";
            $query_add      = " AND";
        }
        
        if ( $option['gender'] != '' ) {
            $query_option[] = $query_add. " gender = " .$conn->qStr($option['gender']). "";
            $query_add      = " AND";
        }
        
        if ( $option['emailverified'] != '' ) {
            $query_option[] = $query_add. " emailverified = " .$conn->qStr($option['emailverified']). "";
            $query_add      = " AND";            
        }		
		
		if ( $option['status'] != '' ) {
            $query_option[] = $query_add. " account_status = " .$conn->qStr($option['status']). "";
            $query_add      = " AND";
		}
		
        if ( $option['premium'] != '' ) {
            $query_option[] = $query_add. " premium = " .$conn->qStr($option['premium']). "";
            $query_add      = " AND";            
        }		
		
	}
    
    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('users', $users);
$smarty->assign('total_users', $total_users);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('countries', $countries);
?>

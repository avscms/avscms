<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

if (isset($_POST['unflag_selected_users'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_users' && substr($key, 0, 17) == 'user_id_checkbox_') {
            if ( $value == 'on' ) {
                $sql = "DELETE FROM users_flags WHERE UID = " .intval(str_replace('user_id_checkbox_', '', $key)). " LIMIT 1";
                $conn->execute($sql);
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select users to be unflagged!';
    } else {
        $messages[] = 'Successfully unflagged ' .$index. ' (selected) users!';
    }
}

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

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_count        = "SELECT COUNT(f.UID) AS total_users FROM signup AS u, users_flags AS f WHERE f.UID = u.UID";
    $query_select       = "SELECT u.*, f.RID, f.reason, f.message, f.addtime, f.flag_id
                           FROM signup AS u, users_flags AS f
                           WHERE f.UID = u.UID";
    $query_option       = array();
    $option_orig        = array('username' => '', 'email' => '', 'country' => '', 'name' => '', 'gender' => '', 'relation' => '',
                                'sort' => 'u.UID', 'order' => 'DESC', 'display' => 100);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_users_flagged_option']);
	}								
								
    $option             = ( isset($_SESSION['search_users_flagged_option']) ) ? $_SESSION['search_users_flagged_option'] : $option_orig;
    
    if ( isset($_POST['search_users']) ) {
        global $config;
        require $config['BASE_DIR']. '/classes/filter.class.php';
        $filter                 = new VFilter();
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
            $query_option[] = " AND u.username LIKE '%" .trim($conn->qStr($option['username']), "'"). "%'";
        }

        if ( $option['email'] != '' ) {
            $query_option[] = " AND u.email LIKE '%" .trim($conn->qStr($option['email']), "'"). "%'";
        }

        if ( $option['country'] != '' ) {
            $query_option[] = " AND u.country LIKE '%" .trim($conn->qStr($option['country']), "'"). "%'";
        }
        
        if ( $option['name'] != '' ) {
            $query_option[] = " AND ( u.fname LIKE '%" .trim($conn->qStr($option['name']), "'"). "%' OR u.lname LIKE '%" .trim($conn->qStr($option['name']), "'"). "%' )";
        }
        
        if ( $option['gender'] != '' ) {
            $query_option[] = " AND u.gender = " .$conn->qStr($option['gender']). "";
        }
        
        if ( $option['emailverified'] != '' ) {
            $query_option[] = " AND u.emailverified = " .$conn->qStr($option['emailverified']). "";        
        }

		if ( $option['status'] == 'Active' || $option['status'] == 'Inactive' ) {
            $query_option[] = " AND u.account_status = " .$conn->qStr($option['status']). "";			
		}		

        if ( $option['premium'] != '' ) {
            $query_option[] = " AND u.premium = " .$conn->qStr($option['premium']). "";           
        }	

        $_SESSION['search_users_flagged_option'] = $option;
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
?>

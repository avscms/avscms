<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/function_global.php';

Auth::checkAdmin();

$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if (isset($_POST['delete_selected_notices'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_notices' && substr($key, 0, 19) == 'notice_id_checkbox_') {
            if ( $value == 'on' ) {
                $notice_id = str_replace('notice_id_checkbox_', '', $key);
                deleteNotice($notice_id);
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select notices to be deleted!';
    } else {
        $messages[] = 'Successfully deleted ' .$index. ' (selected) notices!';
    }
}
            
if (isset($_POST['suspend_selected_notices']) || isset($_POST['approve_selected_notices']) ) {
    $act        = 1;
    $act_name   = 'activated';
    $index      = 0;
    if ( isset($_POST['suspend_selected_notices']) ) {
        $act        = 0;
        $act_name   = 'suspended';
    }

    foreach ( $_POST as $key => $value ) {
        if ( substr($key, 0, 19) == 'notice_id_checkbox_' && $value == 'on' ) {
            $nid = intval(str_replace('notice_id_checkbox_', '', $key));
            $sql = "UPDATE notice SET status = '" .$act. "' WHERE NID = " .$nid. " LIMIT 1";
            $conn->execute($sql);
            ++$index;
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select notices to be ' .$act_name. '!';
    } else {
        $messages[] = 'Successfully ' .$act_name. ' ' .$index. ' (selected) notices!';
    }
}


$remove = NULL;

$query          = constructQuery();
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_notices    = $rs->fields['total_notices'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_notices);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$notices          = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT n.*, s.username FROM notice AS n, signup AS s WHERE n.UID = s.UID";
    $query_count        = "SELECT count(n.NID) AS total_notices FROM notice AS n, signup AS s WHERE n.UID = s.UID";
    $query_option       = array();
    $option_orig        = array('username' => '', 'title' => '', 'content' => '', 'status' => '',
                                'sort' => 'n.NID', 'order' => 'DESC', 'display' => 100);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_notices_option']);
	}

	$option             = ( isset($_SESSION['search_notices_option']) ) ? $_SESSION['search_notices_option'] : $option_orig;			
	
	if ( isset($_GET['CID']) && is_numeric($_GET['CID']) && channelExists($_GET['CID'], 'notice') ) {
		unset ($_SESSION['search_notices_option']);
		$CID = $_GET['CID'];
		$query_option[] = " AND n.category = " .intval($CID);
		$option['category'] = $CID;
	}						
						
    if ( isset($_POST['search_notices']) ) {
	
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['category']     = intval(trim($_POST['category']));		
        $option['content']      = trim($_POST['content']);
        $option['status']       = trim($_POST['status']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
    
		if ( $option['username'] != '' || isset($_GET['UID']) ) {
			if ( $option['username'] != '' ) {
				$UID            = getUserID($option['username']);
			} else {
				$UID            = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? $_GET['UID'] : 0;
			}
			$UID            = ( $UID ) ? intval($UID) : 0;
			$query_option[] = " AND n.UID = " .$UID;
		}

		if ( $option['title'] != '' ) {
			$query_option[] = " AND n.title LIKE '%" .trim($conn->qStr($option['title']), "'"). "%'";
		}

		if ( $option['category'] != '' ) {
			$query_option[] = " AND n.category = " .intval($option['category']);
		}		
		
		if ( $option['content'] != '' ) {
			$query_option[] = " AND n.content LIKE '%" .trim($conn->qStr($option['content']), "'"). "%'";
		}

		if ( $option['status'] == '1' || $option['status'] == '0' ) {
			$query_option[] = " AND n.status = '" .$option['status']. "'";
		}
		
		$_SESSION['search_notices_option'] = $option;
		
	} elseif (isset($_SESSION['search_notices_option'])) {
		
		$option = $_SESSION['search_notices_option'];

		if ( $option['username'] != '' || isset($_GET['UID']) ) {
			if ( $option['username'] != '' ) {
				$UID            = getUserID($option['username']);
			} else {
				$UID            = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? $_GET['UID'] : 0;
			}
			$UID            = ( $UID ) ? intval($UID) : 0;
			$query_option[] = " AND n.UID = " .$UID;
		}

		if ( $option['title'] != '' ) {
			$query_option[] = " AND n.title LIKE '%" .trim($conn->qStr($option['title']), "'"). "%'";
		}

		if ( $option['category'] != '' ) {
			$query_option[] = " AND n.category = " .intval($option['category']);
		}		
		
		if ( $option['content'] != '' ) {
			$query_option[] = " AND n.content LIKE '%" .trim($conn->qStr($option['content']), "'"). "%'";
		}

		if ( $option['status'] == '1' || $option['status'] == '0' ) {
			$query_option[] = " AND n.status = '" .$option['status']. "'";
		}		
		
	}

    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];    
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];
    
    $smarty->assign('option', $option);
    
    return $query;
}

function getUserID( $username )
{
    global $conn;
    
    $sql = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 )
        return $rs->fields['UID'];
    
    return false;
}

$smarty->assign('notices', $notices);
$smarty->assign('total_notices', $total_notices);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('editor', true);
$smarty->assign('categories', get_notice_categories());
?>

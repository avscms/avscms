<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
Auth::checkAdmin();

$remove = '';
$ban_ip = NULL;

$action = ( isset($_GET['a']) && $_GET['a'] != '' ) ? $_GET['a'] : NULL;
if ( isset($_POST['add_ban']) or $action == 'add' ) {
    if ( isset($_GET['ip']) ) {
        $ban_ip = ( $_GET['ip'] != '' ) ? trim($_GET['ip']) : NULL;
		$remove = '&a=add&ip='.$ban_ip;
    } else {
        $ban_ip = trim($_POST['add_ip']);
    }

    if ( $ban_ip == '' ) {
        $errors[] = 'Ban IP field cannot be empty!';
		$err['add_ip'] = 1;
	} else {
        $ip = ip2long($ban_ip);
        if ( $ip == -1 || $ip === FALSE ) {
            $errors[] = 'Ban IP is not valid IP address!';
			$err['add_ip'] = 1;
		}		
    }
    
    if ( !$errors ) {
        $sql = "SELECT ban_id FROM bans WHERE ban_ip = " .$conn->qStr($ban_ip). " LIMIT 1";
        $conn->execute($sql);
        if ( !$conn->Affected_Rows() ) {
            $sql = "INSERT INTO bans (ban_ip, ban_date) VALUES (" .$conn->qStr($ban_ip). ", '" .date('Y-m-d h:i:s'). "')";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() ) {
                $messages[] = 'IP was successfully banned!';
			} else {
                $errors[] = 'Failed to ban IP!';
				$err['add_ip'] = 1;
			}
        } else {
            $errors[] = 'IP is already in the ban list!';
			$err['add_ip'] = 1;
		}
    }
}

if ( $action == 'delete' ) {
    $BID = ( isset($_GET['BID']) && is_numeric($_GET['BID']) ) ? trim($_GET['BID']) : NULL;
    if ( $BID ) {
        $sql = "DELETE FROM bans WHERE ban_id = " .$conn->qStr($BID). "";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() )
            $messages[] = 'Ban was successfully removed!';
        else
            $errors[] = 'Failed to remove ban! Ban does not exist!?';
    } else
        $errors[] = 'Ban id not set or not numeric!?';
		$remove = '&a=delete&BID='.$BID;
	
}



$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

$query          = constructQuery();
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_bans    = $rs->fields['total_bans'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_bans);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$bans           = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query_module = '';

    $query              = array();
    $query_select       = "SELECT * FROM bans" .$query_module;
    $query_count        = "SELECT count(*) AS total_bans FROM bans" .$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $option_orig        = array('ip' => '', 'sort' => 'ban_id', 'order' => 'DESC', 'display' => '10');
	
	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_bans_option']);
	}	
	
    $option             = ( isset($_SESSION['search_bans_option']) ) ? $_SESSION['search_bans_option'] : $option_orig;
    
    if ( isset($_POST['search_bans']) ) {
        $option['ip']       = trim($_POST['ip']);
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        $option['display']  = trim($_POST['display']);
        
        if ( $option['ip'] != '' ) {
            $query_option[] = " WHERE ban_ip LIKE '%" .trim($conn->qStr($option['ip']), "'"). "%'";
		}
        
        $query_add .= " ORDER BY " .$option['sort']. " " .$option['order'];
        
        $_SESSION['search_bans_option'] = $option;
		
	} elseif (isset($_SESSION['search_bans_option'])) {	
	
		$option = $_SESSION['search_bans_option'];	

        if ( $option['ip'] != '' ) {
            $query_option[] = " WHERE ban_ip LIKE '%" .trim($conn->qStr($option['ip']), "'"). "%'";
		}
        
        $query_add .= " ORDER BY " .$option['sort']. " " .$option['order'];
		
    }
    
    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];	
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('bans', $bans);
$smarty->assign('ban_ip', $ban_ip);
$smarty->assign('total_bans', $total_bans);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>

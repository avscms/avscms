<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if (isset($_POST['delete_selected_blogs'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_blogs' && substr($key, 0, 17) == 'blog_id_checkbox_') {
            if ( $value == 'on' ) {
                $blog_id = str_replace('blog_id_checkbox_', '', $key);
                deleteBlog($blog_id);
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select blogs to be deleted!';
    } else {
        $messages[] = 'Successfully deleted ' .$index. ' (selected) blogs!';
    }
}
            
if (isset($_POST['suspend_selected_blogs']) || isset($_POST['approve_selected_blogs']) ) {
    $act        = 1;
    $act_name   = 'activated';
    $index      = 0;
    if ( isset($_POST['suspend_selected_blogs']) ) {
        $act        = 0;
        $act_name   = 'suspended';
    }

    foreach ( $_POST as $key => $value ) {
        if ( substr($key, 0, 17) == 'blog_id_checkbox_' && $value == 'on' ) {
            $bid = intval(str_replace('blog_id_checkbox_', '', $key));
            $sql = "UPDATE blog SET status = '" .$act. "' WHERE BID = " .$bid. " LIMIT 1";
            $conn->execute($sql);
            ++$index;
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select blogs to be ' .$act_name. '!';
    } else {
        $messages[] = 'Successfully ' .$act_name. ' ' .$index. ' (selected) blogs!';
    }
}


$remove = NULL;

$query          = constructQuery();
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_blogs    = $rs->fields['total_blogs'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_blogs);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$blogs          = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT b.*, s.username FROM blog AS b, signup AS s WHERE b.UID = s.UID";
    $query_count        = "SELECT count(b.BID) AS total_blogs FROM blog AS b, signup AS s WHERE b.UID = s.UID";
    $query_option       = array();
    $option_orig        = array('username' => '', 'title' => '', 'content' => '', 'status' => '',
                                'sort' => 'b.BID', 'order' => 'DESC', 'display' => 100);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_blogs_option']);
	}
	
	$option             = ( isset($_SESSION['search_blogs_option']) ) ? $_SESSION['search_blogs_option'] : $option_orig;								
						
    if ( isset($_POST['search_blogs']) ) {
	
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
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
			$query_option[] = " AND b.UID = " .$UID;
		}

		if ( $option['title'] != '' ) {
			$query_option[] = " AND b.title LIKE '%" .trim($conn->qStr($option['title']), "'"). "%'";
		}

		if ( $option['content'] != '' ) {
			$query_option[] = " AND b.content LIKE '%" .trim($conn->qStr($option['content']), "'"). "%'";
		}

		if ( $option['status'] == '1' || $option['status'] == '0' ) {
			$query_option[] = " AND b.status = '" .$option['status']. "'";
		}
		
		$_SESSION['search_blogs_option'] = $option;
		
	} elseif (isset($_SESSION['search_blogs_option'])) {
		
		$option = $_SESSION['search_blogs_option'];

		if ( $option['username'] != '' || isset($_GET['UID']) ) {
			if ( $option['username'] != '' ) {
				$UID            = getUserID($option['username']);
			} else {
				$UID            = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? $_GET['UID'] : 0;
			}
			$UID            = ( $UID ) ? intval($UID) : 0;
			$query_option[] = " AND b.UID = " .$UID;
		}

		if ( $option['title'] != '' ) {
			$query_option[] = " AND b.title LIKE '%" .trim($conn->qStr($option['title']), "'"). "%'";
		}

		if ( $option['content'] != '' ) {
			$query_option[] = " AND b.content LIKE '%" .trim($conn->qStr($option['content']), "'"). "%'";
		}

		if ( $option['status'] == '1' || $option['status'] == '0' ) {
			$query_option[] = " AND b.status = '" .$option['status']. "'";
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

$smarty->assign('blogs', $blogs);
$smarty->assign('total_blogs', $total_blogs);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('categories', get_categories());
?>

<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/include/function_smarty.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';

if (isset($_POST['delete_selected_videos'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_videos' && substr($key, 0, 18) == 'video_id_checkbox_') {        
            if ( $value == 'on' ) {
                deleteVideo(str_replace('video_id_checkbox_', '', $key));
                ++$index;
            }
        }
    }
    
    if ( $index === 0 ) {
        $errors[]   = 'Please select videos to be deleted!';
    } else {
        $messages[] = 'Successfully deleted ' .$index. ' (selected) videos!';
    }
}

if (isset($_POST['suspend_selected_videos']) || isset($_POST['approve_selected_videos']) ) {
    $act        = 1;
    $act_name   = 'activated';
    $index      = 0;
    if ( isset($_POST['suspend_selected_videos']) ) {
        $act        = 0;
        $act_name   = 'suspended';
    }

    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_videos' && substr($key, 0, 18) == 'video_id_checkbox_') {        
            if ( $value == 'on' ) {
                $vid = intval(str_replace('video_id_checkbox_', '', $key));
                $sql = "UPDATE video SET active = '" .$act. "' WHERE VID = " .$vid. " LIMIT 1";
                $conn->execute($sql);
                if ( $act_name == 'activated' ) {
                    send_video_approve_email($vid);
                }
                ++$index;
            }
        }
    }
    
    if ( $index === 0 ) {
        $errors[]   = 'Please select videos to be ' .$act_name. '!';
    } else {    
        $messages[] = 'Successfully ' .$act_name. ' ' .$index. ' (selected) videos!';
    }
}

$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

$query          = constructQuery($module_keep);
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_videos   = $rs->fields['total_videos'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_videos);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();

function constructQuery($module)
{
    global $smarty, $conn;

    $query_module = '';

    $query              = array();
    $query_select       = "SELECT v.*,s.username FROM video AS v, signup AS s WHERE v.UID = s.UID" .$query_module;
    $query_count        = "SELECT count(v.VID) AS total_videos FROM video AS v WHERE v.VID != ''" .$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $option_orig        = array('username' => '', 'title' => '', 'description' => '', 'keyword' => '', 'channel' => '', 'active' => '',
                                'sort' => 'VID', 'order' => 'DESC', 'display' => 100);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_videos_option']);
	}
	
	$option             = ( isset($_SESSION['search_videos_option']) ) ? $_SESSION['search_videos_option'] : $option_orig;
	
	if ( isset($_GET['UID'] ) ) {
		unset ($_SESSION['search_videos_option']);
		$UID = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? $_GET['UID'] : 0;
		$query_option[] = " AND v.UID = " .$conn->qStr($UID). "";
	}

	if ( isset($_GET['CID']) && is_numeric($_GET['CID']) && channelExists($_GET['CID']) ) {
		unset ($_SESSION['search_videos_option']);
		$CID = $_GET['CID'];
		$query_option[] = " AND v.channel = " .intval($CID);
		$option['channel'] = $CID;
	}

	if ( isset($_GET['status'] ) ) {
		unset ($_SESSION['search_videos_option']);
		$status = ( isset($_GET['status']) && is_numeric($_GET['status']) ) ? $_GET['status'] : 0;
		$query_option[] = " AND v.active = '" .$status. "'";
		$option['active'] = $status;
	}
	
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['description']  = null;
        $option['keyword']      = trim($_POST['keyword']);
        $option['channel']      = intval(trim($_POST['channel']));
        $option['active']       = trim($_POST['active']);
        $option['type']         = trim($_POST['type']);		
		$option['sort']         = trim($_POST['sort']);		
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
	
		if ( $option['username'] != '' && !isset($UID)) {
			$UID            = getUserID($option['username']);
			$UID            = ( $UID ) ? $UID : 0;
			$query_option[] = " AND v.UID = " .$conn->qStr($UID). "";
		}

		if ( $option['title'] != '' ) {
			$query_option[] = " AND v.title LIKE '%" .trim($conn->qStr($option['title']), "'"). "%'";
		}

		if ( $option['description'] != '' ) {
			$query_option[] = " AND v.description LIKE '%" .trim($conn->qStr($option['description']), "'"). "%'";
		}
			
		if ( $option['keyword'] != '' ) {
			$query_option[] = " AND v.keyword LIKE '%" .trim($conn->qStr($option['keyword']), "'"). "%'";
		}

		if ( $option['channel'] != '' ) {
			$query_option[] = " AND v.channel = " .intval($option['channel']);
		}
		
		if ( $option['type'] != '' ) {
			$query_option[] = " AND v.type = " .$conn->qStr($option['type']). "";
		}

		if ( $option['active'] == '0' || $option['active'] == '1' ) {
			$query_option[] = " AND v.active = '" .$option['active']. "'";
		}
	
		$_SESSION['search_videos_option'] = $option;
	
	} elseif (isset($_SESSION['search_videos_option'])) {
		
		$option = $_SESSION['search_videos_option'];
		
		if ( $option['username'] != '' || isset($_GET['UID']) ) {
			if ( $option['username'] != '' ) {
				$UID            = getUserID($option['username']);
			} else {
				$UID            = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? $_GET['UID'] : 0;
			}
			$UID            = ( $UID ) ? $UID : 0;
			$query_option[] = " AND v.UID = " .$conn->qStr($UID). "";
		}

		if ( $option['title'] != '' ) {
			$query_option[] = " AND v.title LIKE '%" .trim($conn->qStr($option['title']), "'"). "%'";
		}

		if ( $option['description'] != '' ) {
			$query_option[] = " AND v.description LIKE '%" .trim($conn->qStr($option['description']), "'"). "%'";
		}
			
		if ( $option['keyword'] != '' ) {
			$query_option[] = " AND v.keyword LIKE '%" .trim($conn->qStr($option['keyword']), "'"). "%'";
		}

		if ( $option['channel'] != '' ) {
			$query_option[] = " AND v.channel = " .intval($option['channel']);
		}

		if ( $option['active'] == '0' || $option['active'] == '1' ) {
			$query_option[] = " AND v.active = '" .$option['active']. "'";
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

$smarty->assign('videos', $videos);
$smarty->assign('total_videos', $total_videos);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('channels', get_categories());
?>

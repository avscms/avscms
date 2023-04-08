<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/include/function_smarty.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$remove         = NULL;

if (isset($_POST['unflag_selected_videos'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_videos' && substr($key, 0, 18) == 'video_id_checkbox_') {
            if ( $value == 'on' ) {
                $sql = "DELETE FROM video_flags WHERE VID = " .intval(str_replace('video_id_checkbox_', '', $key)). " LIMIT 1";
                $conn->execute($sql);
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select videos to be unflagged!';
    } else {
        $messages[] = 'Successfully unflagged ' .$index. ' (selected) videos!';
    }
}

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

$query          = constructQuery();
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_videos   = $rs->fields['total_videos'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_videos);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();


function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT v.*, s.username, f.UID AS SUID, f.FID, f.add_date, f.reason, f.message
                           FROM video AS v, signup AS s, video_flags AS f
                           WHERE v.VID = f.VID AND v.UID = s.UID";
    $query_count        = "SELECT COUNT(f.VID) AS total_videos FROM video AS v, signup AS s, video_flags AS f
                           WHERE v.VID = f.VID AND v.UID = s.UID";
    $query_option       = array();
    $option_orig        = array('username' => '', 'title' => '', 'flagger' => '', 'sort' => 'v.VID', 'order' => 'DESC', 'display' => 100);
	
	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_videos_flagged_option']);
	}
	
	$option             = ( isset($_SESSION['search_videos_flagged_option']) ) ? $_SESSION['search_videos_flagged_option'] : $option_orig;	
	
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['flagger']      = trim($_POST['flagger']);
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
			$query_option[] = " AND v.UID = " .$UID;
		}
		
		if ( $option['flagger'] != '' ) {
			$UID                = getUserID($option['flagger']);
			$UID                = ( $UID ) ? intval($UID) : 0;
			$query_option[]     = " AND f.UID = " .$UID;
		}
									
		if ( $option['title'] != '' ) {
			$query_option[] = " AND v.title LIKE '%" .trim($conn->qStr($option['title']), "'"). "%'";
		}

		$_SESSION['search_videos_flagged_option'] = $option;
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
    if ( $conn->Affected_Rows() == 1 ) {
        return $rs->fields['UID'];
    }

    return false;
}

$smarty->assign('videos', $videos);
$smarty->assign('total_videos', $total_videos);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>

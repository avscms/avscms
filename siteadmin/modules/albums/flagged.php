<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';

Auth::checkAdmin();

$remove         = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if (isset($_POST['unflag_selected_photos'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_albums' && substr($key, 0, 18) == 'photo_id_checkbox_') {
            if ( $value == 'on' ) {
                $sql = "DELETE FROM photo_flags WHERE PID = " .intval(str_replace('photo_id_checkbox_', '', $key)). " LIMIT 1";
                $conn->execute($sql);
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select photos to be unflagged!';
    } else {
        $messages[] = 'Successfully unflagged ' .$index. ' (selected) photos!';
    }
}

if (isset($_POST['delete_selected_photos'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_albums' && substr($key, 0, 18) == 'photo_id_checkbox_') {
            if ( $value == 'on' ) {
                deletePhoto(str_replace('photo_id_checkbox_', '', $key));
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $errors[]   = 'Please select photos to be deleted!';
    } else {
        $messages[] = 'Successfully deleted ' .$index. ' (selected) photos!';
    }
}

if (isset($_POST['suspend_selected_photos']) || isset($_POST['approve_selected_photos']) ) {
    $act        = 1;
    $act_name   = 'activated';
    $index      = 0;
    if ( isset($_POST['suspend_selected_photos']) ) {
        $act        = 0;
        $act_name   = 'suspended';
    }

    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_albums' && substr($key, 0, 18) == 'photo_id_checkbox_') {
            if ( $value == 'on' ) {
                $pid = intval(str_replace('photo_id_checkbox_', '', $key));
                $sql = "UPDATE photos SET status = '" .$act. "' WHERE PID = " .$pid. " LIMIT 1";
                $conn->execute($sql);
                ++$index;
            }
        }
    }
    
    if ( $index === 0 ) {
        $errors[]   = 'Please select photos to be ' .$act_name. '!';
    } else {
        $messages[] = 'Successfully ' .$act_name. ' ' .$index. ' (selected) photos!';
    }
}

$query          = constructQuery();
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_photos   = $rs->fields['total_photos'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_photos);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$photos         = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT p.*, s.username, f.*
                           FROM photos AS p, signup AS s, photo_flags AS f
                           WHERE p.PID = f.PID AND f.UID = s.UID";
    $query_count        = "SELECT COUNT(f.PID) AS total_photos
                           FROM photos AS p, signup AS s, photo_flags AS f
                           WHERE p.PID = f.PID AND f.UID = s.UID";
    $query_option       = array();
    $option_orig        = array('flagger' => '', 'sort' => 'p.PID', 'order' => 'DESC', 'display' => 100);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_albums_flagged_option']);
	}
	
	$option             = ( isset($_SESSION['search_albums_flagged_option']) ) ? $_SESSION['search_albums_flagged_option'] : $option_orig;
	
    if ( isset($_POST['search_flags']) ) {

        $option['flagger']      = trim($_POST['flagger']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);

		if ( $option['flagger'] != '' ) {
			$UID                = getUserID($option['flagger']);
			$UID                = ( $UID ) ? intval($UID) : 0;
			$query_option[]     = " AND f.UID = " .$UID;
		}
		
		$_SESSION['search_albums_flagged_option'] = $option;
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

$smarty->assign('photos', $photos);
$smarty->assign('photos_total', $total_photos);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>

<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
Auth::checkAdmin();

$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if ( isset($_GET['a']) ) {
    $action = trim($_GET['a']);
    $AID    = ( isset($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
    switch ( $action ) {
    case 'delete':
        $sql    = "DELETE FROM adv_pause WHERE id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $messages[] = 'Pause ad was successfully deleted!';
        } else {
            $errors[] = 'Failed to delete pause ad! Are you sure this ad exists?!';
        }
        $remove = '&a=delete&AID=' .$AID;
        break;
    case 'activate':
    case 'suspend':
        $status     = ( $action == 'activate' ) ? 1 : 0;
        $sql        = "UPDATE adv_pause SET status = '" .$status. "' WHERE id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $messages[] = 'Pause advertise was successfully ' .$action. 'ed!';
        } else {
            $errors[] = 'Failed to ' .$action. ' pause advertise! Are you sure this advertise exists?!';
        }
        $remove = '&a=' .$action. '&AID=' .$AID;
        break;
    default:
        $errors[] = 'Invalid action! Allowed actions: delete, activate and suspend!';
    }
}

$query          = constructQuery();
$rs             = $conn->execute($query['count']);
$total_advs     = $rs->fields['total_advs'];
$pagination     = new Pagination($query['items']);
$limit          = $pagination->getLimit($total_advs);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$advs           = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_count        = "SELECT COUNT(id) AS total_advs FROM adv_pause";
    $query_select       = "SELECT * FROM adv_pause";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'id', 'order' => 'DESC', 'display' => 20);
	
	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_pause_advertise']);
	}		
	
    $option             = ( isset($_SESSION['search_pause_advertise']) ) ? $_SESSION['search_pause_advertise'] : $option_orig;
    if ( isset($_POST['search_pause']) ) {
		
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        $option['display']  = intval(trim($_POST['display']));

        $_SESSION['search_pause_advertise'] = $option;		
		
    } elseif (isset($_SESSION['search_pause_advertise'])) {
		
		$option = $_SESSION['search_pause_advertise'];
		
	}
	
	$query_add = " ORDER BY " .$option['sort']. " " .$option['order'];		
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count;
    $query['items']     = $option['display'];

    $smarty->assign('option', $option);

    return $query;
}

$smarty->assign('advs', $advs);
$smarty->assign('advs_total', $total_advs);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
?>
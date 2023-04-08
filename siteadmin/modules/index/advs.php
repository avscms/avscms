<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_GET['a']) ) {
    $action     = trim($_GET['a']);
    $AID        = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
    if ( $action == 'activate' or $action == 'suspend' ) {
        $status = ( $_GET['a'] == 'activate' ) ? '1' : '0';
        $sql    = "UPDATE adv SET adv_status = '" .$status. "' WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $messages[] = 'Advertise successfully ' .$_GET['a']. 'ed!';
        } else {
            $errors[] = 'Failed to ' .$_GET['a']. ' advertise! Invalid advertise id!?';
        }
    } elseif ( $action == 'delete' ) {
        $sql    = "DELETE FROM adv WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        $messages[]    = 'Advertise deleted successfully!';
    } else {
        $errors[] = 'Invalid action specified! Allowed actions: activate, suspend and delete!';
    }
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$advs       = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT a.*, g.advgrp_name FROM adv AS a, adv_group AS g WHERE a.adv_group = g.advgrp_id";
    $query_count        = "SELECT COUNT(adv_id) AS total_advs FROM adv";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'a.adv_id', 'order' => 'DESC');
	
	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_advertise_option']);
	}		
	
    $option             = ( isset($_SESSION['search_advertise_option']) ) ? $_SESSION['search_advertise_option'] : $option_orig;
    
    if ( isset($_POST['search_advertise']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        
        $_SESSION['search_advertise_option'] = $option;
    }
    $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];	
    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('advs', $advs);
?>

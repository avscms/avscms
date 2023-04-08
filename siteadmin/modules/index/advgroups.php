<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_GET['a']) && ( $_GET['a'] == 'activate' or $_GET['a'] == 'suspend' ) ) {
    $AGID   = ( isset($_GET['AGID']) && is_numeric($_GET['AGID']) ) ? intval(trim($_GET['AGID'])) : NULL;
    $status = ( $_GET['a'] == 'activate' ) ? '1' : '0';
    $sql    = "UPDATE adv_group SET advgrp_status = '" .$status. "' WHERE advgrp_id = " .$AGID. " LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() ) {
        $messages[] = 'Advertise group successfully ' .$_GET['a']. 'ed!';
    } else {
        $errors[] = 'Failed to ' .$_GET['a']. ' advertise group! Invalid advertise id!?';
    }
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$advgroups  = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT * FROM adv_group";
    $query_count        = "SELECT COUNT(advgrp_id) AS total_adv_groups FROM adv_group";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'advgrp_id', 'order' => 'ASC');
	
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

$smarty->assign('advgroups', $advgroups);
?>

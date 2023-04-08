<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_GET['a']) ) {
    $action     = trim($_GET['a']);
    $EID        = ( isset($_GET['EID']) && is_numeric($_GET['EID']) ) ? intval(trim($_GET['EID'])) : NULL;
    if ( $action == 'activate' or $action == 'suspend' ) {
        $status = ( $_GET['a'] == 'activate' ) ? '1' : '0';
        $sql    = "UPDATE encoding SET status = '" .$status. "' WHERE id = " .$EID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $messages[] = 'Encoding successfully ' .$_GET['a']. 'ed!';
        } else {
            $errors[] = 'Failed to ' .$_GET['a']. ' encoding! Invalid encoding id!?';
        }
    } elseif ( $action == 'delete' ) {
        $sql    = "DELETE FROM encoding WHERE id = " .$EID. " LIMIT 1";
        $conn->execute($sql);
        $messages[]    = 'Encoding deleted successfully!';
    } else {
        $errors[] = 'Invalid action specified! Allowed actions: activate, suspend and delete!';
    }
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$encodings       = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT * FROM encoding";
    $query_count        = "SELECT COUNT(id) AS total_encodings FROM encoding";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'id', 'order' => 'DESC');
	
	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset($_SESSION['search_encoding_option']);
	}		
	
    $option             = ( isset($_SESSION['search_encoding_option']) ) ? $_SESSION['search_encoding_option'] : $option_orig;
    
    if ( isset($_POST['search_encoding']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        
        $_SESSION['search_encoding_option'] = $option;
    }
    $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];	
    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('encodings', $encodings);
?>

<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$remove = NULL;
if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
    $VID = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? trim($_GET['VID']) : NULL;
    if ( $VID ) {
        $sql = "DELETE FROM feature_req WHERE VID = " .$conn->qStr($VID). "";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() > 0 )
            $msg = 'Feature request(s) deleted successfuly!';
        else
            $err = 'Failed to delete video feature request(s)! Invalid video id?';
    } else
        $err = 'Invalid Video Id. The video id must hav a numeric value!';
    $remove = '&a=delete&VID=' .$VID;
}

$query  = constructQuery();
$sql    = $query['select'];
$rs     = $conn->execute($sql);
$videos = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT * FROM feature_req f, video v WHERE f.VID = v.VID and v.featured = 'no'";
    $query_count        = "SELECT count(fr.VID) AS total_videos FROM feature_req f, video v WHERE f.VID = v.VID and v.featured = 'no'";
    $query_add          = " AND";
    $query_option       = array();
    $option_orig        = array('username' => '', 'title' => '', 'description' => '', 'sort' => 'VID', 'order' => 'DESC', 'display' => 10);
    $option             = ( isset($_SESSION['search_videos_option']) ) ? $_SESSION['search_videos_option'] : $option_orig;
    
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['description']  = trim($_POST['description']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
        
        if ( $option['username'] != '' ) {
            $UID            = getUserID($option['username']);
            $UID            = ( $UID ) ? $UID : 0;
            $query_option[] = $query_add. " v.UID = " .$conn->qStr($UID). "";
            $query_add      = " AND";
        }

        if ( $option['title'] != '' ) {
            $query_option[] = $query_add. " v.title LIKE '%" .trim($conn->qStr($option['title']), "'"). "%'";
            $query_add      = " AND";
        }

        if ( $option['description'] != '' ) {
            $query_option[] = $query_add. " v.description LIKE '%" .trim($conn->qStr($option['description']), "'"). "%'";
            $query_add      = " AND";
        }

        $_SESSION['search_videos_option'] = $option;
    }
    
    $sort                   = ( $option['sort'] == 'req' or $option['sort'] == 'date' ) ? 'f.' .$option['sort'] : 'v.' .$option['sort'];
    $query_option[]         = " ORDER BY " .$sort. " " .$option['order'];
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
?>

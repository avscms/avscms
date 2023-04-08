<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$category['name'] = '';

if ( isset($_POST['add_category']) ) {
    $name   = trim($_POST['name']);
    
    if ( $name == '' ) {
        $errors[] = 'Category name field cannot be blank!';
		$err['name'] = 1;
    } else {
        $sql        = "SELECT category_id FROM notice_categories WHERE name = " .$conn->qStr($name). " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() > 0 ) {
            $errors[]   = 'Category name \'' .htmlspecialchars($name, ENT_QUOTES, 'UTF-8'). ' is already used. Please choose another name!';
        }
    }
    $category['name'] = $name;
    
    if ( !$errors ) {
        $sql = "INSERT INTO notice_categories (name) VALUES (" .$conn->qStr($name). ")";
        $conn->execute($sql);
        $messages[] = 'Category successfully added!';
		$category['name'] = '';		
    }
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$categories   = $rs->getrows();

function constructQuery()
{
    global $smarty, $conn;

    $query              = array();
    $query_select       = "SELECT * FROM notice_categories";
    $query_count        = "SELECT count(category_id) AS total_categories FROM notice_categories";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'category_id', 'order' => 'DESC');
	
	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset($_SESSION['search_ncategories_option']);
	}	
	
    $option             = ( isset($_SESSION['search_ncategories_option']) ) ? $_SESSION['search_ncategories_option'] : $option_orig;
    
    if ( isset($_POST['search_categories']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);      
        $_SESSION['search_ncategories_option'] = $option;
    }
    $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('categories', $categories);
$smarty->assign('category', $category);
?>

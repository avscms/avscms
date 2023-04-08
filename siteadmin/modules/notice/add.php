<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/include/function_editor.php';

$notice     = array('username' => '', 'title' => '', 'category' => '', 'content' => '', 'status' => 1);
if ( isset($_POST['add_notice']) ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter     = new VFilter();
    $valid      = new VValidation();    
    $username   = $filter->get('username');
    $title      = $filter->get('title');
    $content    = wysiwygColorToCSS(nl2br(trim($_POST['notice-content'])));
    $category   = (int) $filter->get('category');
	$status		= (int) $filter->get('status');
	
    if ( $username == '' ) {
        $errors[]   = 'Username field cannot be blank!';
		$err['username'] = 1;		
    } elseif ( !$valid->usernameExists($username) ) {
        $errors[]   = 'Username does not exist!';
		$err['username'] = 1;		
    }
   $notice['username'] = $username;

    
    if ( $title == '' ) {
        $errors[]   = 'Notice title field cannot be blank!';
		$err['title'] = 1;
    } elseif ( strlen($title) > 299 ) {		
        $errors[]   = 'Notice title field cannot contain more then 299 characters!';
		$err['title'] = 1;		
    }
	$notice['title']    = $title;

    
    if ( $category == '0' or $category == '' ) {
        $errors[]   = 'Please select a notice category!';
		$err['category'] = 1;		
    } else {
        $notice['category'] = $category;
    }
    
    if ( $content == '' ) {
        $errors[]   = 'Notice content cannot be blank!';
		$err['content'] = 1;
    }
    $notice['content'] = nl2br(trim($_POST['notice-content']));
	$notice['status'] = $status;
    
    if ( !$errors ) {
        $sql    = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $rs     = $conn->execute($sql);
        $uid    = $rs->fields['UID'];
        $sql    = "INSERT INTO notice (UID, category, title, content, addtime, adddate, status)
                   VALUES (" .intval($uid). ", " .intval($category). ", " .$conn->qStr($title). ",
                           " .$conn->qStr($content). ", " .time(). ", '" .date('Y-m-d'). "', '" .$status. "')";
        $conn->execute($sql);

		$sql    = "UPDATE notice_categories SET total_notices = total_notices+1 WHERE category_id = " .intval($category). " LIMIT 1";
		$conn->execute($sql);	
	
        $messages[] = 'Notice was successfully added!';
		$notice['username'] = '';
		$notice['title']    = '';
		$notice['category'] = '';
		$notice['content'] ='';		
    }	
}


$sql        = "SELECT category_id, name FROM notice_categories
               WHERE status = '1' ORDER BY name DESC";
$rs         = $conn->execute($sql);
$categories = $rs->getrows();

$smarty->assign('notice', $notice);
$smarty->assign('editor', true);
$smarty->assign('categories', $categories);
?>

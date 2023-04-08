<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
require_once ('editor_files/editor_functions.php');
require_once ('editor_files/config.php');
require_once ('editor_files/editor_class.php');

$editor = new wysiwygPro();
$editor->usexhtml(true);

$NID    = ( isset($_GET['NID']) && noticeExists($_GET['NID']) ) ? intval($_GET['NID']) : NULL;
if ( !$NID ) {
    $errors[]   = 'Invalid notice id. Are you sure this notice exists?!';
}

$notice = array();
if ( isset($_POST['submit_edit_notice']) && !$errors ) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter     = new VFilter();
    $valid      = new VValidation();    
    $username   = $filter->get('username');
    $title      = $filter->get('title');
    $content    = trim($_POST['htmlCode']);
    $category   = $filter->get('category', 'INTEGER');
    
    if ( $username == '' ) {
        $errors[]   = 'Username field cannot be blank!';
    } elseif ( !$valid->usernameExists($username) ) {
        $errors[]   = 'Username does not exist!';
    }
    
    if ( $title == '' ) {
        $errors[]   = 'Notice title field cannot be blank!';
    } elseif ( strlen($title) > 299 ) {
        $errors[]   = 'Notice title field cannot contain more then 299 characters!';
    }
    
    if ( $category == '0' or $category == '' ) {
        $errors[]   = 'Please select a notice category!';
    }
    
    if ( $content == '' ) {
        $errors[]   = 'Notice content cannot be blank!';
    }
    
    if ( !$errors ) {
        $sql    = "SELECT UID FROM signup WHERE username = " .$conn->qStr($username). " LIMIT 1";
        $rs     = $conn->execute($sql);
        $uid    = intval($rs->fields['UID']);
        $sql    = "UPDATE notice SET UID = " .$uid. ", category = " .$category. ", title = " .$conn->qStr($title). ",
                                     content = " .$conn->qStr($content). "
                   WHERE NID = " .$NID. " LIMIT 1";
        echo var_dump($sql). '<br>';
        $conn->execute($sql);
        $_SESSION['message'] = 'Notice was successfully updated!';
        VRedirect::go($config['BASE_URL']. '/siteadmin/notices.php?m=list');
    }
}

$sql        = "SELECT category_id, name FROM notice_categories
               WHERE status = '1' ORDER BY name DESC";
$rs         = $conn->execute($sql);
$categories = $rs->getrows();

function noticeExists( $nid ) {
    global $conn;
    $sql    = "SELECT NID FROM notice WHERE NID = " .intval($nid). " LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

if ( !$errors ) {
    $sql    = "SELECT n.NID, n.category, n.title, n.content, s.username
               FROM notice AS n, signup AS s WHERE n.NID = " .$NID. " AND n.UID = s.UID LIMIT 1";
    $rs     = $conn->execute($sql);
    $notice = $rs->getrows();
    $notice = $notice['0'];
}

$editor->set_code($notice['content']);

$smarty->assign('editor_wysiswyg', $editor->return_editor('100%', 350));
$smarty->assign('categories', $categories);
$smarty->assign('notice', $notice);
?>

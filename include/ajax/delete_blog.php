<?php

defined('_VALID') or die('Restricted Access!');

if ( $config['blog_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/function_user.php';


$response = array('status' => 0, 'msg' => '', 'debug' => '');
if ( isset($_POST['blog_id']) ) {
    if ( isset($_SESSION['uid']) ) {
        $filter     = new VFilter();
        $bid        = $filter->get('blog_id', 'INTEGER');

        $uid        = intval($_SESSION['uid']);
        $sql        = "SELECT UID FROM blog WHERE BID = " .$bid. " LIMIT 1";
        $rs         = $conn->execute($sql);
	   
       if ( $conn->Affected_Rows() === 1 ) { 
           $blog  = $rs->getrows();
			if ($uid == $blog[0][0]) {
				deleteBlog( $bid );
				$response['status'] = 1;
				$response['msg'] = $lang['ajax.delete_blog_success'];
           } else {
                $response['msg'] = $lang['ajax.delete_blog_failed'];
           }
		} else {
			$response['msg'] = $lang['ajax.delete_blog_failed'];
        } 
       
    } else {
		$response['msg']   = $lang['ajax.delete_blog_login'];
    }
}

echo json_encode($response);
die();
?>

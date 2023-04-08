<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'users' => '', 'page' => 0, 'pages' => 0);
if ( isset($_POST['gender']) && isset($_POST['order']) && isset($_POST['page']) && isset($_POST['move']) ) {
    $filter     = new VFilter();
    $gender     = $filter->get('gender');
    $order      = $filter->get('order');
    $move       = $filter->get('move');
    $page       = $filter->get('page', 'INTEGER');
    if ( ( $gender == 'Male' || $gender == 'Female' || $gender == 'All' ) &&
         ( $order == 'new' || $order == 'online' || $order == 'popular' ) &&
         ( $move == 'prev' || $move == 'next' ) ) {
        if ( $move == 'prev' ) {
            $page = ( $page < 1 ) ? 1: $page-1;
        } else {
            $page = $page+1;
        }
        
        if ( $order == 'online' ) {
            $sql_count  = "SELECT COUNT(o.UID) AS total_users FROM users_online AS o, signup AS s
                           WHERE s.account_status = 'Active' AND s.gender = '" .$gender. "'
                           AND s.UID = o.UID AND o.online > " .(time()-300);
            $sql        = "SELECT s.UID, s.username, s.photo, s.gender FROM signup AS s, users_online AS o
                           WHERE s.account_status = 'Active' AND s.gender = '" .$gender. "'
                           AND s.UID = o.UID AND o.online > " .(time()-300). " ORDER BY o.online DESC LIMIT ";
        } elseif ( $order == 'popular' ) {
            $sql_count  = "SELECT COUNT(UID) AS total_users FROM signup WHERE account_status = 'Active'";
            $sql        = "SELECT UID, username, photo, gender FROM signup WHERE account_status = 'Active' ORDER BY popularity DESC LIMIT ";
        } else {
            $sql_count  = "SELECT COUNT(UID) AS total_users FROM signup WHERE account_status = 'Active' AND gender = '" .$gender. "'";
            $sql        = "SELECT UID, username, photo, gender FROM signup WHERE account_status = 'Active' AND gender = '" .$gender. "' ORDER BY addtime DESC LIMIT ";
        }
        $rs             = $conn->execute($sql_count);
        $total          = $rs->fields['total_users'];
        $pagination     = new Pagination(5, $page);
        $limit          = $pagination->getLimit($total);
        $sql            = $sql . $limit;
        $rs             = $conn->execute($sql);
        $users          = $rs->getrows();
        $code           = array();
        $total_pages    = $pagination->getTotalPages();
        $page           = ( $page >= $total_pages ) ? $total_pages : $page;
        foreach ( $users as $user ) {
            $photo      = ( $user['photo'] == '' ) ? 'nopic-' .$user['gender']. '.gif' : $user['photo'];
            $code[]     = '<div class="user_box">';
            $code[]     = '<a href="' .$config['BASE_URL']. '/user/' .$user['username']. '"><img src="' .$config['BASE_URL']. '/media/users/' .$photo. '" width="100" height="120" alt="' .$user['username']. '" /><br /><span class="font-12">' .$user['username']. '</span></a><br />';
            $code[]     = '</div>';
        }
        
        $data['status'] = ( $total_pages > 1 ) ? 1 : 0;
        $data['page']   = $page;
        $data['users']  = implode("\n", $code);
        $data['pages']  = $total_pages;
    }
}

echo json_encode($data);
die();
?>

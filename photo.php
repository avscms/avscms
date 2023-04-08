<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';
require 'include/function_user.php';

if ( $config['photo_module'] == '0' ) {
        VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$pid = get_request_arg('photo');
if ( !$pid ) {
    VRedirect::go($config['BASE_URL']. '/notfound/photo_missing');
}

$sql        = "SELECT PID, AID, caption, rate, likes, dislikes FROM photos WHERE PID = " .$pid. " AND status = '1' LIMIT 1";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/photo_missing');
}
$photo      = $rs->getrows();
$photo      = $photo['0'];
$aid        = intval($photo['AID']); 

$sql        = "SELECT UID, name, type, tags, total_photos FROM albums WHERE AID = " .$aid. " AND status = '1' LIMIT 1";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/album_missing');
}
$album      = $rs->getrows();
$album      = $album['0'];
$uid        = intval($album['UID']);
$is_friend  = true;
if ( $album['type'] == 'private' ) {
    $UID = ( isset($_SESSION['uid']) ) ? intval($_SESSION['uid']) : NULL;
    if ( $UID ) {
        if ( $UID != $uid ) {
            $sql = "SELECT FID FROM friends WHERE UID = " .$uid. " AND FID = " .$UID. " AND status = 'Confirmed' LIMIT 1";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 0 ) {
                $is_friend = false;
            }
        }
    } else {
        $is_friend = false;
    }
}

$sql    = "SELECT * FROM signup WHERE UID = " .$album['UID']. " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/user_missing');
}
$user   = $rs->getrows();
$user   = $user['0'];

$sql        = "SELECT * FROM users_online WHERE UID = " .$album['UID']. " AND online > " .(time()-300). " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 )
	$online = true;
else
	$online = false;


$sql    = "SELECT PID FROM photos WHERE AID = " .$aid. " AND PID < " .$pid. " AND status = '1'
           ORDER BY PID DESC LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
    $prev   = $rs->fields['PID'];
    $smarty->assign('prev', $prev);    
}

$sql    = "SELECT PID FROM photos WHERE AID = " .$aid. " AND PID > " .$pid. " AND status = '1'
           ORDER BY PID ASC LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
    $next   = $rs->fields['PID'];
    $smarty->assign('next', $next);
}

$sql            = "UPDATE photos SET total_views = total_views+1 WHERE PID = " .$pid. " LIMIT 1";
$conn->execute($sql);

$sql            = "SELECT COUNT(CID) AS total_comments FROM photo_comments WHERE PID = " .$pid. " AND status = '1'";
$rsc            = $conn->execute($sql);
$total          = $rsc->fields['total_comments'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT c.*, s.username, s.photo, s.gender
                   FROM photo_comments AS c, signup AS s
                   WHERE PID = " .$pid. " AND status = '1' AND c.UID = s.UID
                   ORDER BY addtime DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$comments       = $rs->getrows();
$page_link      = $pagination->getPagination('photo/' .$pid, 'p_photo_comments_' .$pid. '_');
$page_link_b    = $pagination->getPagination('photo/' .$pid, 'pp_photo_comments_' .$pid. '_');
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$self_title         = $album['name']. ' Photo - ' .$config['site_name'];
$self_description   = $album['name'];
$self_keywords      = $album['tags'];

$user['total_subscribers'] = get_user_total_subscribers($user['UID']);

$smarty->assign('errors',$errors);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'albums');
$smarty->assign('photo', $photo);
$smarty->assign('album', $album);
$smarty->assign('username', $user['username']);
$smarty->assign('user', $user);
$smarty->assign('online', $online);
$smarty->assign('is_friend', $is_friend);
$smarty->assign('comments', $comments);
$smarty->assign('comments_total', $total);
$smarty->assign('page_link', $page_link);
$smarty->assign('page_link_b', $page_link_b);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_description', $self_description);
$smarty->assign('self_keywords', $self_keywords);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display('photo.tpl');
$smarty->display('footer.tpl');
?>

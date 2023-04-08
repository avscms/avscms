<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';

if ( $config['photo_module'] == '0' ) {
	VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$module_template    = 'album';
$page               = ( isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
$query              = get_request();
if ( is_array($query) ) {
    foreach ( $query as $key => $value ) {
        if ( $value == 'album' ) {
            if ( isset($query[$key+1]) ) {
                $next       = $query[$key+1];
                if ( is_numeric($next) ) {
                    $aid    = $next;
                } else {
                    $module             = $next;
                    $modules_allowed    = array('slideshow', 'edit', 'addphotos', 'delete');
                    if ( in_array($module, $modules_allowed) ) {
                        $aid            = ( isset($query[$key+2]) ) ? $query[$key+2] : NULL;
                    } else {
                        VRedirect::go($config['BASE_URL']. '/notfound/album_missing');
                    }
                }
            }
        }
    }
}

if ( !isset($aid) || !is_numeric($aid) ) {
    VRedirect::go($config['BASE_URL']. '/notfound/album_missing');
}

$aid        = intval($aid);
$sql        = "SELECT * FROM albums WHERE AID = " .$aid. " LIMIT 1";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/album_missing');
}

$album      = $rs->getrows();
$album      = $album['0'];
$name       = $album['name'];
$tags       = $album['tags'];
$uid        = intval($album['UID']);

$sql        = "SELECT * FROM signup WHERE UID = '" .$uid. "' LIMIT 1";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    VRedirect::go($config['BASE_URL']. '/notfound/user_missing');
}
$user       = $rs->getrows();
$user       = $user['0'];
$username   = $user['username'];

$sql        = "SELECT * FROM users_online WHERE UID = " .$uid. " AND online > " .(time()-300). " LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 )
	$online = true;
else
	$online = false;

if ( isset($module) ) {
    require 'modules/album/' .$module. '.php';
    $module_template    = 'album_' .$module;
} else {
    $is_friend      = true;
    if ( $album['type'] == 'private' ) {
        $UID = ( isset($_SESSION['uid']) ) ? intval($_SESSION['uid']) : NULL;
        if ( $UID ) {
            if ( $UID != $album['UID'] ) {
                $sql = "SELECT FID FROM friends
                        WHERE ((UID = " .$uid. " AND FID = " .$UID. ")
                        OR (UID = " .$UID. " AND FID = " .$uid. "))
                        AND status = 'Confirmed'
                        LIMIT 1";
                $conn->execute($sql);
                if ( $conn->Affected_Rows() == 0 ) {
                    $is_friend = false;
                }
            }
        } else {
            $is_friend = false;
        }
    }
    
    $sql            = "SELECT COUNT(PID) AS total_photos FROM photos WHERE AID = " .$aid. " AND status = '1'";
    $rsc            = $conn->execute($sql);
    $total          = $rsc->fields['total_photos'];
    $pagination     = new Pagination(12);
    $limit          = $pagination->getLimit($total);
    $sql            = "SELECT PID, caption FROM photos WHERE AID = " .$aid. " AND status = '1' ORDER BY PID ASC LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $photos         = $rs->getrows();
    $page_link      = $pagination->getPagination('album/' .$aid. '/');
    $start_num      = $pagination->getStartItem();
    $end_num        = $pagination->getEndItem();        
    $sql            = "UPDATE albums SET total_views = total_views+1 WHERE AID = " .$aid. " LIMIT 1";
    $conn->execute($sql);
    
    $smarty->assign('photos_total', $total);
    $smarty->assign('photos', $photos);
    $smarty->assign('page_link', $page_link);
    $smarty->assign('start_num', $start_num);
    $smarty->assign('end_num', $end_num);
    $smarty->assign('is_friend', $is_friend);
}

$self_title            = $name.$seo['album_title'];
$self_meta_description = $name;
$self_meta_keywords    = str_replace(' ', ', ', $tags);

$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'albums');
$smarty->assign('user', $user);
$smarty->assign('online', $online);
$smarty->assign('username', $username);
$smarty->assign('album', $album);
$smarty->assign('self_title', $self_title);
$smarty->assign('self_meta_description', $self_meta_description);
$smarty->assign('self_meta_keywords', $self_meta_keywords);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display($module_template. '.tpl');
$smarty->display('footer.tpl');
?>

<?php
define('_VALID', true);
require 'include/config.php';
require 'include/function_global.php';
require 'include/function_smarty.php';
require 'classes/pagination.class.php';
require 'include/function_user.php';

if (isset($new_permisions['write_in_blog'])) {
	if ($new_permisions['write_in_blog'] == 0) {
		VRedirect::go($config['BASE_URL']. '/notfound/blog_permission');
	}
}

if ( $config['blog_module'] == '0' ) {
        VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$module_template    = 'blog';
$page               = ( isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
$query              = get_request();
if ( is_array($query) ) {
    foreach ( $query as $key => $value ) {
        if ( $value == 'blog' ) {
            if ( isset($query[$key+1]) ) {
                $next = $query[$key+1];
                if ( is_numeric($next) ) {
                    $bid = intval($next);
                } else {
                    $module             = $next;
                    $modules_allowed    = array('add', 'edit', 'delete');
                    if ( in_array($module, $modules_allowed) ) {
                        $bid                = ( isset($query[$key+2]) ) ? intval($query[$key+2]) : NULL;
                        $module_template    = 'blog_' .$module;
                    } else {
                        VRedirect::go($config['BASE_URL']. '/notfound/blog_missing');
                    }
                }
            }
        }
    }
}

if ( isset($module) && $module == 'add' ) {
    require 'modules/blog/add.php';
} else {
    if ( !isset($bid) || !is_numeric($bid) ) {
        VRedirect::go($config['BASE_URL']. '/notfound/blog_missing');
    }
    
    $sql            = "SELECT BID, UID, title, content, total_comments, total_views, addtime FROM blog
                       WHERE BID = " .$bid. " AND status = '1' LIMIT 1";
    $rs             = $conn->execute($sql);
    if ( $conn->Affected_Rows() != 1 ) {
        VRedirect::go($config['BASE_URL']. '/notfound/blog_missing');
    }
    $blog           = $rs->getrows();
    $blog           = $blog['0'];
	$blog['content'] = blog_output($blog['content']);
    $uid            = intval($blog['UID']);        
    $sql            = "SELECT * FROM signup WHERE UID = " .$uid. " LIMIT 1";
    $rs             = $conn->execute($sql);
    if ( $conn->Affected_Rows() != 1 ) {
        session_write_close();
        header('Location: ' .$config['BASE_URL']. '/notfound/user_missing');
        die();
    }
    $user           = $rs->getrows();
    $user           = $user['0'];
    $username       = $user['username'];
    
    if ( isset($module) ) {
        require 'modules/blog/' .$module. '.php';
    } else {
        $sql            = "UPDATE blog SET total_views = total_views+1 WHERE BID = " .$bid. " LIMIT 1";
        $conn->execute($sql);    
        $sql            = "SELECT COUNT(CID) AS total_comments FROM blog_comments WHERE BID = " .$bid. " AND status = '1'";
        $rsc            = $conn->execute($sql);
        $total_comments = $rsc->fields['total_comments'];
        $pagination     = new Pagination(10);
        $limit          = $pagination->getLimit($total_comments);
        $sql            = "SELECT c.*, s.username, s.photo, s.gender
                           FROM blog_comments AS c, signup AS s  
                           WHERE c.BID = " .$bid. " AND c.status = '1' AND c.UID = s.UID  
                           ORDER BY c.addtime DESC LIMIT " .$limit;
						   
        $rs             = $conn->execute($sql);
        $comments       = $rs->getrows();
        $page_link      = $pagination->getPagination('blog/' .$bid, 'p_blog_comments_' .$bid. '_');
        $page_link_b    = $pagination->getPagination('blog/' .$bid, 'pp_blog_comments_' .$bid. '_');
        $start_num      = $pagination->getStartItem();
        $end_num        = $pagination->getEndItem();
                
        $smarty->assign('blog', true);
        $smarty->assign('user', $user);
        $smarty->assign('username', $username);
        $smarty->assign('blog', $blog);
        $smarty->assign('comments', $comments);
        $smarty->assign('comments_total', $total_comments);
        $smarty->assign('page_link', $page_link);
        $smarty->assign('page_link_b', $page_link_b);
        $smarty->assign('start_num', $start_num);
        $smarty->assign('end_num', $end_num);
        $smarty->assign('self_title', $username. '\'s' .$seo['blog_title']);
    }
}

$user['total_subscribers'] = get_user_total_subscribers($user['UID']);

$smarty->assign('errors',$errors);
$smarty->assign('err',$err);
$smarty->assign('messages',$messages);
$smarty->assign('menu', 'blogs');
$smarty->assign('user', $user);
$smarty->assign('username', $username);
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display('header.tpl');
$smarty->display($module_template. '.tpl');
$smarty->display('footer.tpl');
?>

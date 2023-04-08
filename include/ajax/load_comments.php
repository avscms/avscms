<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/dbconn.php';


$data   = array('status' => 1, 'msg' => '', 'code' => '', 'more_comments' => 0);

if ( isset($_POST['id']) && isset($_POST['page']) && isset($_POST['type'])) {
    $filter         = new VFilter();
    $id             = $filter->get('id', 'INTEGER');
    $page           = $filter->get('page', 'INTEGER');
    $type           = $filter->get('type', 'STRING');
	$order          = $filter->get('order', 'STRING');
	$prefix			= substr(ucfirst($type),0,1);
	
    $uid            = ( isset($_SESSION['uid']) ) ? intval($_SESSION['uid']) : NULL;
    
	if ($order == 'top') {
		$order = ' c.rate DESC,';
	} else {
		$order = '';
	}
	
    $sql            = "SELECT COUNT(CID) AS total_comments FROM ".$type."_comments WHERE ".$prefix."ID = " .$id;
    $rsc            = $conn->execute($sql);
    $total          = $rsc->fields['total_comments'];
    $pagination     = new Pagination(10, $page);
    $limit          = $pagination->getLimit($total);
    $sql            = "SELECT c.*, u.username, u.photo, u.gender FROM ".$type."_comments AS c, signup AS u WHERE c.".$prefix."ID = " .$id. " AND c.status = '1' AND c.UID = u.UID 
                       ORDER BY".$order." c.addtime DESC LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $comments       = $rs->getrows();
    $page_link      = $pagination->getPagination('user/' .$username. '/wall', 'p_wall_comments_' .$oid. '_');
    $page_link_b    = $pagination->getPagination('user/' .$username. '/wall', 'pp_wall_comments_' .$oid. '_');
    $start_num      = $pagination->getStartItem();
    $end_num        = $pagination->getEndItem();

    if ( $comments ) {
		$code = '<div id="comments_page_'.$page.'" class="d-none">';		
        foreach ( $comments as $comment ) {
			$photo          = ( $comment['photo'] == '' ) ? 'nopic-' .$comment['gender']. '.gif' : $comment['photo'];
			$code          .= '<div class="comment-item" id="comment_'.$comment['CID'].'">';
			$code          .= '<div class="comment-user">';
			$code          .= '<a href="' .$config['BASE_URL']. '/user/' .$comment['username']. '">';
			$code          .= '<img src="' .$config['BASE_URL']. '/media/users/' .$photo. '" title="' .$comment['username']. '" alt="' .$comment['username']. '"/>';	
			$code          .= '</a>';
			$code          .= '</div>';
			$code          .= '<div class="comment-info">';
			$code          .= '<div class="comment-body">';
			$code          .= '<div class="comment-actions">';
			$code          .= '<a id="comment_actions_'.$type.'_'.$comment['CID'].'" data-uid="' .$comment['UID']. '" data-rel="'.$type.'_'.$comment['CID'].'" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$code          .= '<i class="fas fa-ellipsis-h"></i>';
			$code          .= '</a>';
			$code          .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="comment_actions_'.$type.'_'.$comment['CID'].'">';
			$code          .= '<a class="dropdown-item d-none" id="report_comment_'.$type.'_'.$comment['CID'].'" href="#">';
			$code          .= '<i class="fas fa-flag"></i> '.$lang['global.report_spam'];
			$code          .= '</a>';
			$code          .= '<a class="dropdown-item  d-none" id="delete_comment_'.$type.'_'.$comment['CID'].'" href="#">';
			$code          .= '<i class="fas fa-trash"></i> '.$lang['global.delete'];
			$code          .= '</a>';
			$code          .= '</div>';
			$code          .= '</div>';
			$code          .= '<div class="comment-user-info">';
			$code          .= '<a class="comment-username" href="' .$config['BASE_URL']. '/user/' .$comment['username']. '">' .$comment['username']. '</a>';
			$code          .= '<span class="comment-add-time"><i class="far fa-clock"></i>'.time_range($comment['addtime']).'</span>';
			$code          .= '</div>';
			$code          .= '<div class="comment-text">';
			$code          .= '' .nl2br(comment_output($comment['message'])). '';
			$code          .= '</div>';
			$code          .= '<div class="comment-meta">';
			$code          .= '<div class="vote-box">';
			$code          .= '<span class="content-rating">';
			$code          .= '<span class="vote-up mr-1"><i id="comment_vote_up_'.$type.'_'.$comment['CID'].'" class="fas fa-thumbs-up"></i> <span id="comment_rate_'.$type.'_'.$comment['CID'].'">'.$comment['rate'].'</span></span>';
			$code          .= '<span class="vote-down"><i id="comment_vote_down_'.$type.'_'.$comment['CID'].'" class="fas fa-thumbs-down"></i>';									
			$code          .= '</span>';
			$code          .= '</div>';
			$code          .= '<div class="comment-reply">';
			$code          .= '<a id="comment_reply_'.$type.'_'.$comment['CID'].'" data-id="'.$comment['CID'].'" data-type="'.$type.'" data-reply-username="' .$comment['username']. '" class="" href="#"><i class="fas fa-share"></i>'.$lang['global.reply'].'</a>';
			$code          .= '</div>';
			$code          .= '</div>';				
			$code          .= '</div>';			
			$code          .= '</div>';		
			$code          .= '<div class="comment-replies">';
			$code          .= '<div class="comment-reply-container d-none" id="reply_container_'.$type.'_'.$comment['CID'].'"></div>';	
			$code          .= '<div class="comments-list replies-list" id="replies_more_'.$type.'_'.$comment['CID'].'"></div>';			
			$code          .= '<div class="comments-list replies-list" id="replies_list_'.$type.'_'.$comment['CID'].'"></div>';
			$total_replies = replies_total($type, $comment['CID']);
			if ($total_replies > 0) {
				if ($total_replies == 1) {
					$lang_view_replies = $lang['comments.view_reply'];
					$lang_hide_replies = $lang['comments.hide_reply'];					
				} else {
					$lang_view_replies = $lang['comments.view_replies'];
					$lang_hide_replies = $lang['comments.hide_replies'];
				}
				$code          .= '<div id="replies_show_hide_container_'.$type.'_'.$comment['CID'].'" class="replies-show-hide-container">';
				$code          .= '<a id="replies_show_more_'.$type.'_'.$comment['CID'].'" class="replies-show-more" data-page="1" data-type="'.$type.'" data-id="'.$comment['CID'].'" href="#">'.$lang_view_replies.' <span id="replies_total_'.$type.'_'.$comment['CID'].'">'.$total_replies.'</span><i class="fas fa-chevron-down"></i></a>';
				$code          .= '<a id="replies_show_more_'.$type.'_'.$comment['CID'].'_" class="replies-show-more replies-view-more" data-page="1" data-type="'.$type.'" data-id="'.$comment['CID'].'" href="#">'.$lang['comments.view_more_replies'].' <span id="replies_total_'.$type.'_'.$comment['CID'].'_">0</span><i class="fas fa-chevron-down"></i></a>';
				$code          .= '<a id="replies_hide_'.$type.'_'.$comment['CID'].'" class="replies-hide" data-type="'.$type.'" data-id="'.$comment['CID'].'" href="#">'.$lang_hide_replies.' <i class="fas fa-chevron-up"></i></a>';
				$code          .= '<span class="reply-response" id="replies_loading_'.$type.'_'.$comment['CID'].'"></span>';
				$code          .= '</div>';
			}
			$code          .= '</div>';		
			$code          .= '</div>';			
        }
		$code .= '</div>';
		$data['status'] = 1;		
		$data['code'] = $code;		
    }
	$data['more_comments'] = $total - ($page*10);
} 

echo json_encode($data);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/dbconn.php';


$data   = array('status' => 0, 'msg' => '', 'code' => '', 'more_replies' => 0, 'loaded_replies' => 0);

if ( isset($_POST['id']) && isset($_POST['page']) && isset($_POST['type'])) {
    $filter         = new VFilter();
    $id             = $filter->get('id', 'INTEGER');
    $page           = $filter->get('page', 'INTEGER');
    $type           = $filter->get('type', 'STRING');
	$order          = $filter->get('order', 'STRING');	
	$prefix			= substr(ucfirst($type),0,1);
	
    $uid            = ( isset($_SESSION['uid']) ) ? intval($_SESSION['uid']) : NULL;

	if ($order == 'top') {
		$order = ' c.rate DESC, c.addtime DESC';		
	} else {
		$order = ' c.addtime ASC';
	}
    
    $sql            = "SELECT COUNT(CID) AS total_comments FROM ".$type."_comments WHERE PARENT_ID = " .$id;
    $rsc            = $conn->execute($sql);
    $total          = $rsc->fields['total_comments'];
    $pagination     = new Pagination(10, $page);
    $limit          = $pagination->getLimit($total);
    $sql            = "SELECT c.*, u.username, u.photo, u.gender FROM ".$type."_comments AS c, signup AS u WHERE c.PARENT_ID = " .$id. " AND c.status = '1' AND c.UID = u.UID 
                       ORDER BY".$order." LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $comments       = $rs->getrows();
	$data['loaded_replies'] = count($comments);
    if ( $comments ) {
		$code = '<div id="replies_page_'.$type.'_'.$id.'_'.$page.'" class="d-none">';		
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
			$code          .= '<a id="comment_reply_'.$type.'_'.$id.'_'.$comment['CID'].'" data-id="'.$id.'" data-type="'.$type.'" data-reply-username="' .$comment['username']. '" class="" href="#"><i class="fas fa-share"></i>'.$lang['global.reply'].'</a>';
			$code          .= '</div>';
			$code          .= '</div>';				
			$code          .= '</div>';			
			$code          .= '</div>';		
			$code          .= '</div>';
			$code          .= '<div class="comment-reply-container d-none" id="reply_container_'.$type.'_'.$id.'_'.$comment['CID'].'"></div>';
        }
		$code .= '</div>';
		$data['status'] = 1;		
		$data['code'] = $code;		
    }
	$data['more_replies'] = $total - ($page*10);
} 

echo json_encode($data);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'msg' => '', 'code' => '', 'wid' => 0, 'cid' => 0);
if ( isset($_POST['id']) && isset($_POST['type']) && isset($_POST['comment'])) {
	
	$filter         = new VFilter();
	$uid            = intval($_SESSION['uid']);
	$id  			= $filter->get('id', 'INTEGER');
	$type  			= $filter->get('type', 'STRING');	
	$prefix			= substr(ucfirst($type),0,1);	
	$comment        = $filter->get('comment');	
	$comment	    = strlen($comment) > 1000 ? substr($comment,0,1000)."..." : $comment;
	
	if ( isset($_SESSION['uid']) ) {
	$spam   = false;
	if ( isset($_SESSION['comment_added']) ) {
		$delay  = intval($_SESSION['comment_added'])+10;
		if ( time() < $delay ) {
			$spam                      = true;
			$_SESSION['comment_added'] = time();
		}            
	}
	
	if ( $spam ) {
		$data['msg']    = $lang['ajax.dont_spam'];
	} else {                    
		$sql            = "INSERT INTO ".$type."_comments (PARENT_ID, UID, message, addtime) 
						   VALUES (" .$id. ", " .$uid. ", " .$conn->qStr($comment). ", " .time(). ")";
		$data['sql'] = $sql;
		$conn->execute($sql);
		$cid            = $conn->insert_Id();
		$username       = $_SESSION['username'];
		$photo          = ( $_SESSION['photo'] == '' ) ? 'nopic-' .$_SESSION['gender']. '.gif' : $_SESSION['photo'];
		$comment        = comment_output($comment);
		
		$code           = '<div class="comment-item" id="comment_'.$cid.'" style="display:none;">';
		$code          .= '<div class="comment-user">';
		$code          .= '<a href="' .$config['BASE_URL']. '/user/' .$username. '">';
		$code          .= '<img src="' .$config['BASE_URL']. '/media/users/' .$photo. '" title="' .$username. '" alt="' .$username. '"/>';	
		$code          .= '</a>';
		$code          .= '</div>';
		$code          .= '<div class="comment-info">';
		$code          .= '<div class="comment-body">';
		$code          .= '<div class="comment-actions">';
		$code          .= '<a id="comment_actions_'.$type.'_'.$cid.'" data-uid="' .$uid. '" data-rel="'.$type.'_'.$cid.'" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
		$code          .= '<i class="fas fa-ellipsis-h"></i>';
		$code          .= '</a>';
		$code          .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="comment_actions_'.$type.'_'.$cid.'">';
		$code          .= '<a class="dropdown-item d-none" id="report_comment_'.$type.'_'.$cid.'" href="#">';
		$code          .= '<i class="fas fa-flag"></i> '.$lang['global.report_spam'];
		$code          .= '</a>';
		$code          .= '<a class="dropdown-item  d-none" id="delete_comment_'.$type.'_'.$cid.'" href="#">';
		$code          .= '<i class="fas fa-trash"></i> '.$lang['global.delete'];
		$code          .= '</a>';
		$code          .= '</div>';
		$code          .= '</div>';
		$code          .= '<div class="comment-user-info">';
		$code          .= '<a class="comment-username" href="' .$config['BASE_URL']. '/user/' .$username. '">' .$username. '</a>';
		$code          .= '<span class="comment-add-time"><i class="far fa-clock"></i>'.$lang['global.right_now'].'</span>';
		$code          .= '</div>';
		$code          .= '<div class="comment-text">';
		$code          .= '' .nl2br($comment). '';
		$code          .= '</div>';
		$code          .= '<div class="comment-meta">';
		$code          .= '<div class="vote-box">';
		$code          .= '<span class="content-rating">';
		$code          .= '<span class="vote-up mr-1"><i id="comment_vote_up_'.$type.'_'.$cid.'" class="fas fa-thumbs-up"></i> <span id="comment_rate_'.$type.'_'.$cid.'">0</span></span>';
		$code          .= '<span class="vote-down"><i id="comment_vote_down_'.$type.'_'.$cid.'" class="fas fa-thumbs-down"></i>';									
		$code          .= '</span>';
		$code          .= '</div>';
		$code          .= '<div class="comment-reply">';
		$code          .= '<a id="comment_reply_'.$type.'_'.$id.'_'.$cid.'" data-id="'.$id.'" data-type="'.$type.'" data-reply-username="' .$username. '" class="" href="#"><i class="fas fa-share"></i>'.$lang['global.reply'].'</a>';
		$code          .= '</div>';
		$code          .= '</div>';				
		$code          .= '</div>';			
		$code          .= '</div>';		
		$code          .= '</div>';
		$code          .= '<div class="comment-reply-container d-none" id="reply_container_'.$type.'_'.$id.'_'.$cid.'"></div>';
		$data['code']   = $code;
		$data['cid']    = $cid;
		$data['wid']    = $id;
		$data['status'] = 1;
		$data['msg'] 	= $lang['global.comment_success'];
		$_SESSION['comment_added'] = time();
	}
} else {
	$data['msg'] = $lang['ajax.comment_login'];
}	
	
	if ($data['status']) {
		switch ($type) {
			case 'user':

				break;
			case 'video':

				break;
			case 'photo':

				break;
			case 'blog':

				break;				
		}	
	}
}

echo json_encode($data);
die();
?>

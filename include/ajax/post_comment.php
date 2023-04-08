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
		$sql            = "INSERT INTO ".$type."_comments (".$prefix."ID, UID, message, addtime) 
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
		$code          .= '<a id="comment_reply_'.$type.'_'.$cid.'" data-id="'.$cid.'" data-type="'.$type.'" data-reply-username="' .$username. '" class="" href="#"><i class="fas fa-share"></i>'.$lang['global.reply'].'</a>';
		$code          .= '</div>';
		$code          .= '</div>';				
		$code          .= '</div>';			
		$code          .= '</div>';		
		$code          .= '<div class="comment-replies">';
		$code          .= '<div class="comment-reply-container d-none" id="reply_container_'.$type.'_'.$cid.'"></div>';	
		$code          .= '<div class="comments-list replies-list" id="replies_more_'.$type.'_'.$cid.'"></div>';			
		$code          .= '<div class="comments-list replies-list" id="replies_list_'.$type.'_'.$cid.'"></div>';
		$code          .= '</div>';		
		$code          .= '</div>';
		
		$data['code']   = $code;
		$data['cid']    = $cid;
		$data['wid']    = $id;
		$data['status'] = 1;
		$data['total'] = comments_total($type, $id);
		$data['msg'] 	= $lang['global.comment_success'];
		$_SESSION['comment_added'] = time();
	}
} else {
	$data['msg'] = $lang['ajax.comment_login'];
}	
	
	if ($data['status']) {
		switch ($type) {
			case 'wall':
					$sql    = "SELECT s.username, s.email, u.wall_write
							   FROM signup AS s, users_prefs AS u
							   WHERE s.UID = " .$id. "
							   AND s.UID = u.UID
							   LIMIT 1";
					$rs     = $conn->execute($sql);
					if ( $conn->Affected_Rows() === 1 ) {
						$prefs_w_comment = $rs->fields['wall_write'];
						if ( $prefs_w_comment == '1' ) {
							$email          = $rs->fields['email'];
							$username       = $rs->fields['username'];
							require $config['BASE_DIR']. '/classes/file.class.php';
							require $config['BASE_DIR']. '/classes/email.class.php';
							$wall_link      = $config['BASE_URL']. '/user/' .$username. '/wall';
							$search         = array('{$username}', '{$site_title}', '{$site_name}', '{$baseurl}', '{$wall_link}');
							$replace        = array($_SESSION['username'], $config['site_title'], $config['site_name'], $config['BASE_URL'], $wall_link);
							$mail           = new VMail();
							$mail->sendPredefined($email, 'wall_comment', $search, $replace);
						}
					}
				break;
			case 'video':
					$sql	= "UPDATE video SET com_num = com_num+1 WHERE VID = " .$id. " LIMIT 1";
					$conn->execute($sql);			
					
					$sql    = "SELECT v.UID, v.title, s.email, u.video_comment
							   FROM video AS v, users_prefs AS u, signup As s
							   WHERE v.VID = " .$id. "
							   AND v.UID = u.UID
							   AND v.UID = s.UID
							   LIMIT 1";
					$rs     = $conn->execute($sql);
					if ( $conn->Affected_Rows() === 1 ) {
						$prefs_v_comment = $rs->fields['video_comment'];
						if ( $prefs_v_comment == '1' ) {
							$email          = $rs->fields['email'];
							$title          = $rs->fields['title'];
							require $config['BASE_DIR']. '/classes/file.class.php';
							require $config['BASE_DIR']. '/classes/email.class.php';
							$video_link     = $config['BASE_URL']. '/video/' .$id. '/' .prepare_string($title);
							$search         = array('{$username}', '{$site_title}', '{$site_name}', '{$baseurl}', '{$video_link}');
							$replace        = array($_SESSION['username'], $config['site_title'], $config['site_name'], $config['BASE_URL'], $video_link);
							$mail           = new VMail();
							$mail->sendPredefined($email, 'video_comment', $search, $replace);
						}
					}
				break;
			case 'photo':
				$sql    = "UPDATE photos SET total_comments = total_comments+1 WHERE PID = " .$id. " LIMIT 1";
				$conn->execute($sql);			
				
				$sql 	= "SELECT AID from photos WHERE PID = " .$id. " LIMIT 1";
				$rs  	= $conn->execute($sql);
				$aid    = $rs->fields['AID'];
				
				if ( $conn->Affected_Rows() === 1 ) {
					$sql            = "UPDATE albums SET total_comments = total_comments+1 WHERE AID = " .$aid. " LIMIT 1";
					$conn->execute($sql);
				
					$sql    = "SELECT a.UID, s.email, u.photo_comment 
							   FROM albums AS a, users_prefs AS u, signup AS s
							   WHERE a.AID = " .$aid. "
							   AND a.UID = u.UID
							   AND a.UID = s.UID
							   LIMIT 1";
					$rs     = $conn->execute($sql);
					if ( $conn->Affected_Rows() === 1 ) {
						$prefs_p_comment = $rs->fields['photo_comment'];
						if ( $prefs_p_comment == '1' ) {
							$email          = $rs->fields['email'];
							require $config['BASE_DIR']. '/classes/file.class.php';
							require $config['BASE_DIR']. '/classes/email.class.php';
							$photo_link     = $config['BASE_URL']. '/photo/' .$id;
							$search         = array('{$username}', '{$site_title}', '{$site_name}', '{$baseurl}', '{$photo_link}');
							$replace        = array($_SESSION['username'], $config['site_title'], $config['site_name'], $config['BASE_URL'], $photo_link);
							$mail           = new VMail();
							$mail->sendPredefined($email, 'photo_comment', $search, $replace);
						}
					}
				}
				break;
			case 'blog':
				$sql            = "UPDATE blog SET total_comments = total_comments+1 WHERE BID = " .$id. " LIMIT 1";
				$conn->execute($sql);
				
				$sql    = "SELECT b.UID, b.title, s.email, u.blog_comment  
						   FROM blog AS b, users_prefs AS u, signup AS s 
						   WHERE b.BID = " .$id. " 
						   AND b.UID = u.UID 
						   AND b.UID = s.UID 
						   LIMIT 1";
				$rs     = $conn->execute($sql);
				if ( $conn->Affected_Rows() === 1 ) {
					$prefs_b_comment = $rs->fields['blog_comment'];
					if ( $prefs_b_comment == '1' ) {
						$email          = $rs->fields['email'];
						$title          = $rs->fields['title'];
						require $config['BASE_DIR']. '/classes/file.class.php';
						require $config['BASE_DIR']. '/classes/email.class.php';
						$blog_link      = '<a href="' .$config['BASE_URL']. '/blog/' .$id . '/' .prepare_string($title). '">' .$config['BASE_URL']. '/blog/' .$id . '/' .prepare_string($title). '</a>';
						$search         = array('{$username}', '{$site_title}', '{$site_name}', '{$baseurl}', '{$blog_link}');
						$replace        = array($_SESSION['username'], $config['site_title'], $config['site_name'], $config['BASE_URL'], $blog_link);
						$mail           = new VMail();
						$mail->sendPredefined($email, 'blog_comment', $search, $replace);
					}
				}				
				break;				
		}	
	}
}

echo json_encode($data);
die();
?>

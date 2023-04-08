<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['blog_module'] == '0' ) {
    die();
}

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'msg' => '', 'code' => '', 'bid' => 0, 'cid' => 0);
if ( isset($_POST['blog_id']) && isset($_POST['comment']) ) {
    if ( $config['blog_comments'] == '0' ) {    
        $data['msg'] = show_err($lang['ajax.blog_comment_disabled']);
    } elseif ( isset($_SESSION['uid']) ) {
        $spam   = false;
        if ( isset($_SESSION['b_comment_added']) ) {
            $delay  = intval($_SESSION['b_comment_added'])+30;
            if ( time() < $delay ) {
                $spam                           = true;
                $_SESSION['b_comment_added']    = time();
            }
        }
        
        if ( $spam ) {
            $data['msg'] = show_err($lang['ajax.dont_spam']);
        } else {    
            $filter         = new VFilter();
            $uid            = intval($_SESSION['uid']);
            $bid            = $filter->get('blog_id', 'INTEGER');
            $comment        = $filter->get('comment');
            $comment        = preg_replace('/\[photo=(.*?)\]/ms', '<img src="' .$config['BASE_URL']. '/media/photos/tmb/\1.jpg" alt="" class="blog_image" />', $comment);
            $sql            = "INSERT INTO blog_comments ( BID, UID, comment, addtime )
                               VALUES (" .$bid. ", " .$uid. ", " .$conn->qStr($comment). ", '" .time(). "')";
            $conn->execute($sql);
            $cid            = $conn->insert_Id();
            $sql            = "UPDATE blog SET total_comments = total_comments+1 WHERE BID = " .$bid. " LIMIT 1";
            $conn->execute($sql);
        
            $username       = $_SESSION['username'];
            $photo          = ( $_SESSION['photo'] == '' ) ? 'nopic-' .$_SESSION['gender']. '.gif' : $_SESSION['photo'];
			
            $code           = '<div id="blog_comment_' .$bid. '_' .$cid. '" class="col-xs-12 m-t-15">';
			$code          .= '<div class="row">';
			$code          .= '<div class="pull-left">';
			$code          .= '<a href="' .$config['BASE_URL']. '/user/' .$username. '">';
			$code          .= '<img src="' .$config['BASE_URL']. '/media/users/' .$photo. '" title="' .$username. '\'s avatar" alt="' .$username. '\'s avatar" class="img-responsive comment-avatar" />';
			$code          .= '</a>';
			$code          .= '</div>';
			$code          .= '<div class="comment new-comment">';
			$code          .= '<div class="comment-info">';
			$code          .= '<a href="' .$config['BASE_URL']. '/user/' .$username. '">' .$username. '</a>&nbsp;-&nbsp;<span class="">'.$lang['global.right_now'].'</span>';
			$code          .= '</div>';
			$code          .= '<div class="comment-body overflow-hidden">' .nl2br($comment). '</div>';
			$code          .= '<div class="comment-actions">';
			$code          .= '<a href="#delete_comment" id="delete_comment_blog_' .$cid. '_' .$bid. '">'.$lang['global.delete'].'</a> <span id="delete_response_' .$cid. '" style="display: none;"></span>';
			$code          .= '</div>';
			$code          .= '</div>';			
            $code          .= '<div class="clearfix"></div>';
			$code          .= '</div>';
			$code          .= '</div>';        
            $data['code']   = $code;
            $data['cid']    = $cid;
            $data['bid']    = $bid;
			$data['status'] = 1;			
			$data['msg'] 	= show_msg($lang['global.comment_success']);
            $_SESSION['b_comment_added'] = time();
            
            $sql    = "SELECT b.UID, b.title, s.email, u.blog_comment  
                       FROM blog AS b, users_prefs AS u, signup AS s 
                       WHERE b.BID = " .$bid. " 
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
                    $blog_link      = '<a href="' .$config['BASE_URL']. '/blog/' .$bid . '/' .prepare_string($title). '">' .$config['BASE_URL']. '/blog/' .$bid . '/' .prepare_string($title). '</a>';
                    $search         = array('{$username}', '{$site_title}', '{$site_name}', '{$baseurl}', '{$blog_link}');
                    $replace        = array($_SESSION['username'], $config['site_title'], $config['site_name'], $config['BASE_URL'], $blog_link);
                    $mail           = new VMail();
                    $mail->sendPredefined($email, 'blog_comment', $search, $replace);
                }
            }

        }
    } else {
        $data['msg'] = show_err($lang['ajax.comment_login']);
    }
}

echo json_encode($data);
die();
?>

<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require_once ($config['BASE_DIR']. '/include/function_thumbs.php');

$data   = array('status' => 0, 'msg' => '', 'code' => '', 'debug' => '');
if ( isset($_POST['page']) ) {
    if ( isset($_SESSION['uid']) ) {
        $uid            = intval($_SESSION['uid']);
        $page           = intval(trim($_POST['page']));
        $sql            = "SELECT count(VID) AS total_videos FROM video WHERE UID = " .$uid;
        $rs             = $conn->execute($sql);
        $total          = $rs->fields['total_videos'];
        $pagination     = new Pagination(8, $page);
        $limit          = $pagination->getLimit($total);      
        $sql            = "SELECT VID, title FROM video WHERE UID = " .$uid. "
						   AND embed_code = ''
		                   ORDER BY VID DESC LIMIT " .$limit;
        $rs             = $conn->execute($sql);
        $videos         = $rs->getrows();
        $page_link      = $pagination->getPagination('media_content', 'p_mc_my_videos_');
        $start_num      = $pagination->getStartItem();
        $end_num        = $pagination->getEndItem();
        
        $code           = array();
		$code[]			= '<div class="m-b-15">';
        $code[]         = '<a href="#attach_playlist_videos" id="attach_mcp_playlist_videos">'.$lang['user.playlist'].'</a> <strong>&middot;</strong>';
        $code[]         = '<a href="#attach_favorite_videos" id="attach_mcp_favorite_videos">'.$lang['user.favorites'].'</a> <strong>&middot;</strong>';
        $code[]         = '<span class="text-white">'. $lang['ajax.my_videos'] .'</span>';		
		$code[] 		= '<button id="close_attach_mc_mv" type="button" class="close">&#215;</button>';
        $code[]         = '</div>';	
        if ( $videos ) {
			$code[]	    = '<div class="m-b--15">';		
			$code[]     = '<div class="row">';
			foreach ( $videos as $video ) {
                $code[] = '<div class="col-xs-6 col-sm-3 m-b-15">';
                $code[] = '<a href="#attach_my_video_' .$video['VID']. '" id="attach_media_video_' .$video['VID']. '"><img src="' .get_thumb_url($video['VID']). '/1.jpg" alt="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" class="img-responsive" /></a>';
                $code[] = '</div>';
            }
            $code[]     = '</div>';
            $code[]     = '</div>';		
			if ( $page_link ) {				
				$code[]     = '<div class="visible-xs center m-b--15">';
				$code[]     = '<ul class="pagination pagination-lg">'. $page_link .'</ul>';
				$code[]     = '</div>';
				$code[]     = '<div class="hidden-xs center m-b--15">';
				$code[]     = '<ul class="pagination">'. $page_link .'</ul>';
				$code[]     = '</div>';
			}
        } else {
            $code[]     = '<div class="no_items">'.$lang['ajax.see_none'].'</div>';
        }
        $code[]         = '</div>';
        
        $data['status'] = 1;
        $data['code']   = implode("\n", $code);
    } else {
        $data['msg']    = show_err_mb($lang['ajax.video_login']);
    }
} else {
    $data['msg']        = show_err_mb('Invalid request!');
}

echo json_encode($data);
die();
?>

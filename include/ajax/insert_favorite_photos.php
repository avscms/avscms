<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 0, 'msg' => '', 'code' => '', 'debug' => '');
if ( isset($_POST['page']) ) {
    if ( isset($_SESSION['uid']) ) {
        $uid            = intval($_SESSION['uid']);
        $page           = intval(trim($_POST['page']));
        $sql            = "SELECT COUNT(PID) AS total_photos FROM photo_favorites
                           WHERE UID = " .$uid;
        $rs             = $conn->execute($sql);
        $total          = $rs->fields['total_photos'];
        $pagination     = new Pagination(8, $page);
        $limit          = $pagination->getLimit($total);      
        $sql            = "SELECT p.PID, p.caption FROM photos AS p, photo_favorites AS f 
                           WHERE f.UID = " .$uid. " AND p.PID = f.PID ORDER BY p.PID DESC LIMIT " .$limit;
        $rs             = $conn->execute($sql);
        $photos         = $rs->getrows();
        $page_link      = $pagination->getPagination('media_content', 'p_mc_favorite_photos_');
        $start_num      = $pagination->getStartItem();
        $end_num        = $pagination->getEndItem();
        
        $code           = array();
		$code[]			= '<div class="m-b-15">';
        $code[]         = '<span class="text-white">'. $lang['user.favorites'] .'</span> <strong>&middot;</strong>';
        $code[]         = '<a href="#attach_my_photos" id="attach_mcp_my_photos">'.$lang['ajax.my_photos'].'</a>';		
		$code[] 		= '<button id="close_attach_mc_fp" type="button" class="close">&#215;</button>';
        $code[]         = '</div>';
        if ( $photos ) {
            $index      = 0;
            $code[]     = '<div class="m-b--15">';			
            $code[]     = '<div class="row">';
            foreach ( $photos as $photo ) {
                if ( $index == 4 ) {
                    $code[] = '</div><div class="row">';
                }
                $code[] = '<div id="attach_favorite_photo_' .$photo['PID']. '" class="col-xs-6 col-sm-3 m-b-15">';
                $code[] = '<a href="#attach_favorite_photo" id="attach_media_photo_' .$photo['PID']. '"><img src="' .$config['BASE_URL']. '/media/photos/tmb/' .$photo['PID']. '.jpg" alt="' .htmlspecialchars($photo['caption'], ENT_QUOTES, 'UTF-8'). '" class="img-responsive" /></a>';
                $code[] = '</div>';
                ++$index;
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
        $data['msg']    = show_err_mb($lang['ajax.photo_login']);
    }
} else {
    $data['msg']        = show_err_mb('Invalid request!');
}

echo json_encode($data);
die();
?>

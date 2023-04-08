<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require_once ($config['BASE_DIR']. '/include/function_thumbs.php');

function insert_duration ( $options )
{
    $duration_formated  = NULL;
    $duration           = round($options);
    if ( $duration > 3600 ) {
        $hours              = floor($duration/3600);
        $duration_formated .= sprintf('%02d',$hours). ':';
        $duration           = round($duration-($hours*3600));
    }
    if ( $duration > 60 ) {
        $minutes            = floor($duration/60);
        $duration_formated .= sprintf('%02d', $minutes). ':';
        $duration           = round($duration-($minutes*60));
    } else {
        $duration_formated .= '00:';
    }
        
    return $duration_formated . sprintf('%02d', $duration);
}


$data   = array('status' => 1, 'msg' => '');


    if ( isset($_SESSION['uid']) ) {
        $uid            = intval($_SESSION['uid']);
        $page           = intval(trim($_POST['page']));
        $keyword        = trim($_POST['keyword']);		

		$sql_add        = " AND ( title LIKE '%" .trim($conn->qStr($keyword), "'"). "%' OR keyword LIKE '%" .trim($conn->qStr($keyword), "'"). "%' )";		
		$sql_add_count  = " AND ( title LIKE '%" .trim($conn->qStr($keyword), "'"). "%' OR keyword LIKE '%" .trim($conn->qStr($keyword), "'"). "%' )";
		$sql            = "SELECT count(VID) AS total_videos FROM video WHERE active = '1' AND (embed_code = '' OR embed_code IS NULL) AND type != 'private'". $sql_add_count;		
		$rsc            = $conn->execute($sql);
		$total          = $rsc->fields['total_videos'];
		
        $pagination     = new Pagination(8, $page);
        $limit          = $pagination->getLimit($total);      
		$sql            = "SELECT * FROM video WHERE active = '1' AND (embed_code = '' OR embed_code IS NULL) AND type != 'private'". $sql_add. " LIMIT " .$limit;

        $rs             = $conn->execute($sql);
        $videos         = $rs->getrows();
        $page_link      = $pagination->getPagination('media_content', 'comments_search_videos_');
        $start_num      = $pagination->getStartItem();
        $end_num        = $pagination->getEndItem();
		
		
        if ( $videos ) {
	
			$code[]     = '<div class="row content-row">';		
            foreach ( $videos as $video ) {
                $code[] = '<div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">';
                $code[] = '<a href="#" id="attach_media_video_' .$video['VID']. '">';
				if ( $video['vthumbs'] == '1') {	
					$code[] = '<div class="thumb-overlay" id="playvthumb_'.$video['VID'].'">';
					$code[] = '<img src="' .get_thumb_url($video['VID']). '/1.jpg" title="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" alt="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" class="img-responsive"/>';					
				} else {
					$code[] = '<div class="thumb-overlay">';
					$code[] = '<img src="' .get_thumb_url($video['VID']). '/1.jpg" title="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" alt="' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '" class="img-responsive" id="rotate_'.$video['VID'].'_'.$video['thumbs'].'_'.$video['thumb'].'_viewed"/>';					
				}
				$code[] = '<div class="duration">';
				if ($video['hd'] == 1) {
					 $code[] = '<span class="hd-text-icon">HD</span>';
				}
				$code[] = insert_duration($video['duration']);
                $code[] = '</div>';								
                $code[] = '</div>';				
				$code[] = '</a>';
				$code[] = '<div class="content-info">';
				$code[] = '<a href="#" id="attach_media_video_' .$video['VID']. '_">';				
				$code[] = '<div class="content-truncate">' .htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8'). '</div>';
				$code[] = '</a>';								
                $code[] = '</div>';		
                $code[] = '</div>';
            }
            $code[]     = '</div>';
            $code[]     = '</div>';			
			if ( $page_link ) {								
				$code[] = '<ul class="pagination">'. $page_link .'</ul>';
			}
        } else {
            $code[]     = '<div class="no-items">'.$lang['global.search_no_results'].'</div>';
        }

        $data['total'] = '<i class="fas fa-search"></i> '.$lang['global.search_videos'].': '.$total;	
        $data['status'] = 1;
        $data['code']   = implode("\n", $code);
    } else {

    }


echo json_encode($data);
die();
?>

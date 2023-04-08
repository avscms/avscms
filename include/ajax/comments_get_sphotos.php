<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$data   = array('status' => 1, 'msg' => '');


    if ( isset($_SESSION['uid']) ) {
        $uid            = intval($_SESSION['uid']);
        $page           = intval(trim($_POST['page']));
        $keyword        = trim($_POST['keyword']);		
		
        $sql            = "SELECT p.PID FROM photos AS p, albums AS a 
                           WHERE ( a.name LIKE '%" .trim($conn->qStr($keyword), "'"). "%' OR a.tags LIKE '%" .trim($conn->qStr($keyword), "'"). "%' ) AND p.AID = a.AID AND a.type != 'private'";
        $rs             = $conn->execute($sql);
        $photos_t       = $rs->getrows();		
		$total			= count($photos_t);
		unset($photos_t);
        $pagination     = new Pagination(8, $page);
        $limit          = $pagination->getLimit($total);      
        $sql            = "SELECT p.PID FROM photos AS p, albums AS a 
                           WHERE ( a.name LIKE '%" .trim($conn->qStr($keyword), "'"). "%' OR a.tags LIKE '%" .trim($conn->qStr($keyword), "'"). "%' ) AND p.AID = a.AID AND a.type != 'private' ORDER BY p.PID DESC LIMIT " .$limit;
        $rs             = $conn->execute($sql);
        $photos         = $rs->getrows();
        $page_link      = $pagination->getPagination('media_content', 'comments_search_photos_');
        $start_num      = $pagination->getStartItem();
        $end_num        = $pagination->getEndItem();
		
		
        if ( $photos ) {
	
			$code[]     = '<div class="row content-row">';		
            foreach ( $photos as $photo ) {
                $code[] = '<div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">';
                $code[] = '<a href="#" id="attach_media_photo_' .$photo['PID']. '">';
				$code[] = '<div class="thumb-overlay">';
				$code[] = '<img src="'.$config['BASE_URL']. '/media/photos/tmb/' .($photo['PID']). '.jpg" title="' .htmlspecialchars($photo['caption'], ENT_QUOTES, 'UTF-8'). '" alt="' .htmlspecialchars($photo['caption'], ENT_QUOTES, 'UTF-8'). '" class="img-responsive"/>';											
                $code[] = '</div>';				
				$code[] = '</a>';
				$code[] = '<div class="content-info">';
				$code[] = '<a href="#" id="attach_media_photo_' .$photo['PID']. '_">';
				$code[] = '<div class="content-truncate">' .htmlspecialchars($photo['caption'], ENT_QUOTES, 'UTF-8'). '</div>';
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

        $data['total'] = '<i class="fas fa-heart"></i> '.$lang['global.search_photos'].': '.$total;	
        $data['status'] = 1;
        $data['code']   = implode("\n", $code);
    } else {

    }


echo json_encode($data);
die();
?>

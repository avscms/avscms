<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/classes/filter.class.php';

if ( $config['video_module'] == '0' ) {
    VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$status = ( isset($_GET['status']) ) ? intval($_GET['status']) : 0;

// Added to enforce these paths
$basedir = dirname(dirname(dirname(__FILE__)));
$config['BASE_DIR'] 	= $basedir;
$config['LOG_DIR'] 		= $basedir.'/tmp/logs';
$config['VDO_DIR'] 		= $basedir.'/media/videos/vid';


$upload_id			= mt_rand(). '_' .time();
$upload_max_size    = $config['video_max_size']*1024*1024;
$upload_mb = $config['video_max_size'].'mb';
$video_extensions  	= $config['video_allowed_extensions'];
$video_extensions 	= str_replace('|',',',$video_extensions);
$video_allowed_ext  = '(' .str_replace(',', '|', $config['video_allowed_extensions']). ')';
$video              = array('title' => '', 'description' => '', 'keywords' => '', 'category' => 0, 'privacy' => 'public', 'anonymous' => 'no');
                            
if ($status == 1) {
	$messages[] = $lang['upload.video_uploaded'];
}

if ( isset($_POST['video_upload_started']) ) {

		$error = false;

		$filter     	= new VFilter();
		$title      	= $filter->get('video_title');
		$category   	= $filter->get('video_category', 'INTEGER');
		$keywords   	= $filter->get('video_tags');
		$privacy    	= $filter->get('video_privacy');
		$anonymous  	= $filter->get('video_anonymous');
		$description 	= $filter->get('video_description');
		$fileName 		= $filter->get('video_filename');
		$unique_id 		= $filter->get('unique_id');

	

		$extension = pathinfo($fileName, PATHINFO_EXTENSION);
		$filepath = $config['VDO_DIR'].'/'.$unique_id.'.'.$extension;

		if(!file_exists($filepath)) {
			 $error=true;
		}
			
		$video['title'] = $title;
	
        $keywords  = prepare_tags($keywords); 
        $video['keywords']  = $keywords;
		
		$video['category']  = $category;

		$video['privacy']       = ( $privacy == 'private' ) ? 'private' : 'public';
		$video['anonymous']     = ( $anonymous == 'yes' ) ? 'yes' : 'no';
		$uid                    = ( $anonymous == 'yes' ) ? getAnonymousUID() : intval($_SESSION['uid']);
		$space = filesize($filepath);



		if ( $error!=true ) {

			$sql        = 	"INSERT INTO video 
							SET UID = " .$uid. ", title = " .$conn->qStr($title). ",
							channel = " .$category. ", keyword = " .$conn->qStr($keywords). ",
							description = ".$conn->qStr($description).", 
							space = '" .$space. "', addtime = '" .time(). "', adddate = '" .date('Y-m-d'). "', vkey = '" .mt_rand(). "', 
							type = '" .$video['privacy']. "', active = '2'"; 

			$conn->execute($sql);
			$video_id   = $conn->insert_Id();


			$vdoname	= $video_id. '.' .$extension;
		
			$vdo_path 	= $config['VDO_DIR'].'/'.$vdoname;
			rename($filepath,$vdo_path);

			$vkey       = substr(md5($video_id),11,20);
			$sql        = "UPDATE video SET vkey = '" .$vkey. "' WHERE VID = " .intval($video_id). " LIMIT 1";
			$conn->execute($sql);	
		

			// ---------------------------------------------------------------------------
			// ---------------------------------------------------------------------------
			function run_in_background($Command, $Priority = 0){
				if($Priority) $PID = shell_exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
			    else $PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
			    return($PID);
			}
				
			$cgi = ( strpos(php_sapi_name(), 'cgi') ) ? 'env -i ' : NULL;
			
			// Proc
            $cmd = $cgi.$config['phppath']
		    	." ".$config['BASE_DIR']."/scripts/convert_videos.php"
		    	." ".$vdoname
		    	." ".$video_id
		    	." ".$vdo_path
		    ."";
            log_conversion($config['LOG_DIR']. '/' .$video_id. '.log', $cmd);
            $lg = $config['LOG_DIR']. '/' .$video_id. '.log2';
			if($config['conversion_q'] == '1') {
				insert_into_q_fp($video_id, $vdoname, $vdo_path);
			} else {
				run_in_background($cmd.' > '.$lg);
			}

            $duration    = get_video_duration($vdo_path, $video_id);

			$sql         = "UPDATE video SET 
							duration = " .$conn->qStr($duration). ", 
							vdoname = " .$conn->qStr($vdoname). " 
							WHERE VID = " .intval($video_id). " LIMIT 1";


            $conn->execute($sql);
            
			
            $video_url  = $config['BASE_URL']. '/video/' .$video_id. '/' .prepare_string($title);
			$video_link = '<a href="'.$video_url.'">'.$video_url.'</a>';
            

			$sql = "SELECT SUID, username, email
					FROM video_subscribe
					LEFT JOIN signup ON signup.UID = video_subscribe.SUID
					LEFT JOIN users_prefs ON users_prefs.UID = signup.UID
					WHERE video_subscribe.UID = '". $uid."' AND users_prefs.video_subscribe='1'";


            $rs         = $conn->execute($sql);
            if ( $conn->Affected_Rows() > 0 ) {
                $subscribers    = $rs->getrows();
                $mail           = new VMail();
                $mail->setNoReply();
                $sql            = "SELECT * FROM emailinfo WHERE email_id = 'subscribe_email' LIMIT 1";
                $rs             = $conn->execute($sql);
                $email_path     = $config['BASE_DIR']. '/templates/' .$rs->fields['email_path'];
                $sender         = ( $anonymous == 'yes' ) ? 'anonymous' : $_SESSION['username'];
                $mail->Subject  = str_replace('{$sender_name}', $sender, $rs->fields['email_subject']);
                foreach ( $subscribers as $subscriber ) {
                    $smarty->assign('video_link', $video_link);
                    $smarty->assign('username', $subscriber['username']);
                    $smarty->assign('sender_name', $_SESSION['username']);
                    $body               = $smarty->fetch($email_path);
                    $mail->AltBody      = $body;
                    $mail->Body         = nl2br($body);
                    $mail->AddAddress($subscriber['email']);
                    $mail->Send();
                    $mail->ClearAddresses();
                }
            }
          
            $search     = array('{$site_title}', '{$site_name}', '{$username}', '{$video_link}', '{$baseurl}');
            $replace    = array($config['site_title'], $config['site_name'], $_SESSION['username'], $video_link, $config['BASE_URL']);
            $mail       = new VMail();
            if ( $config['approve'] == '0' ) {
                $mail->sendPredefined($_SESSION['email'], 'video_approve', $search, $replace);
            } else {
                $mail->sendPredefined($_SESSION['email'], 'video_upload', $search, $replace);    
            }
          
            $sql        = "UPDATE channel SET total_videos = total_videos+1 WHERE CHID = " .$category. " LIMIT 1";
            $conn->execute($sql);
            $sql        = "UPDATE signup SET total_videos = total_videos+1, points = points+10 WHERE UID = " .$uid. " LIMIT 1";
            $conn->execute($sql);
			add_tags($keywords);		

            $video['title']       = '';
			$video['description'] = '';
            $video['keywords']    = '';
            $video['category']    = 0;
            $video['privacy']     = 'public';
            $video['anonymous']   = 'no';
            
            if ( $config['approve'] == '1' ) {
				$messages[] = translate('upload.video_approve', $config['site_name']);
            } else {
				$messages[] = translate('upload.video_success', $config['site_name'], $video_url, htmlspecialchars($title, ENT_QUOTES, 'UTF-8'));
            }
		}			
    

}

$smarty->assign('video', $video);
$smarty->assign('upload_id', $upload_id);
$smarty->assign('upload_mb', $upload_mb);
$smarty->assign('upload_max_size', $upload_max_size);
$smarty->assign('allowed_video_extensions', $video_allowed_ext);
$smarty->assign('video_extensions', $video_extensions);
$smarty->assign('upload_video', true);
$smarty->assign('categories', get_categories());
?>

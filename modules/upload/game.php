<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/filter.class.php';

if ( $config['game_module'] == '0' ) {
        VRedirect::go($config['BASE_URL']. '/notfound/page_invalid');
}

$upload_id                  = mt_rand(). '_' .time();
$upload_max_size            = $config['game_max_size']*1024*1024;
$game_allowed_extensions    = '(' .str_replace(',', '|', $config['game_allowed_extensions']). ')';
$image_allowed_extensions   = '(' .str_replace(',', '|', $config['image_allowed_extensions']). ')';
$game                       = array('title' => '', 'category' => 0, 'description' => '', 'keywords' => '', 'privacy' => 'public',
                                    'anonymous' => 'no');
if ( isset($_POST['game_upload_started']) ) {
    $filter     = new VFilter();
    $title      = $filter->get('game_title');
    $category   = $filter->get('game_category', 'INTEGER');
    $keywords   = $filter->get('game_keywords');
    $privacy    = $filter->get('game_privacy');
    $anonymous  = $filter->get('game_anonymous');

    if ( $title == '' ) {
        $errors[]           = $lang['upload.game_title_empty'];
    } else {
        $game['title']     = $title;
    }

    if ( $keywords == '' ) {
        $errors[]           = $lang['upload.game_tags_empty'];
    } else {
        $keywords           = prepare_string($keywords, false);
        $game['keywords']   = $keywords;
    }

    if ( $category == '0' ) {
        $errors[]           = $lang['upload.game_category_empty'];
    } else {
        $game['category']   = $category;
    }
    
    if ( $_FILES['game_file']['tmp_name'] == '' ) {
        $errors[]           = $lang['upload.game_file_error'];
    } elseif ( !is_uploaded_file($_FILES['game_file']['tmp_name']) ) {
        $errors[]           = 'Game file is not a valid uploaded file!';
    } else {
        $filename           = substr($_FILES['game_file']['name'], strrpos($_FILES['game_file']['name'], DIRECTORY_SEPARATOR)+1);
        $extension          = strtolower(substr($filename, strrpos($filename, '.')+1));
        $extensions_allowed = explode(',', $config['game_allowed_extensions']);
        if ( !in_array($extension, $extensions_allowed) ) {
            $errors[]       = translate($lang['upload.game_ext_invalid'], $extension);
        } else {
            $space = filesize($_FILES['game_file']['tmp_name']);
            if ( $space > $upload_max_size ) {
                $errors[]   = translate('upload.game_size', $config['game_max_size']);
			}
        }
    }
    
    if ( $_FILES['game_thumb_file']['tmp_name'] == '' ) {
        $errors[]               = $lang['upload.game_thumb_select'];
    } elseif ( !is_uploaded_file($_FILES['game_thumb_file']['tmp_name']) ) {
        $errors[]               = $lang['upload.game_thumb_invalid'];
    } else {
        $tmb_filename           = substr($_FILES['game_thumb_file']['name'], strrpos($_FILES['game_thumb_file']['name'], DIRECTORY_SEPARATOR)+1);
        $tmb_extension          = strtolower(substr($tmb_filename, strrpos($tmb_filename, '.')+1));
        $tmb_allowed_extensions = explode(',', $config['image_allowed_extensions']);
        if ( !in_array($tmb_extension, $tmb_allowed_extensions) ) {
            $errors[]           = translate($lang['upload.game_thumb_ext_invalid'], $tmb_extension);
		} elseif (!getimagesize($_FILES['game_thumb_file']['tmp_name'])) {
			$errors[]			= 'Invalid image format. Application error!';
        } else {
            $tmb_size = filesize($_FILES['game_thumb_file']['tmp_name']);
            if ( $tmb_size > $config['image_max_size'] ) {
                $errors[]       = translate('upload.game_thumb_size_invalid', $config['image_max_size']);
            } elseif (!check_image($_FILES['game_thumb_file']['tmp_name'], $tmb_extension)) {
				$errors[]   = 'Invalid image format! Application error!';
			}
        }
    }

    $game['privacy']        = ( $privacy == 'private' ) ? 'private' : 'public';
    $game['anonymous']      = ( $anonymous == 'yes' ) ? 'yes' : 'no';
    $uid                    = ( $anonymous == 'yes' ) ? getAnonymousUID() : intval($_SESSION['uid']);

    if ( !$errors ) {
        $status     = ( $config['approve_games'] == '1' ) ? 0 : 1;
        $sql        = "INSERT INTO game
                       SET UID = " .$uid. ", title = " .$conn->qStr($title). ",
                           category = " .$category. ", tags = " .$conn->qStr($keywords). ",
                           space = '" .$space. "', addtime = '" .time(). "', adddate = '" .date('Y-m-d'). "',
                           type = '" .$game['privacy']. "', status = '" .$status. "'";
        $conn->execute($sql);
        $game_id    = $conn->insert_Id();
        $game_file  = $game_id. '.swf';
        $game_path  = $config['BASE_DIR']. '/media/games/swf/' .$game_file;
        if ( !move_uploaded_file($_FILES['game_file']['tmp_name'], $game_path) ) {
            $errors[] = $lang['upload.game_failed'];
        }
        
        if ( !$errors ) {
            $game_tmb_file  = $game_id. '.jpg';
            $game_tmb_path  = $config['BASE_DIR']. '/media/games/tmb/orig/' .$game_tmb_file;
            if ( !move_uploaded_file($_FILES['game_thumb_file']['tmp_name'], $game_tmb_path) ) {
                $errors[] = $lang['upload.game_thumb_failed'];
            }
            
            if ( !$errors ) {        
                require $config['BASE_DIR']. '/classes/image.class.php';
                $src        = $game_tmb_path;
                $dst        = $config['BASE_DIR']. '/media/games/tmb/' .$game_tmb_file;
                $image      = new VImageConv();
                $image->process($src, $dst, 'MAX_WIDTH', 256, 144);
                $image->canvas(256, 144, '000000', true);
                $sql        = "UPDATE game_categories SET total_games = total_games+1 WHERE category_id = " .$category. " LIMIT 1";
                $conn->execute($sql);
                $sql        = "UPDATE signup SET total_games = total_games+1, points = points+5 WHERE UID = " .$uid. " LIMIT 1";
                $conn->execute($sql);
                
				$game_url  = $config['BASE_URL']. '/game/' .$game_id. '/' .prepare_string($title);
                $game_link = '<a href="' .$game_url. '">'.$game_url.'</a>';
                $search     = array('{$site_title}', '{$site_name}', '{$username}', '{$game_link}', '{$baseurl}');
                $replace    = array($config['site_title'], $config['site_name'], $_SESSION['username'], $game_link, $config['BASE_URL']);
                $mail       = new VMail();
                if ( $config['approve_games'] == '0' ) {
                    $mail->sendPredefined($_SESSION['email'], 'game_approve', $search, $replace);
                } else {
                    $mail->sendPredefined($_SESSION['email'], 'game_upload', $search, $replace);
                }
                
                $game['title']      = '';
                $game['category']   = '';
                $game['keywords']   = '';
                $game['privacy']    = 'public';
                $game['anonymous']  = 'no';
                
                if ( $config['approve_games'] == '1' ) {
					$messages[] = translate('upload.game_approve', $config['site_name']);
                } else {
					$messages[] = translate('upload.game_success', $config['site_name'], $game_url, htmlspecialchars($title, ENT_QUOTES, 'UTF-8'));
                }
            }
        }
    }
}

$sql        = "SELECT * FROM game_categories ORDER BY category_name ASC";
$rs         = $conn->execute($sql);
$categories = $rs->getrows();

$smarty->assign('upload_id', $upload_id);
$smarty->assign('upload_max_size', $upload_max_size);
$smarty->assign('upload_allowed_extensions', $game_allowed_extensions);
$smarty->assign('image_allowed_extensions', $image_allowed_extensions);
$smarty->assign('upload_game', true);
$smarty->assign('game', $game);
$smarty->assign('categories', $categories);
?>

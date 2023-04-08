<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_permissions']) ) {
    $filter                 = new VFilter();
	$user_registration 	    = $filter->get('user_registration');
	$email_verification	    = $filter->get('email_verification');
	$video_view		        = $filter->get('video_view');
	$video_comments		    = $filter->get('video_comments');
    $photo_comments         = $filter->get('photo_comments');
    $blog_comments          = $filter->get('blog_comments');
    $wall_comments          = $filter->get('wall_comments');
	$private_msgs		    = $filter->get('private_msgs');
    $video_rate             = $filter->get('video_rate');
    $photo_rate             = $filter->get('photo_rate');
    $user_rate           	= $filter->get('user_rate');		
    $comment_rate           = $filter->get('comment_rate');	
	$edit_videos			= $filter->get('edit_videos');

    $config['user_registration']    = $user_registration;
    $config['email_verification']   = $email_verification;
    $config['video_view']           = $video_view;
    $config['video_comments']       = $video_comments;
    $config['photo_comments']       = $photo_comments;
    $config['blog_comments']        = $blog_comments;
    $config['wall_comments']        = $wall_comments;
    $config['private_msgs']         = $private_msgs;
    $config['video_rate']           = $video_rate;
    $config['photo_rate']           = $photo_rate;
    $config['user_rate']        	= $user_rate;			
    $config['comment_rate']         = $comment_rate;	
	$config['edit_videos']			= $edit_videos;
    update_config($config);
    update_smarty();
	$messages[] = 'Permissions Updated Successfuly!';
}
?>

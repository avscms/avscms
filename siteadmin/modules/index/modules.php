<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_modules']) ) {
    $config['video_module']	= intval($_POST['video_module']);
    $config['photo_module']	= intval($_POST['photo_module']);
    $config['blog_module']	= intval($_POST['blog_module']);
    update_config($config);
    update_smarty();
    $messages[] = 'Module Settings Updated Successfuly!';
}
?>

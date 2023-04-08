<?php
        include("../../include/config.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Install Help</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body { font-family: verdana; font-size: 10pt }
.highlight { background-color: #FFFFCC }
</style>
</head>

<body>
<h2>Install Help </h2>
<p>This file must be located inside your 'editor_files' folder or it will not 
        work! Do not re-name this file!</p>
<p>This file attempts to guess information that might help you to set up your 
        <i><b>config.php</b></i> file.</p>
<p>This file might not work for everyone!</p>
<hr>
<p>Set your <b>WP_WEB_DIRECTORY</b> to: <span class="highlight"><nobr>'<?php echo preg_replace('/INSTALL_HELP\.php/smi', '', $_SERVER['PHP_SELF']); ?>'</nobr></span></p>
<hr>
<p>I can't help you much with your <b>IMAGE_FILE_DIRECTORY</b> because I don't 
        know where you store images but it will be something like: <span class="highlight"><nobr>'<?php echo str_replace(array('\\', '/editor_files'), array('/', '/images'), getcwd().'/'); ?>'</nobr></span></p>
<hr>
<p>I can't help you much with your <b>IMAGE_WEB_DIRECTORY</b> either because I 
        don't know where you store images but it will be something like: <span class="highlight"><nobr>'<?php echo preg_replace('/editor_files\/INSTALL_HELP\.php/smi', 'images/', $_SERVER['PHP_SELF']); ?>'</nobr></span></p>
<hr>
<p>I can't help you much with your <b>DOCUMENT_FILE_DIRECTORY</b> because I don't 
        know where you store downloadable documents but it will be something like: <span class="highlight"><nobr>'<?php echo str_replace(array('\\', '/editor_files'), array('/', '/downloads'), getcwd().'/'); ?>'</nobr></span></p>
<hr>
<p>I can't help you much with your <b>DOCUMENT_WEB_DIRECTORY</b> either because 
        I don't know where you store downloadable documents but it will be something 
        like: <span class="highlight"><nobr>'<?php echo preg_replace('/editor_files\/INSTALL_HELP\.php/smi', 'downloads/', $_SERVER['PHP_SELF']); ?>'</nobr></span></p>
<hr>
<p>Enjoy! That Release From DGT</p>
</body>
</html>

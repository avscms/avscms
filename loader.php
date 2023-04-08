<?php
//die('Only enable this script if you dont have support for MultiViews');
$relative = '';
$loaders  = array(
    'ajax' => 1,
    'album' => 1,
    'albums' => 1,
    'blog' => 1,
    'blogs' => 1,
    'captcha' => 1,
    'categories' => 1,
    'community' => 1,
	'messenger' => 1,
    'confirm' => 1,
    'notfound' => 1,
    'feedback' => 1,
    'feeds' => 1,
    'game' => 1,
    'games' => 1,
    'index' => 1,
    'invite' => 1,
    'loader' => 1,
    'login' => 1,
    'logout' => 1,
    'lost' => 1,
    'mail' => 1,
    'notice' => 1,
    'notices' => 1,
    'photo' => 1,
    'requests' => 1,
    'search' => 1,
    'signup' => 1,
    'static' => 1,
    'stream' => 1,
	'tags' => 1,
    'upload' => 1,
    'user' => 1,
    'users' => 1,
    'video' => 1,
    'videos' => 1,
	'edit' => 1,
    'embed' => 1,
    'view' => 1,	
	'ads' => 1
);

$query      = ( isset($_SERVER['QUERY_STRING']) ) ? $_SERVER['QUERY_STRING'] : NULL;
$request    = str_replace($relative, '', $_SERVER['REQUEST_URI']);
$request    = str_replace('?' .$query, '', $request);
$request    = explode('/', trim($request, '/'));
if (isset($request['0'])) {
    $page   = $request['0'];
    if (isset($loaders[$page])) {
        require $page. '.php';
    } else {
		header('HTTP/1.0 404 Not Found');
  		die();
	}
} else {
	header('HTTP/1.0 404 Not Found');
    die();
}
?>

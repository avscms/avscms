<!DOCTYPE html>
<html lang="en">
{if $view}
	<head prefix="og: http://ogp.me/ns#">
{else}
	<head>
{/if}
	{if $view}
		{assign var='vtags' value=$video.keyword}
	
		<meta property="og:site_name" content="{$site_name}">
		<meta property="og:title" content="{$video.title|escape:'html'}">
		<meta property="og:url" content="{$baseurl}/video/{$video.VID}/{$video.title|clean}">
		<meta property="og:type" content="video">
		<meta property="og:image" content="{insert name=thumb_path vid=$video.VID}/{if $video.embed_code != ''}1{else}default{/if}.jpg">
		<meta property="og:description" content="{if $video.description}{$video.description|escape:'html'}{else}{$video.title|escape:'html'}{/if}">
	{section name=i loop=$vtags}
	<meta property="video:tag" content="{$vtags[i]}">
	{/section}			
		{if !$video.embed_code}	
			{include file='player_settings.tpl'}	
		{/if}
	{/if}

    <title>{if isset($self_title) && $self_title != ''}{$self_title|escape:'html'}{else}{$site_name}{/if}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">	
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 days" />
    <meta name="keywords" content="{if isset($self_keywords) && $self_keywords != ''}{$self_keywords|escape:'html'}{else}{$meta_keywords}{/if}" />
    <meta name="description" content="{if isset($self_description) && $self_description != ''}{$self_description|escape:'html'}{else}{$meta_description}{/if}" />

	<link rel="Shortcut Icon" type="image/ico" href="{$baseurl}/images/favicons/favicon.ico" />
	<link rel="apple-touch-icon" sizes="57x57" href="{$baseurl}/images/favicons/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="{$baseurl}/images/favicons/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="{$baseurl}/images/favicons/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="{$baseurl}/images/favicons/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="{$baseurl}/images/favicons/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="{$baseurl}/images/favicons/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="{$baseurl}/images/favicons/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="{$baseurl}/images/favicons/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="{$baseurl}/images/favicons/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="{$baseurl}/images/favicons/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="{$baseurl}/images/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="{$baseurl}/images/favicons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="{$baseurl}/images/favicons/favicon-16x16.png">
	<link rel="manifest" href="{$baseurl}/images/favicons/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="{$baseurl}/images/favicons/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">		

    <script type="text/javascript">
    var base_url = "{$baseurl}";
	var max_thumb_folders = "{$max_thumb_folders}";
    var tpl_url = "{$relative_tpl}";
	{if isset($video.VID)}var video_id = "{$video.VID}";{/if}
	var lang_deleting = "{t c='global.deleting'}";
	var lang_flaging = "{t c='global.flaging'}";
	var lang_loading = "{t c='global.loading'}";
	var lang_sending = "{t c='global.sending'}";
	var lang_share_name_empty = "{t c='share.name_empty'}";
	var lang_share_rec_empty = "{t c='share.recipient'}";
	var fb_signin = "{$fb_signin}";
	var fb_appid = "{$fb_appid}";
	var g_signin = "{$g_signin}";
	var g_cid = "{$g_cid}";
	var signup_section = false;
	var relative = "{$relative}";
	var search_v = "{t c='ajax.search'} {t c='global.videos'}";
	var search_a = "{t c='ajax.search'} {t c='global.albums'}";
	var search_u = "{t c='ajax.search'} {t c='global.users'}";	
	var lang_global_delete 		 	 = "{t c='global.delete'}";
	var lang_global_yes 		 	 = "{t c='global.yes'}";
	var lang_global_no 				 = "{t c='global.no'}";		
	var lang_global_remove 		 	 = "{t c='global.remove'}";
	{if isset($smarty.session.uid)}
		var session_uid = "{$smarty.session.uid}";
	{else}
		var session_uid = "";	
	{/if}
	var current_url = "{$current_url}";	
	var alert_messages = {$messages|json_encode};
	var alert_errors = {$errors|json_encode};	
	</script>

    <script src="https://code.jquery.com/jquery-3.1.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<link rel="stylesheet" href="{$relative_tpl}/css/easy-autocomplete.min.css"> 	
	<link rel="stylesheet" href="{$relative_tpl}/css/easy-autocomplete.themes.min.css">	
	
	<link href="{$relative_tpl}/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	
	<!-- Video Player -->
	{if $view && !$video.embed_code}
		<link href="{$baseurl}/media/player/videojs/video-js.css" rel="stylesheet">	
		<link href="{$baseurl}/media/player/videojs/plugins/videojs-resolution-switcher-master/lib/videojs-resolution-switcher.css" rel="stylesheet">		
		<link href="{$baseurl}/media/player/videojs/plugins/videojs-logobrand-master/src/videojs.logobrand.css" rel="stylesheet">
		<link href="{$baseurl}/media/player/videojs/plugins/videojs-thumbnails-master/videojs.thumbnails.css" rel="stylesheet">
		<link href="{$baseurl}/media/player/videojs/video-js-custom.css" rel="stylesheet">					
		{if $vast_vpaid && $player.vast_vpaid_adv}
			<link href="{$baseurl}/media/player/videojs/plugins/videojs-vast-vpaid-master/bin/videojs.vast.vpaid.css" rel="stylesheet">			
		{/if}
		<script src="{$baseurl}/media/player/videojs/ie8/videojs-ie8.min.js"></script>
		<script src="{$baseurl}/media/player/videojs/video.js"></script>
		{if $vast_vpaid && $player.vast_vpaid_adv}
			<script src="{$baseurl}/media/player/videojs/plugins/videojs-vast-vpaid-master/bin/es5-shim.js"></script>				
			<script src="{$baseurl}/media/player/videojs/plugins/videojs-vast-vpaid-master/bin/ie8fix.js"></script>			
			<script src="{$baseurl}/media/player/videojs/plugins/videojs-vast-vpaid-master/bin/videojs_5.vast.vpaid.min.js"></script>				
		{/if}
		<script src="{$baseurl}/media/player/videojs/plugins/videojs-resolution-switcher-master/lib/videojs-resolution-switcher.js"></script>
		<script src="{$baseurl}/media/player/videojs/plugins/videojs-logobrand-master/src/videojs.logobrand.js"></script>
		<script src="{$baseurl}/media/player/videojs/plugins/videojs-thumbnails-master/videojs.thumbnails.js"></script>
	{/if}	
	<!-- End Video Player -->
	{if $menu == 'blogs'}
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-lite.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-lite.min.js"></script>
	{/if}
	
</head>
<body>

<div class="modal fade in" id="login-modal">
	<div class="modal-dialog login-modal">
		<div class="modal-content">
			<form name="login_form" method="post" action="{$relative}/login">	
				<div class="modal-header">
					<h4 class="modal-title">{t c='signup.login'}</h4>				
					<button type="button" class="close" data-dismiss="modal">&times;</button>		
				</div>
				<div class="modal-body">
					<input name="current_url" type="hidden" value="{$current_url}"/>
					{if $fb_signin == '1'}
					<div class="mb-4">
						<button id="facebook-signin" class="btn btn-facebook" disabled><div></div><i class="fab fa-facebook-f"></i> <span>{t c='socialsignup.login_with'} Facebook</span></button>
					</div>
					{/if}
					{if $g_signin == '1'}						
					<div class="mb-4">
						<button id="google-signin" class="btn btn-google" disabled><div></div><i class="fab fa-google-plus-g"></i> <span>{t c='socialsignup.login_with'} Google</span></button>
					</div>
					{/if}
					<input name="username" type="text" value="" id="login_username" class="form-control mb-3" placeholder="{t c='global.username'}"/>
					<input name="password" type="password" value="" id="login_password" class="form-control mb-3" placeholder="{t c='global.password'}"/>
					<a href="{$relative}/lost" id="lost_password">{t c='global.forgot'}</a><br />
					<a href="{$relative}/confirm" id="confirmation_email">{t c='global.confirm'}</a>		
				</div>
				<div class="modal-footer">
					<button name="submit_login" id="login_submit" type="submit" class="btn btn-primary btn-bold">{t c='global.login'}</button>
					<a href="{$relative}/signup" class="btn btn-secondary btn-bold">{translate c='global.sign_up'}</a>
				</div>
			</form>			
		</div>
    </div>
</div>

<div class="modal fade" id="dialogModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-bold opt-1"></button>			
				<button type="button" class="btn btn-secondary btn-bold opt-2" data-dismiss="modal"></button>
			</div>
		</div>
	</div>
</div>

{if $fb_signin == '1'}
	{include file='fb_signup_modal.tpl'}
{/if}
{if $g_signin == '1'}
	{include file='g_signup_modal.tpl'}
{/if}

<div class="modal fade" id="language-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{t c='global.select_language'}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row mb-4">
				{foreach from=$languages key=key item=language }
					<div class="col-6 col-sm-4">
						{if $smarty.session.language != $key}
							<a href="#" id="{$key}" class="change-language">{$language.name}</a>
						{else}
							<span class="change-language language-active">{$language.name}</span>
						{/if}
					</div>
				{/foreach}
				</div>
			</div>
			<form name="languageSelect" id="languageSelect" method="post" action="">
			<input name="language" id="language" type="hidden" value="" />
			</form>	
		</div>
	</div>
</div>


<div class="sticky-top">
	<div class="top-nav">
		<div class="container">
			<div class="top-menu">
				<div class="float-left">
					<a class="top-brand" href="{$relative}/"><img src="{$relative}/images/logo/logo.png" alt="{$site_name}"></a>
				</div>
				<div class="search-top-container mx-auto d-none d-md-inline-block">
				<form class="form-inline" name="search" id="search_form" method="post" action="{$relative}/search/{if !isset($search_type)}videos{else}{$search_type}{/if}">
					<div class="input-group">			
						<input type="text" class="form-control search-box" placeholder="{t c='ajax.search'} {if isset($search_type) && $search_type == 'photos'} {t c='global.albums'}{elseif isset($search_type) && $search_type == 'users'} {t c='global.users'}{else}{t c='global.videos'}{/if}" name="search_query" id="search_query" value="{if isset($search_query)}{$search_query_f}{/if}" autocomplete="off">				
						<span>
							<a id="search_select" class="btn btn-search-select">{if isset($search_type) && $search_type == 'photos'}<i class="fas fa-camera"></i>{elseif isset($search_type) && $search_type == 'users'}<i class="fas fa-user"></i>{else}<i class="fas fa-video"></i>{/if}</a>
						</span>				
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
						</span>
					</div>
					<input type="hidden" id="search_type" value="{$search_type}">
				</form>			
				</div>			
				{if $multi_language}
					<div class="float-right">
						{insert name=language assign=flag}
						<div class="top-menu-item">
							<a data-toggle="modal" href="#language-modal">{$flag} <span class="caret"></span></a>
						</div>
					</div>
				{/if}
				<div class="float-right">
				{if isset($smarty.session.uid)}
					<div class="btn-group">
						<a href="#" class="dropdown-toggle top-menu-item" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
							<span class="d-xs-inline d-sm-none">
								{if $requests_count > 0 || $mails_count > 0}<span class="badge badge-danger">{$requests_count+$mails_count}</span>{/if} <i class="fas fa-user"></i> <i class="fas fa-caret-down"></i>
							</span>
							<span class="d-none d-sm-inline">
								{if $requests_count > 0 || $mails_count > 0}<span class="badge badge-danger">{$requests_count+$mails_count}</span>{/if} {$smarty.session.username|truncate:15:"..."} <i class="fas fa-caret-down"></i></span>
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href = "{$relative}/user/edit">{t c='user.edit_profile'}</a>							
							<a class="dropdown-item" href="{$relative}/user">{t c='topnav.my_profile'}</a>						
							{if $video_module == '1'}<li><a class="dropdown-item" href="{$relative}/user/{$smarty.session.username}/videos">{t c='topnav.my_videos'}</a>{/if}
							{if $photo_module == '1'}<li><a class="dropdown-item" href="{$relative}/user/{$smarty.session.username}/albums">{t c='topnav.my_photos'}</a>{/if}
							<a class="dropdown-item" href="{$relative}/user/{$smarty.session.username}/blog">{t c='topnav.my_blog'}</a>
							<a class="dropdown-item" href="{$relative}/feeds">{translate c='global.my_feeds'}</a>
							<a class="dropdown-item" href="{$relative}/requests"><span class="float-left">{translate c='global.requests'}</span>{if $requests_count > 0}<span class="badge badge-danger float-right">{$requests_count}</span>{/if}<div class="clearfix"></div></a>
							<a class="dropdown-item" href="{$relative}/mail/inbox"><span class="float-left">{translate c='global.inbox'}</span>{if $mails_count > 0}<span class="badge badge-danger float-right">{$mails_count}</span>{/if}<div class="clearfix"></div></a>
							<a class="dropdown-item" href="{$relative}/logout">{translate c='global.sign_out'}</a>						
						</div>
					</div>
				{else}
					<div class="top-menu-item">
						<a data-toggle="modal" href="#login-modal"><i class="fas fa-key"></i><span class="d-none d-lg-inline"> {translate c='global.login'}</span></a>	
					</div>
					<div class="top-menu-item">
						<a href="{$relative}/signup" rel="nofollow"><i class="fas fa-user-plus"></i><span class="d-none d-lg-inline"> {translate c='global.sign_up'}</span></a>
					</div>					
				{/if}
				</div>
				<div class="clearfix"></div>
			</div> 
		</div>
	</div>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">

		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="d-block d-md-none search-bot-container">
				<form class="form-inline" name="search" id="search_form_xs" method="post" action="{$relative}/search/{if !isset($search_type)}videos{else}{$search_type}{/if}">
					<div class="input-group">			
						<input type="text" class="form-control search-box" placeholder="{t c='ajax.search'} {if isset($search_type) && $search_type == 'photos'} {t c='global.albums'}{elseif isset($search_type) && $search_type == 'users'} {t c='global.users'}{else}{t c='global.videos'}{/if}" name="search_query" id="search_query_xs" value="{if isset($search_query)}{$search_query_f}{/if}" autocomplete="off">				
						<span>
							<a id="search_select_xs" class="btn btn-search-select">{if isset($search_type) && $search_type == 'photos'}<i class="fas fa-camera"></i>{elseif isset($search_type) && $search_type == 'users'}<i class="fas fa-user"></i>{else}<i class="fas fa-video"></i>{/if}</a>
						</span>				
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
						</span>
					</div>				
				</form>	
			</div>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {if $menu == 'home'}active{/if}">
					<a class="nav-link" href="{$relative}/">{translate c='menu.home'}</a>
				</li>
				{if $video_module == '1'}
					<li class="nav-item d-block d-md-none {if $menu == 'videos'}active{/if}">
						<a class="nav-link" href="{$relative}/videos">{translate c='menu.videos'}</a>
					</li>
					<li class="nav-item dropdown d-none d-md-block {if $menu == 'videos'} active{/if}">
						<a href="{$relative}/videos" class="dropdown-toggle nav-link" data-toggle="dropdown" data-hover="dropdown">
							{translate c='menu.videos'} <b class="caret"></b>
						</a>
						{if $featured_videos_sm}
						<div class="dropdown-menu multi-column-dropdown">
							<div class="container">
								<div class="sub-menu-left">
									<div class="sub-menu-title">
										{t c='menu.discover_videos'}
									</div>
									<div class="sub-menu-content">
										<ul>
											<li><a href="{$relative}/videos?type=featured"><i class="far fa-star"></i> {t c='global.featured'}</a></li>								
											<li><a href="{$relative}/videos?o=mr"><i class="far fa-clock"></i> {t c='global.most_recent'}</a></li>
											<li><a href="{$relative}/videos?o=mv"><i class="far fa-eye"></i> {t c='global.most_viewed'}</a></li>
											<li><a href="{$relative}/videos?o=tr"><i class="far fa-thumbs-up"></i> {t c='global.top_rated'}</a></li>
											<li><a href="{$relative}/videos?o=tf"><i class="far fa-heart"></i> {t c='global.top_favorites'}</a></li>								
										</ul>									
									</div>
									{if $suggestion_arr}
									<div class="sub-menu-title mt-3">
										{t c='menu.trending_searches'}										
									</div>
									<div class="sub-menu-content">
										{section name=i loop=$suggestion_arr max=10}
											<span class="trending-searches"><a href="{$relative}/search/videos/{$suggestion_arr[i].expression}"><i class="fas fa-search"></i>{$suggestion_arr[i].expression}</a></span>
										{/section}									
									</div>
									{/if}									
								</div>								
								<div class="sub-menu-right">
									<div class="sub-menu-title">
										{t c='menu.featured_videos'}	
									</div>
									<div class="sub-menu-content">
										{if $featured_videos_sm}
											<div class="row content-row">
											{section name=i loop=$featured_videos_sm}
												<div class="col-md-6 col-lg-4 col-xl-3 {if $smarty.section.i.index > 5}d-sm-none d-md-none d-lg-none d-xl-block{/if}">
													<a href="{$relative}/video/{$featured_videos_sm[i].VID}/{$featured_videos_sm[i].title|clean}">
														<div class="thumb-overlay" {if $featured_videos_sm[i].vthumbs == '1'} id="playvthumb_{$featured_videos_sm[i].VID}"{/if}>
															<img src="{insert name=thumb_path vid=$featured_videos_sm[i].VID}/{$featured_videos_sm[i].thumb}.jpg" title="{$featured_videos_sm[i].title|escape:'html'}" alt="{$featured_videos_sm[i].title|escape:'html'}" {if $featured_videos_sm[i].vthumbs == '0'}id="rotate_{$featured_videos_sm[i].VID}_{$featured_videos_sm[i].thumbs}_{$featured_videos_sm[i].thumb}_viewed"{/if} class="img-responsive {if $featured_videos_sm[i].type == 'private'}img-private{/if}"/>
															{if $featured_videos_sm[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
															<div class="duration">
																{if $featured_videos_sm[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
																{insert name=duration assign=duration duration=$featured_videos_sm[i].duration}
																{$duration}
															</div>
														</div>

													</a>
													<div class="content-info">
														<a href="{$relative}/video/{$featured_videos_sm[i].VID}/{$featured_videos_sm[i].title|clean}">
															<span class="content-title">{$featured_videos_sm[i].title|escape:'html'}</span>					
														</a>
														<div class="content-details">
															{insert name=views assign=s_views views=$featured_videos_sm[i].viewnumber}											
															<span class="content-views">
																{$s_views}								
															</span>
															{if $featured_videos_sm[i].rate != 0}
																<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$featured_videos_sm[i].rate}%</span></span>
															{/if}
														</div>				
													</div>
												</div>			
											{/section}
											</div>
										{/if}
									</div>									
								</div>
							</div>
						</div>
						{/if}
					</li>
				{/if}
				{if $photo_module == '1'}
					<li class="nav-item {if $menu == 'albums'}active{/if}">
						<a class="nav-link" href="{$relative}/albums">{translate c='menu.photos'}</a>
					</li>
				{/if}
				{if $blog_module == '1'}
					<li class="nav-item {if $menu == 'blogs'}active{/if}">
						<a class="nav-link" href="{$relative}/blogs">{translate c='menu.blogs'}</a>
					</li>
				{/if}
				<li class="nav-item d-block d-md-none {if $menu == 'categories'}active{/if}">
					<a class="nav-link" href="{$relative}/categories">{translate c='menu.categories'}</a>
				</li>
				<li class="nav-item dropdown d-none d-md-block {if $menu == 'categories'} active{/if}">
					<a href="{$relative}/categories" class="dropdown-toggle nav-link" data-toggle="dropdown">
						{translate c='menu.categories'} <b class="caret"></b>
					</a>
					{if $categories_sm}
					<div class="dropdown-menu multi-column-dropdown">
						<div class="container">
							<div class="sub-menu-left">							
								{if $suggestion_arr}
								<div class="sub-menu-title">
									{t c='menu.trending_searches'}
								</div>
								<div class="sub-menu-content">
									{section name=i loop=$suggestion_arr max=20}
										<span class="trending-searches"><a href="{$relative}/search/videos/{$suggestion_arr[i].expression}"><i class="fas fa-search"></i>{$suggestion_arr[i].expression}</a></span>
									{/section}									
								</div>
								{/if}				
								<div class="sub-menu-content mt-3">
									<a href="{$relative}/categories"><i class="fas fa-th"></i> {translate c='categories.view_all'}</a>
								</div>									
							</div>								
							<div class="sub-menu-right">
								<div class="sub-menu-title">
									{t c='menu.popular_categories'}								
								</div>
								<div class="sub-menu-content">
									{if $categories_sm}
										<div class="row content-row">
											{section name=i loop=$categories_sm}
												<div class="col-md-6 col-lg-4 col-xl-3 {if $smarty.section.i.index > 5}d-sm-none d-md-none d-lg-none d-xl-block{/if} m-b-20">
													<a href="{$relative}/videos/{$categories_sm[i].slug}">
														<div class="thumb-overlay">
															<img src="{$relative}/media/categories/video/{$categories_sm[i].CHID}.jpg" title="{$categories_sm[i].name|escape:'html'}" alt="{$categories_sm[i].name|escape:'html'}" class="img-responsive"/>
															<div class="category-title">
																<div class="float-left title-truncate">
																	{$categories_sm[i].name|escape:'html'}
																</div>
																<div class="float-right">
																	{$categories_sm[i].total_videos}
																</div>
															</div>							
														</div>
													</a>
												</div>			
											{/section}
										</div>
									{/if}
								</div>									
							</div>
						</div>
					</div>
					{/if}
				</li>
				<li class="nav-item d-block d-md-none {if $menu == 'tags'}active{/if}">
					<a class="nav-link" href="{$relative}/tags">{translate c='menu.tags'}</a>
				</li>
				
				<div class="nav-item dropdown d-none d-md-block {if $menu == 'tags'} active{/if}">
					<a href="{$relative}/tags" class="dropdown-toggle nav-link" data-toggle="dropdown">
						{translate c='menu.tags'} <b class="caret"></b>
					</a>
					{if $tags_sm}
					<div class="dropdown-menu multi-column-dropdown">
						<div class="container">
							<div class="sub-menu-left w-100 m-b-10">
								{if $tags_sm}
								<div class="sub-menu-title">
									{translate c='tags.popular_tags'}										
								</div>
								<div class="sub-menu-content">
									<div class="row content-row">
									{section name=i loop=$tags_sm}										
										<div class="popular-tag">
											<span>	
												<span class="tag-counter">{$tags_sm[i].counter}</span>							
												<i class="fas fa-search"></i>						
												<a href="{$relative}/search/tags/{$tags_sm[i].tag}" title="{$tags_sm[i].tag}">{$tags_sm[i].tag}</a>
											</span>
										</div>																					
									{/section}									
									</div>
								</div>
								{/if}	
								<div class="sub-menu-content mt-3">
									<a href="{$relative}/tags"><i class="fas fa-tags"></i> {translate c='global.view_more'}</a>
								</div>								
							</div>								
						</div>
					</div>
					{/if}
				</div>
				
				<li class="nav-item {if $menu == 'community'} active{/if}">
					<a class="nav-link" href="{$relative}/community">{translate c='menu.community'}</a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item {if $menu == 'upload'}active{/if}">
					<a class="nav-link" href="{$relative}/upload">{translate c='menu.upload'}</a>
				</li>				
			</ul>
			</div>
		</div>
	</nav>
</div>
<div id="wrapper">


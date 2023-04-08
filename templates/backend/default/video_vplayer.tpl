<!DOCTYPE html>
<html>
<head>
	{if !$video.embed_code}
		{include file='player_settings.tpl'}	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
		<link href="/media/player/videojs/video-js.css" rel="stylesheet">	
		<link href="/media/player/videojs/plugins/videojs-resolution-switcher-master/lib/videojs-resolution-switcher.css" rel="stylesheet">		
		<link href="/media/player/videojs/plugins/videojs-logobrand-master/src/videojs.logobrand.css" rel="stylesheet">
		<link href="/media/player/videojs/plugins/videojs-thumbnails-master/videojs.thumbnails.css" rel="stylesheet">
		<link href="/media/player/videojs/video-js-custom.css" rel="stylesheet">					
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
		<script src="/media/player/videojs/plugins/videojs-resolution-switcher-master/lib/videojs-resolution-switcher.js"></script>
		<script src="/media/player/videojs/plugins/videojs-logobrand-master/src/videojs.logobrand.js"></script>
		<script src="/media/player/videojs/plugins/videojs-thumbnails-master/videojs.thumbnails.js"></script>
	{/if}		
	<style>
	{literal}
	body {
		margin:0!important;
		padding:0!important;
		overflow:hidden;
		background-color: #000;
	}
	.text-error {  
		font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 14px;
		line-height: 1.42857143;
		color: red;
		padding: 10px;	
	}
	.text-message {  
		font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 16px;
		line-height: 1.42857143;
		color: #fff;
		padding: 10px;
	}
	.text-message a {
		color: #ccc;
	}
	.text-message a:visited {  
		color: #ccc;
	}
	.video-container {
		position: relative;
		width: 100%;
	}
	.video-embedded {
		width: 100%;
		overflow: hidden;
	}
	.video-embedded iframe {
		width: 100%!important;
		height: 100%!important;
		overflow: hidden;
		position: absolute;		
	}
	{/literal}
	</style>
</head>
<body>
{if $video.VID}
	{if $video.embed_code != ''}
		<div class="video-embedded">
			{$video.embed_code}
		</div>
	{else}
	<div class="video-container">
		<video id="video" class="video-js vjs-16-9 vjs-big-play-centered vjs-sublime-skin" preload="auto" controls="true" playsinline webkit-playsinline poster="{insert name=thumb_path vid=$video.VID}/default.jpg" data-setup='{
		  "autoplay": {if $player.autoplay}true{else}false{/if}{if $vast_vpaid && $player.vast_vpaid_adv},
		  "plugins": {
		  "vastClient": {
			"adTagUrl": "{$vast_vpaid.adtagurl}",
			"adCancelTimeout": {$vast_vpaid.adscanceltimeout},
			"playAdAlways": true,		
			"adsEnabled": {if $player.vast_vpaid_adv}true{else}false{/if}
			}
		  }
		{/if}}'>
			{if $video.iphone == 1}
				<source src="{$video_root}/iphone/{$video.VID}.mp4" type='video/mp4' label='SD' res='720'/>
				{if $video.hd == 1}
					<source src="{$video_root}/hd/{$video.VID}.mp4" type='video/mp4' label='HD' res ='1080'/>
				{/if}
			{else}
				{section name=i loop=$video.files}
					<source src="{$video_root}/h264/{$video.files[i].file}" type='video/{$video.files[i].format}' label='{$video.files[i].label}' res='{$video.files[i].height}'/>
				{/section}
			{/if}
			<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
		</video>		
	</div>
	{/if}
{else}
	<center>
		<div class="text-error">This video is not available on this platform.</div>
		<div class="text-message">Watch more videos here:<br><a href="{$baseurl}">{$baseurl}</a></div>
	</center>
{/if}
{if !$video.embed_code}
	<script src="/media/player/videojs/video-js-events.js"></script>
{/if}
</body>
</html>

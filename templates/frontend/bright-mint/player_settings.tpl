<script type="text/javascript">
	var player_autoplay = "{$player.autoplay}";
	var player_resolution = "{$player.resolution}";	
	var player_timeline_preview = "{$player.timeline_preview}";		
	var player_sprite = "{$player.sprite}";
	var player_logo = "{$player.logo}";
	var player_logo_redirect = "{$player.logo_redirect}";
	var player_logo_position = "{$player.logo_position}";
	var player_logo_link = "{$player.logo_link}";	
	if (player_logo_link == '') {literal}{{/literal}
		player_logo_link = "{$baseurl}/video/{$video.VID}/{$video.title|clean}";
	{literal}}{/literal}
	var player_logo_image = "{$baseurl}/media/player/logo/logo.png";	
	var player_logo_opacity = "{$player.logo_opacity}";
	var player_pause_adv = "{$player.pause_adv}";
	var video_duration = "{$video.duration}";	
	var video_id = "{$video.VID}";
	var base_url = "{$baseurl}";	
	var aid = "{$aid}";
</script>
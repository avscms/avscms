<script type="text/javascript">
var lang_playlist_remove_confirm = "{t c='playlist.remove_confirm'}";
</script>
<div class="container mt-3">
	{include file='user_info.tpl'}
	<div class="user-right">
		{if $playlist}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.recently_watched'}</h1>
				</div>	
				<div class="clearfix"></div>
			</div>
			<div class="well-info">
				{if $playlist}
				{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$playlist_total}</span> {t c='videos.videos'}.
				{/if}
			</div>
			<div class="row content-row {if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}my{/if}">
				{section name=i loop=$playlist}
					<div id="playlist_block_{$playlist[i].VID}" class="{if $min_col == '2'}col-6{/if} col-sm-6 col-md-4 col-lg-4 {if $max_col == '5'}col-xl-3{/if}">
						<a href="{$relative}/video/{$playlist[i].VID}/{$playlist[i].title|clean}">
							<div class="thumb-overlay" {if $playlist[i].vthumbs == '1'} id="playvthumb_{$playlist[i].VID}"{/if}>
								<img src="{insert name=thumb_path vid=$playlist[i].VID}/{$playlist[i].thumb}.jpg" title="{$playlist[i].title|escape:'html'}" alt="{$playlist[i].title|escape:'html'}" {if $playlist[i].vthumbs == '0'}id="rotate_{$playlist[i].VID}_{$playlist[i].thumbs}_{$playlist[i].thumb}_viewed"{/if} class="img-responsive {if $playlist[i].type == 'private'}img-private{/if}"/>
								{if $playlist[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
								<div class="duration">
									{if $playlist[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
									{insert name=duration assign=duration duration=$playlist[i].duration}
									{$duration}
								</div>
							</div>
						</a>
						<div class="content-info">
							<a href="{$relative}/video/{$playlist[i].VID}/{$playlist[i].title|clean}">
								<span class="content-title">{$playlist[i].title|escape:'html'}</span>					
							</a>
							<div class="content-details">
								{insert name=views assign=s_views views=$playlist[i].viewnumber}											
								<span class="content-views">
									{$s_views}								
								</span>
								{if $playlist[i].rate != 0}
									<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$playlist[i].rate}%</span></span>
								{/if}
							</div>	
							{if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}
							<div class="content-actions">
								<a href="#" data-vid="{$playlist[i].VID}" id="remove_playlist_video_{$playlist[i].VID}"  data-toggle="tooltip" data-placement="top" title="{t c='global.remove'}"><i class="fas fa-times"></i>
							</div>
							{/if}
						</div>
					</div>			
				{/section}				
			</div>		
			{if $page_link}			
				<div class="d-block d-sm-none">
					<ul class="pagination pagination-lg">{$page_link}</ul>
				</div>
				<div class="d-none d-sm-block">
					<ul class="pagination">{$page_link}</ul>
				</div>					
			{/if}			
		</div>	
		{/if}
	</div>
</div>


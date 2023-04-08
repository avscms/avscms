<script type="text/javascript">
var lang_favorites_remove_confirm = "{t c='favorites.remove_confirm'}";
</script>
<div class="container mt-3">
	{include file='user_info.tpl'}
	<div class="user-right">
		{if $favorites}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.FAVORITE_VIDEOS'}</h1>
				</div>	
				<div class="clearfix"></div>
			</div>
			<div class="well-info">
				{if $favorites}
				{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$favorites_total}</span> {t c='videos.videos'}.
				{/if}
			</div>
			<div class="row content-row {if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}my{/if}">
				{section name=i loop=$favorites}
					<div id="favorite_block_{$favorites[i].VID}" class="{if $min_col == '2'}col-6{/if} col-sm-6 col-md-4 col-lg-4 {if $max_col == '5'}col-xl-3{/if}">
						<a href="{$relative}/video/{$favorites[i].VID}/{$favorites[i].title|clean}">
							<div class="thumb-overlay" {if $favorites[i].vthumbs == '1'} id="playvthumb_{$favorites[i].VID}"{/if}>
								<img src="{insert name=thumb_path vid=$favorites[i].VID}/{$favorites[i].thumb}.jpg" title="{$favorites[i].title|escape:'html'}" alt="{$favorites[i].title|escape:'html'}" {if $favorites[i].vthumbs == '0'}id="rotate_{$favorites[i].VID}_{$favorites[i].thumbs}_{$favorites[i].thumb}_viewed"{/if} class="img-responsive {if $favorites[i].type == 'private'}img-private{/if}"/>
								{if $favorites[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
								<div class="duration">
									{if $favorites[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
									{insert name=duration assign=duration duration=$favorites[i].duration}
									{$duration}
								</div>
							</div>
						</a>
						<div class="content-info">
							<a href="{$relative}/video/{$favorites[i].VID}/{$favorites[i].title|clean}">
								<span class="content-title">{$favorites[i].title|escape:'html'}</span>					
							</a>
							<div class="content-details">
								{insert name=views assign=s_views views=$favorites[i].viewnumber}											
								<span class="content-views">
									{$s_views}								
								</span>
								{if $favorites[i].rate != 0}
									<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$favorites[i].rate}%</span></span>
								{/if}
							</div>	
							{if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}
							<div class="content-actions">
								<a href="#" data-vid="{$favorites[i].VID}" id="remove_favorite_video_{$favorites[i].VID}"  data-toggle="tooltip" data-placement="top" title="{t c='global.remove'}"><i class="fas fa-times"></i>
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


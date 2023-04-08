<script type="text/javascript">
var lang_videos_delete_confirm = "{t c='videos.delete_confirm'}";
</script>
<div class="container mt-3">
	{include file='user_info.tpl'}
	<div class="user-right">
		{if $videos}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='global.videos'}</h1>
				</div>	
				<div class="clearfix"></div>
			</div>
			<div class="well-info">
				{if $videos}
				{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$videos_total}</span> {t c='videos.videos'}.
				{/if}
			</div>
			<div class="row content-row {if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}my{/if}">
				{section name=i loop=$videos}
					<div id="video_block_{$videos[i].VID}" class="{if $min_col == '2'}col-6{/if} col-sm-6 col-md-4 col-lg-4 {if $max_col == '5'}col-xl-3{/if}">
						<a href="{$relative}/video/{$videos[i].VID}/{$videos[i].title|clean}">
							<div class="thumb-overlay" {if $videos[i].vthumbs == '1'} id="playvthumb_{$videos[i].VID}"{/if}>
								<img src="{insert name=thumb_path vid=$videos[i].VID}/{$videos[i].thumb}.jpg" title="{$videos[i].title|escape:'html'}" alt="{$videos[i].title|escape:'html'}" {if $videos[i].vthumbs == '0'}id="rotate_{$videos[i].VID}_{$videos[i].thumbs}_{$videos[i].thumb}_viewed"{/if} class="img-responsive {if $videos[i].type == 'private'}img-private{/if}"/>
								{if $videos[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
								<div class="duration">
									{if $videos[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
									{insert name=duration assign=duration duration=$videos[i].duration}
									{$duration}
								</div>
							</div>
						</a>
						<div class="content-info">
							<a href="{$relative}/video/{$videos[i].VID}/{$videos[i].title|clean}">
								<span class="content-title">{$videos[i].title|escape:'html'}</span>					
							</a>
							<div class="content-details">
								{insert name=views assign=s_views views=$videos[i].viewnumber}											
								<span class="content-views">
									{$s_views}								
								</span>
								{if $videos[i].rate != 0}
									<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$videos[i].rate}%</span></span>
								{/if}
							</div>	
							{if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}
							<div class="content-actions">						
								<a href="{$relative}/edit/{$videos[i].VID}" data-toggle="tooltip" data-placement="top" title="{t c='global.edit'}"><i class="fas fa-edit"></i></a>
								<a href="#" data-vid="{$videos[i].VID}" id="delete_video_{$videos[i].VID}"  data-toggle="tooltip" data-placement="top" title="{t c='global.delete'}" class="ml-2"><i class="fas fa-trash"></i></a>
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
		{else}
		<div class="well well-sm">
			<span class="text-danger">{t c='videos.no_videos_found'}.</span>
		</div>		
		{/if}		
	</div>
</div>


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
					<h1>{t c='user.FAVORITE_PHOTOS'}</h1>
				</div>	
				<div class="clearfix"></div>
			</div>
			<div class="well-info">
				{if $favorites}
				{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$favorites_total}</span> {t c='album.photos'}.
				{/if}
			</div>
			<div class="row content-row {if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}my{/if}">
				{section name=i loop=$favorites}
					<div id="favorite_block_{$favorites[i].PID}" class="{if $min_col == '2'}col-6{/if} col-sm-6 col-md-4 col-lg-4 {if $max_col == '5'}col-xl-3{/if}">
						<a href="{$relative}/photo/{$favorites[i].PID}">
							<div class="thumb-overlay">
								<img src="{$relative}/media/photos/tmb/{$favorites[i].PID}.jpg" title="{$favorites[i].caption|escape:html}" alt="{$favorites[i].caption|escape:html}" class="img-responsive {if $favorites[i].type == 'private'}img-private{/if}"/>
								{if $favorites[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
							</div>
						</a>
						<div class="content-info">
							<a href="{$relative}/album/{$favorites[i].AID}/{$favorites[i].name|clean}">
								<span class="content-title">{$favorites[i].caption|escape:'html'}</span>
							</a>
							<div class="content-details">	
								{insert name=views assign=s_views views=$favorites[i].total_views}											
								<span class="content-views">
									{$s_views}								
								</span>
								{if $favorites[i].rate != 0}
									<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$favorites[i].rate}%</span></span>
								{/if}
							</div>
							{if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}
							<div class="content-actions">
								<a href="#" data-pid="{$favorites[i].PID}" id="remove_favorite_photo_{$favorites[i].PID}"  data-toggle="tooltip" data-placement="top" title="{t c='global.remove'}"><i class="fas fa-times"></i>
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


<script type="text/javascript">
var lang_favorites_remove_confirm = "{t c='favorites.remove_confirm'}";
</script>
<div class="container mt-3">
	{include file='user_info.tpl'}
	<div class="user-right">
		{if $friends}
		<div>
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.FRIENDS'}</h1>
				</div>	
				<div class="clearfix"></div>
			</div>
			<div class="well-info">
				{if $friends}
				{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$friends_total}</span> {t c='global.friends'}.
				{/if}
			</div>
			<div class="row content-row {if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}my{/if}">
				{section name=i loop=$friends}
					<div id="friends_block_{$friends[i].FID}" class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
						<a href="{$relative}/user/{$friends[i].username}">
							<div class="thumb-overlay">
								<img src="{$relative}/media/users/{if $friends[i].photo == ''}nopic-{$friends[i].gender}.gif{else}{$friends[i].photo}{/if}" alt="{$friends[i].username}'s avatar" class="img-responsive"/>
							</div>
						</a>			
						<div class="content-info">
							<a href="{$relative}/user/{$friends[i].username}">
								<span class="content-truncate {if $friends[i].rate != 0}content-ml{/if}">{$friends[i].username|escape:'html'}</span>
							</a>
							{if $friends[i].rate != 0}
								<span class="content-rating content-mr"><i class="fas fa-thumbs-up"></i> <span>{$friends[i].rate}%</span></span>
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


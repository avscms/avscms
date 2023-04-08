<script type="text/javascript" src="{$relative_tpl}/js/jquery.requests.js"></script>
<div class="container mt-3 mb-3">
	<div class="well-filters mb-2">
		<h1>{t c='requests.title'}</h1>
	</div>
	{if $requests}
		<div class="well-info">
			{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$requests_total}</span> {t c='requests.friend'}.
		</div>		

		<div class="mb-3">
		{section name=i loop=$requests}
		<div id="request_{$requests[i].FID}" class="mb-3">
			<div class="request-sub">
				<div class="float-left">
					<a href="{$relative}/user/{$requests[i].username}">
						<img src="{$relative}/media/users/{if $requests[i].photo != ''}{$requests[i].photo}{else}nopic-{$requests[i].gender}.gif{/if}" alt="{$requests[i].username}'s avatar" class="small-avatar"  />
					</a>
					<a href="{$relative}/user/{$requests[i].username}">{$requests[i].username}</a>
				</div>
				<div class="float-right">
					<a href="#accept_friend" id="accept_friend_{$requests[i].FID}" class="btn btn-primary">{t c='global.accept'}</a>
					<a href="#reject_friend" id="reject_friend_{$requests[i].FID}" class="btn btn-secondary m-l-5">{t c='global.reject'}</a>					
				</div>
			</div>				
			<div class="clearfix"></div>
		</div>
		{/section}
		</div>
	{else}
		<span class="text-danger">{t c='requests.none'}.</span>
	{/if}	
</div>
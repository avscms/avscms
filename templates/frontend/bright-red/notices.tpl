<div class="container mt-3">

	<div class="well-filters">
		<h1>{$site_name|escape:'html'} {t c='global.notices'}</h1>
	</div>
	{if $notices}	
	<div class="well-info">
		{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$notices_total}</span> {t c='notice.notices'}.
	</div>	
	{/if}	
	<div class="row mt-3">	
		<div class="content-left">
            {if $notices}		
			<div class="row">
            {section name=i loop=$notices}
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title"><a href="{$relative}/notice/{$notices[i].NID}/{$notices[i].title|clean}">{$notices[i].title|escape:'html'}</a></h5>
						<p class="card-text">{$notices[i].content|nl2br}</p>
						<div class="card-sub">
							<div class="float-left">
								<a href="{$relative}/user/{$notices[i].username}"><img class="small-avatar" src="{$relative}/media/users/{if $notices[i].photo == ''}nopic-{$notices[i].gender}.gif{else}{$notices[i].photo}{/if}" /><span>{$notices[i].username|truncate:25:"..."}</span></a>
							</div>
							{insert name=time_range assign=addtime time=$notices[i].addtime}
							<div class="float-right">
								{$notices[i].total_views} <i class="fas fa-eye"></i> &nbsp; {$addtime}						
							</div>
						</div>
					</div>
				</div>
			</div>			
            {/section}
			
			</div>
            {else}
			<div class="well well-sm">
				<span class="text-danger">{t c='notice.none'}.</span>
			</div>
            {/if}	

			{if $notices}
				{if $page_link}			
					<div class="d-block d-sm-none">
						<ul class="pagination pagination-lg">{$page_link}</ul>
					</div>
				{/if}
			{/if}

		</div>
		
		<div class="content-right">
			<div class="list-group">
				<a href="{url base='notices' strip='c' value=""}" {if $category == "0" || !$category}class="list-group-item active"{else}class="list-group-item"{/if}>
					{t c='global.all'}
				</a>
				{section name=i loop=$categories}
				<a href="{url base='notices' strip='c' value=$categories[i].category_id}" {if $category == $categories[i].category_id}class="list-group-item active"{else}class="list-group-item"{/if}>
					{$categories[i].name|escape:'html'}
				</a>
				{/section}
			</div>
			<div class="list-group mt-3">
				<a href="{url base='notices' strip='t' value=""}" {if !$timestamp}class="list-group-item active"{else}class="list-group-item"{/if}>
					{t c='global.all'}
				</a>
				{section name=i loop=$arhive}
				<a href="{url base='notices' strip='t' value=$arhive[i]}" {if $timestamp == $arhive[i]}class="list-group-item active"{else}class="list-group-item"{/if}>
					{$arhive[i]|date_format:"%B %Y"}
				</a>
				{/section}
			</div>			
			<div class="ad-body mt-3">
				<p class="ad-title">{t c='global.sponsors'}</p>
				{insert name=adv assign=adv group='notices_right'}
				{if $adv}{$adv}{/if}
			</div>			
		</div>
	</div>
	{if $notices}
		{if $page_link}	
			<div class="d-none d-sm-block">
				<ul class="pagination">{$page_link}</ul>
			</div>
		{/if}
	{/if}
	
	<div class="ad-body mt-3">
		<p class="ad-title">{t c='global.sponsors'}</p>
		{insert name=adv assign=adv group='notices_bottom'}
		{if $adv}{$adv}{/if}
	</div>	
</div>
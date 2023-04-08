<div class="container mt-3 mb-3">

	<div class="well-filters">
			<div class="float-left">
				<h1>{t c='search.title'}<span class="d-none d-md-inline"> - Tags</span></h1>
			</div>
			<div class="float-left">
				<div class="d-none d-md-inline">
					<div class="well-action float-left m-l-20 {if $quality != 'hd'}active{/if}">
						<a href="{url base=$base strip='q' value='all'}"><span class="sw-left">{t c='global.all'}</span></a>
					</div>
					<div class="well-action float-left m-r-15 {if $quality == 'hd'}active{/if}">						
						<a href="{url base=$base strip='q' value='hd'}"><span class="sw-right">HD</span></a>						
					</div>					
					<div class="btn-group m-r-10">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $type == ''}{t c='global.type'}{elseif $type == 'public'}{t c='global.public'}{elseif $type == 'private'}{t c='global.private'}{else}{t c='global.featured'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $type == ''}class="active"{/if}><a href="{url base=$base strip='type' value=''}">{t c='global.all'}</a></li>
							<li {if $type == 'public'}class="active"{/if}><a href="{url base=$base strip='type' value='public'}">{t c='global.public'}</a></li>
							<li {if $type == 'private'}class="active"{/if}><a href="{url base=$base strip='type' value='private'}">{t c='global.private'}</a></li>	
							<li {if $type == 'featured'}class="active"{/if}><a href="{url base=$base strip='type' value='featured'}">{t c='global.featured'}</a></li>								
						</ul>
					</div>
					
					<div class="btn-group m-r-10">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $timeframe == 'a'}{t c='global.timeline'}{elseif $timeframe == 't'}{t c='global.added'} {t c='global.today'}{elseif $timeframe == 'w'}{t c='global.added'} {t c='global.this_week'}{else}{t c='global.added'} {t c='global.this_month'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $timeframe == 'a'}class="active"{/if}><a href="{url base=$base strip='t' value='a'}">{t c='global.all'}</a></li>							
							<li {if $timeframe == 't'}class="active"{/if}><a href="{url base=$base strip='t' value='t'}">{t c='global.added'} {t c='global.today'}</a></li>
							<li {if $timeframe == 'w'}class="active"{/if}><a href="{url base=$base strip='t' value='w'}">{t c='global.added'} {t c='global.this_week'}</a></li>
							<li {if $timeframe == 'm'}class="active"{/if}><a href="{url base=$base strip='t' value='m'}">{t c='global.added'} {t c='global.this_month'}</a></li>
						</ul>
					</div>					

					<div class="btn-group m-r-10">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $order == 'bw'}{t c='global.being_watched'}{elseif $order == 'mr'}{t c='global.most_recent'}{elseif $order == 'mv'}{t c='global.most_viewed'}{elseif $order == 'tr'}{t c='global.top_rated'}{elseif $order == 'md'}{t c='global.most_commented'}{elseif $order == 'tf'}{t c='global.top_favorites'}{else}{t c='global.longest'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $order == 'bw'}class="active"{/if}><a href="{url base=$base strip='o' value='bw'}">{t c='global.being_watched'}</a></li>						
							<li {if $order == 'mr'}class="active"{/if}><a href="{url base=$base strip='o' value='mr'}">{t c='global.most_recent'}</a></li>
							<li {if $order == 'mv'}class="active"{/if}><a href="{url base=$base strip='o' value='mv'}">{t c='global.most_viewed'}</a></li>
							<li {if $order == 'md'}class="active"{/if}><a href="{url base=$base strip='o' value='md'}">{t c='global.most_commented'}</a></li>
							<li {if $order == 'tr'}class="active"{/if}><a href="{url base=$base strip='o' value='tr'}">{t c='global.top_rated'}</a></li>							
							<li {if $order == 'tf'}class="active"{/if}><a href="{url base=$base strip='o' value='tf'}">{t c='global.top_favorites'}</a></li>
							<li {if $order == 'lg'}class="active"{/if}><a href="{url base=$base strip='o' value='lg'}">{t c='global.longest'}</a></li>
						</ul>
					</div>					
				</div>	
				<div class="d-inline d-md-none">
					<div class="btn-group m-l-20">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">Filters <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $type == ''}class="active"{/if}><a href="{url base=$base strip='type' value=''}">{t c='global.all'}</a></li>
							<li {if $type == 'public'}class="active"{/if}><a href="{url base=$base strip='type' value='public'}">{t c='global.public'}</a></li>
							<li {if $type == 'private'}class="active"{/if}><a href="{url base=$base strip='type' value='private'}">{t c='global.private'}</a></li>						
							<div class="dropdown-divider"></div>
							<li {if $timeframe == 'a'}class="active"{/if}><a href="{url base=$base strip='t' value='a'}">{t c='global.all'}</a></li>							
							<li {if $timeframe == 't'}class="active"{/if}><a href="{url base=$base strip='t' value='t'}">{t c='global.added'} {t c='global.today'}</a></li>
							<li {if $timeframe == 'w'}class="active"{/if}><a href="{url base=$base strip='t' value='w'}">{t c='global.added'} {t c='global.this_week'}</a></li>
							<li {if $timeframe == 'm'}class="active"{/if}><a href="{url base=$base strip='t' value='m'}">{t c='global.added'} {t c='global.this_month'}</a></li>
							<div class="dropdown-divider"></div>			
							<li {if $order == 'bw'}class="active"{/if}><a href="{url base=$base strip='o' value='bw'}">{t c='global.being_watched'}</a></li>						
							<li {if $order == 'mr'}class="active"{/if}><a href="{url base=$base strip='o' value='mr'}">{t c='global.most_recent'}</a></li>
							<li {if $order == 'mv'}class="active"{/if}><a href="{url base=$base strip='o' value='mv'}">{t c='global.most_viewed'}</a></li>
							<li {if $order == 'md'}class="active"{/if}><a href="{url base=$base strip='o' value='md'}">{t c='global.most_commented'}</a></li>
							<li {if $order == 'tr'}class="active"{/if}><a href="{url base=$base strip='o' value='tr'}">{t c='global.top_rated'}</a></li>							
							<li {if $order == 'tf'}class="active"{/if}><a href="{url base=$base strip='o' value='tf'}">{t c='global.top_favorites'}</a></li>
							<li {if $order == 'lg'}class="active"{/if}><a href="{url base=$base strip='o' value='lg'}">{t c='global.longest'}</a></li>
						</ul>
					</div>				
				</div>
			</div>
			<div class="float-right well-action">
				<a href="{$relative}/upload/video"><span class="d-none d-sm-inline">{t c='videos.upload'}</span><span class="d-xs-inline d-sm-none"><i class="fas fa-upload"></i></span></a>
			</div>		
			<div class="clearfix"></div>
	</div>
	<div class="well-info">
		<div>{t c='search.results_for'}: <span class="text-highlighted">{$search_query|escape:'html'}</span></div>
		{if $videos}
		{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$videos_total}</span> {t c='videos.videos'}.
		{/if}
	</div>		
	<div class="row">	
		<div class="content-left">
            {if $videos}		
			<div class="row content-row">
            {section name=i loop=$videos}
				<div class="{if $min_col == '2'}col-6{/if} col-sm-6 col-md-4 col-lg-4 {if $max_col == '5'}col-xl-3{/if}">
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
					</div>
				</div>			
            {/section}
			
			</div>
            {else}
			<div class="well well-sm">
				<span class="text-danger">{t c='videos.no_videos_found'}.</span>
			</div>
            {/if}	

			{if $videos}
				{if $page_link}			
					<div class="d-block d-sm-none">
						<ul class="pagination pagination-lg">{$page_link}</ul>
					</div>
					<div class="d-none d-sm-block">
						<ul class="pagination">{$page_link}</ul>
					</div>					
				{/if}
			{/if}

		</div>
		
		<div class="content-right mb-3">
			<div class="list-group mb-3">
				<a href="{url base='search/videos/'|cat:$search_query strip='c' value=''}" {if $category == "0"}class="list-group-item active"{else}class="list-group-item"{/if}>
					{t c='global.all'}
				</a>
				{section name=i loop=$categories}
				<a href="{url base='search/videos/'|cat:$search_query|cat:'/'|cat:$categories[i].slug strip='c' value=''}" {if $category == $categories[i].CHID}class="list-group-item active"{else}class="list-group-item"{/if}>
					{$categories[i].name}
				</a>
				{/section}
			</div>

			{insert name=adv assign=adv group='videos_right'}
			{if $adv.ad}
			<div class="ad-content">
				{$adv.ad}
			</div>	
			{elseif $adv.help}		
				<div class="ad-body" style="width:{$adv.width}px;">
					<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">VIDEOS RIGHT</span></p>
					<p class="ad-size">{$adv.width} &times; Auto</p>
				</div>			
			{/if}		
		</div>
	</div>
	
	{insert name=adv assign=adv group='videos_bottom'}
	{if $adv.ad}
	<div class="ad-content">
		{$adv.ad}
	</div>	
	{elseif $adv.help}		
		<div class="ad-body">
			<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">VIDEOS BOTTOM</span></p>
			<p class="ad-size">Auto &times; Auto</p>
		</div>			
	{/if}

</div>

<div class="container mt-3 mb-3">
	<div class="well-filters">
			<div class="float-left">
				<h1>{t c='global.albums'}</h1>
			</div>
			<div class="float-left m-l-20">
				<div class="d-none d-md-inline">
					<div class="btn-group m-r-10">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $type == ''}{t c='global.type'}{elseif $type == 'public'}{t c='global.public'}{else}{t c='global.private'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $type == ''}class="active"{/if}><a href="{url base=$base strip='type' value=''}">{t c='global.all'}</a></li>
							<li {if $type == 'public'}class="active"{/if}><a href="{url base=$base strip='type' value='public'}">{t c='global.public'}</a></li>
							<li {if $type == 'private'}class="active"{/if}><a href="{url base=$base strip='type' value='private'}">{t c='global.private'}</a></li>
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

					<div class="btn-group">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $order == 'bw'}{t c='global.being_watched'}{elseif $order == 'mr'}{t c='global.most_recent'}{elseif $order == 'mv'}{t c='global.most_viewed'}{elseif $order == 'tr'}{t c='global.top_rated'}{elseif $order == 'md'}{t c='global.most_commented'}{else}{t c='global.top_favorites'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $order == 'mr'}class="active"{/if}><a href="{url base=$base strip='o' value='mr'}">{t c='global.most_recent'}</a></li>
							<li {if $order == 'mv'}class="active"{/if}><a href="{url base=$base strip='o' value='mv'}">{t c='global.most_viewed'}</a></li>
							<li {if $order == 'mp'}class="active"{/if}><a href="{url base=$base strip='o' value='mp'}">{t c='album.most_photos'}</a></li>
							<li {if $order == 'tr'}class="active"{/if}><a href="{url base=$base strip='o' value='tr'}">{t c='global.top_rated'}</a></li>
							<li {if $order == 'md'}class="active"{/if}><a href="{url base=$base strip='o' value='md'}">{t c='global.most_commented'}</a></li>
							<li {if $order == 'tf'}class="active"{/if}><a href="{url base=$base strip='o' value='tf'}">{t c='global.top_favorites'}</a></li>
						</ul>
					</div>					
				</div>	
				<div class="d-xs-inline d-md-none">
					<div class="btn-group">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">Filters <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $type == ''}class="active"{/if}><a href="{url base=$base strip='type' value=''}">{t c='global.all'}</a></li>
							<li {if $type == 'public'}class="active"{/if}><a href="{url base=$base strip='type' value='public'}">{t c='global.public'}</a></li>
							<li {if $type == 'private'}class="active"{/if}><a href="{url base=$base strip='type' value='private'}">{t c='global.private'}</a></li>						
							<li class="dropdown-divider"></li>
							<li {if $timeframe == 'a'}class="active"{/if}><a href="{url base=$base strip='t' value='a'}">{t c='global.all'}</a></li>							
							<li {if $timeframe == 't'}class="active"{/if}><a href="{url base=$base strip='t' value='t'}">{t c='global.added'} {t c='global.today'}</a></li>
							<li {if $timeframe == 'w'}class="active"{/if}><a href="{url base=$base strip='t' value='w'}">{t c='global.added'} {t c='global.this_week'}</a></li>
							<li {if $timeframe == 'm'}class="active"{/if}><a href="{url base=$base strip='t' value='m'}">{t c='global.added'} {t c='global.this_month'}</a></li>
							<li class="dropdown-divider"></li>				
							<li {if $order == 'mr'}class="active"{/if}><a href="{url base=$base strip='o' value='mr'}">{t c='global.most_recent'}</a></li>
							<li {if $order == 'mv'}class="active"{/if}><a href="{url base=$base strip='o' value='mv'}">{t c='global.most_viewed'}</a></li>
							<li {if $order == 'mp'}class="active"{/if}><a href="{url base=$base strip='o' value='mp'}">{t c='album.most_photos'}</a></li>
							<li {if $order == 'tr'}class="active"{/if}><a href="{url base=$base strip='o' value='tr'}">{t c='global.top_rated'}</a></li>
							<li {if $order == 'md'}class="active"{/if}><a href="{url base=$base strip='o' value='md'}">{t c='global.most_commented'}</a></li>
							<li {if $order == 'tf'}class="active"{/if}><a href="{url base=$base strip='o' value='tf'}">{t c='global.top_favorites'}</a></li>
						</ul>
					</div>				
				</div>
			</div>
			<div class="float-right well-action">
				<a href="{$relative}/upload/photo"><span class="d-none d-sm-inline">{t c='album.upload'}</span><span class="d-xs-inline d-sm-none"><i class="fas fa-upload"></i></span></a>
			</div>		
			<div class="clearfix"></div>
	</div>
	<div class="well-info">
		{if $albums}
		{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$albums_total}</span> {t c='album.albums'}.
		{/if}
	</div>		
	<div class="row">	
		<div class="content-left">
            {if $albums}		
			<div class="row content-row">
			
            {section name=i loop=$albums}
				<div class="{if $min_col == '2'}col-6{/if} col-sm-6 col-md-4 col-lg-4 {if $max_col == '5'}col-xl-3{/if}">
					<a href="{$relative}/album/{$albums[i].AID}/{$albums[i].name|clean}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/albums/{$albums[i].AID}.jpg" title="{$albums[i].name|escape:'html'}" alt="{$albums[i].name|escape:'html'}" class="img-responsive {if $albums[i].type == 'private'}img-private{/if}"/>
							{if $albums[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
						</div>
					</a>
					<div class="content-info">
						<a href="{$relative}/album/{$albums[i].AID}/{$albums[i].name|clean}">
							<span class="content-title">{$albums[i].name|escape:'html'}</span>
						</a>
						<div class="content-details">									
							<span class="content-views">
								{$albums[i].total_photos} {if $albums[i].total_photos == '1'}{t c='photo.photo'}{else}{t c='photo.photos'}{/if}
							</span>
							{if $albums[i].rate != 0}
								<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$albums[i].rate}%</span></span>
							{/if}
						</div>
					</div>
				</div>			
            {/section}
			
			</div>
            {else}
			<div class="well well-sm">
				<span class="text-danger">{t c='albums.none_found'}.</span>
			</div>
            {/if}	

			{if $albums}
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
				<a href="{url base='albums' strip='c' value=''}" {if $category == "0"}class="list-group-item active"{else}class="list-group-item"{/if}>
					{t c='global.all'}
				</a>
				{section name=i loop=$categories}
				<a href="{url base='albums/'|cat:$categories[i].slug strip='c' value=''}" {if $category == $categories[i].CID}class="list-group-item active"{else}class="list-group-item"{/if}>
					{$categories[i].name}
				</a>
				{/section}
			</div>
			{insert name=adv assign=adv group='albums_right'}
			{if $adv.ad}
			<div class="ad-content">
				{$adv.ad}
			</div>	
			{elseif $adv.help}		
				<div class="ad-body" style="width:{$adv.width}px;">
					<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">ALBUMS RIGHT</span></p>
					<p class="ad-size">{$adv.width} &times; Auto</p>
				</div>			
			{/if}		
		</div>
	</div>

	{insert name=adv assign=adv group='albums_bottom'}
	{if $adv.ad}		
	<div class="ad-content">
		{$adv.ad}
	</div>	
	{elseif $adv.help}		
		<div class="ad-body">
			<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">ALBUMS BOTTOM</span></p>
			<p class="ad-size">Auto &times; Auto</p>
		</div>			
	{/if}	
</div>
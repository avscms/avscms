<div class="container mt-3 mb-3">
	<div class="well-filters">
			<div class="float-left">
				<h1>{t c='menu.blogs'}</h1>
			</div>
			<div class="float-left m-l-20">
				<div class="d-none d-md-inline">					
					<div class="btn-group m-r-10">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $timeframe == 'a'}{t c='global.timeline'}{elseif $timeframe == 't'}{t c='global.added'} {t c='global.today'}{elseif $timeframe == 'w'}{t c='global.added'} {t c='global.this_week'}{else}{t c='global.added'} {t c='global.this_month'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $timeframe == 'a'}class="active"{/if}><a href="{url base='blogs' strip='t' value='a'}">{t c='global.all'}</a></li>							
							<li {if $timeframe == 't'}class="active"{/if}><a href="{url base='blogs' strip='t' value='t'}">{t c='global.added'} {t c='global.today'}</a></li>
							<li {if $timeframe == 'w'}class="active"{/if}><a href="{url base='blogs' strip='t' value='w'}">{t c='global.added'} {t c='global.this_week'}</a></li>
							<li {if $timeframe == 'm'}class="active"{/if}><a href="{url base='blogs' strip='t' value='m'}">{t c='global.added'} {t c='global.this_month'}</a></li>
						</ul>
					</div>					

					<div class="btn-group">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $order == 'bw'}{t c='global.being_watched'}{elseif $order == 'mr'}{t c='global.most_recent'}{elseif $order == 'mv'}{t c='global.most_viewed'}{elseif $order == 'tr'}{t c='global.top_rated'}{elseif $order == 'md'}{t c='global.most_commented'}{else}{t c='global.top_favorites'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $order == 'mr'}class="active"{/if}><a href="{url base='blogs' strip='o' value='mr'}">{t c='global.most_recent'}</a></li>
							<li {if $order == 'mv'}class="active"{/if}><a href="{url base='blogs' strip='o' value='mv'}">{t c='global.most_viewed'}</a></li>
							<li {if $order == 'md'}class="active"{/if}><a href="{url base='blogs' strip='o' value='md'}">{t c='global.most_commented'}</a></li>
						</ul>
					</div>					
				</div>	
				<div class="d-inline d-md-none">
					<div class="btn-group">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">Filters <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $timeframe == 'a'}class="active"{/if}><a href="{url base='blogs' strip='t' value='a'}">{t c='global.all'}</a></li>							
							<li {if $timeframe == 't'}class="active"{/if}><a href="{url base='blogs' strip='t' value='t'}">{t c='global.added'} {t c='global.today'}</a></li>
							<li {if $timeframe == 'w'}class="active"{/if}><a href="{url base='blogs' strip='t' value='w'}">{t c='global.added'} {t c='global.this_week'}</a></li>
							<li {if $timeframe == 'm'}class="active"{/if}><a href="{url base='blogs' strip='t' value='m'}">{t c='global.added'} {t c='global.this_month'}</a></li>
							<li class="divider"></li>				
					
							<li {if $order == 'mr'}class="active"{/if}><a href="{url base='blogs' strip='o' value='mr'}">{t c='global.most_recent'}</a></li>
							<li {if $order == 'mv'}class="active"{/if}><a href="{url base='blogs' strip='o' value='mv'}">{t c='global.most_viewed'}</a></li>
							<li {if $order == 'md'}class="active"{/if}><a href="{url base='blogs' strip='o' value='md'}">{t c='global.most_commented'}</a></li>

						</ul>
					</div>				
				</div>
			</div>
			<div class="float-right well-action">			
				<a href="{$relative}/blog/add"><span class="d-none d-sm-inline">{t c='blog.create_new'}</span><span class="d-xs-inline d-sm-none"><i class="fas fa-pencil-alt"></i></span></a>
			</div>		
			<div class="clearfix"></div>
	</div>

	<div class="well-info">
		{if $blogs}
		{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$blogs_total}</span> {t c='blog.blog_art'}.
		{/if}
	</div>		
	<div class="row">	
		<div class="content-left">
            {if $blogs}
			<div class="row">
            {section name=i loop=$blogs}
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title"><a href="{$relative}/blog/{$blogs[i].BID}/{$blogs[i].title|clean}">{$blogs[i].title|escape:'html'}</a></h5>
						<p class="card-text">{$blogs[i].content|nl2br}</p>
						<div class="card-sub">
							<div class="float-left">
								<a href="{$relative}/user/{$blogs[i].username}"><img class="small-avatar" src="{$relative}/media/users/{if $blogs[i].photo == ''}nopic-{$blogs[i].gender}.gif{else}{$blogs[i].photo}{/if}" /><span>{$blogs[i].username|truncate:25:"..."}</span></a>
							</div>
							{insert name=time_range assign=addtime time=$blogs[i].addtime}
							<div class="float-right">
								<span class="text-highlighted"><i class="fas fa-eye"></i> {$blogs[i].total_views}</span>  &nbsp; {$addtime}						
							</div>
						</div>
					</div>
				</div>
			</div>
            {/section}			
			</div>
            {else}
			<div class="well well-sm">
				<span class="text-danger">{t c='blog.none'}.</span>
			</div>
            {/if}	

			{if $blogs}
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
			{insert name=adv assign=adv group='blogs_right'}
			{if $adv.ad}
			<div class="ad-content">
				{$adv.ad}
			</div>	
			{elseif $adv.help}		
				<div class="ad-body" style="width:{$adv.width}px;">
					<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">BLOGS RIGHT</span></p>
					<p class="ad-size">{$adv.width} &times; Auto</p>
				</div>			
			{/if}		
		</div>
	</div>	
	{insert name=adv assign=adv group='blogs_bottom'}
	{if $adv.ad}		
	<div class="ad-content">
		{$adv.ad}
	</div>	
	{elseif $adv.help}		
		<div class="ad-body">
			<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">BLOGS BOTTOM</span></p>
			<p class="ad-size">Auto &times; Auto</p>
		</div>			
	{/if}
</div>
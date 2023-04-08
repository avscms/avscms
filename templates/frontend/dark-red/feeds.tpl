<script type="text/javascript" src="{$relative_tpl}/js/jquery.requests.js"></script>
<div class="container mt-3 mb-3">
	<div class="well-filters mb-3">
		<div class="float-left m-r-15">
			<h1>{t c='global.SUBSCRIPTIONS'}</h1>
		</div>
		<div class="float-left">
			<div class="btn-group">
				<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $table == 'all'}{t c='global.all'}{elseif $table == 'albums'}{t c='global.albums'}{elseif $table == 'blogs'}{t c='menu.blogs'}{elseif $table == 'games'}{t c='global.games'}{else}{t c='global.videos'}{/if} <span class="caret"></span></a>
				<ul class="dropdown-menu">
					 <li {if $table == 'all'}class="active"{/if}><a href="{url base='feeds' strip='t' value='all'}">{t c='global.all'}</a></li>
					 <li {if $table == 'albums'}class="active"{/if}><a href="{url base='feeds' strip='t' value='albums'}">{t c='global.albums'}</a></li>
					 <li {if $table == 'blogs'}class="active"{/if}><a href="{url base='feeds' strip='t' value='blogs'}">{t c='menu.blogs'}</a></li>
					 <li {if $table == 'videos'}class="active"{/if}><a href="{url base='feeds' strip='t' value='videos'}">{t c='global.videos'}</a></li>
				</ul>		
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="row">
		<div class="col-12 col-lg-3">
			<ul class="list-unstyled m-b-0">
				<li>
					{if $username == 'all'}
						<span class="text-highlighted">{t c='global.all'}</span>
					{else}
						<a href="{$relative}/feeds">{t c='global.all'}</a>
					{/if}
				</li>
				{section name=i loop=$subscriptions}
					<li class="overflow-hidden">
						{if $username == $subscriptions[i].username}
							<span class="text-highlighted">{$subscriptions[i].username|escape:'html'}</span>
						{else}
							<a href="{url base='feeds' strip='u' value=$subscriptions[i].username}">{$subscriptions[i].username|escape:'html'}</a>
						{/if}
					</li>
				{/section}
			</ul>	
		</div>
		<div class="col-12 col-lg-9">
			<h5>{t c='feeds.activity'}</h5>	
					{if $feeds}
						<div class="mb-3 mt-3">					
							<div class="row content-row feed-wall">
							{assign var="current_user" value=''}
							{assign var="current_type" value=''}
							{section name=i loop=$feeds}
							{if $current_user != $feeds[i].data.username}	
								<div class="col-12 feed-left">											
									<a href="{$relative}/user/{$feeds[i].data.username}"><img class="medium-avatar mb-1" src="{$relative}/media/users/{if $feeds[i].data.photo == ''}nopic-{$feeds[i].data.gender}.gif{else}{$feeds[i].data.photo}{/if}" />{$feeds[i].data.username}</a>
								</div>			
							{assign var="current_type" value=$feeds[i].type}
							{assign var="current_user" value=$feeds[i].data.username}								
							{elseif $current_type != $feeds[i].type}
								<div class="col-12"></div>
								{assign var="current_type" value=$feeds[i].type}
							{/if}
							{if $feeds[i].type == 'video'}
								<div class="col-12 col-sm-6 col-md-4 feed-right">
									<a href="{$relative}/video/{$feeds[i].data.VID}/{$feeds[i].data.title|clean}">
										<div class="thumb-overlay" {if $feeds[i].data.vthumbs == '1'} id="playvthumb_{$feeds[i].data.VID}"{/if}>
											<img src="{insert name=thumb_path vid=$feeds[i].data.VID}/{$feeds[i].data.thumb}.jpg" title="{$feeds[i].data.title|escape:'html'}" alt="{$feeds[i].data.title|escape:'html'}" {if $feeds[i].data.vthumbs == '0'}id="rotate_{$feeds[i].data.VID}_{$feeds[i].data.thumbs}_{$feeds[i].data.thumb}_viewed"{/if} class="img-responsive"/>
											<div class="label-date">{$feeds[i].time|date_format}</div>
											<div class="duration">
												{if $feeds[i].data.hd==1}<span class="hd-text-icon">HD</span>{/if}
												{insert name=duration assign=duration duration=$feeds[i].data.duration}
												{$duration}
											</div>
										</div>
									</a>
									<div class="content-info">
										<a href="{$relative}/video/{$feeds[i].data.VID}/{$feeds[i].data.title|clean}">
											<span class="content-title">{$feeds[i].data.title|escape:'html'}</span>					
										</a>
										<div class="content-details">
											{insert name=views assign=s_views views=$feeds[i].data.viewnumber}											
											<span class="content-views">
												{$s_views}								
											</span>
											{if $feeds[i].data.rate != 0}
												<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$feeds[i].data.rate}%</span></span>
											{/if}
										</div>				
									</div>											
								</div>
							{elseif $feeds[i].type == 'album'}									
								<div class="col-12 col-sm-6 col-md-4 feed-right">
									<a href="{$relative}/album/{$feeds[i].data.AID}/{$feeds[i].data.name|clean}">
										<div class="thumb-overlay">
											<img src="{$relative}/media/albums/{$feeds[i].data.AID}.jpg" title="{$feeds[i].data.name|escape:'html'}" alt="{$feeds[i].data.name|escape:'html'}" class="img-responsive"/>
											<div class="label-date">{$feeds[i].time|date_format}</div>
										</div>
									</a>
									<div class="content-info">
										<a href="{$relative}/album/{$feeds[i].data.AID}/{$feeds[i].data.name|clean}">
											<span class="content-title">{$feeds[i].data.name|escape:'html'}</span>
										</a>
										<div class="content-details">									
											<span class="content-views">
												{$feeds[i].data.total_photos} {if $feeds[i].data.total_photos == '1'}{t c='photo.photo'}{else}{t c='photo.photos'}{/if}
											</span>
											{if $feeds[i].data.rate != 0}
												<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$feeds[i].data.rate}%</span></span>
											{/if}
										</div>
									</div>
								</div>
							{elseif $feeds[i].type == 'blog'}
								<div class="col-12 col-sm-6 col-md-4 feed-right">
									<div class="feed-blog">
										<a href="{$relative}/blog/{$feeds[i].data.BID}/{$feeds[i].data.title|clean}"><i class="fas fa-pencil-alt"></i> {$feeds[i].data.title} </a>
										<div>{$feeds[i].time|date_format}</div>
									</div>
								</div>
							{/if}

					{/section}
					</div>
				</div>
				{if $page_link}
					<div class="d-none d-sm-block">
						<ul class="pagination">{$page_link}</ul>
					</div>
					<div class="d-block d-sm-none">
						<ul class="pagination pagination-lg">{$page_link}</ul>
					</div>		
				{/if}
			{else}
				<span class="text-danger">{t c='feeds.none'}.</span>
			{/if}			
		</div>
	</div>	
</div>
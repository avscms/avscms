<div class="container mt-3 mb-3">
	<div class="well-filters">
			<div class="float-left">
				<h1>{t c='global.users'}</h1>
			</div>
			<div class="float-left m-l-20">
				<div class="d-none d-md-inline">
					<div class="btn-group m-r-10">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $interest == ''}{t c='global.interested'}{elseif $interest == 'Guys'}{t c='global.guys'}{elseif $interest == 'Girls'}{t c='global.girls'}{else}{t c='global.guys_girls'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $interest == ''}class="active"{/if}><a href="{url base='users' strip='i' value=''}">{t c='global.any'}</a></li>
							<li {if $interest == 'Guys'}class="active"{/if}><a href="{url base='users' strip='i' value='Guys'}">{t c='global.guys'}</a></li>
							<li {if $interest == 'Girls'}class="active"{/if}><a href="{url base='users' strip='i' value='Girls'}">{t c='global.girls'}</a></li>
							<li {if $interest == 'Guys + Girls'}class="active"{/if}><a href="{url base='users' strip='i' value='Guys%2BGirls'}">{t c='global.guys_girls'}</a></li>
						</ul>
					</div>

					<div class="btn-group m-r-10">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $avatar == ''}{t c='global.avatar'}{elseif $avatar == 'yes'}{t c='avatar.yes'}{else}{t c='avatar.no'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $avatar == ''}class="active"{/if}><a href="{url base='users' strip='a' value=''}">{t c='global.any'}</a></li>							
							<li {if $avatar == 'yes'}class="active"{/if}><a href="{url base='users' strip='a' value='yes'}">{t c='avatar.yes'}</a></li>
							<li {if $avatar == 'no'}class="active"{/if}><a href="{url base='users' strip='a' value='no'}">{t c='avatar.no'}</a></li>
						</ul>
					</div>					

					<div class="btn-group m-r-10">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $order == 'mr'}{t c='global.most_recent'}{elseif $order == 'mv'}{t c='global.most_viewed'}{elseif $order == 'ma'}{t c='global.most_active'}{elseif $order == 'tr'}{t c='global.top_rated'}{elseif $order == 'mp'}{t c='global.most_popular'}{else}{t c='global.online_now'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $order == 'mr'}class="active"{/if}><a href="{url base='users' strip='o' value='mr'}">{t c='global.most_recent'}</a></li>
							<li {if $order == 'mv'}class="active"{/if}><a href="{url base='users' strip='o' value='mv'}">{t c='global.most_viewed'}</a></li>
							<li {if $order == 'ma'}class="active"{/if}><a href="{url base='users' strip='o' value='ma'}">{t c='global.most_active'}</a></li>
							<li {if $order == 'mp'}class="active"{/if}><a href="{url base='users' strip='o' value='mp'}">{t c='global.most_popular'}</a></li>
							<li {if $order == 'tr'}class="active"{/if}><a href="{url base='users' strip='o' value='tr'}">{t c='global.top_rated'}</a></li>
							<li {if $order == 'on'}class="active"{/if}><a href="{url base='users' strip='o' value='on'}">{t c='global.online_now'}</a></li>
						</ul>
					</div>
					<div class="btn-group">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">{if $gender == ''}{t c='global.gender'}{elseif $gender == 'Male'}{t c='global.male'}{else}{t c='global.female'}{/if} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $gender == ''}class="active"{/if}><a href="{url base='users' strip='g' value=''}">{t c='global.any'}</a></li>							
							<li {if $gender == 'Male'}class="active"{/if}><a href="{url base='users' strip='g' value='Male'}">{t c='global.male'}</a></li>
							<li {if $gender == 'Female'}class="active"{/if}><a href="{url base='users' strip='g' value='Female'}">{t c='global.female'}</a></li>
						</ul>
					</div>						
				</div>	
				<div class="d-xs-inline d-md-none">
					<div class="btn-group">
						<a class="well-action dropdown-toggle" data-toggle="dropdown">Filters <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li {if $interest == ''}class="active"{/if}><a href="{url base='users' strip='i' value=''}">{t c='global.any'}</a></li>
							<li {if $interest == 'Guys'}class="active"{/if}><a href="{url base='users' strip='i' value='Guys'}">{t c='global.guys'}</a></li>
							<li {if $interest == 'Girls'}class="active"{/if}><a href="{url base='users' strip='i' value='Girls'}">{t c='global.girls'}</a></li>
							<li {if $interest == 'Guys + Girls'}class="active"{/if}><a href="{url base='users' strip='i' value='Guys%2BGirls'}">{t c='global.guys_girls'}</a></li>
							<li class="dropdown-divider"></li>
							<li {if $avatar == ''}class="active"{/if}><a href="{url base='users' strip='a' value=''}">{t c='global.any'}</a></li>							
							<li {if $avatar == 'yes'}class="active"{/if}><a href="{url base='users' strip='a' value='yes'}">{t c='avatar.yes'}</a></li>
							<li {if $avatar == 'no'}class="active"{/if}><a href="{url base='users' strip='a' value='no'}">{t c='avatar.no'}</a></li>
							<li class="dropdown-divider"></li>				
							<li {if $order == 'mr'}class="active"{/if}><a href="{url base='users' strip='o' value='mr'}">{t c='global.most_recent'}</a></li>
							<li {if $order == 'mv'}class="active"{/if}><a href="{url base='users' strip='o' value='mv'}">{t c='global.most_viewed'}</a></li>
							<li {if $order == 'ma'}class="active"{/if}><a href="{url base='users' strip='o' value='ma'}">{t c='global.most_active'}</a></li>
							<li {if $order == 'mp'}class="active"{/if}><a href="{url base='users' strip='o' value='mp'}">{t c='global.most_popular'}</a></li>
							<li {if $order == 'tr'}class="active"{/if}><a href="{url base='users' strip='o' value='tr'}">{t c='global.top_rated'}</a></li>
							<li {if $order == 'on'}class="active"{/if}><a href="{url base='users' strip='o' value='on'}">{t c='global.online_now'}</a></li>
							<li class="dropdown-divider"></li>	
							<li {if $gender == ''}class="active"{/if}><a href="{url base='users' strip='g' value=''}">{t c='global.any'}</a></li>							
							<li {if $gender == 'Male'}class="active"{/if}><a href="{url base='users' strip='g' value='Male'}">{t c='global.male'}</a></li>
							<li {if $gender == 'Female'}class="active"{/if}><a href="{url base='users' strip='g' value='Female'}">{t c='global.female'}</a></li>							
						</ul>
					</div>				
				</div>
			</div>
			<div class="float-right well-action">
				<a href="{$relative}/signup"><span class="d-none d-sm-inline">{t c='user.new'}</span><span class="d-xs-inline d-sm-none"><i class="fas fa-plus"></i></span></a>
			</div>		
			<div class="clearfix"></div>
	</div>
	<div class="well-info">
		{if $users}
		{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$users_total}</span> {t c='user.users'}.
		{/if}
	</div>		

	{if $users}
	<div class="row content-row">
	   {section name=i loop=$users}
			<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 member {if $smarty.section.i.index>5}d-none d-md-block{/if}">
				<a href="{$relative}/user/{$users[i].username}">
					<div class="thumb-overlay">
						<img src="{$relative}/media/users/{if $users[i].photo == ''}nopic-{$users[i].gender}.gif{else}{$users[i].photo}{/if}" alt="{$users[i].username}'s avatar" class="img-responsive"/>
					</div>
				</a>			
				<div class="content-info">
					<a href="{$relative}/user/{$users[i].username}">
						<span class="content-truncate {if $users[i].rate != 0}content-ml{/if}">{$users[i].username|escape:'html'}</span>
					</a>
					{if $users[i].rate != 0}
						<span class="content-rating content-mr"><i class="fas fa-thumbs-up"></i> <span>{$users[i].rate}%</span></span>
					{/if}								
				</div>			
			</div>			
		{/section}
		</div>
	{else}
	<div class="well well-sm">
		<span class="text-danger">{t c='users.none'}.</span>
	</div>
	{/if}	

	{if $users}
		{if $page_link}			
			<div class="d-block d-sm-none">
				<ul class="pagination pagination-lg">{$page_link}</ul>
			</div>
			<div class="d-none d-sm-block">
				<ul class="pagination">{$page_link}</ul>
			</div>
		{/if}
	{/if}
	
	{insert name=adv assign=adv group='users_bottom'}
	{if $adv.ad}		
	<div class="ad-content">
		{$adv.ad}
	</div>	
	{elseif $adv.help}		
		<div class="ad-body">
			<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">USERS BOTTOM</span></p>
			<p class="ad-size">Auto &times; Auto</p>
		</div>			
	{/if}	
</div>
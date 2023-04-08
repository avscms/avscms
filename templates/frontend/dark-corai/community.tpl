<div class="container mt-3 mb-3">
		{if $popular_users}
			<div class="well-filters mb-3">
				<div class="float-left">
					<h1>{t c='community.most_popular'}</h1>
				</div>
				<div class="float-right well-action">
					<a href="{$relative}/users?o=mp"><span class="d-none d-sm-inline">{t c='global.view_more'}</span><span class="d-xs-inline d-sm-none"><i class="fa fa-plus"></i></span></a>
				</div>		
				<div class="clearfix"></div>
			</div>
	
			<div class="row content-row">
		   {section name=i loop=$popular_users}
				<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 member {if $smarty.section.i.index>5}d-none d-md-block{/if}">
					<a href="{$relative}/user/{$popular_users[i].username}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/users/{if $popular_users[i].photo == ''}nopic-{$popular_users[i].gender}.gif{else}{$popular_users[i].photo}{/if}" alt="{$popular_users[i].username}'s avatar" class="img-responsive"/>
						</div>
					</a>			
					<div class="content-info">
						<a href="{$relative}/user/{$popular_users[i].username}">
							<span class="content-truncate {if $popular_users[i].rate != 0}content-ml{/if}">{$popular_users[i].username|escape:'html'}</span>
						</a>
						{if $popular_users[i].rate != 0}
							<span class="content-rating content-mr"><i class="fas fa-thumbs-up"></i> <span>{$popular_users[i].rate}%</span></span>
						{/if}								
					</div>			
				</div>
			{/section}
			</div>
        {/if}

		{if $female_users}
			<div class="well-filters mb-3">
					<div class="float-left">
						<h1>{t c='community.new_female'}</h1>
					</div>
					<div class="float-right well-action">
						<a href="{$relative}/users?o=mr&amp;g=Female"><span class="d-none d-sm-inline">{t c='global.view_more'}</span><span class="d-xs-inline d-sm-none"><i class="fa fa-plus"></i></span></a>
					</div>		
					<div class="clearfix"></div>
			</div>
			<div class="row content-row">
           {section name=i loop=$female_users}
				<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 member {if $smarty.section.i.index>5}d-none d-md-block{/if}">
					<a href="{$relative}/user/{$female_users[i].username}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/users/{if $female_users[i].photo == ''}nopic-{$female_users[i].gender}.gif{else}{$female_users[i].photo}{/if}" alt="{$female_users[i].username}'s avatar" class="img-responsive"/>
						</div>
					</a>			
					<div class="content-info">
						<a href="{$relative}/user/{$female_users[i].username}">
							<span class="content-truncate {if $female_users[i].rate != 0}content-ml{/if}">{$female_users[i].username|escape:'html'}</span>
						</a>
						{if $female_users[i].rate != 0}
							<span class="content-rating content-mr"><i class="fas fa-thumbs-up"></i> <span>{$female_users[i].rate}%</span></span>
						{/if}								
					</div>			
				</div>		
            {/section}
			</div>
        {/if}
		 <div class="clearfix"></div>

		{if $male_users}
			<div class="well-filters mb-3">
					<div class="float-left">
						<h1>{t c='community.new_male'}</h1>
					</div>
					<div class="float-right well-action">
						<a href="{$relative}/users?o=mr&amp;g=Male"><span class="d-none d-sm-inline">{t c='global.view_more'}</span><span class="d-xs-inline d-sm-none"><i class="fa fa-plus"></i></span></a>
					</div>		
					<div class="clearfix"></div>
			</div>
			<div class="row content-row">
           {section name=i loop=$male_users}
				<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 member {if $smarty.section.i.index>5}d-none d-md-block{/if}">
					<a href="{$relative}/user/{$male_users[i].username}">
						<div class="thumb-overlay">
							<img src="{$relative}/media/users/{if $male_users[i].photo == ''}nopic-{$male_users[i].gender}.gif{else}{$male_users[i].photo}{/if}" alt="{$male_users[i].username}'s avatar" class="img-responsive"/>
						</div>
					</a>			
					<div class="content-info">
						<a href="{$relative}/user/{$male_users[i].username}">
							<span class="content-truncate {if $male_users[i].rate != 0}content-ml{/if}">{$male_users[i].username|escape:'html'}</span>
						</a>
						{if $male_users[i].rate != 0}
							<span class="content-rating content-mr"><i class="fas fa-thumbs-up"></i> <span>{$male_users[i].rate}%</span></span>
						{/if}								
					</div>			
				</div>			
            {/section}
			</div>
        {/if}
		<div class="clearfix"></div>
		{insert name=adv assign=adv group='community_bottom'}
		{if $adv.ad}		
		<div class="ad-content">
			{$adv.ad}
		</div>	
		{elseif $adv.help}		
			<div class="ad-body">
				<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">COMMUNITY BOTTOM</span></p>
				<p class="ad-size">Auto &times; Auto</p>
			</div>			
		{/if}			
	
</div>
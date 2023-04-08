<div class="container mt-3 mb-3">
	<div class="well-filters mb-3">
			<div class="float-left">
				<h1>{translate c='index.videos_being_watched'}</h1>
			</div>
			<div class="float-right well-action">
				<a href="{$relative}/videos?o=bw"><span class="d-none d-sm-inline">{translate c='index.videos_being_watched_more'}</span><span class="d-xs-inline d-sm-none"><i class="fas fa-plus"></i></span></a>
			</div>		
			<div class="clearfix"></div>
	</div>
	<div class="row">
		{insert name=adv assign=adv group='index_right'}
		<div class="content-left {if !$adv && !$adv.help}w-100{/if}">
            {if $viewed_videos}
			<div class="row content-row">
            {section name=i loop=$viewed_videos}
				<div class="
					{if !$adv && !$adv.help}
						{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-3 {if $max_col == '5'} col-xl-2dot4 {/if} {if $max_col == '5'}{if $smarty.section.i.index > 9} d-xl-block d-lg-none {elseif $smarty.section.i.index > 7} d-lg-none d-xl-none {/if}{/if}
					{else}
						{if $min_col == '2'} col-6 {/if} col-sm-6 col-md-4 col-lg-4 {if $max_col == '5'} col-xl-3{/if} {if $max_col == '4'}{if $smarty.section.i.index > 5} d-md-none d-lg-none d-xl-none {/if}{elseif $smarty.section.i.index > 7} d-md-none d-lg-none d-xl-none {elseif $smarty.section.i.index > 5} d-md-none d-lg-none d-xl-block {/if}
					{/if}">
					<a href="{$relative}/video/{$viewed_videos[i].VID}/{$viewed_videos[i].title|clean}">
						<div class="thumb-overlay" {if $viewed_videos[i].vthumbs == '1'} id="playvthumb_{$viewed_videos[i].VID}"{/if}>
							<img src="{insert name=thumb_path vid=$viewed_videos[i].VID}/{$viewed_videos[i].thumb}.jpg" title="{$viewed_videos[i].title|escape:'html'}" alt="{$viewed_videos[i].title|escape:'html'}" {if $viewed_videos[i].vthumbs == '0'}id="rotate_{$viewed_videos[i].VID}_{$viewed_videos[i].thumbs}_{$viewed_videos[i].thumb}_viewed"{/if} class="img-responsive {if $viewed_videos[i].type == 'private'}img-private{/if}"/>
							{if $viewed_videos[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
							<div class="duration">
								{if $viewed_videos[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
								{insert name=duration assign=duration duration=$viewed_videos[i].duration}
								{$duration}
							</div>
						</div>

					</a>
					<div class="content-info">
						<a href="{$relative}/video/{$viewed_videos[i].VID}/{$viewed_videos[i].title|clean}">
							<span class="content-title">{$viewed_videos[i].title|escape:'html'}</span>					
						</a>
						<div class="content-details">
							{insert name=views assign=s_views views=$viewed_videos[i].viewnumber}											
							<span class="content-views">
								{$s_views}								
							</span>
							{if $viewed_videos[i].rate != 0}
								<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$viewed_videos[i].rate}%</span></span>
							{/if}
						</div>				
					</div>
				</div>			
            {/section}
			</div>
            {else}
			<div>
				<span class="text-danger">{t c='videos.no_videos_found'}.</span>
			</div>
            {/if}			
		</div>		
		<div class="content-right">			
			{if $adv.ad}
			<div class="ad-content">
				{$adv.ad}
			</div>	
			{elseif $adv.help}		
				<div class="ad-body" style="width:{$adv.width}px; height:{$adv.height}px;">
					<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">INDEX RIGHT</span></p>
					<p class="ad-size">{$adv.width} &times; {$adv.height}</p>
				</div>			
			{/if}
		</div>
	</div>
	
	<div class="well-filters mb-3">
		<div class="float-left">
			<h1>{translate c='index.most_recent_videos'}</h1>
		</div>
		<div class="float-right well-action">
			<a href="{$relative}/videos?o=mr"><span class="d-none d-sm-inline">{translate c='index.most_recent_videos_more'}</span><span class="d-xs-inline d-sm-none"><i class="fas fa-plus"></i></span></a>
		</div>		
		<div class="clearfix"></div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
            {if $recent_videos}
			<div class="row content-row">
            {section name=i loop=$recent_videos}
				<div class="{if $min_col == '2'}col-6{/if} col-sm-6 col-md-4 col-lg-3 {if $max_col == '5'}col-xl-2dot4{/if} i-container">
					<a href="{$relative}/video/{$recent_videos[i].VID}/{$recent_videos[i].title|clean}">
						<div class="thumb-overlay" {if $recent_videos[i].vthumbs == '1'} id="playvthumb_{$recent_videos[i].VID}"{/if}>
							<img src="{insert name=thumb_path vid=$recent_videos[i].VID}/{$recent_videos[i].thumb}.jpg" title="{$recent_videos[i].title|escape:'html'}" alt="{$recent_videos[i].title|escape:'html'}" {if $recent_videos[i].vthumbs == '0'}id="rotate_{$recent_videos[i].VID}_{$recent_videos[i].thumbs}_{$recent_videos[i].thumb}_viewed"{/if} class="img-responsive {if $recent_videos[i].type == 'private'}img-private{/if}"/>
							{if $recent_videos[i].type == 'private'}<div class="label-private">{t c='global.PRIVATE'}</div>{/if}
							<div class="duration">
								{if $recent_videos[i].hd==1}<span class="hd-text-icon">HD</span>{/if}
								{insert name=duration assign=duration duration=$recent_videos[i].duration}
								{$duration}
							</div>
						</div>

					</a>
					<div class="content-info">
						<a href="{$relative}/video/{$recent_videos[i].VID}/{$recent_videos[i].title|clean}">
							<span class="content-title">{$recent_videos[i].title|escape:'html'}</span>					
						</a>
						<div class="content-details">
							{insert name=views assign=s_views views=$recent_videos[i].viewnumber}											
							<span class="content-views">
								{$s_views}								
							</span>
							{if $recent_videos[i].rate != 0}
								<span class="content-rating"><i class="fas fa-thumbs-up"></i> <span>{$recent_videos[i].rate}%</span></span>
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
		</div>
	</div>

	{insert name=adv assign=adv group='index_bottom'}
	{if $adv.ad}
	<div class="ad-content">
		{$adv.ad}
	</div>	
	{elseif $adv.help}		
		<div class="ad-body">
			<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">INDEX BOTTOM</span></p>
			<p class="ad-size">Auto &times; Auto</p>
		</div>			
	{/if}	
</div>
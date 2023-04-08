<div class="container mt-3 mb-3">
	<div class="well-filters">
		<h1>{t c='tags.popular_tags'}</h1>
	</div>
	<div class="row">
		{if $tags}
			{assign var="letter" value="."}
			{section name=i loop=$tags}
				{assign var=firstletter value=$tags[i].name|substr:0:1}
				{if $letter != $firstletter}
				{assign var="letter" value=$firstletter}
				<div class="clearfix"></div>		
				<div class="col-12">
					<div class="col-12 tag-heading">
					#{$firstletter}	
					</div>
				</div>
				{/if}
					<div class="tag-item">
						<span>	
							<span class="tag-counter">{$tags[i].counter}</span>							
							<i class="fas fa-search"></i>						
							<a href="{$relative}/search/videos/{$tags[i].name}" title="{$tags[i].tag}">{$tags[i].tag}</a>															
						</span>
					</div>		
			{/section}

			<div class="clearfix"></div>
		{/if}	
	</div>
	<div class="mb-3"></div>
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
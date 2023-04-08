<div class="container mt-3">
	<div class="row">
		<div class="col-md-9 col-sm-8">
		<div class="well">
			  <fieldset>
				<legend>{t c='global.ERROR'}</legend>
				<div class="m-b-20 text-danger">
					{$message}
				</div>
			  </fieldset>
		</div>
		</div>
		<div class="col-md-3 col-sm-4">
			{insert name=adv assign=adv group='index_right'}
			{if $adv.ad}
			<div class="ad-content">
				{$adv.ad}
			</div>	
			{elseif $adv.help}		
				<div class="ad-body" style="width:{$adv.width}px;">
					<p class="ad-title"><span>{t c='global.sponsors'}</span><span class="ad-group">INDEX RIGHT</span></p>
					<p class="ad-size">{$adv.width} &times; Auto</p>
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
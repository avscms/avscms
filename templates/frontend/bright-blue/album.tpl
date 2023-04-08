<div class="container mt-3">
	{if !$is_friend}
	<h1>
		<span class="text-danger">{t c='album.private' url=$relative u=$username un=$username}</span>
	</h1>
	{else}	
	<div class="well-filters">	
		<div class="float-left">
			<h1>{$album.name}</h1>
		</div>
		{if $photos_total > 1}
		<div class="float-right well-action">
			<a href="{$relative}/album/slideshow/{$album.AID}">{t c='global.slideshow'}</a>
		</div>
		{/if}
		<div class="clearfix"></div>
	</div>
	<div class="row">
		<div class="col-12">		
		{if $photos}
			<div class="well-info">
				{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$photos_total}</span> {t c='album.photos'}.
			</div>
			<div class="row content-row">
				{section name=i loop=$photos}
					<div class="col-6 col-sm-4 col-xl-3 mb-3">
						<a href="{$relative}/photo/{$photos[i].PID}/">
							<div class="thumb-overlay">
								<img src="{$relative}/media/photos/tmb/{$photos[i].PID}.jpg" alt="{$photos[i].caption|escape:html}" id="album_photo_{$photos[i].PID}" class="img-responsive" />
							</div>
						</a>
					</div>  
				{/section}
			</div>
			{if $page_link}
				<div class="d-block d-sm-none">
					<ul class="pagination pagination-lg">{$page_link}</ul>
				</div>
				<div class="d-none d-sm-block">
					<ul class="pagination">{$page_link}</ul>
				</div>
			{/if}								
		{else}
			<span class="text-danger">{t c='global.no_photos_found'}.</span>
		{/if}

		</div>
		<div class="col-12 mb-3">
			<div class="card-sub">
				<div class="float-left">
					<a href="{$relative}/user/{$user.username}"><img class="small-avatar" src="{$relative}/media/users/{if $user.photo == ''}nopic-{$user.gender}.gif{else}{$user.photo}{/if}" /><span>{$username|truncate:25:"..."}</span></a>
				</div>
				{insert name=time_range assign=addtime time=$album.addtime}
				<div class="float-right">
					{$album.total_views} <i class="fas fa-eye"></i> &nbsp; {$addtime}						
				</div>
			</div>
		</div>		
	</div>
	{/if}
</div>
<script type="text/javascript">
var lang_albums_delete_confirm = "{t c='albums.delete_confirm'}";
</script>
<div class="container mt-3">
	{include file='user_info.tpl'}
	<div class="user-right">
		{if $albums && $photo_module == '1'}
		<div>	
			<div class="well-filters mb-1">
				<div class="float-left">
					<h1>{t c='user.PHOTO_ALBUMS'}</h1>
				</div>	
				<div class="clearfix"></div>
			</div>
			<div class="well-info">
				{if $albums}
				{t c='global.showing'} <span class="text-highlighted">{$start_num}</span> {t c='global.to'} <span class="text-highlighted">{$end_num}</span> {t c='global.of'} <span class="text-highlighted">{$albums_total}</span> {t c='album.albums'}.
				{/if}
			</div>				
			<div class="row content-row {if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}my{/if}">
			{section name=i loop=$albums}
				<div id="album_block_{$albums[i].AID}" class="{if $min_col == '2'}col-6{/if} col-sm-6 col-md-4 col-lg-4 {if $max_col == '5'}col-xl-3{/if}">
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
							{if isset($smarty.session.uid) && $smarty.session.uid == $user.UID}
							<div class="content-actions">						
								<a href="{$relative}/album/edit/{$albums[i].AID}" data-toggle="tooltip" data-placement="top" title="{t c='global.edit'}"><i class="fas fa-edit"></i></a>
								<a href="#" data-aid="{$albums[i].AID}" id="delete_album_{$albums[i].AID}"  data-toggle="tooltip" data-placement="top" title="{t c='global.delete'}" class="ml-2"><i class="fas fa-trash"></i></a>
							</div>
							{/if}							
						</div>
					</div>
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
		</div>
		{else}
		<div class="well well-sm">
			<span class="text-danger">{t c='albums.none_found'}.</span>
		</div>
		{/if}
	</div>
</div>


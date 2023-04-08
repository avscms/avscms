<script type="text/javascript">
var lang_photo = "{t c='photo.Photo'}";
var lang_of = "{t c='global.of'}";
</script>
<script type="text/javascript" src="{$relative_tpl}/js/lightbox.js"></script>
<link href="{$relative_tpl}/css/lightbox.css" rel="stylesheet" />
<script>
{literal}
$( document ).ready(function() {
    $('#0-lb').trigger('click');
});
{/literal}
</script>

<div class="container mt-3">
	<div class="well-filters">
		<div class="float-left">
			<h1>{t c='album.SLIDESHOW'}: {$album.name}</h1>
		</div>
		<div class="float-right well-action">
			 <a href="{$relative}/album/{$album.AID}/">{t c='global.back_to'} <b>{$album.name|escape:'html'}</b></a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="row">
		<div class="col-12">
			{if !$is_friend}
			<div class="text-danger">{t c='album.private' url=$relative u=$username un=$username}</div>
			{else}				
				{if $photos}
					<div class="row content-row mt-3">
						{section name=i loop=$photos}
							<div class="col-6 col-sm-4 col-xl-3 mb-3">
								<a id="{$smarty.section.i.index}-lb" href="{$relative}/media/photos/{$photos[i].PID}.jpg" data-lightbox="slideshow-{$album.AID}" data-title="{$photos[i].caption|escape:html}">
									<img src="{$relative}/media/photos/tmb/{$photos[i].PID}.jpg" alt="{$photos[i].caption|escape:html}" class="img-responsive" />
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
</div>
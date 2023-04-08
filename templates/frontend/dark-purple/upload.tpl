<div class="container mt-3 mb-3">
	<div class="well-filters">
		<h1>{t c='upload.title'}</h1>
	</div>
	<div class="row">
		{if $video_module == '1'}
			<div class="col-sm-6 mt-5 d-flex justify-content-center">
				<a href="{$relative}/upload/video">
					<div class="text-white"><i class="fas fa-film fa-7x"></i></div>
					<div class="d-flex mt-1 justify-content-center"><h5>{t c='global.videos'}</h5></div>
				</a>
			</div>
		{/if}
		{if $photo_module == '1'}					
			<div class="col-sm-6 mt-5 d-flex justify-content-center">
				<a href="{$relative}/upload/photo">
					<div class="text-white"><i class="fas fa-camera fa-7x"></i></div>
					<div class="d-flex mt-1 justify-content-center"><h5>{t c='global.photos'}</h5></div>
				</a>
			</div>
		{/if}
	</div>
</div>
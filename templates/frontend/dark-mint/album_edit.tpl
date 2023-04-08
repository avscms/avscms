<script type="text/javascript" src="{$relative_tpl}/js/jquery.browser.min.js"></script>
<link rel="stylesheet" type="text/css" href="{$relative_tpl}/css/imgareaselect/imgareaselect-default.css" />
<script type="text/javascript" src="{$relative_tpl}/js/jquery.imgareaselect.js"></script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.album.js"></script>
<script type="text/javascript">
var lang_photos_delete_confirm = "{t c='photos.delete_confirm'}";
</script>

<div class="container mt-3">
	<div class="well-filters">
		<div class="float-left">
			<h1>{t c='global.edit'}: {$album.name|escape:'html'}</h1>
		</div>
		<div class="float-right">
		    <a href="{$relative}/album/{$album.AID}/">{t c='global.back_to'} <b>{$album.name|escape:'html'}</b></a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-3 d-flex justify-content-center">		
			<form class="form-horizontal" name="uploadPhoto" id="uploadPhoto" method="post" enctype="multipart/form-data" action="{$relative}/album/edit/{$album.AID}">
				<h5>
					{t c='upload.album_details'}
				</h5>
				
				<div class="form-group {if $err.name}has-error{/if}">
					<label for="upload_album_name" >{t c='global.name'}</label>
					<div>
						<input name="album_name" type="text" class="form-control" value="{$album.name}" id="upload_album_name" placeholder="{t c='global.name'}" />
						<div id="album_name_error" class="text-danger m-t-5" style="display: none;">{t c='upload.album_name_empty'}</div>
					</div>
				</div>
				
				<div class="form-group {if $err.tags}has-error{/if}">
					<label for="upload_album_tags" >{t c='global.tags'}</label>
					<div>
						<textarea name="album_tags" id="upload_album_tags" rows="3" style="resize: none;" class="form-control" placeholder="{t c='global.tags'}">{$album.tags}</textarea>
						<div id="album_tags_error" class="text-danger m-t-5" style="display: none;">{t c='upload.album_tags_empty'}</div>
					</div>
				</div>						

				<div class="form-group {if $err.category}has-error{/if}">
					<label for="upload_album_category" >{t c='global.category'}</label>
					<div>
						<select name="album_category" id="upload_album_category" class="form-control">
							<option value="0"{if $album.category == ''} selected="selected"{/if}>-----</option>
							{section name=i loop=$categories}
							<option value="{$categories[i].CID}"{if $album.category == $categories[i].CID} selected="selected"{/if}>{$categories[i].name}</option>
							{/section}
						</select>
						<div id="album_category_error" class="text-danger m-t-5" style="display: none;">{t c='global.category_empty'}</div>
					</div>
				</div>						

				<div class="form-group {if $err.type}has-error{/if}">
					<label >{t c='upload.privacy'}</label>
					<div>
						<div class="radio">
							<label>
								<input name="album_type" type="radio" value="public" id="upload_album_type_public"{if $album.type == 'public'} checked="checked"{/if} />
								{t c='upload.album_public'}
							</label>
						</div>
						<div class="radio">
							<label>
								<input name="album_type" type="radio" value="private" id="upload_album_type_private"{if $album.type == 'private'} checked="checked"{/if} />
								{t c='upload.album_private'}
							</label>
						</div>
					</div>
				</div>

				<h5>
					{t c='album.add_more_photos'}
				</h5>
				<div class="form-group">
					<label for="upload_album_file">{t c='upload.album_add_title'}</label>
					<div class="custom-file">
					  <input type="file" name="album_file[]" class="custom-file-input" id="upload_album_file" multiple accept=".gif,.jpg,.jpeg,.png">
					  <label class="custom-file-label" for="upload_album_file">{t c='file.choose_files'}</label>
					</div>				
					<div id="album_file_error" class="text-danger m-t-5" style="display: none;">{t c='upload.album_file_empty'}</div>			
				</div>	
				
				{if $photos}
					<h5 class="mt-4">
						{t c='album.step_one'}
					</h5>
					<div class="row">
						{section name=i loop=$photos}
							<div id="photo_block_{$photos[i].PID}" class="col-6 col-md-4 col-xl-3 mb-3">
								<a href="{$relative}/photo/{$photos[i].PID}/">
									<img src="{$relative}/media/photos/tmb/{$photos[i].PID}.jpg" alt="{$photos[i].caption|escape:html}" id="album_photo_{$photos[i].PID}" class="img-responsive" />
								</a>
								<div>
									<div class="edit-photo-actions">
										<a href="#" data-pid="{$photos[i].PID}" id="delete_photo_{$photos[i].PID}"  data-toggle="tooltip" data-placement="top" title="{t c='global.delete'}"><i class="fas fa-trash"></i></a>
									</div>
									<div class="edit-photo-caption">
										<input name="photo_caption[]" type="text" class="form-control" value="{$photos[i].caption|escape:html}" placeholder="{t c='album.caption'}" maxlength="100"/>
									</div>
								<input name="photo_index[]" type="hidden" value="{$photos[i].PID}">
								</div>
							</div>
						{/section}
					</div>
					<h5 class="mt-3">
						<span class="d-none d-sm-block">{t c='album.step_two'}</span>
						<span class="d-block d-sm-none">{t c='album.step_two_xs'}</span>
					</h5>							
					<input name="x1" type="hidden" value="0" id="x1" />
					<input name="y1" type="hidden" value="0" id="y1" />
					<input name="x2" type="hidden" value="400" id="x2" />
					<input name="y2" type="hidden" value="400" id="y2" />
					<input name="width" type="hidden" value="400" id="width" />
					<input name="height" type="hidden" value="400" id="height" />

					<input name="x1-i" type="hidden" value="0" id="x1-i" />
					<input name="y1-i" type="hidden" value="0" id="y1-i" />
					<input name="x2-i" type="hidden" value="400" id="x2-i" />
					<input name="y2-i" type="hidden" value="400" id="y2-i" />
					<input name="width-i" type="hidden" value="400" id="width-i" />
					<input name="height-i" type="hidden" value="400" id="height-i" />							
					
					<input name="photo" type="hidden" value="1" id="photo" />
					<input name="random" type="hidden" value="" id="random" />
					<input name="init-s" type="hidden" value="0" id="init-s" />

					<div id="current_cover" class="mb-3">
						<label class="control-label">{t c='album.current_cover'}</label>
					</div>							
					<div class="d-flex justify-content-center">
						<div class="mb-3">
							<img src="{$relative}/media/albums/{$album.AID}.jpg?{0|rand:100}" id="album_cover" class="img-responsive-mw"/>
						</div>
					</div>	
					<div class="form-group">
						<div class="mt-3">
							<input name="submit_album_edit" type="submit" value=" {t c='global.save'} " class="btn btn-primary" />
						</div>
					</div>							
				{else}
					<div class="text-danger">
						{t c='album.edit_no_photos' r=$relative a=$album.AID}!
					</div>
				{/if}		
			</form>
		</div>
	</div>
</div>
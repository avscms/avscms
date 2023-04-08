<script type="text/javascript">
var lang_file = "{t c='global.file'}";
var lang_choose_files = "{t c='file.choose_files'}";
var lang_files = "{t c='global.files'}";
var lang_caption = "{t c='album.caption'}";
var lang_remove = "{t c='global.remove'}";
var lang_ext_invalid = "{t c='upload.album_ext_invalid' s=$image_extensions}";
var lang_submit = "{t c='upload.album_submit'}";
var lang_choose_file = "{t c='file.choose_file'}";
var lang_no_file = "{t c='file.no_file'}";
</script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.upload-photo.js"></script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.form.min.js"></script>

<div class="container mt-3 mb-3">
	<div class="well-filters">
		<h1>{t c='upload.album_title'}</h1>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-5 d-flex justify-content-center">		

			<form class="form-horizontal" name="uploadPhoto" id="uploadPhoto" method="post" enctype="multipart/form-data" target="_self" action="{$relative}/upload/photo"> 
	
				<input type="hidden" name="album_upload_started" value='1'/>	
	
				<div id="upload_name" class="form-group">
					<label for="upload_album_name">{t c='global.name'}</label>
					<input type="text" name="album_name" value="{$album.name}" id="upload_album_name" class="form-control" placeholder="{t c='global.name'}" autocomplete="off">
					<div id="album_name_error" class="text-danger text-small" style="display: none;">{t c='upload.album_name_empty'}</div>					
				</div>			

				<div id="upload_tags" class="form-group">
					<label for="upload_album_tags">{t c='global.tags'}</label>
					<textarea name="album_tags" id="upload_album_tags" class="form-control" placeholder="{t c='upload.tags_explanation'}" autocomplete="off">{$album.tags}</textarea>
					<div id="album_tags_error" class="text-danger text-small" style="display: none;">{t c='upload.album_tags_empty'}</div>					
				</div>

				<div id="upload_category" class="form-group">
					<label for="upload_album_category">{t c='global.category'}</label>
					<select name="album_category" id="upload_album_category" class="form-control">
						<option value="0"{if $album.category == ''} selected="selected"{/if}>---</option>
						{section name=i loop=$categories}
						<option value="{$categories[i].CID}"{if $album.category == $categories[i].CID} selected="selected"{/if}>{$categories[i].name}</option>
						{/section}
					</select>
					<div id="album_category_error" class="text-danger text-small" style="display: none;">{t c='global.category_empty'}</div>
				</div>
				<div id="upload_file" class="form-group">
					<label for="upload_album_file">{t c='upload.album_add_title'}</label>
					<div class="custom-file">
					  <input type="file" name="album_file[]" class="custom-file-input" id="upload_album_file" multiple accept=".gif,.jpg,.jpeg,.png">
					  <label class="custom-file-label" for="upload_album_file">{t c='file.choose_files'}</label>
					</div>				
					<div id="album_file_error" class="text-danger m-t-5" style="display: none;">{t c='upload.album_file_empty'}</div>
					<input type="hidden" id="album_filesize_error_" value="0">			
				</div>			
				<div class="form-group">
					<label for="">{t c='upload.anonymous'}</label></br>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="album_anonymous" id="upload_album_anonymous_no" value="no" {if $album.anonymous == 'no'} checked="checked"{/if}>
						<label class="form-check-label" for="upload_album_anonymous_no">{t c='upload.anonymous_yes'}</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="album_anonymous" id="upload_album_anonymous_yes" value="yes" {if $album.anonymous == 'yes'} checked="checked"{/if}>
						<label class="form-check-label" for="upload_album_anonymous_yes">{t c='upload.anonymous_no'}</label>
					</div>
				</div>

				<div class="form-group">
					<label for="">{t c='upload.privacy'}</label></br>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="album_type" id="upload_album_privacy_public" value="public" {if $album.type == 'public'} checked="checked"{/if}>
						<label class="form-check-label" for="upload_album_privacy_public">{t c='upload.album_public'}</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="album_type" id="upload_album_privacy_private" value="private" {if $album.type == 'private'} checked="checked"{/if}>
						<label class="form-check-label" for="upload_album_privacy_private">{t c='upload.album_private'}</label>
					</div>
				</div>	
				
				<div class="form-group">
					<small id="submit_uploadHelp" class="form-text text-muted text-x2">{t c='upload.terms' s=$site_name}</small>
				</div>	

				<div id="upload_status" class="form-group" style="display:none;">
					<div class="progress">
					  <div id="upload_progress_bar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
					</div>								
					<div id="upload_time"></div>
					<div id="upload_size"></div>
				</div>
				
				<div id="upload_message" style="display: none;"></div>

				
				<div class="form-group mt-3">
					<button type="submit" name="submit_upload_album" id="upload_album_submit" class="btn btn-primary">{t c='upload.album_button'}</button>							
				</div>			
			</form>
		</div>
	</div>
</div>
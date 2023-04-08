<script type="text/javascript">
var chunk_mb = '10MB';
var populate = true;
var upload_limit = 1;
var upload_max_size = "{$upload_max_size}";
var video_max_size = "{$video_max_size}";
var unique_id = "{$upload_id}";
var video_allowed_extensions = "{$video_extensions}";
var lang_ext_invalid = "{t c='upload.video_ext_invalid' s=$video_extensions}";
var lang_submit = "{t c='upload.video_submit'}";
</script>
<script type="text/javascript" src="{$relative_tpl}/js/plupload.full.min.js"></script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.upload.js"></script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.form.min.js"></script>
<div class="container mt-3 mb-3">
	<div class="well-filters">
		<h1>{t c='upload.video_title'}</h1>
	</div>
	<div class="row">
		<div class="col-lg-12 col-xl-8 mt-5 d-flex justify-content-center">		

			<form class="form-horizontal" name="uploadVideo" id="uploadForm" method="post" action="{$relative}/upload/video">
				
					<div class="fileupload fileupload-theme-dragdrop" id="upload-container">
						<div class="fileupload-input" id="upload_video_file">
							<div class="fileupload-input-inner">
								<i class="fas fa-cloud-upload-alt"></i>
								<h3 class="fileupload-input-caption"><span>{t c='upload.drag_and_drop_video_file'}</span></h3>
								<p>{t c='global.or'}</p>
								<div class="btn btn-primary"><span>{t c='file.choose_file'}</span></div>
							</div>
						</div>
						<div class="text-danger" id="upload_error" style="display: none;">{t c='upload.video_size_invalid' s=$video_max_size}</div>	
					</div>					
				

				<div id="uploadVideoForm" style="display:none;">

					<input name="upload_submitted" type="hidden" value="{$smarty.now}">
					<input name="unique_id" type="hidden" value="{$upload_id}">
					<input type="hidden" name="video_upload_started" value="1">	
					<input type="hidden" id="video_filename" name="video_filename" value="">

					<div class="fileupload-fileinfo">
						<a class="btn btn-secondary fileupload-file-remove">{t c='global.remove'}</a>
						<div class="fileupload-file-title"><span></span></div>
						<div class="fileupload-file-size"><span></span></div>
						<div class="clearfix"></div>					
					</div>
						
				
					<div id="upload_title" class="form-group">
						<label for="upload_video_title">{t c='global.title'}</label>
						<input type="text" name="video_title" value="{$video.title}" id="upload_video_title" class="form-control" placeholder="{t c='global.title'}" autocomplete="off">
						<div id="video_title_error" class="text-danger text-small" style="display: none;">{t c='upload.video_title_empty'}</div>					
					</div>			

					<div class="form-group">
						<label for="upload_video_description">{t c='global.description'}</label>
						<textarea name="video_description" id="upload_video_description" class="form-control" placeholder="{t c='global.description'}" autocomplete="off">{$video.description}</textarea>
					</div>					

					<div id="upload_tags" class="form-group">
						<label for="upload_video_tags">{t c='global.tags'}</label>
						<textarea name="video_tags" id="upload_video_tags" class="form-control" placeholder="{t c='upload.tags_explanation'}" autocomplete="off">{$video.tags}</textarea>
						<div id="video_tags_error" class="text-danger text-small" style="display: none;">{t c='upload.video_tags_empty'}</div>					
					</div>

					<div id="upload_category" class="form-group">
						<label for="upload_video_category">{t c='global.category'}</label>
						<select name="video_category" id="upload_video_category" class="form-control">
							<option value="0"{if $video.category == '0'} selected="selected"{/if}>---</option>
							{section name=i loop=$categories}
							<option value="{$categories[i].CHID}"{if $video.category == $categories[i].CHID} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
							{/section}
						</select>
						<div id="video_category_error" class="text-danger text-small" style="display: none;">{t c='global.category_empty'}</div>
					</div>
			
					<div class="form-group">
						<label for="">{t c='upload.anonymous'}</label></br>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="video_anonymous" id="upload_video_anonymous_no" value="no" {if $video.anonymous == 'no'} checked="checked"{/if}>
							<label class="form-check-label" for="upload_video_anonymous_no">{t c='upload.anonymous_yes'}</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="video_anonymous" id="upload_video_anonymous_yes" value="yes" {if $video.anonymous == 'yes'} checked="checked"{/if}>
							<label class="form-check-label" for="upload_video_anonymous_yes">{t c='upload.anonymous_no'}</label>
						</div>
					</div>

					<div class="form-group">
						<label for="">{t c='upload.privacy'}</label></br>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="video_privacy" id="upload_video_privacy_public" value="public" {if $video.privacy == 'public'} checked="checked"{/if}>
							<label class="form-check-label" for="upload_video_privacy_public">{t c='upload.video_public'}</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="video_privacy" id="upload_video_privacy_private" value="private" {if $video.privacy == 'private'} checked="checked"{/if}>
							<label class="form-check-label" for="upload_video_privacy_private">{t c='upload.video_private'}</label>
						</div>
					</div>	
			
					<div class="form-group">
						<small id="submit_uploadHelp" class="form-text text-muted text-x2">{t c='upload.terms' s=$site_name}</small>
					</div>	
					
					<div class="form-group">
						<div class="fileupload-progress" style="display: none">
							<div class="progress">
								<div id="upload_progress_bar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<div>
								<div class="item-title"></div> 
								<div class="item-size"></div>
								<div class="clearfix"></div>
							</div>
						</div>			
					</div>							
					
					<div class="form-group mt-3">
						<input type="button" class="btn btn-primary" value="{t c='upload.video_button'}" id="upload_video_submit" name="submit_upload_video">
					</div>			
					
				</div>						
			</form>
		</div>
	</div>
</div>

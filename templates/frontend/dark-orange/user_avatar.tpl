<script type="text/javascript" src="{$relative_tpl}/js/jquery.browser.min.js"></script>
<link rel="stylesheet" type="text/css" href="{$relative_tpl}/css/imgareaselect/imgareaselect-default.css" />
<script type="text/javascript" src="{$relative_tpl}/js/jquery.imgareaselect.js"></script>
<script type="text/javascript">
    var uploaded = "{$uploaded}";
    {literal}
	
    function selectChange(img, selection)
    {
        document.getElementById("x1").value = selection.x1;
        document.getElementById("y1").value = selection.y1;
        document.getElementById("x2").value = selection.x2;
        document.getElementById("y2").value = selection.y2;
        document.getElementById("width").value = selection.width;
        document.getElementById("height").value = selection.height;
    }

    
	
    $(window).on('load', function(){
		if ( uploaded != '' ) {
			var newImg = document.getElementById("user_avatar");
		
			var iw = newImg.naturalWidth;
			var ih = newImg.naturalHeight;
			
			var s_max = iw;
			var s_x = 0;
			var s_y = 0;
			

			

			
			if ( ih < iw ) {
				s_max = ih;
				
				s_x = Math.floor((iw - s_max)/2);
			}
			else {
			
			s_y = Math.floor((ih - s_max)/2);
				
			}
			
			var s_margin =  Math.floor(( 5 * s_max ) / 100);

			$('img#user_avatar').imgAreaSelect({ selectionOpacity: 0.2, x1: s_x + s_margin, y1: s_y + s_margin, x2: s_x + s_max - s_margin, y2: s_y + s_max - s_margin, resizable: true, aspectRatio: '1:1', handles: true, persistent:true, minHeight: '50', minWidth: '50', maxHeight: '500', maxWidth: '500', onSelectChange: selectChange });

			$("#x1").val( s_x + s_margin );
			$("#y1").val( s_y + s_margin );
			$("#x2").val( s_x + s_max - s_margin );
			$("#y2").val( s_y + s_max - s_margin );
			$("#width").val( s_max - ( 2 * s_margin ) );
			$("#height").val( s_max - ( 2 * s_margin ) );
		}
    });

	$(document).ready(function(){	

		$('#upload_avatar').on('change',function(){
			//get the file name
			var file =  $(this).val();
			var fileName = file.split("\\");
			var fileTr = fileName[fileName.length-1];		
			$(this).next('.custom-file-label').html(fileTr);
			$("div[id='upload_file']").removeClass( "has-error" );			
		})	
		
	});
	
    {/literal}
</script>
	
<div class="container mt-3">
	<fieldset>
	<legend>{t c='user.AVATAR_TITLE'}</legend>
	<form class="form-horizontal" name="profile_avatar_form" id="profile_avatar_form" method="post" enctype="multipart/form-data" action="{$relative}/user/avatar">	
	
		<div class="form-group">
			<div class="d-flex justify-content-center">
			{if $user.photo != ''}
				
				<div class="col-6 col-md-3">
					<img src="{$relative}/media/users/{$user.photo}?{0|rand:100}" class="img-responsive">
				</div>
			{else}
				<div class="col-6 col-md-3">
					<span class="text-danger">{t c='user.avatar_none'}</span>
				</div>
			{/if}
			</div>
		</div>
				
		<div id="upload_file" class="form-group {if $err.file} has-error{/if}">
			<div class="d-flex justify-content-center">
				<div class="col-12 col-sm-6">
					<label for="upload_avatar">{t c='global.file'}</label>	
					<div class="custom-file col-12">
						<input type="file" name="avatar" class="custom-file-input" id="upload_avatar" accept=".gif,.jpg,.jpeg,.png">
						<label class="custom-file-label" for="upload_avatar">{t c='file.choose_file'}</label>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="d-flex justify-content-center">
				<div class="col-6">					
					<input name="avatar_submit" type="submit" class="btn btn-primary" value=" {t c='global.upload'} " />
				</div>
			</div>
		</div>
	</form>
	</fieldset>
	<div class="clearfix"></div>
	{if $uploaded}
		<form class="form-horizontal" name="profile_avatar_crop_form" id="profile_avatar_crop_form" method="post" action="{$relative}/user/avatar">
			<input name="x1" type="hidden" value="0" id="x1">
			<input name="y1" type="hidden" value="0" id="y1">
			<input name="x2" type="hidden" value="150" id="x2">
			<input name="y2" type="hidden" value="150" id="y2">
			<input name="width" type="hidden" value="150" id="width">
			<input name="height" type="hidden" value="150" id="height">
			<div class="d-flex justify-content-center">
				<div class="mb-3" >
					<img src="{$relative}/media/users/orig/{$user.UID}.jpg?{0|rand:100}" id="user_avatar" class="img-responsive"/>
				</div>
			</div>							
			<div class="form-group m-b-0">
				<div class="d-flex justify-content-center">
					<div class="col-6">				
						<button name="avatar_crop_submit" type="submit" class="btn btn-primary"><span class="d-block d-sm-none">{t c='global.auto_crop_save'}</span><span class="d-none d-sm-block">{t c='global.crop_save'}</span></button>										
					</div>
				</div>
			</div>							
		</form>
	{/if}
</div>

	
	


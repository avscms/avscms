var index   = 1;
var pic     = 2;

function getFile(d){
   document.getElementById(d).click();
}
 
function validateSize(size, maxfilesize, error_id) {
	if (size != null && size > maxfilesize) {
		$('#' + error_id).show();
		$("div[id='upload_file']").addClass( " has-error" );
		$('#' + error_id + '_').val(1);
	} else {
		if ( $('#'+ error_id).is(':visible') ) {
			$('#'+ error_id).hide();		
		}				
		$('#' + error_id + '_').val(0);	
	}
}

$(document).ready(function(){
	
	var errors = false;
	var uploader = new plupload.Uploader({
	  runtimes : 'html5,flash,silverlight,html4',
	  browse_button : document.getElementById('upload_video_file'),
	  container: document.getElementById('upload-container'),
	  url : base_url+'/fileupload.php?id='+unique_id,
	  flash_swf_url : tpl_url+'/js/Moxie.swf',
	  silverlight_xap_url : tpl_url+'/js/Moxie.xap',
	  multipart: true,
	  multi_selection: false,
	  max_retries: 3,
	  drop_element:  document.getElementById('upload-container'),
	  dragdrop: true,
	  chunk_size : chunk_mb,
	  filters : {
		max_file_size : video_max_size+'mb',
		mime_types: [
		  {title : "Video file", extensions : video_allowed_extensions},
		]
	  }
	});	  
		  
	uploader.init();              
	  
	uploader.bind('FilesAdded', function(up, files) {
	  if (files.length > 1) uploader.splice(1, files.length - 1);
		var filesize = this.files[0].size;
		var filename = this.files[0].name;
		var filetype = this.files[0].type;
		if(filesize>(upload_max_size)) {

			$("#upload_error").show();
			return;
		}
		var mbsize = (filesize/1048576).toFixed(2);
		$("#fileerror").hide();
		$(".fileupload-file-title").html(filename);
		$(".fileupload-file-size").html(mbsize+' MB');
		$("#video_filename").val(filename);
		$(".fileupload").hide();
		$("#uploadVideoForm").show();

			var ttl = filename.split('.').slice(0, -1).join('.');
			ttl = ttl.replace(/[\_\-]/g, ' ');
			ttl = ttl.replace("."," ");

		var pop_title=true;
		var pop_tags=true;

		if(populate) {
			var title_el = $('#upload_video_title');
			if(title_el.val().length == 0) title_el.val(ttl);

			var desc_el = $('#upload_video_description');

			if(desc_el.length) {
				desc_el.val(ttl);
			}			
		}
      //to pass filename to fileupload.php
      uploader.setOption('url', base_url+'/fileupload.php?id='+unique_id+'&name='+filename);
	  up.refresh();
	});
					
	uploader.bind('UploadProgress', function(up, file) {
		$("#upload_progress_bar").attr("aria-valuenow", file.percent);	
		$("#upload_progress_bar").width(file.percent + "%");  
	});
					
	uploader.bind('Error', function(up, err) {
	  errors = true;
	  if(err.message) {
		$("#upload_error").html(err.message);
		$("#upload_error").show();
	  }
		$.each(uploader.files, function (i, file) {
			uploader.removeFile(file);
		});
		uploader.splice();
		uploader.refresh();
		$("input[id='video_filename']").val('');
	});

	uploader.bind('UploadComplete', function(up) {    

		uploader.splice();
		uploader.refresh();

		$.post($("#uploadForm").attr('action'), $("#uploadForm").serialize(), function(res){
			window.location.href = base_url + "/upload/video?status=1";			
		});
		return false; 

	});

	$("body").on('click', ".fileupload-file-remove", function(e) {
		$("#uploadVideoForm").hide();
		$("#upload_error").hide();
		$(".fileupload").show();
		$(".fileupload-file-title").html('');
		$(".fileupload-file-title span").html('')
		$.each(uploader.files, function (i, file) {
				uploader.removeFile(file);
		});
		$("input[id='video_filename']").val('');
		uploader.splice();
		uploader.refresh();

	});

	$('body').on('click', '[id="upload_video_submit"]', function(e) {

		var error           = false;
		var video_title     = $("input[id='upload_video_title']").val();
		var video_tags      = $("textarea[id='upload_video_tags']").val();
		var video_category  = $("select[id='upload_video_category']").val();
		var video_file      = $("input[id='upload_video_file']").val();
		var title_error     = $("div[id='video_title_error']");
		var tags_error      = $("div[id='video_tags_error']");
		var category_error  = $("div[id='video_category_error']");
		var file_error      = $("div[id='video_file_error']");

		video_category = parseInt(video_category);		

		if ( video_title == '' ) {
			error   = true;
			$(title_error).show();
			$("div[id='upload_title']").addClass( " has-error" );			
		} else {
			if ( $(title_error).is(':visible') ) {
				$(title_error).hide();
				$("div[id='upload_title']").removeClass( " has-error" );				
			}
		}
		if ( video_tags == '' ) {
			error   = true;
			$(tags_error).show();
			$("div[id='upload_tags']").addClass( " has-error" );			
		} else {
			if ( $(tags_error).is(':visible') ) {            
				$(tags_error).hide();
				$("div[id='upload_tags']").removeClass( " has-error" );
			}
		}
		if ( video_category == '0' ) {
			error   = true;
			$(category_error).show();
			$("div[id='upload_category']").addClass( " has-error" );						
		} else {
			if ( $(category_error).is(':visible') ) {
				$(category_error).hide();
				$("div[id='upload_category']").removeClass( " has-error" );				
			}    
		}

		if(error!=true) {			
			$(".item-title").html( $(".fileupload-file-title").html() );
			$(".item-size").html( $(".fileupload-file-size").html() );
			$(".fileupload-fileinfo").hide();					
			$(".fileupload-progress").show();		
			uploader.start();
		}

	});
    
  
    $("#uploadPhoto").submit(function(e) {	
		e.preventDefault();		
        var error       = false;
        var album_name  = $("input[id='upload_album_name']").val();
        var album_cat   = $("select[id='upload_album_category']").val();
        var album_tags  = $("textarea[id='upload_album_tags']").val();
		var album_file  = $("input[id='upload_album_file']").val();
		var file_error  = $("div[id='album_file_error']");	
        
        if ( album_name == '' ) {
            error       = true;
            $("div[id='album_name_error']").show();
			$("div[id='upload_name']").addClass(" has-error");				
        } else {
            $("div[id='album_name_error']").hide();
			$("div[id='upload_name']").removeClass(" has-error");				
        }
        
        if ( album_cat == '0' ) {
            error       = true;
            $("div[id='album_category_error']").show();
			$("div[id='upload_category']").addClass(" has-error");				
        } else {
            $("div[id='album_category_error']").hide();
			$("div[id='upload_category']").removeClass(" has-error");			
        }
                       
        if ( album_tags == '' ) {
            error       = true;
            $("div[id='album_tags_error']").show();
			$("div[id='upload_tags']").addClass(" has-error");				
        } else {
            $("div[id='album_tags_error']").hide();
			$("div[id='upload_tags']").removeClass(" has-error");			
        }

		if ( album_file == '' ) {
			error   = true;
			$(file_error).show();
			$("div[id='upload_file']").addClass( " has-error" );			
		} else {
			if ( $(file_error).is(':visible') ) {
				$(file_error).hide();
				$("div[id='upload_file']").removeClass( " has-error" );					
			}
		}

		if (!error) {
			$(this).ajaxSubmit({ 
				target: '#alerts_bottom',
				beforeSubmit: function() {
					$('#upload_status').show();
					$('#alerts_bottom').html('');
				},
				uploadProgress: function (event, position, total, percentComplete){	
					$("#upload_progress_bar").attr("aria-valuenow", percentComplete);	
					$("#upload_progress_bar").width(percentComplete + "%");
					if (percentComplete >= 100) {
						$('#upload_status').hide();
						$("#upload_progress_bar").attr("aria-valuenow", 0);	
						$("#upload_progress_bar").width(0);					
						$('#upload_video_file').next('.custom-file-label').html(lang_choose_files);							
					}
				},
				success:function (){
					$('#upload_status').hide();
					$("#upload_progress_bar").attr("aria-valuenow", 0);	
					$("#upload_progress_bar").width(0);					
					$('#upload_album_file').next('.custom-file-label').html(lang_choose_files);
				},				
				resetForm: true			
			});		
		}
		return true;
    });

});

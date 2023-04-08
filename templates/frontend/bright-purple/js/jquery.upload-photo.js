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

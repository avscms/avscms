function copyToClipboard(input) {
  /* Get the text field */
  var copyText = document.getElementById(input);

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  $("#" + input + '_copied').html('<i class="fas fa-check"></i>');
}	

function is_int(x) {
	return x % 1 === 0;
}

$(document).ready(function(){
    $("body").on('click', "a[id='photo_share']", function(event) {
        event.preventDefault();			
		$("#shareModal").modal('show');		
    });
	
	$( "#custom_width" ).change(function() {
		var cw = $( "#custom_width" ).val();
		if ( is_int(cw) && cw >= 320) {
			if ($("#custom_size").hasClass("has-error")) {
				$("#custom_size").removeClass("has-error");
			}
			var ch = Math.round( cw / ( photo_width / photo_height ) );
			$( "#custom_height" ).val( ch );
			var embed_code = '<iframe width="' + cw + '" height="' + ch + '" src="' + base_url + '/embed/' + ephoto_vkey + '" frameborder="0" allowfullscreen></iframe>';
			$( "#photo_embed_code" ).val( embed_code );
		}
		else {
			$("#custom_size").addClass("has-error");
		}
		if ( cw == '' && $( "#custom_height" ).val() == '') {
			if ($("#custom_size").hasClass("has-error")) {
				$("#custom_size").removeClass("has-error");
			}			
		}		
	});

	$( "#custom_height" ).change(function() {
		var ch = $( "#custom_height" ).val();
		if ( is_int(ch) && ch >= 180) {
			if ($("#custom_size").hasClass("has-error")) {
				$("#custom_size").removeClass("has-error");
			}					
			var cw = Math.round( ch * ( photo_width / photo_height ) );
			$( "#custom_width" ).val( cw );
			var embed_code = '<iframe width="' + cw + '" height="' + ch + '" src="' + base_url + '/embed/' + ephoto_vkey + '" frameborder="0" allowfullscreen></iframe>';
			$( "#photo_embed_code" ).val( embed_code );
		}
		else {
			$("#custom_size").addClass("has-error");
		}
		if ( cw == '' && ch == '') {
			if ($("#custom_size").hasClass("has-error")) {
				$("#custom_size").removeClass("has-error");
			}			
		}		
	});

    $("a[id*='photo_favorite']").click(function(event) {
        event.preventDefault();
        var photo_id    = $(this).attr('data-pid');
        var album_id    = $(this).attr('data-aid');		
        $.post(base_url + '/ajax/favorite_photo', { photo_id: photo_id, album_id: album_id},
        function (response) {
            if ( response.status == 0 ) {
                alertBottom(response.msg, 'error');
            } else {
                alertBottom(response.msg, 'success');
            }    
        }, 'json');                                                
    });

    $("body").on('click', "a[id='photo_flag']", function(event) {
        event.preventDefault();			
		$("#flagModal").modal('show');		
    });	
	
    $("button[id='submit_flag_photo']").click(function(event) {
        event.preventDefault();
        var type            = 'photo'
        var item_id         = $(this).attr('data-pid');
        var flag_id         = $("input[name='flag_reason']:checked").val();
        var message         = $("textarea[id='flag_message']").val();
        $.post(base_url + '/ajax/flag_' + type, { item_id: item_id, flag_id: flag_id, message: message },
        function(response) {
			$("#flagModal").modal('hide');			
            if ( response.status == 0 ) {
                alertBottom(response.msg, 'error');
            } else {
				alertBottom(response.msg, 'success');
            }
        }, 'json');
    });	
	
    $("body").on('click', "a[id='user_subscription']", function(event) {
        event.preventDefault();
        var user_id    = $(this).attr('data-uid');
        $.post(base_url + '/ajax/user_subscription', { user_id: user_id },
        function(response) {
            if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
            } else {
				$("#user_subscription").html(response.btn);				
				$("#total_subscribers").html(response.total_s);						
				alertBottom(response.msg, 'success');	
            } 
        }, 'json');
    });		
	
});

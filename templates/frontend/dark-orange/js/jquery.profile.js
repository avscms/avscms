$(document).ready(function(){
	$('#user_friendship').tooltip({ trigger:'hover' });
    $("#user-info-show-more").click(function(event) {
        event.preventDefault();
			$("#user-info-more").fadeIn();
			$(this).hide();
			$("#user-info-show-less").show();
    });
	
    $("#user-info-show-less").click(function(event) {
        event.preventDefault();
			$("#user-info-more").fadeOut();
			$(this).hide();
			$("#user-info-show-more").show();
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
	
    $("body").on('click', "a[id='user_friendship']", function(event) {
        event.preventDefault();
        var user_id    = $(this).attr('data-uid');
        var friendship = $(this).attr('data-friendship');
		if (friendship == 'Add') {
			$.post(base_url + '/ajax/user_friendship', { user_id: user_id, friendship: friendship },
			function(response) {
				if ( response.status == 0 ) {
					alertBottom(response.msg, 'error');			
				} else {
					$("#user_friendship").html('<i class="fas fa-user-clock"></i>');
					$("#user_friendship").attr('data-friendship', 'Pending_sent');
					$("#user_friendship").attr('data-toggle', 'dropdown');
					$("#user_friendship").attr('data-original-title', lang_friend_rs);	
					$("#user_friendship_dd").removeClass('d-none');
					$("#user_friendship_dd").html('<a class="dropdown-item" id="user_friendship_" data-uid="' + user_id + '" data-friendship="Cancel" href="#">' + lang_friend_rc + '</a>');
					alertBottom(response.msg, 'success');	
				} 
			}, 'json');
		}
    });	
    $("body").on('click', "a[id*='user_friendship_']", function(event) {
        event.preventDefault();
        var user_id    = $(this).attr('data-uid');
        var friendship = $(this).attr('data-friendship');
		$.post(base_url + '/ajax/user_friendship', { user_id: user_id, friendship: friendship },
		function(response) {
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				if (friendship == 'Cancel') {
					$("#user_friendship").html('<i class="fas fa-user-plus"></i>');
					$("#user_friendship").attr('data-friendship', 'Add');
					$("#user_friendship").attr('data-original-title', lang_add_friend);		
					$("#user_friendship").attr('data-toggle', '');	
					$("#user_friendship_dd").html('');	
					$("#user_friendship_dd").addClass('d-none');
					$('#user_friendship').dropdown('dispose');		
				}
				if (friendship == 'Accept') {
					$("#user_friendship").html('<i class="fas fa-user-check"></i>');
					$("#user_friendship").attr('data-friendship', 'Confirmed_received');
					$("#user_friendship").attr('data-original-title', lang_friends);		
					$("#user_friendship").attr('data-toggle', '');	
					$("#user_friendship_dd").html('<a class="dropdown-item" id="user_friendship_" data-uid="' + user_id + '" data-friendship="Unfriend" href="#">' + lang_unfriend + '</a>');					
					$("#user_friendship_dd").removeClass('d-none');
					$('#user_friendship').dropdown();			
				}
				if (friendship == 'Reject') {
					$("#user_friendship").html('<i class="fas fa-user-plus"></i>');
					$("#user_friendship").attr('data-friendship', 'Add');
					$("#user_friendship").attr('data-original-title', lang_add_friend);		
					$("#user_friendship").attr('data-toggle', '');	
					$("#user_friendship_dd").html('');					
					$("#user_friendship_dd").addClass('d-none');
					$('#user_friendship').dropdown('dispose');			
				}					
				if (friendship == 'Unfriend') {
					$("#user_friendship").html('<i class="fas fa-user-plus"></i>');
					$("#user_friendship").attr('data-friendship', 'Add');
					$("#user_friendship").attr('data-original-title', lang_add_friend);		
					$("#user_friendship").attr('data-toggle', '');	
					$("#user_friendship_dd").html('');					
					$("#user_friendship_dd").addClass('d-none');
					$('#user_friendship').dropdown('dispose');			
				}					
				alertBottom(response.msg, 'success');	
			} 
		}, 'json');
    });	
    $("body").on('click', "a[id='user_block']", function(event) {
        event.preventDefault();
        var user_id = $(this).attr('data-uid');
        var action 	= $(this).attr('data-block');
		$.post(base_url + '/ajax/user_block', { user_id: user_id, action: action },
		function(response) {
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				if (action 	== 'Block') {
					$("#user_friendship_container").addClass('d-none');
					$("#user_block").attr('data-block', 'Unblock');		
					$("#user_block").html(lang_unblock);
				} else {
					$("#user_friendship_container").removeClass('d-none');
					$("#user_block").attr('data-block', 'Block');
					$("#user_block").html(lang_block);					
				}
				$("#user_friendship").html('<i class="fas fa-user-plus"></i>');
				$("#user_friendship").attr('data-friendship', 'Add');
				$("#user_friendship").attr('data-original-title', lang_add_friend);		
				$("#user_friendship").attr('data-toggle', '');	
				$("#user_friendship_dd").html('');					
				$("#user_friendship_dd").addClass('d-none');
				$('#user_friendship').dropdown('dispose');			
				alertBottom(response.msg, 'success');	
			} 
		}, 'json');
    });
	
    $("body").on('click', "a[id='user_report']", function(event) {
        event.preventDefault();			
		$("#other_reason").hide();		
		$("#other_reason").val('');		
		$("#report_reason_1").prop('checked', true);		
		$("#reportModal").modal('show');		
    });	

	$('input[type=radio][name=report_reason]').change(function() {
		if (this.value == 'other') {
			$("#other_reason").show();
		} else {
			$("#other_reason").hide();
		}
	});

    $("body").on('click', "button[id='submit_user_report']", function(event) {
        event.preventDefault();
        var user_id = $(this).attr('data-uid');
        var reason 	= $("input[name='report_reason']:checked").val();
        var other   = $("#other_reason").val();
		$.post(base_url + '/ajax/user_report', { user_id: user_id, reason: reason, other: other },
		function(response) {
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				$("#user_reported").removeClass('d-none');
				alertBottom(response.msg, 'success');		
			} 
			$("#reportModal").modal('hide');
		}, 'json');
    });	
	
    $("body").on('click', "a[id='user_message']", function(event) {
        event.preventDefault();	
		$("#message_subject").val('');		
		$("#message_body").val('');			
		$("#messageModal").modal('show');		
    });	
	
    $("body").on('click', "button[id='send_user_message']", function(event) {
        event.preventDefault();
        var receiver = $(this).attr('data-receiver');
		var	sender = $(this).attr('data-sender');
        var message_subject   = $("#message_subject").val();		
        var message_body      = $("#message_body").val();		
		$.post(base_url + '/ajax/user_message', { receiver: receiver, sender: sender, message_subject: message_subject, message_body: message_body },
		function(response) {
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				alertBottom(response.msg, 'success');		
			} 
			$("#messageModal").modal('hide');
		}, 'json');
    });		


	$("body").on('click', "[id*='delete_video_']", function(event) {				
		event.preventDefault();
        var this_id   = $(this).attr('id');
        var video_id  = $(this).attr('data-vid');		
		$("#dialogModal .modal-title").html(lang_global_delete);
		$("#dialogModal .modal-body").html(lang_videos_delete_confirm);
		$("#dialogModal .modal-footer .opt-1").html(lang_global_yes);		
		$("#dialogModal .modal-footer .opt-2").html(lang_global_no);	
		$("#dialogModal .modal-footer .opt-1").attr('id', 'confirm_' + this_id);	
		$("#dialogModal .modal-footer .opt-1").attr('data-vid', video_id);
		$("#dialogModal").modal('show');
	});	

    $("body").on('click', "button[id*='confirm_delete_video_']", function(event) {
        event.preventDefault();
        var video_id    = $(this).attr('data-vid');
		$.post(base_url + '/ajax/delete_video', { video_id: video_id },
		function(response) {
			$("#dialogModal").modal('hide');
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				$("#video_block_" + video_id).hide();
				alertBottom(response.msg, 'success');	
			} 
		}, 'json');
    });
	
	$("body").on('click', "[id*='delete_album_']", function(event) {				
		event.preventDefault();
        var this_id   = $(this).attr('id');
        var album_id  = $(this).attr('data-aid');		
		$("#dialogModal .modal-title").html(lang_global_delete);
		$("#dialogModal .modal-body").html(lang_albums_delete_confirm);
		$("#dialogModal .modal-footer .opt-1").html(lang_global_yes);		
		$("#dialogModal .modal-footer .opt-2").html(lang_global_no);	
		$("#dialogModal .modal-footer .opt-1").attr('id', 'confirm_' + this_id);	
		$("#dialogModal .modal-footer .opt-1").attr('data-aid', album_id);
		$("#dialogModal").modal('show');
	});

    $("body").on('click', "button[id*='confirm_delete_album_']", function(event) {
        event.preventDefault();
        var album_id    = $(this).attr('data-aid');
		$.post(base_url + '/ajax/delete_album', { album_id: album_id },
		function(response) {
			$("#dialogModal").modal('hide');
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				$("#album_block_" + album_id).hide();
				alertBottom(response.msg, 'success');	
			} 
		}, 'json');
    });	
	
	$("body").on('click', "[id*='remove_favorite_video_']", function(event) {				
		event.preventDefault();
        var this_id   = $(this).attr('id');
        var video_id  = $(this).attr('data-vid');		
		$("#dialogModal .modal-title").html(lang_global_remove);
		$("#dialogModal .modal-body").html(lang_favorites_remove_confirm);
		$("#dialogModal .modal-footer .opt-1").html(lang_global_yes);		
		$("#dialogModal .modal-footer .opt-2").html(lang_global_no);	
		$("#dialogModal .modal-footer .opt-1").attr('id', 'confirm_' + this_id);	
		$("#dialogModal .modal-footer .opt-1").attr('data-vid', video_id);
		$("#dialogModal").modal('show');
	});	
	
    $("body").on('click', "button[id*='confirm_remove_favorite_video_']", function(event) {
        event.preventDefault();
        var video_id    = $(this).attr('data-vid');
		$.post(base_url + '/ajax/remove_video_favorite', { video_id: video_id },
		function(response) {
			$("#dialogModal").modal('hide');
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				$("#favorite_block_" + video_id).hide();
				alertBottom(response.msg, 'success');	
			} 
		}, 'json');
    });

	$("body").on('click', "[id*='remove_favorite_photo_']", function(event) {				
		event.preventDefault();
        var this_id   = $(this).attr('id');
        var photo_id  = $(this).attr('data-pid');		
		$("#dialogModal .modal-title").html(lang_global_remove);
		$("#dialogModal .modal-body").html(lang_favorites_remove_confirm);
		$("#dialogModal .modal-footer .opt-1").html(lang_global_yes);		
		$("#dialogModal .modal-footer .opt-2").html(lang_global_no);	
		$("#dialogModal .modal-footer .opt-1").attr('id', 'confirm_' + this_id);	
		$("#dialogModal .modal-footer .opt-1").attr('data-pid', photo_id);
		$("#dialogModal").modal('show');
	});	

    $("body").on('click', "button[id*='confirm_remove_favorite_photo_']", function(event) {
        event.preventDefault();
        var photo_id    = $(this).attr('data-pid');
		$.post(base_url + '/ajax/remove_photo_favorite', { photo_id: photo_id },
		function(response) {
			$("#dialogModal").modal('hide');
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				$("#favorite_block_" + photo_id).hide();
				alertBottom(response.msg, 'success');	
			} 
		}, 'json');
    });	
	
	$("body").on('click', "[id*='delete_blog_']", function(event) {				
		event.preventDefault();
        var this_id   = $(this).attr('id');
        var blog_id  = $(this).attr('data-bid');		
		$("#dialogModal .modal-title").html(lang_global_delete);
		$("#dialogModal .modal-body").html(lang_blogs_delete_confirm);
		$("#dialogModal .modal-footer .opt-1").html(lang_global_yes);		
		$("#dialogModal .modal-footer .opt-2").html(lang_global_no);	
		$("#dialogModal .modal-footer .opt-1").attr('id', 'confirm_' + this_id);	
		$("#dialogModal .modal-footer .opt-1").attr('data-bid', blog_id);
		$("#dialogModal").modal('show');
	});		

    $("body").on('click', "button[id*='confirm_delete_blog_']", function(event) {
        event.preventDefault();
        var blog_id    = $(this).attr('data-bid');
		$.post(base_url + '/ajax/delete_blog', { blog_id: blog_id },
		function(response) {
			$("#dialogModal").modal('hide');
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				$("#blog_block_" + blog_id).hide();
				alertBottom(response.msg, 'success');	
			} 
		}, 'json');
    });

	$("body").on('click', "[id*='remove_playlist_video_']", function(event) {				
		event.preventDefault();
        var this_id   = $(this).attr('id');
        var video_id  = $(this).attr('data-vid');		
		$("#dialogModal .modal-title").html(lang_global_remove);
		$("#dialogModal .modal-body").html(lang_playlist_remove_confirm);
		$("#dialogModal .modal-footer .opt-1").html(lang_global_yes);		
		$("#dialogModal .modal-footer .opt-2").html(lang_global_no);	
		$("#dialogModal .modal-footer .opt-1").attr('id', 'confirm_' + this_id);	
		$("#dialogModal .modal-footer .opt-1").attr('data-vid', video_id);
		$("#dialogModal").modal('show');
	});	
	
    $("body").on('click', "button[id*='confirm_remove_playlist_video_']", function(event) {
        event.preventDefault();
        var video_id    = $(this).attr('data-vid');
		$.post(base_url + '/ajax/remove_video_playlist', { video_id: video_id },
		function(response) {
			$("#dialogModal").modal('hide');
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				$("#playlist_block_" + video_id).hide();
				alertBottom(response.msg, 'success');	
			} 
		}, 'json');
    });
	
    $("body").on('click', "a[id*='block_username_'],a[id*='unblock_username_']", function(event) {  	
        event.preventDefault();
        var act_id      = $(this).attr('id');
        var id_split    = act_id.split('_');
        var action      = id_split[0];
        var user_id     = id_split[2];
        $.post(base_url + '/ajax/' + action + '_user', { user_id: user_id },
        function(response) {
            if (response.status == 1) {
                if ( action == 'block' ) {
                    $('#unblock_' + user_id).html('<a href="#unblock" id="unblock_username_' + user_id + '">' + lang_unblock_user + '</a>');
                } else {
                    $('#unblock_' + user_id).html('<a href="#block" id="block_username_' + user_id + '">' + lang_block_user + '</a>');
                }
            }
        }, 'json');
    });	
		
});

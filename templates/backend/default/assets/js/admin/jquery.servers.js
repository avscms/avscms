function validateString(input,ml) {
	$(input).change(function(){
		if($(this).val().length < ml) {
			$(this).addClass('error');
		} else {
			$(this).removeClass('error');
		}
	});	
}

function hasErrors(input) {
	var err = false;
	$(input).each(function(){		
		if($(this).hasClass('error')) {
			err = true;
		}
	});
	return err;
}

$(document).ready(function(){
		
	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'server_id';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';		
	});	


	//Ajax:

    $("body").on('click', "a[id*='delete_server_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var server_id = split[2];
		$('#delete__server_' + server_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_server', { server_id: server_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Server <b>ID ' + server_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#item-' + server_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Server <b>ID ' + server_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

    $("body").on('click', "a[id*='status_server_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);	
			var server_status = $(this).attr('data-status');
			var id = $(this).attr('id');
			var split = id.split('_');
			var server_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_status_server', { server_id: server_id, server_status: server_status},
				function (response) {
					if (response.status) {
						if (server_status == 0) {
							Messenger().post({
								message: 'Server <b>ID ' + server_id + '</b>: Successfully activated!',
								type: 'success'
							});						
							$('#status_server_' + server_id).attr('data-status', 1);							
							$('#status_server_' + server_id).attr('alt', 'Suspend');
							$('#status_server_' + server_id).attr('title', 'Suspend');
							$('#status_server_' + server_id).html('<i class="fa fa-times"></i>');
							$('#status-' + server_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							Messenger().post({
								message: 'Server <b>ID ' + server_id + '</b>: Successfully suspended!',
								type: 'success'
							});
							$('#status_server_' + server_id).attr('data-status', 0);
							$('#status_server_' + server_id).attr('alt', 'Activate');
							$('#status_server_' + server_id).attr('title', 'Activate');
							$('#status_server_' + server_id).html('<i class="fa fa-check"></i>');
							$('#status-' + server_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}

					} else {
						if (server_status == 0) {
							Messenger().post({
								message: 'Server <b>ID ' + server_id + '</b>: Failed activating or already active!',
								type: 'error'
							});
							$('#status_server_' + server_id).html('<i class="fa fa-check"></i>');							
						} else {
							Messenger().post({
								message: 'Server <b>ID ' + server_id + '</b>: Failed suspending or already inactive!',
								type: 'error'
							});
							$('#status_server_' + server_id).html('<i class="fa fa-times"></i>');							
						}
					}
					$('#status_server_' + server_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});	
	
	//Edit Server
    $("body").on('click', "a[id*='edit_server_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var server_id = split[2];


		$.post(base_url + '/ajax/admin_get_server', { server_id: server_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Server Data
					$('#edit-id-span').text(response.server_id);					
					$('#edit-id').val(response.server_id);
					$('#edit-url').val(response.url);
					$('#edit-video_url').val(response.video_url);
					$('#edit-server_ip').val(response.server_ip);
					$('#edit-ftp_username').val(response.ftp_username);
					$('#edit-ftp_password').val(response.ftp_password);
					$('#edit-ftp_root').val(response.ftp_root);
					$('input:radio[name="edit-current_used"]').filter('[value="' + response.current_used + '"]').attr('checked', true);
					$('input:radio[name="edit-status"]').filter('[value="' + response.active + '"]').attr('checked', true);

					//Adjust margin left to integer value - Center
					var modal_ml = parseInt(($(window).width()-$('#editModalDialog').width())/2);					
					$('#editModal').modal('show');
					if ($(window).width()>768) {
						$('#editModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
					}
					
				} else {
					Messenger().post({
						message: 'Server <b>ID ' + server_id + '</b>: Failed getting server details!',
						type: 'error'
					});
				}				
		}, "json"); 		
	});	

	//Reset
	$("body").on('click', "button[id='edit-reset']", function(event) {
        event.preventDefault();
		var server_id = $('#edit-id').val();

		$.post(base_url + '/ajax/admin_get_server', { server_id: server_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Server Data
					$('#edit-id-span').text(response.server_id);					
					$('#edit-id').val(response.server_id);
					$('#edit-url').val(response.url);
					$('#edit-video_url').val(response.video_url);
					$('#edit-server_ip').val(response.server_ip);
					$('#edit-ftp_username').val(response.ftp_username);
					$('#edit-ftp_password').val(response.ftp_password);
					$('#edit-ftp_root').val(response.ftp_root);
					$('input:radio[name="edit-current_used"]').filter('[value="' + response.current_used + '"]').attr('checked', true);
					$('input:radio[name="edit-status"]').filter('[value="' + response.active + '"]').attr('checked', true);
					
				} else {
					Messenger().post({
						message: 'Server <b>ID ' + server_id + '</b>: Failed getting server details!',
						type: 'error'
					});
				}				
		}, "json"); 					
	});	
	
	//Edit Save
	$("body").on('click', "button[id='edit-save']", function(event) {		
		event.preventDefault();
		var server_id = $('#edit-id').val();
		if (!hasErrors("input[id*='edit-']") && !hasErrors("textarea[id*='edit-']")) {
			//save code
			$('#edit_server_' + server_id).html('<i class="small-loader"></i>');			
			var serverData = {
				id 		     : $('#edit-id').val(),
				url 		 : $('#edit-url').val(),
				video_url 	 : $('#edit-video_url').val(),
				server_ip 	 : $('#edit-server_ip').val(),
				ftp_username : $('#edit-ftp_username').val(),
				ftp_password : $('#edit-ftp_password').val(),
				ftp_root 	 : $('#edit-ftp_root').val(),
				current_used : $('input[name="edit-current_used"]:checked').val(),				
				active		 : $('input[name="edit-status"]:checked').val(),
			};
			
			$.post(base_url + '/ajax/admin_save_server', { data: serverData },
				function (response) {					
					$('#editModal').modal('hide');
					if (response.status) {
						Messenger().post({
							message: 'Server <b>ID ' + server_id + '</b>: Successfully updated!',
							type: 'success'
						});
						$('#url-' + server_id).text(serverData.url);
						if (serverData.active == 1) {
							$('#status_server_' + server_id).attr('data-status', 1);							
							$('#status_server_' + server_id).attr('alt', 'Suspend');
							$('#status_server_' + server_id).attr('title', 'Suspend');
							$('#status_server_' + server_id).html('<i class="fa fa-times"></i>');
							$('#status-' + server_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							$('#status_server_' + server_id).attr('data-status', 0);
							$('#status_server_' + server_id).attr('alt', 'Activate');
							$('#status_server_' + server_id).attr('title', 'Activate');
							$('#status_server_' + server_id).html('<i class="fa fa-check"></i>');
							$('#status-' + server_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}
						if (serverData.current_used == 1) {
							$('#used_server_' + server_id).attr('data-used', 1);							
							$('#used_server_' + server_id).attr('alt', 'Disable Usage');
							$('#used_server_' + server_id).attr('title', 'Disable Usage');
							$('#used_server_' + server_id).html('<i class="fa fa-times-circle-o"></i>');
							$('#used-' + server_id).html('<span class="text-info" alt="Enabled" title="Enabled">Yes</span>');							
						} else {
							$('#used_server_' + server_id).attr('data-used', 0);
							$('#used_server_' + server_id).attr('alt', 'Enable Usage');
							$('#used_server_' + server_id).attr('title', 'Enable Usage');
							$('#used_server_' + server_id).html('<i class="fa fa-check-circle-o"></i>');
							$('#used-' + server_id).html('<span class="text-red" alt="Disabled" title="Disabled">No</span>');
						}						
					} else {
						Messenger().post({
							message: 'Server <b>ID ' + server_id + '</b>: Failed updating!',
							type: 'error'
						});
					}
					$('#edit_server_' + server_id).html('<i class="fa fa-pencil"></i>');	
			}, "json");			
		}
		
	});

    $("body").on('click', "a[id*='used_server_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing-used');
		if (processing == 0) {
			$(this).attr('data-processing-used', 1);	
			var server_used = $(this).attr('data-used');
			var id = $(this).attr('id');
			var split = id.split('_');
			var server_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_used_server', { server_id: server_id, server_used: server_used},
				function (response) {
					if (response.status) {
						if (server_used == 0) {
							Messenger().post({
								message: 'Server <b>ID ' + server_id + '</b>: Successfully enabled!',
								type: 'success'
							});						
							$('#used_server_' + server_id).attr('data-used', 1);							
							$('#used_server_' + server_id).attr('alt', 'Disable Usage');
							$('#used_server_' + server_id).attr('title', 'Disable Usage');
							$('#used_server_' + server_id).html('<i class="fa fa-times-circle-o"></i>');
							$('#used-' + server_id).html('<span class="text-info" alt="Enabled" title="Enabled">Yes</span>');					
						} else {
							Messenger().post({
								message: 'Server <b>ID ' + server_id + '</b>: Successfully disabled!',
								type: 'success'
							});
							$('#used_server_' + server_id).attr('data-used', 0);
							$('#used_server_' + server_id).attr('alt', 'Enable Usage');
							$('#used_server_' + server_id).attr('title', 'Enable Usage');
							$('#used_server_' + server_id).html('<i class="fa fa-check-circle-o"></i>');
							$('#used-' + server_id).html('<span class="text-red" alt="Disabled" title="Disabled">No</span>');
						}

					} else {
						if (server_used == 0) {
							Messenger().post({
								message: 'Server <b>ID ' + server_id + '</b>: Failed enabling or already enabled!',
								type: 'error'
							});
							$('#used_server_' + server_id).html('<i class="fa fa-check"></i>');							
						} else {
							Messenger().post({
								message: 'Server <b>ID ' + server_id + '</b>: Failed disabling or already disabled!',
								type: 'error'
							});
							$('#used_server_' + server_id).html('<i class="fa fa-times"></i>');							
						}
					}
					$('#used_server_' + server_id).attr('data-processing-used', 0);
			}, "json"); 			
		}
	});	
	
	//Validate
	validateString('#edit-url',1);
	validateString('#edit-video_url',1);
	validateString('#edit-server_ip',1);	
	validateString('#edit-ftp_username',1);
	validateString('#edit-ftp_password',1);
	
	$(window).on('resize', function(){	
		if ($(window).width()>768) {
			var modal_ml = parseInt(($(window).width()-$('#editModalDialog').width())/2);
			$('#editModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
		} else {
			$('#editModalDialog').css('margin-left','10px');
			$('#editModalDialog').css('margin-right','10px');
		}
		
	});			
	
});
function validateString(input,ml) {
	$(input).change(function(){
		if($(this).val().length < ml) {
			$(this).addClass('error');
		} else {
			$(this).removeClass('error');
		}
	});	
}

function validateNumber(input,dv) {
	$(input).change(function(){
		var iv = parseInt($(this).val().match(/\d+/));
		if (isNaN(iv)) {
			iv = dv;
		}
		$(this).val(iv);
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

function thumbsLoaded(video_id) {
	var imgs = $('#thumbnails-container img').not(function() { return this.complete; });
	var count = imgs.length;
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#thumbnailsModal').modal('show');
				$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');
			}
		});
	} else {
		$('#thumbnailsModal').modal('show');
		$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');		
	}
}

function thumbsReLoaded(video_id) {
	var imgs = $('#thumbnails-container-rel img').not(function() { return this.complete; });
	var count = imgs.length;
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#thumbnails-container').html($('#thumbnails-container-rel').html());
				$('#thumbnails-loading').hide();
				$('#thumbnails-processing').val('0');
				$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');
			}
		});
	} else {		
		$('#thumbnails-container').html($('#thumbnails-container-rel').html());
		$('#thumbnails-loading').hide();
		$('#thumbnails-processing').val('0');
		$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');		
	}
}

$(document).ready(function(){
		
	$("#filter_active").select2();
	$("#filter_active").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#filter_channel").select2();
	//$("#filter_channel").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#filter_type").select2();
	$("#filter_type").select2 ('container').find ('.select2-search').addClass ('hidden');		
	$("#edit-category").select2();
	//$("#edit-category").select2 ('container').find ('.select2-search').addClass ('hidden');
	
	$('#check_all_videos').change(function() {
		var checkboxes = $(this).closest('form').find(':checkbox');
		if($(this).is(':checked')) {
			checkboxes.prop('checked', true);
			$('.item-main-container').addClass('selected');
		} else {
			checkboxes.prop('checked', false);
			$('.item-main-container').removeClass('selected');
		}
	});
	
	//Multiple Selection
	var checkboxes = $('.select-multiple');
	var lastChecked = null;	
	checkboxes.click(function(e) {
		if(!lastChecked) {
			lastChecked = this;
			return;
		}
		if(e.shiftKey) {
			var start = checkboxes.index(this);
			var end = checkboxes.index(lastChecked);
			if (lastChecked.checked) {
				checkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);				
				checkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).closest('.item-main-container').addClass('selected');
			} else {
				$(this).prop('checked', true);
			}
		}
		lastChecked = this;
	});

	$('input[type=checkbox]').each(function () {
		 $(this).change(function() {
		   if (this.checked) {
			   $(this).closest('.item-main-container').addClass('selected');
		   } else {
			   $(this).closest('.item-main-container').removeClass('selected');
		   }
		});
	});	
	
    $("img[id*='change_tmb_']").click(function(event) {
        event.preventDefault();
        var click_id    = $(this).attr('id');
        var id_split    = click_id.split('_');
        var vkey        = id_split[2];
        var thumb       = id_split[3];
        for( var i=1; i<=20; i++ ) {
            if ( i == thumb ) {
				$(this).addClass('tmb-active');		
				$(this).removeClass('tmb');		
            } else {
                $('#change_tmb_' + vkey + '_' + i).removeClass('tmb-active');				
				$('#change_tmb_' + vkey + '_' + i).addClass('tmb');				
            }
        }
        $("input[id='" + vkey + "']").val(thumb);
    });

	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'v.VID';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
		document.getElementById('display_items').innerText = '100';
		document.getElementById('display').value = '100';
		
		$("#filter_channel").select2("val", "");
		$("#filter_active").select2("val", "");
		$("#filter_type").select2("val", "");
		
		$("select[id*='filter_']" ).each(function() {
			$(this).select2("val", "");
			$(this).removeClass("filter-active");	
		});

		$("input[id*='filter_']" ).each(function() {
			var id = $(this).attr('id');
			var split = id.split('_');
			var filter_name = split[1];		
			$(this).val("");
			$(this).removeClass("filter-active");
			$("i[id='filter_remove_" + filter_name + "']").hide();
		});
	});	

    $("body").on('click', "i[id*='filter_remove_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var filter_name = split[2];
		$("input[name='" + filter_name + "']").val('');
		$("input[name='" + filter_name + "']").removeClass("filter-active");
		$(this).hide();
    });

	$("input[id*='filter_']" ).each(function() {
		var id = $(this).attr('id');
		var split = id.split('_');
		var filter_name = split[1];		
		$(this).on('input', function() {
			if($(this).val() != '') {
				$("i[id='filter_remove_" + filter_name + "']").show();
				$(this).addClass("filter-active");
			} else {
				$("i[id='filter_remove_" + filter_name + "']").hide();
				$(this).removeClass("filter-active");
			}
		});
	});	

	$("select[id*='filter_']" ).each(function() {
		var id = $(this).attr('id');
		var split = id.split('_');
		var filter_name = split[1];		
		if($(this).val() != '') {
			$("#s2id_" + id).addClass("filter-active");
		}
	});	
	
	$("select[id*='filter_']" ).each(function() {
		var id = $(this).attr('id');
		var split = id.split('_');
		var filter_name = split[1];		
		$(this).change(function() {
			if($(this).val() != '') {
				$("#s2id_" + id).addClass("filter-active");
			} else {
				$("#s2id_" + id).removeClass("filter-active");
			}
		});
	});
	
	//Ajax:

    $("body").on('click', "a[id='view_del_video']", function(event) {
        event.preventDefault();	
		var video_id = $(this).attr("data-id");
		$.post(base_url + '/ajax/admin_delete_video', { video_id: video_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#viewModal').modal('hide');					
					$('#item-' + video_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});	
	
    $("body").on('click', "a[id*='delete_video_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var video_id = split[2];
		$('#delete__video_' + video_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_video', { video_id: video_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#item-' + video_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

    $("body").on('click', "a[id*='unflag_video_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var f_id = split[2];
		var video_id = split[3];		
		$('#unflag__video_' + video_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_unflag_video', { f_id: f_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Successfully unflagged!',
						type: 'success'
					});
					$('#item-' + video_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Unflag failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});
	
    $("body").on('click', "a[id*='thumb_video_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);			
			var id = $(this).attr('id');
			var split = id.split('_');
			var video_id = split[2];
			$('#thumb__video_' + video_id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_thumb_video', { video_id: video_id },
				function (response) {
					if (response.status) {
						Messenger().post({
							message: 'Video <b>ID ' + video_id + '</b>: Successfully regenerated thumbnails!',
							type: 'success'
						});
						d = new Date();
						$('#thumb-' + video_id).attr('src', response.src + '?' + d.getTime());
					} else {
						Messenger().post({
							message: 'Video <b>ID ' + video_id + '</b>: Failed regenerating thumbnails!',
							type: 'error'
						});
					}
					$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');
					$('#thumb_video_' + video_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});	
	
    $("body").on('click', "a[id*='duration_video_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);	
			var id = $(this).attr('id');
			var split = id.split('_');
			var video_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_duration_video', { video_id: video_id },
				function (response) {
					if (response.status) {
						Messenger().post({
							message: 'Video <b>ID ' + video_id + '</b>: Successfully regenerated duration!',
							type: 'success'
						});
						$('#duration-' + video_id).text(response.duration);
					} else {
						Messenger().post({
							message: 'Video <b>ID ' + video_id + '</b>: Failed regenerating duration!',
							type: 'error'
						});
					}
					$('#' + id).html('<i class="fa fa-clock-o"></i>');
					$('#duration_video_' + video_id).attr('data-processing', 0);					
			}, "json"); 			
		}
	});	
	
    $("body").on('click', "a[id*='status_video_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);	
			var video_status = $(this).attr('data-status');
			var id = $(this).attr('id');
			var split = id.split('_');
			var video_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_status_video', { video_id: video_id, video_status: video_status},
				function (response) {
					if (response.status) {
						if (video_status == 0) {
							Messenger().post({
								message: 'Video <b>ID ' + video_id + '</b>: Successfully activated!',
								type: 'success'
							});						
							$('#status_video_' + video_id).attr('data-status', 1);							
							$('#status_video_' + video_id).attr('alt', 'Suspend');
							$('#status_video_' + video_id).attr('title', 'Suspend');
							$('#status_video_' + video_id).html('<i class="fa fa-times"></i>');
							$('#status-' + video_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							Messenger().post({
								message: 'Video <b>ID ' + video_id + '</b>: Successfully suspended!',
								type: 'success'
							});
							$('#status_video_' + video_id).attr('data-status', 0);
							$('#status_video_' + video_id).attr('alt', 'Activate');
							$('#status_video_' + video_id).attr('title', 'Activate');
							$('#status_video_' + video_id).html('<i class="fa fa-check"></i>');
							$('#status-' + video_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}

					} else {
						if (video_status == 0) {
							Messenger().post({
								message: 'Video <b>ID ' + video_id + '</b>: Failed activating or already active!',
								type: 'error'
							});
							$('#status_video_' + video_id).html('<i class="fa fa-check"></i>');							
						} else {
							Messenger().post({
								message: 'Video <b>ID ' + video_id + '</b>: Failed suspending or already inactive!',
								type: 'error'
							});
							$('#status_video_' + video_id).html('<i class="fa fa-times"></i>');							
						}
					}
					$('#status_video_' + video_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});	
	
	//View Video
    $("body").on('click', "a[id*='view_video_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var video_id = split[2];		
		$.post(base_url + '/ajax/admin_get_video', { video_id: video_id },
			function (response) {
				if (response.status) {
					//Load Video Data
					$('#view_del_video').attr('data-id', response.VID);										
					$('#view-id-span').text(response.VID);
					$('#view-id').val(response.VID);
					$('#view-title').text(response.title);
					$('#view-vplayer-container').attr('src', base_url + '/siteadmin/view.php?VID=' + video_id);
					$('#viewModal').modal('show');
					
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Failed getting video details!',
						type: 'error'
					});
				}				
		}, "json");	
	});		
	
	//Close View Modal
	$('#viewModal').on('hidden.bs.modal', function () {
		$('#view-vplayer-container').attr('src', '');
		$('#view_del_video').attr('data-id', '');
	})		
	
	//Edit Video
    $("body").on('click', "a[id*='edit_video_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var video_id = split[2];


		$.post(base_url + '/ajax/admin_get_video', { video_id: video_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Video Data
					$('#edit-id-span').text(response.VID);					
					$('#edit-id').val(response.VID);
					$('#edit-title').val(response.title);
					$('#edit-description').val(response.description);
					$('#edit-tags').val(response.keyword);
					$('#edit-category').val(response.channel);	
					$('#edit-category').select2('val', response.channel);
					$('input:radio[name="edit-type"]').filter('[value="' + response.type + '"]').attr('checked', true);
					$('input:radio[name="edit-active"]').filter('[value="' + response.active + '"]').attr('checked', true);
					$('input:radio[name="edit-featured"]').filter('[value="' + response.featured + '"]').attr('checked', true);
					$('input:radio[name="edit-be_comment"]').filter('[value="' + response.be_comment + '"]').attr('checked', true);
					$('input:radio[name="edit-be_rated"]').filter('[value="' + response.be_rated + '"]').attr('checked', true);
					$('input:radio[name="edit-embed"]').filter('[value="' + response.embed + '"]').attr('checked', true);					
					$('#edit-server').val(response.server);
					$('#edit-likes').val(response.likes);
					$('#edit-dislikes').val(response.dislikes);
					$('#edit-viewnumber').val(response.viewnumber);

					//Adjust margin left to integer value - Center
					var modal_ml = parseInt(($(window).width()-$('#editModalDialog').width())/2);					
					$('#editModal').modal('show');
					if ($(window).width()>768) {
						$('#editModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
					}
					
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Failed getting video details!',
						type: 'error'
					});
				}				
		}, "json"); 		
	});	

	//Reset
	$("body").on('click', "button[id='edit-reset']", function(event) {
        event.preventDefault();
		var video_id = $('#edit-id').val();

		$.post(base_url + '/ajax/admin_get_video', { video_id: video_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Video Data
					$('#edit-title').val(response.title);
					$('#edit-description').val(response.description);
					$('#edit-tags').val(response.keyword);
					$('#edit-category').val(response.channel);	
					$('#edit-category').select2('val', response.channel);
					$('input:radio[name="edit-type"]').filter('[value="' + response.type + '"]').attr('checked', true);
					$('input:radio[name="edit-active"]').filter('[value="' + response.active + '"]').attr('checked', true);
					$('input:radio[name="edit-featured"]').filter('[value="' + response.featured + '"]').attr('checked', true);
					$('input:radio[name="edit-be_comment"]').filter('[value="' + response.be_comment + '"]').attr('checked', true);
					$('input:radio[name="edit-be_rated"]').filter('[value="' + response.be_rated + '"]').attr('checked', true);
					$('input:radio[name="edit-embed"]').filter('[value="' + response.embed + '"]').attr('checked', true);					
					$('#edit-server').val(response.server);
					$('#edit-likes').val(response.likes);
					$('#edit-dislikes').val(response.dislikes);
					$('#edit-viewnumber').val(response.viewnumber);
					
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Failed getting video details!',
						type: 'error'
					});
				}				
		}, "json"); 					
	});	
	
	//Edit Save
	$("body").on('click', "button[id='edit-save']", function(event) {		
		event.preventDefault();
		var video_id = $('#edit-id').val();
		if (!hasErrors("input[id*='edit-']") && !hasErrors("textarea[id*='edit-']")) {
			//save code
			$('#edit_video_' + video_id).html('<i class="small-loader"></i>');			
			var videoData = {
				id 		    : $('#edit-id').val(),
				title 		: $('#edit-title').val(),
				description : $('#edit-description').val(),
				tags		: $('#edit-tags').val().replace(/\n/g, " ").replace(/\r/g, " ").replace(/\t/g, " "),
				category	: $('#edit-category').val(),
				type		: $('input[name="edit-type"]:checked').val(),
				active		: $('input[name="edit-active"]:checked').val(),
				featured	: $('input[name="edit-featured"]:checked').val(),
				be_comment	: $('input[name="edit-be_comment"]:checked').val(),
				be_rated	: $('input[name="edit-be_rated"]:checked').val(),
				embed		: $('input[name="edit-embed"]:checked').val(),
				server		: $('#edit-server').val(),
				likes		: $('#edit-likes').val(),
				dislikes	: $('#edit-dislikes').val(),
				viewnumber	: $('#edit-viewnumber').val()
			};
			
			$.post(base_url + '/ajax/admin_save_video', { data: videoData },
				function (response) {					
					$('#editModal').modal('hide');
					if (response.status) {
						Messenger().post({
							message: 'Video <b>ID ' + video_id + '</b>: Successfully updated2!',
							type: 'success'
						});
						$('#title-' + video_id).text(videoData.title);
						if (videoData.active == 1) {
							$('#status_video_' + video_id).attr('data-status', 1);							
							$('#status_video_' + video_id).attr('alt', 'Suspend');
							$('#status_video_' + video_id).attr('title', 'Suspend');
							$('#status_video_' + video_id).html('<i class="fa fa-times"></i>');
							$('#status-' + video_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							$('#status_video_' + video_id).attr('data-status', 0);
							$('#status_video_' + video_id).attr('alt', 'Activate');
							$('#status_video_' + video_id).attr('title', 'Activate');
							$('#status_video_' + video_id).html('<i class="fa fa-check"></i>');
							$('#status-' + video_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}
						if (videoData.type == 'public') {
							$('#private-' + video_id).html('');
						} else {
							$('#private-' + video_id).html('<div class="item-private">PRIVATE</div>');
						}						
						$('#views-' + video_id).text(videoData.viewnumber);
					} else {
						Messenger().post({
							message: 'Video <b>ID ' + video_id + '</b>: Failed updating!',
							type: 'error'
						});
					}
					$('#edit_video_' + video_id).html('<i class="fa fa-pencil"></i>');	
			}, "json");			
		}
		
	});

	//Thumbnails
    $("body").on('click', "a[id*='thumbadv_video_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var video_type = $(this).attr('data-type');
		var split = id.split('_');
		var video_id = split[2];
		$('#thumb__video_' + video_id).html('<i class="small-loader"></i>');
		if (video_type == 'embedded') {
			$('#regen-options').hide();
		} else {
			$('#regen-options').show();
		}
		$.post(base_url + '/ajax/admin_get_thumbs_video', { video_id: video_id },
			function (response) {	
				$('#thumbnails-container').html('');				
				if (response.status && response.count > 0) {
					$('#thumbnails-id-span').html(video_id);
					$('#thumbnails-id').val(video_id);					
					$('#thumbnails-default').val(response.thumb);
					$('#thumbnails-processing').val('0');
					if (conf_remove_bb == '0') {
						$('#thumbnails-remove-bb').attr('checked', false);
					} else {
						$('#thumbnails-remove-bb').attr('checked', true);
					}
					if (conf_keep_ar == '0') {					
						$('#thumbnails-keep-ar').attr('checked', false);
					} else {
						$('#thumbnails-keep-ar').attr('checked', true);
					}
					var thumb_block = '';
					var active_class = '';
					//Load Thumbs
					d = new Date();						
					for (i = 1; i <= response.count; i++) {
						if (i == response.thumb) {
							active_class = 'thumb-block-active';
						} else {
							active_class = '';
						}
						thumb_block = '<div id="tb_' + i + '" class="col-xs-6 col-sm-3 col-md-5ths thumb-block ' + active_class + '"><img src="' + response['thumbnails'][i] + '?' + d.getTime() + '" class="img-responsive" title="Main: ' + i + '" alt="Main: ' + i + '" /></div>';
						$("#thumbnails-container").append(thumb_block);
					}
					if (response.player) {
						thumb_block = '<div id="tb-player" class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 thumb-block thumb-block-player"><img src="' + response.player + '?' + d.getTime() + '" class="img-responsive" title="Player Thumbnail" alt="Player Thumbnail" /></div>';
						$("#thumbnails-container").append(thumb_block);					
					}
					thumbsLoaded(video_id);
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Failed getting video thumbnails!',
						type: 'error'
					});
					$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');
				}				
		}, "json"); 		
	});	

	//Thumbnails Reset
	$("body").on('click', "button[id='thumbnails-reset']", function(event) {		
        event.preventDefault();
		var video_id = $('#thumbnails-id').val();
		$('#thumb__video_' + video_id).html('<i class="small-loader"></i>');
		$('#thumbnails-loading').show();
		$.post(base_url + '/ajax/admin_get_thumbs_video', { video_id: video_id },
			function (response) {	
				$('#thumbnails-container-rel').html('');				
				if (response.status && response.count > 0) {
					$('#thumbnails-id-span').html(video_id);
					$('#thumbnails-id').val(video_id);					
					$('#thumbnails-default').val(response.thumb);
					if (conf_remove_bb == '0') {
						$('#thumbnails-remove-bb').attr('checked', false);
					} else {
						$('#thumbnails-remove-bb').attr('checked', true);
					}
					if (conf_keep_ar == '0') {					
						$('#thumbnails-keep-ar').attr('checked', false);
					} else {
						$('#thumbnails-keep-ar').attr('checked', true);
					}
					var thumb_block = '';
					var active_class = '';
					//Load Thumbs
					d = new Date();	
					for (i = 1; i <= response.count; i++) {
						if (i == response.thumb) {
							active_class = 'thumb-block-active';
						} else {
							active_class = '';
						}
						thumb_block = '<div id="tb_' + i + '" class="col-xs-6 col-sm-3 col-md-5ths thumb-block ' + active_class + '"><img src="' + response['thumbnails'][i] + '?' + d.getTime() + '" class="img-responsive" title="Main: ' + i + '" alt="Main: ' + i + '" /></div>';
						$("#thumbnails-container-rel").append(thumb_block);
					}
					if (response.player) {
						thumb_block = '<div id="tb-player" class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 thumb-block thumb-block-player"><img src="' + response.player + '?' + d.getTime() + '" class="img-responsive" title="Player Thumbnail" alt="Player Thumbnail" /></div>';
						$("#thumbnails-container-rel").append(thumb_block);					
					}
					thumbsReLoaded(video_id);
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Failed getting video thumbnails!',
						type: 'error'
					});
					$('#thumbnails-loading').hide();					
					$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');
				}				
		}, "json"); 		
	});		

	//Thumbnails Regen
	$("body").on('click', "button[id*='thumbnails-regen-']", function(event) {		
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('-');
		var target = split[2];		
		var video_id = $('#thumbnails-id').val();
		var black_bars = 0;
		var keep_ar = 0;		
		if ($('#thumbnails-remove-bb').is(':checked')) {
			black_bars = 1;
		}
		if ($('#thumbnails-keep-ar').is(':checked')) {
			keep_ar = 1;
		}		
		$('#thumb__video_' + video_id).html('<i class="small-loader"></i>');
		$('#thumbnails-loading').show();
		if ($('#thumbnails-processing').val() == '0') {
			$('#thumbnails-processing').val('1');			
			$.post(base_url + '/ajax/admin_thumbnails_video', { video_id: video_id, target: target, black_bars: black_bars, keep_ar: keep_ar },
				function (response) {	
					$('#thumbnails-container-rel').html('');				
					if (response.status && response.count > 0) {
						$('#thumbnails-id-span').html(video_id);
						$('#thumbnails-id').val(video_id);					
						$('#thumbnails-default').val(response.thumb);
						var thumb_block = '';
						var active_class = '';
						//Load Thumbs
						d = new Date();	
						for (i = 1; i <= response.count; i++) {
							if (i == response.thumb) {
								active_class = 'thumb-block-active';
							} else {
								active_class = '';
							}
							thumb_block = '<div id="tb_' + i + '" class="col-xs-6 col-sm-3 col-md-5ths thumb-block ' + active_class + '"><img src="' + response['thumbnails'][i] + '?' + d.getTime() + '" class="img-responsive" title="Main: ' + i + '" alt="Main: ' + i + '" /></div>';
							$("#thumbnails-container-rel").append(thumb_block);
						}
						if (response.player) {
							thumb_block = '<div id="tb-player" class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 thumb-block thumb-block-player"><img src="' + response.player + '?' + d.getTime() + '" class="img-responsive" title="Player Thumbnail" alt="Player Thumbnail" /></div>';
							$("#thumbnails-container-rel").append(thumb_block);					
						}
						thumbsReLoaded(video_id);
					} else {
						Messenger().post({
							message: 'Video <b>ID ' + video_id + '</b>: Failed getting video thumbnails!',
							type: 'error'
						});
						$('#thumbnails-loading').hide();					
						$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');
						$('#thumbnails-processing').val('0');
					}				
			}, "json");
		}
	});	
	
	//Thumbnails Save
	$("body").on('click', "button[id='thumbnails-save']", function(event) {		
		event.preventDefault();
		var video_id = $('#thumbnails-id').val();
		var thumbnails_default = $('#thumbnails-default').val();		
		//save code	
		$('#thumb__video_' + video_id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_save_thumbnails', { video_id: video_id, thumbnails_default: thumbnails_default },
			function (response) {					
				$('#thumbnailsModal').modal('hide');
				if (response.status) {						
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Thumbnails successfully updated!',
						type: 'success'
					});
					d = new Date();					
					$('#thumb-' + video_id).attr('src', response.src + '?' + d.getTime());
				} else {
					Messenger().post({
						message: 'Video <b>ID ' + video_id + '</b>: Thumbnails failed updating!',
						type: 'error'
					});
				}
				$('#thumb__video_' + video_id).html('<i class="fa fa-picture-o"></i>');	
		}, "json");	
	});
	
	
    $("body").on('click', "div[id*='tb_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var thumb_id = split[1];
		for (i = 1; i <= 20; i++) {
			if (i != thumb_id) {
				if ($("#tb_" + i).hasClass('thumb-block-active')) {
					$("#tb_" + i).removeClass('thumb-block-active');
				}
			} else {
				$("#tb_" + i).addClass('thumb-block-active');
			}
		}
		$('#thumbnails-default').val(thumb_id);
	});		
	
	//Close Thumbnails Modal
	$('#thumbnailsModal').on('hidden.bs.modal', function () {
		var video_id = $('#thumbnails-id').val();
		$.post(base_url + '/ajax/admin_delete_tmp', { video_id: video_id},
			function (response) {
		}, "json");			
	})	
	
	//Validate
	validateString('#edit-title',2);
	validateString('#edit-tags',2);
	validateNumber('#edit-likes',0);
	validateNumber('#edit-dislikes',0);
	validateNumber('#edit-viewnumber',0);	
	
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
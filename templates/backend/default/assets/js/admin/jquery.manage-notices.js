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

function thumbLoaded(notice_id) {
	var imgs = $('#notice-thumbnail-container img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/media/notices/tmb/default.jpg');
		});	
	});	
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#thumb_notice_' + notice_id).html('<i class="fa fa-picture-o"></i>');
				$('#notice-thumbnailModal').modal('show');				
			}
		});
	} else {
		$('#thumb_notice_' + notice_id).html('<i class="fa fa-picture-o"></i>');
		$('#notice-thumbnailModal').modal('show');		
	}
}


function startUpload() {
	$('#notice-thumbnail-loading').show();
	return true;
}

function stopUpload(gid, uploaded) {
      var result = '';
      if (uploaded){
		$('#addthumb').replaceWith($('#addthumb').val('').clone(true));
		$('#upaddthumb').html($('#nofile').val());		
		
		d = new Date();	
		$("#notice-thumbnail-img-" + gid).attr("src", base_url + '/media/notices/tmb/' + gid + '.jpg?' + d.getTime());
		$("#thumb-" + gid).attr("src", base_url + '/media/notices/tmb/' + gid + '.jpg?' + d.getTime());
		$('#notice-thumbnail-loading').hide();
	
		Messenger().post({
			message: 'Notice <b>ID ' + gid + '</b>: Thumbnail successfully updated!',
			type: 'success'
		});
      }
      else {
			Messenger().post({
			message: 'Notice <b>ID ' + gid + '</b>: Thumbnail updating failed!',
				type: 'error'
			});			 
      }
    return true;   
}

$(document).ready(function(){
		
	$("#filter_status").select2();
	$("#filter_status").select2 ('container').find ('.select2-search').addClass ('hidden');

	$("#filter_category").select2();	
	$("#edit-category").select2();		
	
	$('#check_all_notices').change(function() {
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
	

	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'n.NID';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
		document.getElementById('display_items').innerText = '100';
		document.getElementById('display').value = '100';
		
		$("#filter_category").select2("val", "");
		$("#filter_status").select2("val", "");
		
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

	//Delete
    $("body").on('click', "a[id='view_del_notice']", function(event) {
        event.preventDefault();	
		var notice_id = $(this).attr("data-id");
		$.post(base_url + '/ajax/admin_delete_notice', { notice_id: notice_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Notice <b>ID ' + notice_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#viewModal').modal('hide');					
					$('#item-' + notice_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Notice <b>ID ' + notice_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});	
	
    $("body").on('click', "a[id*='delete_notice_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var notice_id = split[2];
		$('#delete__notice_' + notice_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_notice', { notice_id: notice_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Notice <b>ID ' + notice_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#item-' + notice_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Notice <b>ID ' + notice_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

	//Status
    $("body").on('click', "a[id*='status_notice_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);	
			var notice_status = $(this).attr('data-status');
			var id = $(this).attr('id');
			var split = id.split('_');
			var notice_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_status_notice', { notice_id: notice_id, notice_status: notice_status},
				function (response) {
					if (response.status) {
						if (notice_status == 0) {
							Messenger().post({
								message: 'Notice <b>ID ' + notice_id + '</b>: Successfully activated!',
								type: 'success'
							});						
							$('#status_notice_' + notice_id).attr('data-status', 1);							
							$('#status_notice_' + notice_id).attr('alt', 'Suspend');
							$('#status_notice_' + notice_id).attr('title', 'Suspend');
							$('#status_notice_' + notice_id).html('<i class="fa fa-times"></i>');
							$('#status-' + notice_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							Messenger().post({
								message: 'Notice <b>ID ' + notice_id + '</b>: Successfully suspended!',
								type: 'success'
							});
							$('#status_notice_' + notice_id).attr('data-status', 0);
							$('#status_notice_' + notice_id).attr('alt', 'Activate');
							$('#status_notice_' + notice_id).attr('title', 'Activate');
							$('#status_notice_' + notice_id).html('<i class="fa fa-check"></i>');
							$('#status-' + notice_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}

					} else {
						if (notice_status == 0) {
							Messenger().post({
								message: 'Notice <b>ID ' + notice_id + '</b>: Failed activating or already active!',
								type: 'error'
							});
							$('#status_notice_' + notice_id).html('<i class="fa fa-check"></i>');							
						} else {
							Messenger().post({
								message: 'Notice <b>ID ' + notice_id + '</b>: Failed suspending or already inactive!',
								type: 'error'
							});
							$('#status_notice_' + notice_id).html('<i class="fa fa-times"></i>');							
						}
					}
					$('#status_notice_' + notice_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});	
	
	//View Notice
    $("body").on('click', "a[id*='view_notice_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var notice_id = split[2];		
		$.post(base_url + '/ajax/admin_get_notice', { notice_id: notice_id, editor: false },
			function (response) {
				if (response.status) {
					//Load Notice Data
					$('#view_del_notice').attr('data-id', response.NID);										
					$('#view-id-span').text(response.NID);
					$('#view-id').val(response.NID);
					$('#view-title').text(response.title);
					$('#view-notice-container').attr('src', base_url + '/siteadmin/view_notice.php?NID=' + notice_id);
					$('#viewModal').modal('show');
					
				} else {
					Messenger().post({
						message: 'Notice <b>ID ' + notice_id + '</b>: Failed getting notice details!',
						type: 'error'
					});
				}				
		}, "json");	
	});		
	
	//Close View Modal
	$('#viewModal').on('hidden.bs.modal', function () {
		$('#view-notice-container').attr('src', '');
		$('#view_del_notice').attr('data-id', '');
	})		
	
	//Edit Notice
    $("body").on('click', "a[id*='edit_notice_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var notice_id = split[2];


		$.post(base_url + '/ajax/admin_get_notice', { notice_id: notice_id, editor: true },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Notice Data
					$('#edit-id-span').text(response.NID);					
					$('#edit-id').val(response.NID);
					$('#edit-title').val(response.title);
					$('#edit-content').data("wysihtml5").editor.setValue(response.content);
					$('#edit-category').val(response.category);	
					$('#edit-category').select2('val', response.category);					
					$('input:radio[name="edit-type"]').filter('[value="' + response.type + '"]').attr('checked', true);
					$('input:radio[name="edit-status"]').filter('[value="' + response.active + '"]').attr('checked', true);
					$('#edit-viewnumber').val(response.total_views);

					//Adjust margin left to integer value - Center
					var modal_ml = parseInt(($(window).width()-$('#editModalDialog').width())/2);					
					$('#editModal').modal('show');
					if ($(window).width()>768) {
						$('#editModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
					}
					
				} else {
					Messenger().post({
						message: 'Notice <b>ID ' + notice_id + '</b>: Failed getting notice details!',
						type: 'error'
					});
				}				
		}, "json"); 		
	});	

	//Reset
	$("body").on('click', "button[id='edit-reset']", function(event) {
        event.preventDefault();
		var notice_id = $('#edit-id').val();

		$.post(base_url + '/ajax/admin_get_notice', { notice_id: notice_id, editor: true },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Notice Data
					$('#edit-id-span').text(response.NID);					
					$('#edit-id').val(response.NID);
					$('#edit-title').val(response.title);
					$('#edit-content').data("wysihtml5").editor.setValue(response.content);
					$('#edit-category').val(response.category);	
					$('#edit-category').select2('val', response.category);					
					$('input:radio[name="edit-type"]').filter('[value="' + response.type + '"]').attr('checked', true);
					$('input:radio[name="edit-status"]').filter('[value="' + response.active + '"]').attr('checked', true);
					$('#edit-viewnumber').val(response.total_views);
					
				} else {
					Messenger().post({
						message: 'Notice <b>ID ' + notice_id + '</b>: Failed getting notice details!',
						type: 'error'
					});
				}				
		}, "json"); 					
	});	
	
	//Edit Save
	$("body").on('click', "button[id='edit-save']", function(event) {		
		event.preventDefault();
		var notice_id = $('#edit-id').val();
		if (!hasErrors("input[id*='edit-']") && !hasErrors("textarea[id*='edit-']")) {
			//save code
			$('#edit_notice_' + notice_id).html('<i class="small-loader"></i>');	
			var noticeData = {
				id 		     : $('#edit-id').val(),
				title 		 : $('#edit-title').val(),
				category	 : $('#edit-category').val(),				
				content		 : $('#edit-content').data("wysihtml5").editor.getValue(),
				active		 : $('input[name="edit-status"]:checked').val(),
				viewnumber	 : $('#edit-viewnumber').val()
			};	
			$.post(base_url + '/ajax/admin_save_notice', { data: noticeData },
				function (response) {					
					$('#editModal').modal('hide');
					if (response.status) {			
						Messenger().post({
							message: 'Notice <b>ID ' + notice_id + '</b>: Successfully updated!',
							type: 'success'
						});
						$('#title-' + notice_id).text(noticeData.title);
						if (noticeData.active == 1) {
							$('#status_notice_' + notice_id).attr('data-status', 1);							
							$('#status_notice_' + notice_id).attr('alt', 'Suspend');
							$('#status_notice_' + notice_id).attr('title', 'Suspend');
							$('#status_notice_' + notice_id).html('<i class="fa fa-times"></i>');
							$('#status-' + notice_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							$('#status_notice_' + notice_id).attr('data-status', 0);
							$('#status_notice_' + notice_id).attr('alt', 'Activate');
							$('#status_notice_' + notice_id).attr('title', 'Activate');
							$('#status_notice_' + notice_id).html('<i class="fa fa-check"></i>');
							$('#status-' + notice_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}
						$('#views-' + notice_id).text(noticeData.viewnumber);
					} else {
						Messenger().post({
							message: 'Notice <b>ID ' + notice_id + '</b>: Failed updating!',
							type: 'error'
						});
					}
					$('#edit_notice_' + notice_id).html('<i class="fa fa-pencil"></i>');	
			}, "json");			
		}
		
	});

	//Validate
	validateString('#edit-title',2);
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
function validateString(input,ml) {
	$(input).change(function(){
		if($.trim($(this).val()).length < ml) {
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

function validateName(input) {
	$(input).change(function(){
		if($.trim($(this).val()).length > 0) {
			var type = $('#edit-type').val();
			var id   = $('#edit-id').val();
			var name = $(this).val();	
			$.post(base_url + '/ajax/admin_check_category', { type: type, id: id, name: name, slug: '' },
				function (response) {
					if (response.status) {
						if(response.name) {
							$('#edit-name').addClass('error');					
						} else {
							$('#edit-name').removeClass('error');
						}
					} else {
					}
			}, "json"); 		
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

function thumbLoaded(category_id) {
	var imgs = $('#category-thumbnail-container img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/media/categories/default.jpg');
		});	
	});	
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#thumb_category_' + category_id).html('<i class="fa fa-picture-o"></i>');
				$('#category-thumbnailModal').modal('show');				
			}
		});
	} else {
		$('#thumb_category_' + category_id).html('<i class="fa fa-picture-o"></i>');
		$('#category-thumbnailModal').modal('show');		
	}
}


function startUpload() {
	$('#category-thumbnail-loading').show();
	return true;
}

function stopUpload(cid, uploaded) {
	var result = '';
	var type = $('#category-thumbnail-type').val();
	if (uploaded) {
		$('#addthumb').replaceWith($('#addthumb').val('').clone(true));
		$('#upaddthumb').html($('#nofile').val());		

		d = new Date();	
		$("#category-thumbnail-img-" + cid).attr("src", base_url + '/media/categories/'+ type +'/' + cid + '.jpg?' + d.getTime());
		$("#thumb-" + cid).attr("src", base_url + '/media/categories/' + type + '/' + cid + '.jpg?' + d.getTime());

		Messenger().post({
			message: 'Category <b>ID ' + cid + '</b>: Thumbnail successfully updated!',
			type: 'success'
		});
	}
	else {
		Messenger().post({
		message: 'Category <b>ID ' + cid + '</b>: Thumbnail updating failed!',
			type: 'error'
		});			 
	}
	$('#category-thumbnail-loading').hide();	  
	return true;   
}

$(document).ready(function(){
		
	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'category_id';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';		
	});	

	//Ajax:
	
	//Delete
    $("body").on('click', "a[id*='delete_category_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var category_type = split[2];		
		var category_id = split[3];
		$('#delete__category_' + category_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_category', { category_type: category_type, category_id: category_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Category <b>ID ' + category_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#item-' + category_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Category <b>ID ' + category_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

	//Edit Category
    $("body").on('click', "a[id*='edit_category_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var category_type = split[2];		
		var category_id = split[3];

		//Load Category Data
		$('#edit-type-span-1').text(category_type);
		$('#edit-type-span-2').text(category_type + 's');
		$('#edit-id-span').text(category_id);
		$('#edit-id').val(category_id);
		$('#edit-type').val(category_type);		
		$('#edit-name').val($('#title-' + category_id).text());
		$('#edit-slug-container').hide();
		$('#edit-status-container').show();
		if($('#status-' + category_id).find('span').text() == 'Active' ) {
			$('input:radio[name="edit-status"]').filter('[value="1"]').attr('checked', true);
		} else {
			$('input:radio[name="edit-status"]').filter('[value="0"]').attr('checked', true);
		}
		$('#edit-update-counter').attr('checked', false);	
		
		//Reset Errors
		$('.form-control').each(function(){
			$(this).removeClass('error');
		});		
		
		//Adjust margin left to integer value - Center
		var modal_ml = parseInt(($(window).width()-$('#editModalDialog').width())/2);					
		$('#editModal').modal('show');
		if ($(window).width()>768) {
			$('#editModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
		}
				
		$('#editModal').modal('show');
		
	});	

	//Reset
	$("body").on('click', "button[id='edit-reset']", function(event) {
        event.preventDefault();
		var category_id = $('#edit-id').val();

		//Reset Errors
		$('.form-control').each(function(){
			$(this).removeClass('error');
		});
		
		//Load Category Data
		$('#edit-name').val($('#title-' + category_id).text());
		$('#edit-update-counter').attr('checked', false);
		if($('#status-' + category_id).find('span').text() == 'Active' ) {
			$('input:radio[name="edit-status"]').filter('[value="1"]').attr('checked', true);
		} else {
			$('input:radio[name="edit-status"]').filter('[value="0"]').attr('checked', true);
		}		
				
	});	
	
	//Edit Save
	$("body").on('click', "button[id='edit-save']", function(event) {		
		event.preventDefault();
		var category_id   = $('#edit-id').val();
		var category_type = $('#edit-type').val();
		var counter = false;
		if ($('#edit-update-counter').is(":checked")) {
		  counter = true;
		}		
		if (!hasErrors("input[id*='edit-']")) {
			//save code
			$('#edit_category_' + category_id).html('<i class="small-loader"></i>');			
			var categoryData = {
				id 		     : $('#edit-id').val(),
				type	     : $('#edit-type').val(),
				name 		 : $('#edit-name').val(),				
				slug		 : '',
				active		: $('input[name="edit-status"]:checked').val(),				
				counter 	 : counter
			};
			
			$.post(base_url + '/ajax/admin_save_category', { data: categoryData },
				function (response) {					
					$('#editModal').modal('hide');
					if (response.status) {						
						Messenger().post({
							message: 'Category <b>ID ' + category_id + '</b>: Successfully updated!',
							type: 'success'
						});
						$('#title-' + category_id).text(response.name);
						$('#slug-' + category_id).text(response.slug);
						if (response.total != null) {
							$('#total-items-' + category_id).text(response.total);
						}
						if (categoryData.active == 1) {
							$('#status_category_' + category_id).attr('data-status', 1);							
							$('#status_category_' + category_id).attr('alt', 'Suspend');
							$('#status_category_' + category_id).attr('name', 'Suspend');
							$('#status_category_' + category_id).html('<i class="fa fa-times"></i>');
							$('#status-' + category_id).html('<span class="text-green" alt="Active" name="Active">Active</span>');							
						} else {
							$('#status_category_' + category_id).attr('data-status', 0);
							$('#status_category_' + category_id).attr('alt', 'Activate');
							$('#status_category_' + category_id).attr('name', 'Activate');
							$('#status_category_' + category_id).html('<i class="fa fa-check"></i>');
							$('#status-' + category_id).html('<span class="text-red" alt="Inactive" name="Inactive">Inactive</span>');
						}							
					} else {
						Messenger().post({
							message: 'Category <b>ID ' + category_id + '</b>: Failed updating!',
							type: 'error'
						});
					}
					$('#edit_category_' + category_id).html('<i class="fa fa-pencil"></i>');	
			}, "json");			
		}
		
	});

	//Status
    $("body").on('click', "a[id*='status_category_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);	
			var category_status = $(this).attr('data-status');
			var id = $(this).attr('id');
			var split = id.split('_');
			var category_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_status_category', { category_id: category_id, category_status: category_status},
				function (response) {
					if (response.status) {
						if (category_status == 0) {
							Messenger().post({
								message: 'Category <b>ID ' + category_id + '</b>: Successfully activated!',
								type: 'success'
							});						
							$('#status_category_' + category_id).attr('data-status', 1);							
							$('#status_category_' + category_id).attr('alt', 'Suspend');
							$('#status_category_' + category_id).attr('title', 'Suspend');
							$('#status_category_' + category_id).html('<i class="fa fa-times"></i>');
							$('#status-' + category_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							Messenger().post({
								message: 'Category <b>ID ' + category_id + '</b>: Successfully suspended!',
								type: 'success'
							});
							$('#status_category_' + category_id).attr('data-status', 0);
							$('#status_category_' + category_id).attr('alt', 'Activate');
							$('#status_category_' + category_id).attr('title', 'Activate');
							$('#status_category_' + category_id).html('<i class="fa fa-check"></i>');
							$('#status-' + category_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}

					} else {
						if (category_status == 0) {
							Messenger().post({
								message: 'Category <b>ID ' + category_id + '</b>: Failed activating or already active!',
								type: 'error'
							});
							$('#status_category_' + category_id).html('<i class="fa fa-check"></i>');							
						} else {
							Messenger().post({
								message: 'Category <b>ID ' + category_id + '</b>: Failed suspending or already inactive!',
								type: 'error'
							});
							$('#status_category_' + category_id).html('<i class="fa fa-times"></i>');							
						}
					}
					$('#status_category_' + category_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});	

	//Validate
	validateString('#edit-name',1);
	validateName('#edit-name');
	
});
function nl2br (str, is_xhtml) {   
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function validateDate(dtValue) {
	var dtRegex = new RegExp(/\b\d{1,2}[\/-]\d{1,2}[\/-]\d{4}\b/);
	return dtRegex.test(dtValue);
}


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

function validateEmail(input) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	$(input).change(function(){
		var email = $(this).val();
		var uid = $('#edit-id').val();		
		if(re.test(email)) {
			$.post(base_url + '/ajax/admin_check_user_email', { uid: uid, email: email },
				function (response) {
					if (response.status) {
						if (response.valid) {
							$(input).removeClass('error');	
						} else {
							$(input).addClass('error');
						}
					}
			}, "json"); 			
		} else {
			$(this).addClass('error');
		}		
	});
}

function validatePassword(input1,input2,ml) {
	$(input1).change(function(){
		if($(input1).val() ==  $(input2).val() && ($(input1).val().length >= ml || $(input1).val()=='')) {
			$(input1).removeClass('error');
			$(input2).removeClass('error');
		} else {
			$(input1).addClass('error');			
			$(input2).addClass('error');
		} 
	});
	$(input2).change(function(){
		if($(input1).val() ==  $(input2).val() && ($(input1).val().length >= ml || $(input1).val()=='')) {
			$(input1).removeClass('error');
			$(input2).removeClass('error');
		} else {
			$(input1).addClass('error');			
			$(input2).addClass('error');
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

function thumbLoaded(user_id) {
	var imgs = $('#user-thumbnail-container img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			var thumb_src = $('#thumb-' + user_id).attr('src');
			$(this).attr('src', thumb_src);
		});	
	});	
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#thumb_user_' + user_id).html('<i class="fa fa-picture-o"></i>');
				$('#user-thumbnailModal').modal('show');				
			}
		});
	} else {
		$('#thumb_user_' + user_id).html('<i class="fa fa-picture-o"></i>');
		$('#user-thumbnailModal').modal('show');		
	}
}


function startUpload() {
	$('#user-thumbnail-loading').show();
	return true;
}

function stopUpload(uid, uploaded, remove, gender) {	
	if (remove) {
			$('#user-thumbnail-remove-container').hide();
			$('#user-thumbnail-remove').attr('checked', false);		
			if (gender == '') {
				gender = 'Male';
			}
			$("#user-thumbnail-img-" + uid).attr("src", base_url + '/media/users/nopic-' + gender + '.gif');
			$("#thumb-" + uid).attr("src", base_url + '/media/users/nopic-' + gender + '.gif');
			Messenger().post({
				message: 'User <b>ID ' + uid + '</b>: Thumbnail successfully updated!',
				type: 'success'
			});		
	} else {
		if (uploaded) {
			$('#user-thumbnail-remove-container').show();
			$('#user-thumbnail-remove').attr('checked', false);
			d = new Date();	
			$("#user-thumbnail-img-" + uid).attr("src", base_url + '/media/users/' + uid + '.jpg?' + d.getTime());
			$("#thumb-" + uid).attr("src", base_url + '/media/users/' + uid + '.jpg?' + d.getTime());
			Messenger().post({
				message: 'User <b>ID ' + uid + '</b>: Thumbnail successfully updated!',
				type: 'success'
			});
		}
		else {
			Messenger().post({
			message: 'User <b>ID ' + uid + '</b>: Thumbnail updating failed!',
				type: 'error'
			});			 
		}
	}
	$('#addthumb').replaceWith($('#addthumb').val('').clone(true));
	$('#upaddthumb').html($('#nofile').val());	
	$('#user-thumbnail-loading').hide();	  
    return true;   
}

$(document).ready(function(){
		
	$("#filter_status").select2();
	$("#filter_status").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#filter_gender").select2();
	$("#filter_gender").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#filter_emailverified").select2();
	$("#filter_emailverified").select2 ('container').find ('.select2-search').addClass ('hidden');		
	$('#filter_premium').select2();
	$('#filter_premium').select2 ('container').find ('.select2-search').addClass ('hidden');	
	$("#edit-relationship").select2();
	$("#edit-relationship").select2 ('container').find ('.select2-search').addClass ('hidden');	
	$('#edit-interested').select2();
	$('#edit-interested').select2 ('container').find ('.select2-search').addClass ('hidden');
	$('#edit-country').select2();
	
	$('#check_all_users').change(function() {
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
		document.getElementById('sort').value = 'UID';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
		document.getElementById('display_items').innerText = '100';
		document.getElementById('display').value = '100';
		
		$("#filter_gender").select2("val", "");
		$("#filter_status").select2("val", "");
		$("#filter_emailverified").select2("val", "");
		
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

	$( "#reset_search_flagged" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'u.UID';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
		document.getElementById('display_items').innerText = '100';
		document.getElementById('display').value = '100';
		
		$("#filter_gender").select2("val", "");
		$("#filter_status").select2("val", "");
		$("#filter_emailverified").select2("val", "");
		
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

    $("body").on('click', "a[id='view_del_user']", function(event) {
        event.preventDefault();	
		var user_id = $(this).attr("data-id");
		$.post(base_url + '/ajax/admin_delete_user', { user_id: user_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#viewModal').modal('hide');					
					$('#item-' + user_id).fadeOut();
				} else {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});	
	
    $("body").on('click', "a[id*='delete_user_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var user_id = split[2];
		$('#delete__user_' + user_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_user', { user_id: user_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#item-' + user_id).fadeOut();
				} else {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

    $("body").on('click', "a[id*='unflag_user_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var f_id = split[2];
		var user_id = split[3];		
		$('#unflag__user_' + user_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_unflag_user', { f_id: f_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Successfully unflagged!',
						type: 'success'
					});
					$('#item-' + user_id).fadeOut();
				} else {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Unflag failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});
	
    $("body").on('click', "a[id*='status_user_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);	
			var user_status = $(this).attr('data-status');
			var id = $(this).attr('id');
			var split = id.split('_');
			var user_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_status_user', { user_id: user_id, user_status: user_status},
				function (response) {
					if (response.status) {
						if (user_status == 0) {
							Messenger().post({
								message: 'User <b>ID ' + user_id + '</b>: Successfully activated!',
								type: 'success'
							});						
							$('#status_user_' + user_id).attr('data-status', 1);							
							$('#status_user_' + user_id).attr('alt', 'Suspend');
							$('#status_user_' + user_id).attr('title', 'Suspend');
							$('#status_user_' + user_id).html('<i class="fa fa-times"></i>');
							$('#status-' + user_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							Messenger().post({
								message: 'User <b>ID ' + user_id + '</b>: Successfully suspended!',
								type: 'success'
							});
							$('#status_user_' + user_id).attr('data-status', 0);
							$('#status_user_' + user_id).attr('alt', 'Activate');
							$('#status_user_' + user_id).attr('title', 'Activate');
							$('#status_user_' + user_id).html('<i class="fa fa-check"></i>');
							$('#status-' + user_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}

					} else {
						if (user_status == 0) {
							Messenger().post({
								message: 'User <b>ID ' + user_id + '</b>: Failed activating or already active!',
								type: 'error'
							});
							$('#status_user_' + user_id).html('<i class="fa fa-check"></i>');							
						} else {
							Messenger().post({
								message: 'User <b>ID ' + user_id + '</b>: Failed suspending or already inactive!',
								type: 'error'
							});
							$('#status_user_' + user_id).html('<i class="fa fa-times"></i>');							
						}
					}
					$('#status_user_' + user_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});	
	
	//View User
    $("body").on('click', "a[id*='view_user_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var user_id = split[2];		
		$.post(base_url + '/ajax/admin_get_user', { user_id: user_id },
			function (response) {
				if (response.status) {
					//Load User Data
					$('#view_del_user').attr('data-id', response.UID);										
					$('#view-id-span').text(response.UID);
					$('#view-id').val(response.UID);
					$('#view-username').text(response.username);
					$('#view-name').text(response.fname + ' ' +response.lname);
					if (response.website != '') {
						$('#view-website').text(response.website);					
						$('#view-website-container').show();
					} else {
						$('#view-website-container').hide();						
					}
					if (response.bdate != '') {
						var date = new Date(response.bdate);
						var bdate = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
						if (validateDate(bdate)) {
							$('#view-bdate').text(bdate);					
							$('#view-bdate-container').show();
						} else {
							$('#view-bdate-container').hide();						
						}
					} else {
						$('#view-bdate-container').hide();												
					}					
					$('#view-email').text(response.email);
					$('#view-send-email').attr('href', base_url + '/siteadmin/users.php?m=mail&email=' + response.email + '&username=' + response.username);
					if (response.photo != '') {
						var thumb_src = base_url + '/media/users/' + user_id + '.jpg';
					} else {
						var thumb_src = base_url + '/media/users/nopic-' + response.gender + '.gif';
					}
					
					var info = '';
					var info_block = '';

					if (response.gender != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Gender';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			response.gender;
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}						
					if (response.city != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			City';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			response.city;
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.country != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Country';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			response.country;
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}				
					if (response.user_ip != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Last IP';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			'<span class="pull-left">' + response.user_ip + '</span> <a class="btn btn-danger btn-mini pull-right" href="' + base_url + '/siteadmin/index.php?m=bans&all=1&a=add&ip=' + response.user_ip + '" onClick=\'Javascript:return confirm("Are you sure you want to ban this user?");\' >BAN USER</a>';
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.premium != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Type';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						if (response.premium == '1') {
							info_block += '			Premium';
						} else {
							info_block += '			Free';
						}
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}					
					
					info_block  = ' <div class="user-info">';
					info_block += '		<div class="info-title col-md-3 col-sm-3">';
					info_block += '			Like Rate';
					info_block += '		</div>';
					info_block += '		<div class="info-body col-md-9 col-sm-9">';
					if (response.dislikes == 0 && response.rate == 0) {						
						info_block += 'N/A';
					} else {
						info_block += 			response.rate + '%';
					}						
					info_block += '		</div>';
					info_block += '		<div class="clearfix"></div>';
					info_block += '	</div>';
					info       += info_block;					

					info_block  = ' <div class="user-info">';
					info_block += '		<div class="info-title col-md-3 col-sm-3">';
					info_block += '			Profile Views';
					info_block += '		</div>';
					info_block += '		<div class="info-body col-md-9 col-sm-9">';
					info_block += 			response.profile_viewed;
					info_block += '		</div>';
					info_block += '		<div class="clearfix"></div>';
					info_block += '	</div>';
					info       += info_block;					

					info_block  = ' <div class="user-info">';
					info_block += '		<div class="info-title col-md-3 col-sm-3">';
					info_block += '			Video Views';
					info_block += '		</div>';
					info_block += '		<div class="info-body col-md-9 col-sm-9">';
					info_block += 			response.video_viewed;
					info_block += '		</div>';
					info_block += '		<div class="clearfix"></div>';
					info_block += '	</div>';
					info       += info_block;

					info_block  = ' <div class="user-info">';
					info_block += '		<div class="info-title col-md-3 col-sm-3">';
					info_block += '			Watched Videos';
					info_block += '		</div>';
					info_block += '		<div class="info-body col-md-9 col-sm-9">';
					info_block += 			response.watched_video;
					info_block += '		</div>';
					info_block += '		<div class="clearfix"></div>';
					info_block += '	</div>';
					info       += info_block;

					info_block  = ' <div class="user-info">';
					info_block += '		<div class="info-title col-md-3 col-sm-3">';
					info_block += '			Verified Email';
					info_block += '		</div>';
					info_block += '		<div class="info-body col-md-9 col-sm-9">';
					if (response.emailverified == 'yes') {
						info_block += '			Yes';
					} else {
						info_block += '			No';
					}					
					info_block += '		</div>';
					info_block += '		<div class="clearfix"></div>';
					info_block += '	</div>';
					info       += info_block;

					info_block  = ' <div class="user-info">';
					info_block += '		<div class="info-title col-md-3 col-sm-3">';
					info_block += '			Status';
					info_block += '		</div>';
					info_block += '		<div class="info-body col-md-9 col-sm-9">';
					info_block += 			response.account_status;
					info_block += '		</div>';
					info_block += '		<div class="clearfix"></div>';
					info_block += '	</div>';
					info       += info_block;
					
					$('#view-basic-info-container').html(info);
					var info = '';
					var info_block = '';					
					
					if (response.aboutme != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			About Me';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.aboutme);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.occupation != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Occupation';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.occupation);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.company != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Company';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.company);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.school != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			School';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.school);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}					
					if (response.interest_hobby != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Here For';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.interest_hobby);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}	
					if (response.fav_movie_show != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Favorite Sex Categories';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.fav_movie_show);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.fav_music != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Ideal Sex Partner';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.fav_music);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.fav_book != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			My Erogenic Zones';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.fav_book);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.turnon != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Turn Ons';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.turnon);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (response.turnoff != '') {
						info_block  = ' <div class="user-info">';
						info_block += '		<div class="info-title col-md-3 col-sm-3">';
						info_block += '			Turn Offs';
						info_block += '		</div>';
						info_block += '		<div class="info-body col-md-9 col-sm-9">';
						info_block += 			nl2br(response.turnoff);
						info_block += '		</div>';
						info_block += '		<div class="clearfix"></div>';
						info_block += '	</div>';
						info       += info_block;
					}
					if (info != '') {
						$('#view-advanced-info-container').html(info);
						$('#view-advanced-tab').show();
					} else {
						$('#view-advanced-tab').hide();
					}
					$('#view-profile-pic').attr('src', thumb_src);
					$('.nav-tabs a[href="#view-tab1"]').tab('show');
					$('#viewModal').modal('show');
					
				} else {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Failed getting user details!',
						type: 'error'
					});
				}				
		}, "json");	
	});		
	
	//Close View Modal
	$('#viewModal').on('hidden.bs.modal', function () {
		$('#view-user-container').attr('src', '');
		$('#view_del_user').attr('data-id', '');
	})		
	
	//Edit User
    $("body").on('click', "a[id*='edit_user_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var user_id = split[2];

		$.post(base_url + '/ajax/admin_get_user', { user_id: user_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					$('.nav-tabs a[href="#tab1"]').tab('show');					
					//Load User Data
					//Acount
					$('#edit-id-span').text(response.UID);					
					$('#edit-id').val(response.UID);
					$('#edit-username').val(response.username);					
					$('#edit-email').val(response.email);
					$('input:radio[name="edit-emailverified"]').filter('[value="' + response.emailverified + '"]').attr('checked', true);
					$('input:radio[name="edit-premium"]').filter('[value="' + response.premium + '"]').attr('checked', true);
					$('input:radio[name="edit-status"]').filter('[value="' + response.account_status + '"]').attr('checked', true);
					$('#edit-likes').val(response.likes);
					$('#edit-dislikes').val(response.dislikes);
					$('#edit-viewnumber').val(response.profile_viewed);
					$('#edit-video_viewed').val(response.video_viewed);
					$('#edit-watched_video').val(response.watched_video);	
					$('#edit-password').val('');	
					$('#edit-password_confirm').val('');
					//Personal
					$('#edit-fname').val(response.fname);
					$('#edit-lname').val(response.lname);
					$('input:radio[name="edit-gender"]').filter('[value="' + response.gender + '"]').attr('checked', true);
					$('#edit-relationship').val(response.relation);	
					$('#edit-relationship').select2('val', response.relation);
					$('#edit-interested').val(response.interested);	
					$('#edit-interested').select2('val', response.interested);
					//Location
					$('#edit-town').val(response.town);
					$('#edit-city').val(response.city);
					$('#edit-country').val(response.country);	
					$('#edit-country').select2('val', response.country);
					//Profile
					$('#edit-website').val(response.website);
					$('#edit-aboutme').val(response.aboutme);
					$('#edit-occupation').val(response.occupation);					
					$('#edit-company').val(response.company);					
					$('#edit-school').val(response.school);					
					$('#edit-interest_hobby').val(response.interest_hobby);					
					$('#edit-fav_movie_show').val(response.fav_movie_show);					
					$('#edit-fav_music').val(response.fav_music);					
					$('#edit-fav_book').val(response.fav_book);
					$('#edit-turnon').val(response.turnon);					
					$('#edit-turnoff').val(response.turnoff);					
		
					//Adjust margin left to integer value - Center
					var modal_ml = parseInt(($(window).width()-$('#editModalDialog').width())/2);					
					$('#editModal').modal('show');
					if ($(window).width()>768) {
						$('#editModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
					}
					
				} else {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Failed getting user details!',
						type: 'error'
					});
				}				
		}, "json"); 		
	});	

	//Reset
	$("body").on('click', "button[id='edit-reset']", function(event) {
        event.preventDefault();
		var user_id = $('#edit-id').val();

		$.post(base_url + '/ajax/admin_get_user', { user_id: user_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});

					//Load User Data
					//Acount
					$('#edit-id-span').text(response.UID);					
					$('#edit-id').val(response.UID);
					$('#edit-username').val(response.username);					
					$('#edit-email').val(response.email);
					$('input:radio[name="edit-emailverified"]').filter('[value="' + response.emailverified + '"]').attr('checked', true);
					$('input:radio[name="edit-premium"]').filter('[value="' + response.premium + '"]').attr('checked', true);
					$('input:radio[name="edit-status"]').filter('[value="' + response.account_status + '"]').attr('checked', true);
					$('#edit-likes').val(response.likes);
					$('#edit-dislikes').val(response.dislikes);
					$('#edit-viewnumber').val(response.profile_viewed);
					$('#edit-video_viewed').val(response.video_viewed);
					$('#edit-watched_video').val(response.watched_video);	
					$('#edit-password').val('');	
					$('#edit-password_confirm').val('');
					//Personal
					$('#edit-fname').val(response.fname);
					$('#edit-lname').val(response.lname);
					$('input:radio[name="edit-gender"]').filter('[value="' + response.gender + '"]').attr('checked', true);
					$('#edit-relationship').val(response.relation);	
					$('#edit-relationship').select2('val', response.relation);
					$('#edit-interested').val(response.interested);	
					$('#edit-interested').select2('val', response.interested);
					//Location
					$('#edit-town').val(response.town);
					$('#edit-city').val(response.city);
					$('#edit-country').val(response.country);	
					$('#edit-country').select2('val', response.country);
					//Profile
					$('#edit-website').val(response.website);
					$('#edit-aboutme').val(response.aboutme);
					$('#edit-occupation').val(response.occupation);					
					$('#edit-company').val(response.company);					
					$('#edit-school').val(response.school);					
					$('#edit-interest_hobby').val(response.interest_hobby);					
					$('#edit-fav_movie_show').val(response.fav_movie_show);					
					$('#edit-fav_music').val(response.fav_music);					
					$('#edit-fav_book').val(response.fav_book);
					$('#edit-turnon').val(response.turnon);					
					$('#edit-turnoff').val(response.turnoff);	
					
				} else {
					Messenger().post({
						message: 'User <b>ID ' + user_id + '</b>: Failed getting user details!',
						type: 'error'
					});
				}				
		}, "json"); 					
	});	
	
	//Edit Save
	$("body").on('click', "button[id='edit-save']", function(event) {		
		event.preventDefault();
		var user_id = $('#edit-id').val();
		if (!hasErrors("input[id*='edit-']") && !hasErrors("textarea[id*='edit-']")) {
			//save code
			$('#edit_user_' + user_id).html('<i class="small-loader"></i>');	
			var userData = {
				//Acount
				id 		         : $('#edit-id').val(),
				email 		     : $('#edit-email').val(),
				emailverified    : $('input[name="edit-emailverified"]:checked').val(),
				premium		     : $('input[name="edit-premium"]:checked').val(),				
				account_status   : $('input[name="edit-status"]:checked').val(),
				likes		     : $('#edit-likes').val(),
				dislikes	     : $('#edit-dislikes').val(),
				viewnumber	     : $('#edit-viewnumber').val(),
				video_viewed     : $('#edit-video_viewed').val(),
				watched_video    : $('#edit-watched_video').val(),				
				password	     : $('#edit-password').val(),
				password_confirm : $('#edit-password_confirm').val(),
				//Personal				
				fname            : $('#edit-fname').val(),
				lname            : $('#edit-lname').val(),
				gender           : $('input[name="edit-gender"]:checked').val(),				
				relationship	 : $('#edit-relationship').val(),
				interested		 : $('#edit-interested').val(),
				//Location
				town		     : $('#edit-town').val(),		
				city		     : $('#edit-city').val(),		
				country		     : $('#edit-country').val(),
				//Profile
				website		     : $('#edit-website').val(),		
				aboutme		     : $('#edit-aboutme').val(),
				occupation	     : $('#edit-occupation').val(),
				company		     : $('#edit-company').val(),
				school		     : $('#edit-school').val(),
				interest_hobby	 : $('#edit-interest_hobby').val(),
				fav_movie_show   : $('#edit-fav_movie_show').val(),
				fav_music		 : $('#edit-fav_music').val(),
				fav_book		 : $('#edit-fav_book').val(),
				turnon		     : $('#edit-turnon').val(),
				turnoff 		 : $('#edit-turnoff').val()
			};
			
			$.post(base_url + '/ajax/admin_save_user', { data: userData },
				function (response) {					
					$('#editModal').modal('hide');
					if (response.status) {						
						Messenger().post({
							message: 'User <b>ID ' + user_id + '</b>: Successfully updated!',
							type: 'success'
						});
						$('#title-' + user_id).text(userData.title);
						if (userData.account_status == 'Active') {
							$('#status_user_' + user_id).attr('data-status', 1);							
							$('#status_user_' + user_id).attr('alt', 'Suspend');
							$('#status_user_' + user_id).attr('title', 'Suspend');
							$('#status_user_' + user_id).html('<i class="fa fa-times"></i>');
							$('#status-' + user_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							$('#status_user_' + user_id).attr('data-status', 0);
							$('#status_user_' + user_id).attr('alt', 'Activate');
							$('#status_user_' + user_id).attr('title', 'Activate');
							$('#status_user_' + user_id).html('<i class="fa fa-check"></i>');
							$('#status-' + user_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}
						if (userData.premium == '0') {
							$('#premium-' + user_id).html('');
						} else {
							$('#premium-' + user_id).html('<div class="item-premium">P</div>');
						}						
						$('#views-' + user_id).text(userData.viewnumber);

						var flag_src = base_url + '/templates/backend/default/assets/img/flags/' + userData.country.replace(/ /g, '-').replace(/'/g, '') + '.png';
						$('#flag-' + user_id).attr('src', flag_src).error(function() {
							flag_src = base_url + '/templates/backend/default/assets/img/flags/NoCountry.png';
							$('#flag-' + user_id).attr('src', flag_src);
						});									
						$('#flag-' + user_id).attr('title', userData.country);
						
					} else {
						Messenger().post({
							message: 'User <b>ID ' + user_id + '</b>: Failed updating!',
							type: 'error'
						});
					}
					$('#edit_user_' + user_id).html('<i class="fa fa-pencil"></i>');	
			}, "json");			
		} else {
			 $('.nav-tabs a[href="#tab1"]').tab('show');
		}
		
	});

	//Thumbnail
    $("body").on('click', "a[id*='thumb_user_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var user_id = split[2];
		$('#thumb_user_' + user_id).html('<i class="small-loader"></i>');

		$('#addthumb').replaceWith($('#addthumb').val('').clone(true));
		$('#upaddthumb').html($('#nofile').val());		
		
		d = new Date();
		var thumb_src = $('#thumb-' + user_id).attr('src');

		if ( thumb_src.indexOf('nopic-Male.gif') >= 0 || thumb_src.indexOf('nopic-Female.gif') >= 0) {
			$('#user-thumbnail-remove-container').hide();
		} else {
			$('#user-thumbnail-remove-container').show();
		}
		$('#user-thumbnail-remove').attr('checked', false);
		
		thumb_block = '<div class="col-sm-4 col-sm-offset-4"><img id="user-thumbnail-img-' + user_id + '" src="' + thumb_src + '" class="img-responsive" title="User Thumbnail" alt="User Thumbnail" /></div>';
		$("#user-thumbnail-container").html(thumb_block);		
		$('#user-thumbnail-id-span').html(user_id);
		$('#user-thumbnail-id').val(user_id);					
		//Load Thumb
		thumbLoaded(user_id);
							
			
	});	

	//Validate
	validateEmail('#edit-email');
	validateNumber('#edit-likes',0);
	validateNumber('#edit-dislikes',0);
	validateNumber('#edit-viewnumber',0);	
	validateNumber('#edit-video_viewed',0);
	validateNumber('#edit-watched_video',0);
	validatePassword('#edit-password','#edit-password_confirm',4);
	
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
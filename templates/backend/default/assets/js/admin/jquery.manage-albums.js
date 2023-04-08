function selectChange(img, selection) {
    document.getElementById("x1").value = selection.x1;
    document.getElementById("y1").value = selection.y1;
    document.getElementById("x2").value = selection.x2;
    document.getElementById("y2").value = selection.y2;
    document.getElementById("width").value = selection.width;
    document.getElementById("height").value = selection.height;
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

function hasErrors(input) {
	var err = false;
	$(input).each(function(){		
		if($(this).hasClass('error')) {
			err = true;
		}
	});
	return err;
}

function thumbsLoaded(album_id) {
	var imgs = $('#thumbnails-container img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/media/photos/default.jpg');
		});	
	});	
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');
				$('#cover-step-span').html('Select Cover');	
				$('#cover-save').hide();
				$('#cover-np-back').hide();				
				$('#cover-pagination').show();
				$('#coverModal').modal('show');				
			}
		});
	} else {
		$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');		
		$('#cover-step-span').html('Select Cover');	
		$('#cover-save').hide();
		$('#cover-np-back').hide();
		$('#cover-pagination').show();
		$('#coverModal').modal('show');		
	}
}

function thumbsReLoaded(album_id) {
	var imgs = $('#thumbnails-container-rel img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/media/photos/default.jpg');
		});	
	});	
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#thumbnails-container').html($('#thumbnails-container-rel').html());
				$('#thumbnails-loading').hide();
				$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');
				$('#cover-step-span').html('Select Cover');	
				$('#cover-save').hide();
				$('#cover-np-back').hide();
				$('#cover-pagination').show();
			}
		});
	} else {		
		$('#thumbnails-container').html($('#thumbnails-container-rel').html());
		$('#thumbnails-loading').hide();
		$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');
		$('#cover-step-span').html('Select Cover');		
		$('#cover-save').hide();
		$('#cover-np-back').hide();
		$('#cover-pagination').show();		
	}
}

function photosLoaded(album_id) {
	var imgs = $('#photos-container img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/media/photos/default.jpg');
		});	
	});
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#photos-loading-' + album_id).hide();
				$('#viewModal').modal('show');				
			}
		});
	} else {
		$('#photos-loading-' + album_id).hide();
		$('#viewModal').modal('show');		
	}
}

function photoLoaded(photo_id) {
	var imgs = $('#photo-view-container img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/media/photos/default.jpg');
		});	
	});	
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#photo-loading-' + photo_id).hide();
				$('#photo-viewModal').modal('show');				
			}
		});
	} else {
		$('#photo-loading-' + photo_id).hide();
		$('#photo-viewModal').modal('show');		
	}
}

function photosAddedLoaded() {
	var imgs = $('#photos-add-container img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/media/photos/default.jpg');
		});	
	});	
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$(".photo-added").each(function() {
					$(this).removeClass('photo-added-loading');
					$('#photos-added-loading').hide();
				});				
			}
		});
	} else {
		$(".photo-added").each(function() {
			$(this).removeClass('photo-added-loading');
			$('#photos-added-loading').hide();			
		});		
	}
	$(this).removeClass('photo-added-loading');
	$('#photos-added-loading').hide();		
}

function hideArea() {
	var ias = $('#selected-cover').imgAreaSelect({ instance: true });
	if (ias) {
		ias.cancelSelection();
	}
}

function selectArea() {

	if($('#selected-cover').length != 0) {
 
		var iw = $('#selected-cover').width();
		var ih = $('#selected-cover').height();
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

		$('img#selected-cover').imgAreaSelect({ selectionOpacity: 0.2, x1:s_x, y1: s_y, x2: s_x + s_max, y2: s_y + s_max, resizable: true, aspectRatio: '1:1', handles: true, persistent:true, parent: '#coverModalDialog', minHeight: '100', minWidth: '100', maxHeight: '800', maxWidth: '800', onSelectChange: selectChange });

		$("#x1").val( s_x );
		$("#y1").val( s_y );
		$("#x2").val( s_x + s_max );
		$("#y2").val( s_y + s_max );
		$("#width").val( s_max );
		$("#height").val( s_max );	
	}
	
}

function thumbSelected(album_id) {
	var imgs = $('#thumbnails-container-rel img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/media/photos/default.jpg');
		});	
	});		
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#thumbnails-container').html($('#thumbnails-container-rel').html());
				$('#thumbnails-loading').hide();
				$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');
				$('#cover-step-span').html('Crop Cover');
				$('#cover-save').show();
				$('#cover-np-back').show();				
				$('#cover-pagination').hide();
				selectArea();
			}
		});
	} else {		
		$('#thumbnails-container').html($('#thumbnails-container-rel').html());
		$('#thumbnails-loading').hide();
		$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');
		$('#cover-step-span').html('Crop Cover');
		$('#cover-save').show();
		$('#cover-np-back').show();
		$('#cover-pagination').hide();
		selectArea();
	}
}

function photoAdded(pid) {	
	var thumb_block = '';
	d = new Date();
	thumb_block  = '<div class="item-main-container photo-added photo-added-loading">';
	thumb_block += '	<div class="clearfix"></div>';	
	thumb_block += '	<div class="item-col-left">';
	thumb_block += '		<div class="item-main">';
	thumb_block += '			<div class="item-thumb">';
	thumb_block += '				<div class="thumb-overlay">';
	thumb_block += '					<img src="' + base_url + '/media/photos/tmb/' + pid + '.jpg?' + d.getTime() + '" class="img-responsive" />';					
	thumb_block += '				</div>';
	thumb_block += '			</div>';						
	thumb_block += '		</div>';
	thumb_block += '	</div>';						
	thumb_block += '	<div class="item-col-right">';
	thumb_block += '	<input id="photo_added_caption_' + pid + '" type="text" value="" class="form-control" placeholder="Caption">';	
	thumb_block += '	</div>';
	thumb_block += '	<div class="clearfix"></div>';
	thumb_block += '</div>';
	$("#photos-add-container").prepend(thumb_block);	
    return true;	
}

function startUpload() {
	$('#photos-added-loading').show();
	return true;
}

function stopUpload(aid, photos) {
      var result = '';
      if (photos > 0){
		$('#add-photos-update').show();
		$('#addphotos').replaceWith($('#addphotos').val('').clone(true));
		$('#upaddphotos').html($('#nofile').val());		
		$('#album-total-photos-' + aid).text(parseInt($('#album-total-photos-' + aid).text(), 10) + photos);					
		if (photos > 1) {
			pnum = 'photos'
		} else {
			pnum = 'photo'
		}		
		Messenger().post({
			message: 'Successfully added <b>' + photos + '</b> ' + pnum + ' to album <b>ID ' + aid + '</b>!',
			type: 'success'
		});
      }
      else {
			Messenger().post({
			message: 'Failed adding photos to album <b>ID ' + aid + '</b>!',
				type: 'error'
			});			 
      }
	photosAddedLoaded();
    return true;   
}

    $("body").on('click', "button[id='add-photos-update']", function(event) {
        event.preventDefault();
		$("input[id*='photo_added_caption_']").each(function () {
			var caption = $(this).val();
			var id = $(this).attr('id');
			var split = id.split('_');
			var photo_id = split[3];
			if (caption != '') {
				var captionData = {
							 id : photo_id,
						caption : caption
				};
				
				$.post(base_url + '/ajax/admin_update_caption', {data: captionData },
					function (response) {
						if (response.status) {
							//success message
						}
				}, "json");
			}
		});
		Messenger().post({
			message: 'Photo captions successfully updated!',
			type: 'success'
		});
	});

$(document).ready(function(){
		
	$("#filter_status").select2();
	$("#filter_status").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#filter_category").select2();
	//$("#filter_category").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#filter_type").select2();
	$("#filter_type").select2 ('container').find ('.select2-search').addClass ('hidden');		
	$("#edit-category").select2();
	//$("#edit-category").select2 ('container').find ('.select2-search').addClass ('hidden');
	
	$('#check_all_albums').change(function() {
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
		document.getElementById('sort').value = 'a.AID';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
		document.getElementById('display_items').innerText = '100';
		document.getElementById('display').value = '100';
		
		$("#filter_category").select2("val", "");
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

    $("body").on('click', "a[id='view_del_album']", function(event) {
        event.preventDefault();	
		var album_id = $(this).attr("data-id");
		$.post(base_url + '/ajax/admin_delete_album', { album_id: album_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#viewModal').modal('hide');					
					$('#item-' + album_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});	

    $("body").on('click', "a[id*='addphotos_album_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var album_id = split[2];
		$("#album-add-id").val(album_id);
		$('#add-photos-id-span').html(album_id);
		$('#add-photos-update').hide();
		$('#photos-add-container').html('');
		$('#addphotos').replaceWith($('#addphotos').val('').clone(true));
		$('#upaddphotos').html($('#nofile').val());
		$('#add-photosModal').modal('show');
	});		
	
    $("body").on('click', "a[id='view_del_photo']", function(event) {
        event.preventDefault();	
		var photo_id = $(this).attr("data-id");
		$.post(base_url + '/ajax/admin_delete_photo', { photo_id: photo_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Photo <b>ID ' + photo_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#photo-viewModal').modal('hide');
					$('#photo-item-' + photo_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Photo <b>ID ' + photo_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});	
	
    $("body").on('click', "a[id*='delete_album_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var album_id = split[2];
		$('#delete__album_' + album_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_album', { album_id: album_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#item-' + album_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

    $("body").on('click', "a[id*='unflag_photo_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var f_id = split[2];
		var album_id = split[3];		
		$('#unflag__photo_' + album_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_unflag_photo', { f_id: f_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Successfully unflagged!',
						type: 'success'
					});
					$('#photo-item-' + album_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Unflag failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});
	
    $("body").on('click', "a[id*='thumb_album_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);			
			var id = $(this).attr('id');
			var split = id.split('_');
			var album_id = split[2];
			$('#thumb__album_' + album_id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_thumb_album', { album_id: album_id },
				function (response) {
					if (response.status) {
						Messenger().post({
							message: 'Album <b>ID ' + album_id + '</b>: Successfully regenerated cover!',
							type: 'success'
						});
						d = new Date();
						$('#thumb-' + album_id).attr('src', response.src + '?' + d.getTime());
					} else {
						Messenger().post({
							message: 'Album <b>ID ' + album_id + '</b>: Failed regenerating cover!',
							type: 'error'
						});
					}
					$('#thumb__album_' + album_id).html('<i class="fa fa-picture-o"></i>');
					$('#thumb_album_' + album_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});	
	
    $("body").on('click', "a[id*='status_album_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);	
			var album_status = $(this).attr('data-status');
			var id = $(this).attr('id');
			var split = id.split('_');
			var album_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_status_album', { album_id: album_id, album_status: album_status},
				function (response) {
					if (response.status) {
						if (album_status == 0) {
							Messenger().post({
								message: 'Album <b>ID ' + album_id + '</b>: Successfully activated!',
								type: 'success'
							});						
							$('#status_album_' + album_id).attr('data-status', 1);							
							$('#status_album_' + album_id).attr('alt', 'Suspend');
							$('#status_album_' + album_id).attr('title', 'Suspend');
							$('#status_album_' + album_id).html('<i class="fa fa-times"></i>');
							$('#status-' + album_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							Messenger().post({
								message: 'Album <b>ID ' + album_id + '</b>: Successfully suspended!',
								type: 'success'
							});
							$('#status_album_' + album_id).attr('data-status', 0);
							$('#status_album_' + album_id).attr('alt', 'Activate');
							$('#status_album_' + album_id).attr('title', 'Activate');
							$('#status_album_' + album_id).html('<i class="fa fa-check"></i>');
							$('#status-' + album_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}

					} else {
						if (album_status == 0) {
							Messenger().post({
								message: 'Album <b>ID ' + album_id + '</b>: Failed activating or already active!',
								type: 'error'
							});
							$('#status_album_' + album_id).html('<i class="fa fa-check"></i>');							
						} else {
							Messenger().post({
								message: 'Album <b>ID ' + album_id + '</b>: Failed suspending or already inactive!',
								type: 'error'
							});
							$('#status_album_' + album_id).html('<i class="fa fa-times"></i>');							
						}
					}
					$('#status_album_' + album_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});	
	
	//View Album
    $("body").on('click', "a[id*='view_album_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var album_id = split[2];
		$('#photos-loading-' + album_id).show();		
		$.post(base_url + '/ajax/admin_get_photos_album', { album_id: album_id, start: -1 },
			function (response) {				
				$('#photos-container').html('');
				if (response.status && response.count > 0) {
					$('#view_del_album').attr('data-id', album_id);	
					$('#view-id-span').html(album_id);
					$('#view-id').val(album_id);
					var thumb_block = '';
					//Load Thumbs
					d = new Date();
					for (i = 0; i < response.count; i++) {
						thumb_block  = '<div id="photo-item-' + response['photos'][i] + '" class="item-main-container album">';
						thumb_block += '	<div class="item-col-left">';
						thumb_block += '		<div class="item-main">';
						thumb_block += '			<div class="item-thumb">';						
						thumb_block += '				<div class="thumb-overlay">';
						thumb_block += '					<a id="view_photo_' + response['photos'][i] + '" href="#">';
						thumb_block += '						<img src="' + response['thumbs'][i] + '?' + d.getTime() + '" class="img-responsive" />';
						thumb_block += '					</a>';						
						thumb_block += '					<div class="item-id">';
						thumb_block += '						<b>ID</b> ' + response['photos'][i];						
						thumb_block += '					</div>';
						thumb_block += '					<div id="photo-loading-' + response['photos'][i] + '" class="thumbnails-loading" style="display: none"><i class="loader"></i></div>';
						thumb_block += '				</div>';
						thumb_block += '			</div>';						
						thumb_block += '		</div>';
						thumb_block += '	</div>';						
						thumb_block += '	<div class="item-col-right">';
						thumb_block += '		<div class="item-details">';
						thumb_block += '			<div class="item-title">';
						thumb_block += '				<span id="photo-caption-' + response['photos'][i] + '">';
						thumb_block += 						response['caption'][i] + '&nbsp;';
						thumb_block += '				</span>';						
						thumb_block += '			</div>';
						thumb_block += '			<div class="row">';

						//Status						
						thumb_block += '				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">';
						thumb_block += '				<div class="d-label">Status</div>';
						thumb_block += '					<span id="photo-status-' + response['photos'][i] + '">';
						if (response['active'][i] == 1) {
							thumb_block += '					<span class="text-green" alt="Active" title="Active">Active</span>';
						} else {
							thumb_block += '					<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>';
						}
						thumb_block += '					</span>';						
						thumb_block += '				</div>';
						
						//Comments
						thumb_block += '				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">';
						thumb_block += '					<div class="d-label"><i class="fa fa-comments"></i></div>';
						if (response['total_comments'][i] > 0) {
							thumb_block += '				<a id="comments_Photo_' + response['photos'][i] + '" href="#" class="text-info">' + response['total_comments'][i] + '</a>';
						} else {							
							thumb_block += '				<span class="text-muted">' + response['total_comments'][i] + '</span>';
						}
						thumb_block += '				</div>';						

						//Views
						thumb_block += '				<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">';
						thumb_block += '					<div class="d-label"><i class="fa fa-eye"></i></div>';
						thumb_block += '					<span id="photo-views-' + response['photos'][i] + '">' + response['total_views'][i] + '</span>';
						thumb_block += '				</div>';
						
						thumb_block += '';
						thumb_block += '';
						thumb_block += '';
						thumb_block += '';
						thumb_block += '			</div>';
						thumb_block += '		</div>';						
						thumb_block += '	</div>';
						thumb_block += '	<div class="clearfix"></div>';

						thumb_block += '	<div class="item-actions">';
						thumb_block += '		<div class="btn-group">';
						thumb_block += '			<div class="btn-group">';
						thumb_block += '				<a id="delete__photo_' + response['photos'][i] + '" class="btn btn-success" data-toggle="dropdown" href="#" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>';
						thumb_block += '				<ul class="dropdown-menu">';
						thumb_block += '					<li><a id="delete_photo_' + response['photos'][i] + '" href="#">Delete</a></li>';
						thumb_block += '				</ul>';
						thumb_block += '			</div>';
						thumb_block += '			<a id="edit_photo_' + response['photos'][i] + '" class="btn btn-success" href="#" alt="Edit" title="Edit"><i class="fa fa-pencil"></i></a>';
						if (response['active'][i] == 1) {
							thumb_block += '		<a id="status_photo_' + response['photos'][i] + '" class="btn btn-success" href="#" alt="Suspend" title="Suspend" data-processing="0" data-status="1"><i class="fa fa-times"></i></a>';
						} else {
							thumb_block += '		<a id="status_photo_' + response['photos'][i] + '" class="btn btn-success" href="#" alt="Activate" title="Activate" data-processing="0" data-status="0"><i class="fa fa-check"></i></a>';
						}					
						thumb_block += '		</div>';						
						thumb_block += '	</div>';
						
						thumb_block += '</div>';
						
						$("#photos-container").append(thumb_block);
					}					
					
					photosLoaded(album_id);
				
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Failed getting album photos!',
						type: 'error'
					});
					$('#photos-loading-' + album_id).hide();
				}				
		}, "json"); 	
	});		
	
	//Close View Modal
	$('#viewModal').on('hidden.bs.modal', function () {
		$('#photos-container').scrollTop(0);		
		$('#photos-container').html('');
	})		
	
	//Edit Album
    $("body").on('click', "a[id*='edit_album_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var album_id = split[2];

		$.post(base_url + '/ajax/admin_get_album', { album_id: album_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Album Data
					$('#edit-id-span').text(response.AID);					
					$('#edit-id').val(response.AID);
					$('#edit-name').val(response.name);
					$('#edit-tags').val(response.tags);
					$('#edit-category').val(response.category);	
					$('#edit-category').select2('val', response.category);
					$('input:radio[name="edit-type"]').filter('[value="' + response.type + '"]').attr('checked', true);
					$('input:radio[name="edit-status"]').filter('[value="' + response.active + '"]').attr('checked', true);
					$('#edit-likes').val(response.likes);
					$('#edit-dislikes').val(response.dislikes);
					$('#edit-viewnumber').val(response.total_views);

					//Adjust margin left to integer value - Center
					var modal_ml = parseInt(($(window).width()-$('#editModalDialog').width())/2);					
					$('#editModal').modal('show');
					if ($(window).width()>768) {
						$('#editModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
					}
					
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Failed getting album details!',
						type: 'error'
					});
				}				
		}, "json"); 		
	});	

	//Reset
	$("body").on('click', "button[id='edit-reset']", function(event) {
        event.preventDefault();
		var album_id = $('#edit-id').val();

		$.post(base_url + '/ajax/admin_get_album', { album_id: album_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Album Data
					$('#edit-id-span').text(response.AID);					
					$('#edit-id').val(response.AID);
					$('#edit-name').val(response.name);
					$('#edit-tags').val(response.tags);
					$('#edit-category').val(response.category);	
					$('#edit-category').select2('val', response.category);
					$('input:radio[name="edit-type"]').filter('[value="' + response.type + '"]').attr('checked', true);
					$('input:radio[name="edit-status"]').filter('[value="' + response.active + '"]').attr('checked', true);
					$('#edit-likes').val(response.likes);
					$('#edit-dislikes').val(response.dislikes);
					$('#edit-viewnumber').val(response.total_views);
					
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Failed getting album details!',
						type: 'error'
					});
				}				
		}, "json"); 					
	});	
	
	//Edit Save
	$("body").on('click', "button[id='edit-save']", function(event) {		
		event.preventDefault();
		var album_id = $('#edit-id').val();
		if (!hasErrors("input[id*='edit-']") && !hasErrors("textarea[id*='edit-']")) {
			//save code
			$('#edit_album_' + album_id).html('<i class="small-loader"></i>');			
			var albumData = {
				id 		    : $('#edit-id').val(),
				name 		: $('#edit-name').val(),
				tags		: $('#edit-tags').val().replace(/\n/g, " ").replace(/\r/g, " ").replace(/\t/g, " "),
				category	: $('#edit-category').val(),
				type		: $('input[name="edit-type"]:checked').val(),
				active		: $('input[name="edit-status"]:checked').val(),
				likes		: $('#edit-likes').val(),
				dislikes	: $('#edit-dislikes').val(),
				viewnumber	: $('#edit-viewnumber').val()
			};
			
			$.post(base_url + '/ajax/admin_save_album', { data: albumData },
				function (response) {					
					$('#editModal').modal('hide');
					if (response.status) {	
						Messenger().post({
							message: 'Album <b>ID ' + album_id + '</b>: Successfully updated!',
							type: 'success'
						});
						$('#name-' + album_id).text(albumData.name);
						if (albumData.active == 1) {
							$('#status_album_' + album_id).attr('data-status', 1);							
							$('#status_album_' + album_id).attr('alt', 'Suspend');
							$('#status_album_' + album_id).attr('name', 'Suspend');
							$('#status_album_' + album_id).html('<i class="fa fa-times"></i>');
							$('#status-' + album_id).html('<span class="text-green" alt="Active" name="Active">Active</span>');							
						} else {
							$('#status_album_' + album_id).attr('data-status', 0);
							$('#status_album_' + album_id).attr('alt', 'Activate');
							$('#status_album_' + album_id).attr('name', 'Activate');
							$('#status_album_' + album_id).html('<i class="fa fa-check"></i>');
							$('#status-' + album_id).html('<span class="text-red" alt="Inactive" name="Inactive">Inactive</span>');
						}
						if (albumData.type == 'public') {
							$('#private-' + album_id).html('');
						} else {
							$('#private-' + album_id).html('<div class="item-private">PRIVATE</div>');
						}
						$('#views-' + album_id).text(albumData.viewnumber);
					} else {
						Messenger().post({
							message: 'Album <b>ID ' + album_id + '</b>: Failed updating!',
							type: 'error'
						});
					}
					$('#edit_album_' + album_id).html('<i class="fa fa-pencil"></i>');	
			}, "json");			
		}
		
	});

	//Thumbnails
    $("body").on('click', "a[id*='cover_album_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var album_id = split[2];
		$('#cover_album_' + album_id).html('<i class="small-loader"></i>');
		$('#cover-np-prev').prop('disabled', true);
		$('#cover-np-next').prop('disabled', true);		
		$.post(base_url + '/ajax/admin_get_photos_album', { album_id: album_id, start: 0 },
			function (response) {				
				$('#thumbnails-container').html('');				
				if (response.status && response.count > 0) {
					if (response.prev) {
						$('#cover-np-prev').prop('disabled', false);
					}
					if (response.next) {
						$('#cover-np-next').prop('disabled', false);
					}
					if (response.prev || response.next) {
						$('#cover-pagination-container').show();
					} else {
						$('#cover-pagination-container').hide();
					}					
					$('#cover-id-span').html(album_id);
					$('#cover-id').val(album_id);
					$('#cover-default').val(response.thumb);
					$('#thumbnails-start').val('0');
					var thumb_block = '';
					//Load Thumbs
					d = new Date();
					for (i = 0; i < response.count; i++) {
						thumb_block = '<div id="tb_' + response['photos'][i] + '" class="col-xs-6 col-sm-3 col-md-3 thumb-block"><img src="' + response['thumbs'][i] + '?' + d.getTime() + '" class="img-responsive" /></div>';
						$("#thumbnails-container").append(thumb_block);
					}
					thumbsLoaded(album_id);
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Failed getting album photos!',
						type: 'error'
					});
					$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');
				}				
		}, "json"); 		
	});	

	//Thumbnails Prev/Next
	$("body").on('click', "button[id*='cover-np-']", function(event) {		
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('-');
		var action = split[2];
		if (action == 'next') {
			var start = parseInt($('#thumbnails-start').val()) + 8;
		} else if (action == 'prev') {
			var start = parseInt($('#thumbnails-start').val()) - 8;
		} else {
			var start = parseInt($('#thumbnails-start').val());
		}
		var album_id = $('#cover-id').val();
		$('#cover-np-prev').prop('disabled', true);
		$('#cover-np-next').prop('disabled', true);		
		$('#cover_album_' + album_id).html('<i class="small-loader"></i>');
		hideArea();
		$('#thumbnails-loading').show();
		$.post(base_url + '/ajax/admin_get_photos_album', { album_id: album_id, start: start},
			function (response) {	
				$('#thumbnails-container-rel').html('');				
				if (response.status && response.count > 0) {
					if (response.prev) {
						$('#cover-np-prev').prop('disabled', false);
					}
					if (response.next) {
						$('#cover-np-next').prop('disabled', false);
					}
					if (response.prev || response.next) {
						$('#cover-pagination-container').show();
					} else {
						$('#cover-pagination-container').hide();
					}					
					$('#cover-id-span').html(album_id);
					$('#cover-id').val(album_id);					
					$('#cover-default').val(response.thumb);
					$('#thumbnails-start').val(start);
					var thumb_block = '';
					//Load Thumbs
					d = new Date();	
					for (i = 0; i < response.count; i++) {
						thumb_block = '<div id="tb_' + response['photos'][i] + '" class="col-xs-6 col-sm-3 col-md-3 thumb-block"><img src="' + response['thumbs'][i] + '?' + d.getTime() + '" class="img-responsive" /></div>';
						$("#thumbnails-container-rel").append(thumb_block);
					}
					thumbsReLoaded(album_id);
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Failed getting album photos!',
						type: 'error'
					});
					$('#thumbnails-loading').hide();					
					$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');
				}				
		}, "json"); 		
	});		

	//Cover Save
	$("body").on('click', "button[id='cover-save']", function(event) {		
		event.preventDefault();
		var album_id = $('#cover-id').val();
		var photo_id = $('#cover-photo-id').val();
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var iw = $('#selected-cover').width();
		var ih = $('#selected-cover').height();	
		//save code	
		$('#cover_album_' + album_id).html('<i class="small-loader"></i>');		
		$.post(base_url + '/ajax/admin_save_cover', { album_id: album_id, photo_id: photo_id, x1: x1, y1: y1, x2: x2, y2: y2, iw: iw, ih: ih },
			function (response) {
				$('#coverModal').modal('hide');
				if (response.status) {						
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Cover successfully updated!',
						type: 'success'
					});
					d = new Date();					
					$('#thumb-' + album_id).attr('src', response.src + '?' + d.getTime());
				} else {
					Messenger().post({
						message: 'Album <b>ID ' + album_id + '</b>: Cover failed updating!',
						type: 'error'
					});
				}
				$('#cover_album_' + album_id).html('<i class="fa fa-picture-o"></i>');	
		}, "json");	
	});
	
	//Select Cover
    $("body").on('click', "div[id*='tb_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var thumb_id = split[1];
		var album_id = $('#cover-id').val();
		var thumb_block = '';
		$('#cover_album_' + album_id).html('<i class="small-loader"></i>');
		$('#thumbnails-loading').show();		
		d = new Date();		
		$('#thumbnails-container-rel').html('');
		thumb_block = '<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 thumb-block"><img id="selected-cover" src="' + base_url + '/media/photos/'+ thumb_id + '.jpg?' + d.getTime() + '" class="img-responsive" /></div>';
		$("#thumbnails-container-rel").append(thumb_block);		
		thumbSelected(album_id);
		$('#cover-photo-id').val(thumb_id);	
	});		


	//Close Cover Modal
	$('#coverModal').on('hidden.bs.modal', function () {		
		hideArea();
	})	
	
	//Validate
	validateString('#edit-name',2);
	validateString('#edit-tags',2);
	validateNumber('#edit-likes',0);
	validateNumber('#edit-dislikes',0);
	validateNumber('#edit-viewnumber',0);	
	validateNumber('#photo-edit-likes',0);
	validateNumber('#photo-edit-dislikes',0);
	validateNumber('#photo-edit-viewnumber',0);
	
	//Center Modal
	if ($(window).width()>768) {
		var modal_ml1 = parseInt(($(window).width()-$('#viewModalDialog').width())/2);
		$('#viewModalDialog').css('margin-left',Math.floor(modal_ml1)+'px');
	} else {
		$('#viewModalDialog').css('margin-left','10px');
		$('#viewModalDialog').css('margin-right','10px');
	}

	if ($(window).width()>768) {
		var modal_ml2 = parseInt(($(window).width()-$('#photo-viewModalDialog').width())/2);
		$('#photo-viewModalDialog').css('margin-left',Math.floor(modal_ml2)+'px');
	} else {
		$('#photo-viewModalDialog').css('margin-left','10px');
		$('#photo-viewModalDialog').css('margin-right','10px');
	}
	
	if ($(window).width()>768) {
		var modal_ml3 = parseInt(($(window).width()-$('#add-photosModalDialog').width())/2);
		$('#add-photosModalDialog').css('margin-left',Math.floor(modal_ml3)+'px');
	} else {
		$('#add-photosModalDialog').css('margin-left','10px');
		$('#add-photosModalDialog').css('margin-right','10px');
	}

		
	$(window).on('resize', function(){	
		if ($(window).width()>768) {
			var modal_ml1 = parseInt(($(window).width()-$('#editModalDialog').width())/2);
			$('#editModalDialog').css('margin-left',Math.floor(modal_ml1)+'px');
		} else {
			$('#editModalDialog').css('margin-left','10px');
			$('#editModalDialog').css('margin-right','10px');
		}

		if ($(window).width()>768) {
			var modal_ml2 = parseInt(($(window).width()-$('#viewModalDialog').width())/2);
			$('#viewModalDialog').css('margin-left',Math.floor(modal_ml2)+'px');
		} else {
			$('#viewModalDialog').css('margin-left','10px');
			$('#viewModalDialog').css('margin-right','10px');
		}		
		
		if ($(window).width()>768) {
			var modal_ml3 = parseInt(($(window).width()-$('#photo-editModalDialog').width())/2);
			$('#photo-editModalDialog').css('margin-left',Math.floor(modal_ml3)+'px');
		} else {
			$('#photo-editModalDialog').css('margin-left','10px');
			$('#photo-editModalDialog').css('margin-right','10px');
		}

		if ($(window).width()>768) {
			var modal_ml4 = parseInt(($(window).width()-$('#photo-viewModalDialog').width())/2);
			$('#photo-viewModalDialog').css('margin-left',Math.floor(modal_ml4)+'px');
		} else {
			$('#photo-viewModalDialog').css('margin-left','10px');
			$('#photo-viewModalDialog').css('margin-right','10px');
		}

		if ($(window).width()>768) {
			var modal_ml4 = parseInt(($(window).width()-$('#add-photosModalDialog').width())/2);
			$('#add-photosModalDialog').css('margin-left',Math.floor(modal_ml4)+'px');
		} else {
			$('#add-photosModalDialog').css('margin-left','10px');
			$('#add-photosModalDialog').css('margin-right','10px');
		}			
		
	});

	//Photo
	//Delete Photo
    $("body").on('click', "a[id*='delete_photo_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var photo_id = split[2];
		$('#delete__photo_' + photo_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_photo', { photo_id: photo_id },
			function (response) {
				if (response.status) {
					$('#album-total-photos-' + response.aid).text(parseInt($('#album-total-photos-' + response.aid).text(), 10) - 1);					
					Messenger().post({
						message: 'Photo <b>ID ' + photo_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#photo-item-' + photo_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Photo <b>ID ' + photo_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

	//Status Photo
    $("body").on('click', "a[id*='status_photo_']", function(event) {
        event.preventDefault();
		var processing = $(this).attr('data-processing');
		if (processing == 0) {
			$(this).attr('data-processing', 1);	
			var photo_status = $(this).attr('data-status');
			var id = $(this).attr('id');
			var split = id.split('_');
			var photo_id = split[2];
			$('#' + id).html('<i class="small-loader"></i>');
			$.post(base_url + '/ajax/admin_status_photo', { photo_id: photo_id, photo_status: photo_status},
				function (response) {
					if (response.status) {
						if (photo_status == 0) {
							Messenger().post({
								message: 'Photo <b>ID ' + photo_id + '</b>: Successfully activated!',
								type: 'success'
							});						
							$('#status_photo_' + photo_id).attr('data-status', 1);							
							$('#status_photo_' + photo_id).attr('alt', 'Suspend');
							$('#status_photo_' + photo_id).attr('title', 'Suspend');
							$('#status_photo_' + photo_id).html('<i class="fa fa-times"></i>');
							$('#photo-status-' + photo_id).html('<span class="text-green" alt="Active" title="Active">Active</span>');							
						} else {
							Messenger().post({
								message: 'Photo <b>ID ' + photo_id + '</b>: Successfully suspended!',
								type: 'success'
							});
							$('#status_photo_' + photo_id).attr('data-status', 0);
							$('#status_photo_' + photo_id).attr('alt', 'Activate');
							$('#status_photo_' + photo_id).attr('title', 'Activate');
							$('#status_photo_' + photo_id).html('<i class="fa fa-check"></i>');
							$('#photo-status-' + photo_id).html('<span class="text-red" alt="Inactive" title="Inactive">Inactive</span>');
						}

					} else {
						if (photo_status == 0) {
							Messenger().post({
								message: 'Photo <b>ID ' + photo_id + '</b>: Failed activating or already active!',
								type: 'error'
							});
							$('#status_photo_' + photo_id).html('<i class="fa fa-check"></i>');							
						} else {
							Messenger().post({
								message: 'Photo <b>ID ' + photo_id + '</b>: Failed suspending or already inactive!',
								type: 'error'
							});
							$('#status_photo_' + photo_id).html('<i class="fa fa-times"></i>');							
						}
					}
					$('#status_photo_' + photo_id).attr('data-processing', 0);
			}, "json"); 			
		}
	});

	//Edit Photo
    $("body").on('click', "a[id*='edit_photo_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var photo_id = split[2];

		$.post(base_url + '/ajax/admin_get_photo', { photo_id: photo_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Photo Data
					$('#photo-edit-id-span').text(response.PID);					
					$('#photo-edit-id').val(response.PID);
					$('#photo-edit-caption').val(response.caption);
					$('input:radio[name="photo-edit-status"]').filter('[value="' + response.active + '"]').attr('checked', true);
					$('#photo-edit-likes').val(response.likes);
					$('#photo-edit-dislikes').val(response.dislikes);
					$('#photo-edit-viewnumber').val(response.total_views);

					//Adjust margin left to integer value - Center
					var modal_ml = parseInt(($(window).width()-$('#photo-editModalDialog').width())/2);					
					$('#photo-editModal').modal('show');
					if ($(window).width()>768) {
						$('#photo-editModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
					}
					
				} else {
					Messenger().post({
						message: 'Photo <b>ID ' + photo_id + '</b>: Failed getting photo details!',
						type: 'error'
					});
				}				
		}, "json"); 		
	});		

	//Edit Photo Reset
	$("body").on('click', "button[id='photo-edit-reset']", function(event) {
        event.preventDefault();
		var photo_id = $('#photo-edit-id').val();

		$.post(base_url + '/ajax/admin_get_photo', { photo_id: photo_id },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Photo Data
					$('#photo-edit-id-span').text(response.PID);					
					$('#photo-edit-id').val(response.PID);
					$('#photo-edit-caption').val(response.caption);
					$('input:radio[name="photo-edit-status"]').filter('[value="' + response.active + '"]').attr('checked', true);
					$('#photo-edit-likes').val(response.likes);
					$('#photo-edit-dislikes').val(response.dislikes);
					$('#photo-edit-viewnumber').val(response.total_views);
					
				} else {
					Messenger().post({
						message: 'Photo <b>ID ' + photo_id + '</b>: Failed getting photo details!',
						type: 'error'
					});
				}				
		}, "json"); 					
	});	

	//Edit Save
	$("body").on('click', "button[id='photo-edit-save']", function(event) {		
		event.preventDefault();
		var photo_id = $('#photo-edit-id').val();
		if (!hasErrors("input[id*='photo-edit-']")) {
			//save code
			$('#photo-edit_photo_' + photo_id).html('<i class="small-loader"></i>');			
			var photoData = {
				id 		    : $('#photo-edit-id').val(),
				caption 	: $('#photo-edit-caption').val(),
				active		: $('input[name="photo-edit-status"]:checked').val(),
				likes		: $('#photo-edit-likes').val(),
				dislikes	: $('#photo-edit-dislikes').val(),
				viewnumber	: $('#photo-edit-viewnumber').val()
			};
			
			$.post(base_url + '/ajax/admin_save_photo', { data: photoData },
				function (response) {					
					$('#photo-editModal').modal('hide');
					if (response.status) {	
						Messenger().post({
							message: 'Photo <b>ID ' + photo_id + '</b>: Successfully updated!',
							type: 'success'
						});
						$('#photo-caption-' + photo_id).text(photoData.caption);
						if (photoData.active == 1) {
							$('#status_photo_' + photo_id).attr('data-status', 1);							
							$('#status_photo_' + photo_id).attr('alt', 'Suspend');
							$('#status_photo_' + photo_id).attr('name', 'Suspend');
							$('#status_photo_' + photo_id).html('<i class="fa fa-times"></i>');
							$('#photo-status-' + photo_id).html('<span class="text-green" alt="Active" name="Active">Active</span>');							
						} else {
							$('#status_photo_' + photo_id).attr('data-status', 0);
							$('#status_photo_' + photo_id).attr('alt', 'Activate');
							$('#status_photo_' + photo_id).attr('name', 'Activate');
							$('#status_photo_' + photo_id).html('<i class="fa fa-check"></i>');
							$('#photo-status-' + photo_id).html('<span class="text-red" alt="Inactive" name="Inactive">Inactive</span>');
						}
						$('#photo-views-' + photo_id).text(photoData.viewnumber);
					} else {
						Messenger().post({
							message: 'Photo <b>ID ' + photo_id + '</b>: Failed updating!',
							type: 'error'
						});
					}
					$('#photo-edit_photo_' + photo_id).html('<i class="fa fa-pencil"></i>');	
			}, "json");			
		}
		
	});
	
	//View Photo
    $("body").on('click', "a[id*='view_photo_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var photo_id = split[2];		
		$('#photo-loading-' + photo_id).show();
		//Load Photo Data
		$('#view_del_photo').attr('data-id', photo_id);										
		$('#photo-view-id-span').text(photo_id);
		$('#photo-view-id').val(photo_id);
		var caption = $.trim($('#photo-caption-' + photo_id).text());
		if(caption != '') {
			$('#photo-view-title-container').show();
			$('#photo-view-title').text(caption);
		} else {
			$('#photo-view-title-container').hide();
		}
		$('#photo-view-img').attr('src', base_url + '/media/photos/' + photo_id + '.jpg');
		photoLoaded(photo_id);
	});		
	
});
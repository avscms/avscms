$(document).ready(function(){            
	
	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 2000;  //time in ms, 5 second for example
	var $input = $('#search-cvideos');

	//on keyup, start the countdown
	$input.on('keyup', function () {
	  clearTimeout(typingTimer);
	  typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	//on keydown, clear the countdown 
	$input.on('keydown', function () {
	  clearTimeout(typingTimer);
	});
	
	var typingTimerP;                //timer identifier
	var doneTypingIntervalP = 2000;  //time in ms, 5 second for example
	var $inputP = $('#search-cphotos');

	//on keyup, start the countdown
	$inputP.on('keyup', function () {
	  clearTimeout(typingTimerP);
	  typingTimerP = setTimeout(doneTypingP, doneTypingIntervalP);
	});

	//on keydown, clear the countdown 
	$inputP.on('keydown', function () {
	  clearTimeout(typingTimerP);
	});	

	//user is "finished typing," do something
	function doneTyping () {
		var keyword = $('#search-cvideos').val();
		$('#cvideos-container').html('');		
		$('#info-cvideos').html('');
		$('#cvideos-container').hide();
		$('#cvideos-loader').show();		
		if (keyword != '') {
			$.post(base_url + '/ajax/comments_get_svideos', {page: 1, keyword: keyword}, 
			function (response) {
				if (response.status == '1') {
					$('#cvideos-container').html(response.code);					
					var $images = $('#cvideos-container img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;

							if (loaded_images_count == $images.length) {
								$('#cvideos-loader').hide();
								$("#cvideos-container").show();
								$('#info-cvideos').html(response.total);							
							}
						});	
					} else {
						$('#cvideos-loader').hide();
						$("#cvideos-container").show();
						$('#info-cvideos').html(response.total);							
					}
				}

			}, 'json');	 			
		} else {
			$.post(base_url + '/ajax/comments_get_fvideos', {page: 1},
			function (response) {
				if (response.status == '1') {
					$('#cvideos-container').html(response.code);					
					var $images = $('#cvideos-container img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;

							if (loaded_images_count == $images.length) {
								$('#cvideos-loader').hide();
								$("#cvideos-container").show();
								$('#info-cvideos').html(response.total);							
							}
						});	
					} else {
						$('#cvideos-loader').hide();
						$("#cvideos-container").show();
						$('#info-cvideos').html(response.total);							
					}
				}

			}, 'json');	 			
		}
 
	}	

	function doneTypingP () {
		var keyword = $('#search-cphotos').val();
		$('#cphotos-container').html('');		
		$('#info-cphotos').html('');
		$('#cphotos-container').hide();
		$('#cphotos-loader').show();		
		if (keyword != '') {
			$.post(base_url + '/ajax/comments_get_sphotos', {page: 1, keyword: keyword}, 
			function (response) {
				if (response.status == '1') {
					$('#cphotos-container').html(response.code);					
					var $images = $('#cphotos-container img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;

							if (loaded_images_count == $images.length) {
								$('#cphotos-loader').hide();
								$("#cphotos-container").show();
								$('#info-cphotos').html(response.total);							
							}
						});	
					} else {
						$('#cphotos-loader').hide();
						$("#cphotos-container").show();
						$('#info-cphotos').html(response.total);							
					}
				}

			}, 'json');	 			
		} else {
			$.post(base_url + '/ajax/comments_get_fphotos', {page: 1},
			function (response) {
				if (response.status == '1') {
					$('#cphotos-container').html(response.code);					
					var $images = $('#cphotos-container img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;

							if (loaded_images_count == $images.length) {
								$('#cphotos-loader').hide();
								$("#cphotos-container").show();
								$('#info-cphotos').html(response.total);							
							}
						});	
					} else {
						$('#cphotos-loader').hide();
						$("#cphotos-container").show();
						$('#info-cphotos').html(response.total);							
					}
				}

			}, 'json');	 			
		}
 
	}	
	
	$("body").on('click', "[id*='insert_media']", function(event) {				
		event.preventDefault();
        var this_id  = $(this).attr('id');
        var id_split = this_id.split('_');		
		var rel_id	 = this_id.replace('insert_media_', '');		
		if (id_split[2] != '' && id_split[3] != '' && typeof id_split[2] !== 'undefined' && typeof id_split[3] !== 'undefined') {
			$('#insert_media_target').val('reply_input_' + rel_id);
		} else {
			$('#insert_media_target').val('comments_input');
		}
		$('#search-cvideos').val('');
		$('#cvideos-container').html('');	
		$('#info-cvideos').html('');		
		$('#cvideos-container').hide();
		$('#cvideos-loader').show();
		$('#search-cphotos').val('');
		$('#cphotos-container').html('');	
		$('#info-cphotos').html('');		
		$('#cphotos-container').hide();
		$('#cphotos-loader').show();
		$.post(base_url + '/ajax/comments_get_fvideos', {page: 1}, 
		function (response) {
			if (response.status == '1') {
				$('#cvideos-container').html(response.code);					
				var $images = $('#cvideos-container img');
				if ($images.length > 0) {
					var loaded_images_count = 0;
					$images.on('load', function(){
						loaded_images_count++;

						if (loaded_images_count == $images.length) {
							$('#cvideos-loader').hide();
							$("#cvideos-container").show();
							$('#info-cvideos').html(response.total);							
						}
					});	
				} else {
					$('#cvideos-loader').hide();
					$("#cvideos-container").show();
					$('#info-cvideos').html(response.total);							
				}
			}

		}, 'json');
		$.post(base_url + '/ajax/comments_get_fphotos', {page: 1}, 
		function (response) {
			if (response.status == '1') {
				$('#cphotos-container').html(response.code);					
				var $images = $('#cphotos-container img');
				if ($images.length > 0) {
					var loaded_images_count = 0;
					$images.on('load', function(){
						loaded_images_count++;

						if (loaded_images_count == $images.length) {
							$('#cphotos-loader').hide();
							$("#cphotos-container").show();
							$('#info-cphotos').html(response.total);							
						}
					});	
				} else {
					$('#cphotos-loader').hide();
					$("#cphotos-container").show();
					$('#info-cphotos').html(response.total);							
				}
			}

		}, 'json');		
	});  	
	$("body").on('click', "[id*='comments_favorite_videos_']", function(event) {				
		event.preventDefault();
        var this_id    = $(this).attr('id');
        var id_split        = this_id.split('_');
        var page         = id_split[3];		
		$('#cvideos-container').html('');		
		$('#info-cvideos').html('');		
		$('#cvideos-container').hide();
		$('#cvideos-loader').show();
		$.post(base_url + '/ajax/comments_get_fvideos', {page: page}, 
		function (response) {
			if (response.status == '1') {
				$('#cvideos-container').html(response.code);					
				var $images = $('#cvideos-container img');
				if ($images.length > 0) {
					var loaded_images_count = 0;
					$images.on('load', function(){
						loaded_images_count++;

						if (loaded_images_count == $images.length) {
							$('#cvideos-loader').hide();
							$("#cvideos-container").show();
							$('#info-cvideos').html(response.total);							
						}
					});	
				} else {
					$('#cvideos-loader').hide();
					$("#cvideos-container").show();
					$('#info-cvideos').html(response.total);							
				}
			}

		}, 'json');		
	});  
	
	$("body").on('click', "[id*='comments_search_videos_']", function(event) {				
		event.preventDefault();
        var this_id    = $(this).attr('id');
        var id_split        = this_id.split('_');
        var page         = id_split[3];		
		var keyword = $('#search-cvideos').val();		
		$('#cvideos-container').html('');		
		$('#info-cvideos').html('');		
		$('#cvideos-container').hide();
		$('#cvideos-loader').show();
		$.post(base_url + '/ajax/comments_get_svideos', {page: page, keyword:keyword}, 
		function (response) {
			if (response.status == '1') {
				$('#cvideos-container').html(response.code);					
				var $images = $('#cvideos-container img');
				if ($images.length > 0) {
					var loaded_images_count = 0;
					$images.on('load', function(){
						loaded_images_count++;

						if (loaded_images_count == $images.length) {
							$('#cvideos-loader').hide();
							$("#cvideos-container").show();
							$('#info-cvideos').html(response.total);							
						}
					});	
				} else {
					$('#cvideos-loader').hide();
					$("#cvideos-container").show();
					$('#info-cvideos').html(response.total);							
				}
			}

		}, 'json');		
	}); 

	$("body").on('click', "[id*='comments_favorite_photos_']", function(event) {				
		event.preventDefault();
        var this_id    = $(this).attr('id');
        var id_split        = this_id.split('_');
        var page         = id_split[3];		
		$('#cphotos-container').html('');		
		$('#info-cphotos').html('');		
		$('#cphotos-container').hide();
		$('#cphotos-loader').show();
		$.post(base_url + '/ajax/comments_get_fphotos', {page: page}, 
		function (response) {
			if (response.status == '1') {
				$('#cphotos-container').html(response.code);					
				var $images = $('#cphotos-container img');
				if ($images.length > 0) {
					var loaded_images_count = 0;
					$images.on('load', function(){
						loaded_images_count++;

						if (loaded_images_count == $images.length) {
							$('#cphotos-loader').hide();
							$("#cphotos-container").show();
							$('#info-cphotos').html(response.total);							
						}
					});	
				} else {
					$('#cphotos-loader').hide();
					$("#cphotos-container").show();
					$('#info-cphotos').html(response.total);							
				}
			}

		}, 'json');		
	});  
	
	$("body").on('click', "[id*='comments_search_photos_']", function(event) {				
		event.preventDefault();
        var this_id    = $(this).attr('id');
        var id_split        = this_id.split('_');
        var page         = id_split[3];		
		var keyword = $('#search-cphotos').val();		
		$('#cphotos-container').html('');		
		$('#info-cphotos').html('');		
		$('#cphotos-container').hide();
		$('#cphotos-loader').show();
		$.post(base_url + '/ajax/comments_get_sphotos', {page: page, keyword:keyword}, 
		function (response) {
			if (response.status == '1') {
				$('#cphotos-container').html(response.code);					
				var $images = $('#cphotos-container img');
				if ($images.length > 0) {
					var loaded_images_count = 0;
					$images.on('load', function(){
						loaded_images_count++;

						if (loaded_images_count == $images.length) {
							$('#cphotos-loader').hide();
							$("#cphotos-container").show();
							$('#info-cphotos').html(response.total);							
						}
					});	
				} else {
					$('#cphotos-loader').hide();
					$("#cphotos-container").show();
					$('#info-cphotos').html(response.total);							
				}
			}

		}, 'json');		
	});	
	
	$("body").on('click', "[id*='attach_media_']", function(event) {				
		event.preventDefault();
        var this_id      = $(this).attr('id');
        var id_split     = this_id.split('_');
        var media_type   = id_split[2];	
        var media_id     = id_split[3];	
		var attach_str 	 = '[' + media_type + '=' + media_id + ']';  
		var target_input = $("#insert_media_target").val();	
		var curent_input = $("#" + target_input).val();
		$("#" + target_input).val(curent_input + attach_str);
		$('#commentsMediaModal').modal('hide');
	});

	$("body").on('click', "[id='post_comment']", function(event) {	
        event.preventDefault();
        var id      = $("#comments_input").attr("data-id");
        var type    = $("#comments_input").attr("data-type");		
        var comment = $.trim($("#comments_input").val());
        if ( comment != '' ) {
			$("#comment_response").html('<i class="fas fa-circle-notch fa-spin"></i>');		
			$("#comment_response").show();
			$.post(base_url + '/ajax/post_comment', { id: id, type: type, comment: comment },
			function(response) {
				if ( response.status == '0' ) {
					$("#comment_response").hide();
					alertBottom(response.msg, 'error');
				} else {					
					$("#comments_list").prepend(response.code);
					var $images = $('#comment_' + response.cid + ' img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;
							if (loaded_images_count == $images.length) {
								$('#comment_' + response.cid).show();
								$("#comments_input").val('');
								$("#comment_response").hide();
								alertBottom(response.msg, 'success');
								$("#comments_total").html(response.total);
							}
						});	
					} else {				
						$('#comment_' + response.cid).show();
						$("#comments_input").val('');	
						$("#comment_response").hide();
						alertBottom(response.msg, 'success');
						$("#comments_total").html(response.total);						
					}
				}
				$('#comment_' + response.cid).find('[data-toggle="tooltip"]').tooltip();				
				$('#comment_response').delay(5000).fadeOut(500);				
			}, "json");
		}
    });

	$("body").on('click', "a[id*='comment_actions_']", function(event) {	
        event.preventDefault();
        var data_uid =  $(this).attr('data-uid');
        var data_rel =  $(this).attr('data-rel');
		if(session_uid == data_uid) {
			$("#report_comment_" + data_rel).addClass("d-none");
			$("#delete_comment_" + data_rel).removeClass("d-none");			
		} else {
			$("#delete_comment_" + data_rel).addClass("d-none");
			$("#report_comment_" + data_rel).removeClass("d-none");			
		}
    });

	$("body").on('click', "[id='comments_show_more']", function(event) {	
        event.preventDefault();
        var page =  $(this).attr('data-page');
        var id   =  $(this).attr('data-id');
        var type =  $(this).attr('data-type');
        if ( page ) {
			$("#comments_loading").html('<i class="fas fa-circle-notch fa-spin"></i>');			
			var order = $("#comments_sort").attr('data-sort');
			$.post(base_url + '/ajax/load_comments', { id: id, type: type, page: page, order: order},
			function(response) {
				if ( response.status == '0' ) {
				} else {
					$("#comments_more").append(response.code);
					$('.comments-section [id]').each(function () {
						$('[id="' + this.id + '"]:gt(0)').remove();
					});
					var $images = $("#comments_page_" + page + ' img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;
							if (loaded_images_count == $images.length) {
								$("#comments_page_" + page).removeClass('d-none');
								$("#comments_loading").html('');
								if (response.more_comments > 0) {
									$("#comments_show_more").attr('data-page', ++page);					
								} else {
									$("#comments_show_more").hide();
								}
								$("#comments_hide").show();						
							}
						});	
					} else {				
						$("#comments_page_" + page).removeClass('d-none');
						$("#comments_loading").html('');
						if (response.more_comments > 0) {
							$("#comments_show_more").attr('data-page', ++page);					
						} else {
							$("#comments_show_more").hide();
						}						
						$("#comments_hide").show();						
					}					
				}
				$('#comments_more').find('[data-toggle="tooltip"]').tooltip();					
			}, "json");
		}
    });
	
	$("body").on('click', "[id*='replies_show_more_']", function(event) {	
        event.preventDefault();
        var page 	=  $(this).attr('data-page');
        var id   	=  $(this).attr('data-id');
        var type 	=  $(this).attr('data-type');
        if ( page ) {
			var order = $("#comments_sort").attr('data-sort');
			$("#replies_loading_" + type + '_' + id).html('<i class="fas fa-circle-notch fa-spin"></i>');			
			$.post(base_url + '/ajax/load_replies', { id: id, type: type, page: page, order: order },
			function(response) {
				if ( response.status == '0' ) {
				} else {
					$("#replies_more_" + type + '_' + id).append(response.code);
					$('.comments-section [id]').each(function () {
						$('[id="' + this.id + '"]:gt(0)').remove();
					});
					var $images = $("#replies_page_" + type + '_' + id + '_' + page + ' img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;
							if (loaded_images_count == $images.length) {
								$("#replies_page_" + type + '_' + id + '_' + page).removeClass('d-none');
								$("#replies_loading_" + type + '_' + id).html('');
								if (response.more_replies > 0) {
									$("#replies_show_more_" + type + '_' + id + '_').attr('data-page', ++page);
									$("#replies_total_" + type + '_' + id + '_').html(response.more_replies);									
									$("#replies_show_more_" + type + '_' + id + '_').show();									
								} else {
									$("#replies_show_more_" + type + '_' + id + '_').hide();										
								}
								$("#replies_show_more_" + type + '_' + id).hide();
								$("#replies_hide_" + type + '_' + id).show();										
							}
						});	
					} else {				
						$("#replies_page_" + type + '_' + id + '_' + page).removeClass('d-none');
						$("#replies_loading_" + type + '_' + id).html('');
						if (response.more_replies > 0) {
							$("#replies_show_more_" + type + '_' + id + '_').attr('data-page', ++page);
							$("#replies_total_" + type + '_' + id + '_').html(response.more_replies);									
							$("#replies_show_more_" + type + '_' + id + '_').show();									
						} else {
							$("#replies_show_more_" + type + '_' + id + '_').hide();										
						}
						$("#replies_show_more_" + type + '_' + id).hide();
						$("#replies_hide_" + type + '_' + id).show();						
					}					
				}
				$('#replies_more').find('[data-toggle="tooltip"]').tooltip();					
			}, "json");
		}
    });	
	
	$("body").on('click', "[id*='replies_hide_']", function(event) {	
        event.preventDefault();
        var id   	=  $(this).attr('data-id');
        var type 	=  $(this).attr('data-type');
		$(this).hide();
		$.post(base_url + '/ajax/total_replies', { id: id, type : type },
		function(response) {
			if (response.total > 0) {
				$("#replies_more_" + type + '_' + id).html('');
				$("#replies_show_more_" + type + '_' + id).attr('data-page', 1);
				$("#replies_show_more_" + type + '_' + id).html(response.code);				
				$("#replies_show_more_" + type + '_' + id).show();
				$("#replies_show_more_" + type + '_' + id + '_').hide();		
			} else {
				$("#replies_more_" + type + '_' + id).html('');
				$("#replies_show_more_" + type + '_' + id + '_').hide();					
				$("#replies_show_hide_container_" + type + '_' + id).hide();
			}
		}, "json");	
		
    });
	
    $("#comments_hide").click(function(event) {
        event.preventDefault();
		$("#comments_more").html('');
		$(this).hide();
		$("#comments_show_more").attr('data-page', 2);
		$("#comments_show_more").show();
    });	
	
	$("body").on('click', "[id*='delete_comment_']", function(event) {				
		event.preventDefault();
        var this_id      = $(this).attr('id');
		$("#dialogModal .modal-title").html(lang_global_delete);
		$("#dialogModal .modal-body").html(lang_comments_confirm_delete);
		$("#dialogModal .modal-footer .opt-1").html(lang_global_yes);		
		$("#dialogModal .modal-footer .opt-2").html(lang_global_no);	
		$("#dialogModal .modal-footer .opt-1").attr('data-delete-comment', this_id);		
		$("#dialogModal").modal('show');
	});	
	
	$("body").on('click', "[data-delete-comment]", function(event) {				
		event.preventDefault();
        var this_id      = $(this).attr('data-delete-comment');
        var id_split     = this_id.split('_');
        var type 		 = id_split[2];	
        var cid     	 = id_split[3];	
		$("#dialogModal .modal-title").html('');
		$("#dialogModal .modal-body").html('');
		$("#dialogModal .modal-footer .opt-1").html('');		
		$("#dialogModal .modal-footer .opt-2").html('');	
		$("#dialogModal .modal-footer .opt-1").removeData();	
		$("#dialogModal").modal('hide');		
		$.post(base_url + '/ajax/delete_comment', { cid: cid, type : type },
		function(response) {		
			if ( response.status == '0' ) {
				alertBottom(response.msg, 'error');
			} else {
				$('#comment_' + cid).remove();
				alertBottom(response.msg, 'success');
				if (response.total >= 0) {
					$("#comments_total").html(response.total);										
				}
			}			
		}, "json");	
	});		
	
	$("body").on('click', "[id*='report_comment_']", function(event) {				
		event.preventDefault();
        var this_id      = $(this).attr('id');
        var id_split     = this_id.split('_');
        var type 		 = id_split[2];	
        var cid     	 = id_split[3];	
        var pid     	 =  $("#comments_input").attr('data-id');
		$.post(base_url + '/ajax/report_comment', {  type : type, comment_id: cid, parent_id: pid },
		function(response) {		
			if ( response.status == '0' ) {
				alertBottom(response.msg, 'error');			
			} else {
				alertBottom(response.msg, 'success');
				 $("#comment_" + cid + " .comment-user-info").append('<span class="comment-flagged"><i class="fas fa-flag"></i></span>');
			}			
		}, "json");			
	});		
	
	$("body").on('click', "a[id*='comment_reply_']", function(event) {				
		event.preventDefault();
        var this_id  			= $(this).attr('id');		
		var target_id 			= this_id.replace('comment_reply_', 'reply_container_');
		var rel_id				= this_id.replace('comment_reply_', '');
        var data_type  			= $(this).attr('data-type');
        var data_id    			= $(this).attr('data-id');
        var data_reply_username = $(this).attr('data-reply-username');	
		if (data_reply_username !== '') {
			data_reply_username = '@' + data_reply_username + ' ';
		}
		if ($("#" + target_id).hasClass('d-none')) {
			$('[id^="reply_container_"]').each(function() {
				$(this).html('');
				$(this).addClass('d-none');				
			});			
			var html       = '<textarea data-id="' + data_id + '" data-type="' + data_type + '" id="reply_input_' + rel_id + '" rows="2" maxlength="1000" class="form-control">' + 
							 data_reply_username + '</textarea>' +
							 '<a id="post_reply_' + rel_id + '" href="#" class="btn btn-secondary btn-sm">' + lang_comments_reply + '</a>' +
							 '<span data-toggle="tooltip" data-placement="top" title="' + lang_comments_insert_media + '"><a id="insert_media_' + rel_id + '" href="#" class="btn btn-secondary btn-sm insert-media" data-toggle="modal" data-target="#commentsMediaModal"><i class="fas fa-paperclip"></i></a></span>' +							 
							 '<a id="cancel_reply_' + rel_id + '" href="#" class="btn btn-secondary btn-sm btn-cancel">' + lang_cancel + '</a>' +
							 '<span id="reply_response_' + rel_id + '" class="comment-response"></span>';
			$("#" + target_id).html(html);
			$("#" + target_id).find('[data-toggle="tooltip"]').tooltip();
			$("#" + target_id).removeClass('d-none');
		} else {
			$("#" + target_id).addClass('d-none');
		}	
	});	
	
	$("body").on('click', "[id*='cancel_reply_']", function(event) {	
        event.preventDefault();
        var this_id   =  $(this).attr('id');
		var target_id = this_id.replace('cancel_reply_', 'reply_container_');
		$("#" + target_id).html('');
		$("#" + target_id).addClass('d-none');
    });	

	$("body").on('click', "[id*='post_reply_']", function(event) {	
        event.preventDefault();
        var this_id   	= $(this).attr('id');
		var input_id 	= this_id.replace('post_reply_', 'reply_input_');		
		var response_id = this_id.replace('post_reply_', 'reply_response_');		
		var rel_id 		= this_id.replace('post_reply_', '');	
        var id        	= $("#" + input_id).attr("data-id");
        var type      	= $("#" + input_id).attr("data-type");		
        var comment   	= $.trim($("#" + input_id).val());
        if ( comment != '' ) {		
			$("#" + response_id).html('<i class="fas fa-circle-notch fa-spin"></i>');		
			$("#" + response_id).show();
			$.post(base_url + '/ajax/post_reply', { id: id, type: type, comment: comment },
			function(response) {
				if ( response.status == '0' ) {
					$("#" + response_id).hide();					
					alertBottom(response.msg, 'error');						
				} else {		
					$("#replies_list_" + type + "_" + id).append(response.code);					
					var $images = $('#comment_' + response.cid + ' img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;
							if (loaded_images_count == $images.length) {
								$("#reply_container_" + rel_id).addClass('d-none');					
								$("#reply_container_" + rel_id).html('');												
								$('#comment_' + response.cid).show();
								$("#" + input_id).val('');
								$("#" + response_id).hide();
								alertBottom(response.msg, 'success');								
							}
						});	
					} else {	
						$("#reply_container_" + rel_id).addClass('d-none');					
						$("#reply_container_" + rel_id).html('');									
						$('#comment_' + response.cid).show();
						$("#" + input_id).val('');	
						$("#" + response_id).hide();
						alertBottom(response.msg, 'success');	
					}
				}						
			}, "json");
		}
    });
	
	$("body").on('click', "a[id*='comments_sort_']", function(event) {	
        event.preventDefault();
		var sort = $(this).attr('data-sort');
		var id   = $("#comments_sort").attr('data-id');
		var type = $("#comments_sort").attr('data-type');			
		
        if (sort != $("#comments_sort").attr('data-sort')) {
			$("#comments_sort").attr('data-sort', sort);
			$("#comments_sort_newest").removeClass('active');
			$("#comments_sort_top").removeClass('active');			
			$("#comments_sort_" + sort).addClass('active');
			$("#sort_loading").html('<i class="fas fa-circle-notch fa-spin"></i>');			
			var order = $("#comments_sort").attr('data-sort');
			var page  = 1;
			$.post(base_url + '/ajax/load_comments', { id: id, type: type, page: page, order: order},
			function(response) {
				if ( response.status == '0' ) {
				} else {
					
					$('#comments_more').children('div').each(function () {
						$(this).addClass('content-replacing');
					});					
					$('#comments_list').children('div').each(function () {
						$(this).addClass('content-replacing');
					});
					$("#comments_list").prepend(response.code);
					var $images = $("#comments_page_" + page + ' img');
					if ($images.length > 0) {
						var loaded_images_count = 0;
						$images.on('load', function(){
							loaded_images_count++;
							if (loaded_images_count == $images.length) {
								$("#comments_more").html('');
								$('.content-replacing').each(function(){
									$(this).remove();
								});	
								$("#comments_page_" + page).removeClass('d-none');
								$("#comments_page_" + page).removeAttr('id');
								$("#sort_loading").html('');
								if (sort == 'top') {
									$("#comments_sort").html('<i class="fas fa-sort-amount-up"></i>');
								} else {
									$("#comments_sort").html('<i class="fas fa-sort-amount-down"></i>');
								}								
								if (response.more_comments > 0) {
									$("#comments_show_more").attr('data-page', ++page);					
								} else {
									$("#comments_show_more").hide();
								}
								$("#comments_hide").hide();						
							}
						});	
					} else {				
						$("#comments_more").html('');
						$('.content-replacing').each(function(){
							$(this).remove();
						});						
						$("#comments_page_" + page).removeClass('d-none');
						$("#comments_page_" + page).removeAttr('id');						
						$("#sort_loading").html('');
						if (sort == 'top') {
							$("#comments_sort").html('<i class="fas fa-sort-amount-up"></i>');
						} else {
							$("#comments_sort").html('<i class="fas fa-sort-amount-down"></i>');
						}						
						if (response.more_comments > 0) {
							$("#comments_show_more").attr('data-page', ++page);					
						} else {
							$("#comments_show_more").hide();
						}						
						$("#comments_hide").hide();
					}					
				}
				$('#comments_list').find('[data-toggle="tooltip"]').tooltip();				
			}, "json");
			
			
			
		}

    });	
	
	$("body").on('click', "[id*='comment_vote_']", function(event) {	
        event.preventDefault();
        var this_id   	= $(this).attr('id');
        var id_split    = this_id.split('_');		
		var vote		= id_split[2];
        var type      	= id_split[3];		
        var id        	= id_split[4];
		$.post(base_url + '/ajax/vote_comment', { id: id, type: type, vote: vote },
		function(response) {
			if ( response.status == '0' ) {
				alertBottom(response.msg, 'error');
			} else {								
				$("#comment_rate_" + type + '_' + id).html(response.rate);
				$("#" + this_id).addClass("bounce-" + vote);

			}						
		}, "json");

    });	
	
});

    


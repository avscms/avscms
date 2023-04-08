function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function autoheight(a) {
    if (!$(a).prop('scrollTop')) {
        do {
            var b = $(a).prop('scrollHeight');
            var h = $(a).height();
            $(a).height(h - 5);
        }
        while (b && (b != $(a).prop('scrollHeight')));
    };
    $(a).height($(a).prop('scrollHeight') - 10);
}

$(document).ready(function(){

	//Ajax:

    $("body").on('click', "a[id*='comments_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var item_type = split[1];		
		var item_id = split[2];
		var comment_block  = '';
		$('#comments-container').html('');
		$.post(base_url + '/ajax/admin_get_comments', { id: item_id, type: item_type },
			function (response) {
				if (response.status) {
					//Reset Errors
					$('.form-control').each(function(){
						$(this).removeClass('error');
					});
					
					//Load Data
					$('#comments-id-span').text(item_id);					
					$('#comments-type-span').text(item_type);
					$('#comments-id').val(item_id);
					var options = { year: 'numeric', month: 'short', day: 'numeric' };
					$.each( response.comments, function( index, value ) {
						var date = new Date(value.addtime * 1000).toLocaleDateString('en-US', options);						
						comment_block  = '<div id="comment-id-' + value.CID + '" class="comment-container">';
						comment_block += '	<div class="pull-left">';
						comment_block += '		<b>ID</b> ' + value.CID + ', <a href="users.php?m=view&UID=' + value.UID + '" class="text-info">' + value.username + '</a><span class="item-date">, ' + date + '</span>';
						comment_block += '	</div>';
						comment_block += '	<div class="comment-actions">';
						comment_block += '	<div class="pull-right">';
						comment_block += '		<div class="btn-group">';
						comment_block += '			<a id="delete__comment_' + item_type + '_' + value.CID + '" class="btn btn-success" data-toggle="dropdown" href="#" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>';
						comment_block += '			<ul class="dropdown-menu">';
						comment_block += '				<li><a id="delete_comment_' + item_type + '_' + value.CID + '" href="#">Delete</a></li>';
						comment_block += '			</ul>';
						comment_block += '			<a id="edit_comment_' + item_type + '_' + value.CID + '" class="btn btn-success" href="#" alt="Edit" title="Edit"><i class="fa fa-pencil"></i></a>';						
						comment_block += '			</div>';
						comment_block += '		</div>';
						comment_block += '	</div>';
						comment_block += '	<div class="clearfix"></div>';
						comment_block += '	<div id="item_comment_' + value.CID + '" class="item-comment" data-status="display">';
						comment_block += 			nl2br(value.message);
						comment_block += '	</div>';
						comment_block += '	<div id="item_comment_back_' + value.CID + '" class="item-comment" style="display: none">';
						comment_block += 			nl2br(value.message);
						comment_block += '	</div>';					
						comment_block += '</div>';				
						$("#comments-container").append(comment_block);
					});

					
					//Adjust margin left to integer value - Center
					var modal_ml = parseInt(($(window).width()-$('#commentsModalDialog').width())/2);					
					$('#commentsModal').modal('show');					
				} else {
					Messenger().post({
						message: item_type + ' <b>ID ' + item_id + '</b>: Failed getting comments!',
						type: 'error'
					});
				}				
		}, "json"); 		
	});		

    $("body").on('click', "a[id*='delete_comment_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var item_type = split[2];		
		var item_id = split[3];
		var parent_id = $('#comments-id').val();
		$('#delete__comment_' + item_type + '_' + item_id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_comment', { id: item_id, type: item_type },
			function (response) {
				if (response.status) {
					if (response.aid) {
						$('#comments_Album_' + response.aid).text(parseInt($('#comments_Album_' + response.aid).text(), 10) - 1);											
					}
					$('#comments_' + item_type + '_' + parent_id).text(parseInt($('#comments_' + item_type + '_' + parent_id).text(), 10) - 1);					
					Messenger().post({
						message: item_type + ' comment <b>ID ' + item_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#comment-id-' + item_id).fadeOut();
				} else {
					Messenger().post({
						message: item_type + ' comment <b>ID ' + item_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});
	
	

    $("body").on('click', "a[id*='edit_comment_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var item_type = split[2];		
		var item_id = split[3];
		if ($('#item_comment_' + item_id).attr('data-status') == 'display') {		
			var edit_block = '';
			var comment = $('#item_comment_' + item_id).text();
			$('#item_comment_' + item_id).attr('data-status', 'edit');
			edit_block  = '<textarea id="editval_comment_' + item_type + '_' + item_id + '" class="form-control" style="resize: vertical; margin: 0;">' + $.trim(comment) + '</textarea>';
			edit_block += '<div class="pull-right">';
			edit_block += '	<button type="button" id="comment_cancel_' + item_id + '" class="btn btn-mini btn-white m-t-10">CANCEL</button>';
			edit_block += '	<button type="button" id="comment_save_' + item_type + '_' + item_id + '" class="btn btn-mini btn-success m-t-10">SAVE</button>';
			edit_block += '</div>';
			edit_block += '<div class="clearfix"></div>';
			$('#item_comment_' + item_id).html(edit_block);
			autoheight($('#editval_comment_' + item_type + '_' + item_id));
			validateString('#editval_comment_' + item_type + '_' + item_id,1);
		}
	});

    $("body").on('click', "button[id*='comment_cancel_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var item_id = split[2];
		if ($('#item_comment_' + item_id).attr('data-status') == 'edit') {	
			$('#item_comment_' + item_id).attr('data-status', 'display');
			$('#item_comment_' + item_id).html($('#item_comment_back_' + item_id).html());
		}
	});

    $("body").on('click', "button[id*='comment_save_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var item_type = split[2];		
		var item_id = split[3];
		if (!hasErrors('#editval_comment_' + item_type + '_' + item_id)) {
			$('#edit_comment_' + item_type + '_' + item_id).html('<i class="small-loader"></i>');
			var commentData = {
						 id : item_id,
					   type : item_type,
					comment : $('#editval_comment_' + item_type + '_' + item_id).val()
			};
			$.post(base_url + '/ajax/admin_save_comment', { data: commentData },
				function (response) {
					if (response.status) {
						$('#item_comment_' + item_id).attr('data-status', 'display');					
						$('#item_comment_' + item_id).html(nl2br(response.message));
						$('#item_comment_back_' + item_id).html(nl2br(response.message));
						Messenger().post({
							message: item_type + ' comment <b>ID ' + item_id + '</b>: Successfully updated!',
							type: 'success'
						});
					} else {
						Messenger().post({
							message: item_type + ' comment <b>ID ' + item_id + '</b>: Failed updating!',
							type: 'error'
						});					
					}
					$('#edit_comment_' + item_type + '_' + item_id).html('<i class="fa fa-pencil"></i>');
			}, "json"); 
		}
	});
	
	$(window).on('resize', function(){	
		if ($(window).width()>768) {
			var modal_ml = parseInt(($(window).width()-$('#commentsModalDialog').width())/2);
			$('#commentsModalDialog').css('margin-left',Math.floor(modal_ml)+'px');
		} else {
			$('#commentsModalDialog').css('margin-left','10px');
			$('#commentsModalDialog').css('margin-right','10px');
		}		
	});
	
	$(document).on('show.bs.modal', '.modal', function (event) {
		var zIndex = 1040 + (10 * $('.modal:visible').length);
		$(this).css('z-index', zIndex);
		setTimeout(function() {
			$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
		}, 0);
	});	
	
	$(document).on('hidden.bs.modal', '.modal', function () {
		$('.modal:visible').length && $(document.body).addClass('modal-open');
	});	
	
});

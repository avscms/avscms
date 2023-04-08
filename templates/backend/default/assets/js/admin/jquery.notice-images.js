function imageLoaded(image_id) {
	var imgs = $('#image-view-container img').not(function() { return this.complete; });
	var count = imgs.length;
	imgs.each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/images/notice_images/thumbs/default.jpg');
		});	
	});	
	if (count) {
		imgs.load(function() {
			count--;
			if (!count) {
				$('#image-loading-' + image_id).hide();
				$('#image-viewModal').modal('show');				
			}
		});
	} else {
		$('#image-loading-' + image_id).hide();
		$('#image-viewModal').modal('show');		
	}
}

function copyTextToClipboard(text) {
	var textArea = document.createElement("textarea");

	textArea.style.position = 'fixed';
	textArea.style.top = 0;
	textArea.style.left = 0;
	textArea.style.width = '2em';
	textArea.style.height = '2em';
	textArea.style.padding = 0;
	textArea.style.border = 'none';
	textArea.style.outline = 'none';
	textArea.style.boxShadow = 'none';
	textArea.style.background = 'transparent';

	textArea.value = text;

	document.body.appendChild(textArea);

	textArea.select();

	try {
		var successful = document.execCommand('copy');
		var msg = successful ? 'successful' : 'unsuccessful';
		if (msg == 'successful') {
			Messenger().post({
				message: 'Copying link was successful!',
				type: 'success'
			});		
		}
	} catch (err) {
		Messenger().post({
			message: 'Oops, unable to copy!',
			type: 'error'
		});
	}

	document.body.removeChild(textArea);
}


$(document).ready(function(){

    $("body").on('click', "a[id*='copy-link-']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('-');
		var image_id = split[2];
		copyTextToClipboard($('#link-' + image_id).val());
	});	
	
	$('.image-thumb').each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/images/notice_images/thumbs/default.jpg');
		});	
	});	
		
	$('.image-thumb').each(function() {
		$(this).error(function() {
			$(this).attr('src', base_url + '/images/notice_images/thumbs/default.jpg');
		});	
	});	

	//Ajax:

	//Delete Image
    $("body").on('click', "a[id*='delete_image_']", function(event) {
        event.preventDefault();	
		var id = $(this).attr('id');
		var split = id.split('_');
		var image_id = split[2];
		$('#delete__image_' + image_id).html('<i class="small-loader"></i>');
		$('#' + id).html('<i class="small-loader"></i>');
		$.post(base_url + '/ajax/admin_delete_image', { image_id: image_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Image <b>ID ' + image_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#item-' + image_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Image <b>ID ' + image_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

    $("body").on('click', "a[id='view_del_image']", function(event) {
        event.preventDefault();	
		var image_id = $(this).attr("data-id");
		$.post(base_url + '/ajax/admin_delete_image', { image_id: image_id },
			function (response) {
				if (response.status) {
					Messenger().post({
						message: 'Image <b>ID ' + image_id + '</b>: Successfully deleted!',
						type: 'success'
					});
					$('#image-viewModal').modal('hide');
					$('#item-' + image_id).fadeOut();
				} else {
					Messenger().post({
						message: 'Image <b>ID ' + image_id + '</b>: Delete failed!',
						type: 'error'
					});					
				}
		}, "json"); 
	});

	//Copy Link
    $("body").on('click', "button[id='image-view-copy-link']", function(event) {
        event.preventDefault();	
		var image_id = $(this).attr("data-id");
		$('#image-viewModal').modal('hide');		
		copyTextToClipboard($('#link-' + image_id).val());
	});
	
	//View Image
    $("body").on('click', "a[id*='view_image_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var image_id = split[2];		
		$('#image-loading-' + image_id).show();
		//Load Photo Data
		$('#view_del_image').attr('data-id', image_id);										
		$('#image-view-copy-link').attr('data-id', image_id);			
		$('#image-view-id-span').text(image_id);
		$('#image-view-id').val(image_id);
		var caption = $.trim($('#image-caption-' + image_id).text());
		if(caption != '') {
			$('#image-view-title-container').show();
			$('#image-view-title').text(caption);
		} else {
			$('#image-view-title-container').hide();
		}
		$('#image-view-img').attr('src', base_url + '/images/notice_images/' + image_id + '.jpg');
		imageLoaded(image_id);
	});	
	
});
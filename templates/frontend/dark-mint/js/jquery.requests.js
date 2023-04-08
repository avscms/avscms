$(document).ready(function(){
	$("body").on('click', "a[id*='accept_friend_']", function(event) {
        event.preventDefault();
        var accept_id       = $(this).attr('id');
        var id_split        = accept_id.split('_');
        var friend_id       = id_split[2];  
        $.post(base_url + '/ajax/accept_friend', { friend_id: friend_id },
		function(response) {
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				alertBottom(response.msg, 'success');	
				$("#request_" + friend_id).hide();					
			} 
		}, 'json');
	});		


	$("body").on('click', "a[id*='reject_friend_']", function(event) {		
        event.preventDefault();
        var accept_id       = $(this).attr('id');
        var id_split        = accept_id.split('_');
        var friend_id       = id_split[2];
        $.post(base_url + '/ajax/reject_friend', { friend_id: friend_id },
		function (response) {
			if ( response.status == 0 ) {
				alertBottom(response.msg, 'error');			
			} else {
				alertBottom(response.msg, 'success');	
				$("#request_" + friend_id).hide();				
			} 
			
		}, 'json');
    });	
});

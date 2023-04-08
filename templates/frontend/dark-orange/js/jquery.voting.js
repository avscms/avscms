$(document).ready(function(){            
	$("body").on('click', "[id*='vote_']", function(event) {	
        event.preventDefault();
        var this_id   	= $(this).attr('id');
        var id_split    = this_id.split('_');		
		var vote		= id_split[1];
        var type      	= id_split[2];		
        var id        	= id_split[3];
		$.post(base_url + '/ajax/vote', { id: id, type: type, vote: vote },
		function(response) {
			if ( response.status == '0' ) {
				alertBottom(response.msg, 'error');
			} else {								
				$("#rating_" + type + '_' + id).html(response.rate + '%');
				$("#likes_" + type + '_' + id).html(response.likes);
				$("#dislikes_" + type + '_' + id).html(response.dislikes);		
				$("#" + this_id).addClass("bounce-" + vote);
			}						
		}, "json");

    });	
});

    


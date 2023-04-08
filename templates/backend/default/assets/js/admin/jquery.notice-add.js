$(document).ready(function(){
	$("#category").select2();	
	
	$('#username').on("input", function() {
		var username = this.value;
		if (username != '') {
			$.post(base_url + '/ajax/admin_suggest_users', {username: username },
				function (response) {
					if (response.status) {
						var options = '';
						$.each( response.users, function( index, value ) {
							options += '<option value="' + value.username + '" />';
						});
						$('#suggestions').html(options);
					} else {
						$('#suggestions').html('');
					}
			}, "json"); 
		} else {	
			$('#suggestions').html('');
		}
	});
});
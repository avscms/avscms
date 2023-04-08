var APIsLoaded = false;

function loadAPIs() {
	if (!APIsLoaded) {
		APIsLoaded = true;
		if (g_signin == '1') {
			//Google
			$.when(
				$.getScript( tpl_url + "/js/jquery.google-login.js" ),
				$.Deferred(function( deferred ){
					$( deferred.resolve );
				})
			).done(function(){
				$('#google-signin').attr('disabled', false);
				$('#google-signin-s').attr('disabled', false);				
				$('#google-signup').attr('disabled', false);			
			});	
			//
		}
		if (fb_signin == '1') {	
			//Facebook
			$.when(
				$.getScript( tpl_url+ "/js/jquery.facebook-login.js" ),
				$.Deferred(function( deferred ){
					$( deferred.resolve );
				})
			).done(function(){
				$('#facebook-signin').attr('disabled', false);
				$('#facebook-signin-s').attr('disabled', false);				
				$('#facebook-signup').attr('disabled', false);				
			});
			//	
		}
	}	
}

$(document).ready(function(){
	if (signup_section) {
		loadAPIs();
	}
	$('#login-modal').on('shown.bs.modal', function() {
		loadAPIs();		
	});
	if (fb_signin == '1' || g_signin == '1') {	
		$(function() {
			$("form[name='login_form'] input").keypress(function (e) {
				if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
					$('#login_submit').click();
					return false;
				} else {
					return true;
				}
			});
		});
	}
});


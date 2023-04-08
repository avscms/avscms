// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
	if (response.status === 'connected') {
	  getUserInfo();
	} else if (response.status === 'not_authorized') {
		FB.login(function(response) {
			if (response.status === 'connected') {
				getUserInfo();
			}
		 }, {scope: 'public_profile,email'});				 
	} else {
		FB.login(function(response) {
			if (response.status === 'connected') {
				getUserInfo();
			}
		 }, {scope: 'public_profile,email'});				 
	}
}

function checkLoginState() {
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
}

window.fbAsyncInit = function() {
	FB.init({
	appId      : fb_appid,
	cookie     : true,  // enable cookies to allow the server to access 
						// the session
	xfbml      : true,  // parse social plugins on this page
	version    : 'v5.0' // use version 5.0
	});

	// Now that we've initialized the JavaScript SDK, we call 
	// FB.getLoginStatus().  This function gets the state of the
	// person visiting this page and can return one of three states to
	// the callback you provide.  They can be:
	//
	// 1. Logged into your app ('connected')
	// 2. Logged into Facebook, but not your app ('not_authorized')
	// 3. Not logged into Facebook and can't tell if they are logged into
	//    your app or not.
	//
	// These three cases are handled in the callback function.

	FB.getLoginStatus(function(response) {
	});
};

// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "https://connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function getUserInfo() {
	FB.api('/me', { locale: 'en_US', fields: 'name, first_name, last_name, email, gender, picture, age_range, birthday, significant_other' }, function(response) {
		if (response.id) {
			doSignupFBModal(response);			
		}
	});
}
 
function doSignupFBModal(response) {
	//init
	console.log(response);
	$("#fb-signup-picture").val('');
	$("#fb-signup-username").val('');	
	$("#fb-signup-existing-username").val('');
	$("#fb-signup-existing-username-locked").val('');
	$("#fb-signup-existing-password").val('');
	$("#fb-signup-existing-password-locked").val('');	
	$("#fb-signup-usepp").prop("checked", false);
	
	//get values
	$("#fb-signup-title").text(response.first_name);
	$("#fb-signup-id").val(response.id);
	$("#fb-signup-email").val(response.email);
	$("#fb-signup-email-label").text(response.email);	
	$("#fb-signup-first-name").val(response.first_name);
	$("#fb-signup-last-name").val(response.last_name);
	$("#fb-signup-gender").val(response.gender);
	$("#fb-signup-age-min").val('21');
	$("#fb-signup-picture-block").hide();

	FB.api('/me?fields=picture.height(500)', function(response){
		if (response.picture.data.is_silhouette == false) {
			$("#fb-signup-picture-img").attr("src",response.picture.data.url);
			$("#fb-signup-picture").val(response.picture.data.url);
			$("#fb-signup-picture-block").show();
			$("#fb-signup-usepp").prop("checked", true);
		}
	});
	$('.nav-tabs a[href="#fb-signup-new"]').tab('show');
	$.post(base_url + '/ajax/fb_signup', { email: response.email, fname: response.first_name, lname: response.last_name, id: response.id },
		function (response) {					
		if (response.status == 1) {
			if (response.existing == 1) {
				$("#fb-signup-submit-new").hide();						
				$("#fb-signup-submit-existing").show();	
				$("#fb-signup-tabs").hide();
				$("#fb-signup-single").show();
				$("#fb-signup-existing-username-locked").val(response.username);								
			} else {				
				$("#fb-signup-submit-existing").hide();
				$("#fb-signup-submit-new").show();
				$("#fb-signup-tabs").show();
				$("#fb-signup-single").hide();								
				$("#fb-signup-username").val(response.username);
				checkFBUserName(response.username);
			}
			if (response.connected == 1) {
				window.location.replace(base_url + current_url);
			} else {
				$('#fb-signup-modal').modal('show');
			}
		}
	}, "json");

}

function checkFBUserName (username) {
$.post(base_url + '/ajax/signup_check_username', { username: username },
	function (response) {
		if (response.status == 1) {
			if (response.valid == 1) {
				$('#fb-signup-submit-new').prop('disabled', false);
			} else {				
				$('#fb-signup-submit-new').prop('disabled', true);
			}
		$("#fb-signup-username-check").html(response.msg);
		}
	}, "json");
}	


$(document).ready(function(){
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href") // activated tab
		if (target == "#fb-signup-existing") {
			$("#fb-signup-submit-existing").show();			
			$("#fb-signup-submit-new").hide();
		} else if (target == "#fb-signup-new") {
			$("#fb-signup-submit-new").show();						
			$("#fb-signup-submit-existing").hide();
		}
	});
	
	$("#fb-signup-username").keyup(function(){
		var username = $("#fb-signup-username").val();
		checkFBUserName(username);
  	});
	
    $(".btn-facebook").click(function(event) {
        event.preventDefault();
		checkLoginState();
    });

});
  
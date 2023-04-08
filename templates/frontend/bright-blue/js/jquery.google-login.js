(function() {
var po = document.createElement('script');
po.type = 'text/javascript'; po.async = true;
po.src = 'https://plus.google.com/js/client:platform.js?onload=renderGBtn';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(po, s);
})();

function onSignInCallback(resp) {
	if(resp['g-oauth-window']){
		gapi.client.load('plus', 'v1', apiClientLoaded);
    }
}

function apiClientLoaded() {	
	gapi.client.plus.people.get({userId: 'me'}).execute(handleResponse);
}

function renderGBtn() { 
	gapi.signin.render('google-signin', {
	  'callback': 'onSignInCallback',
	  'clientid': g_cid,
	  'cookiepolicy': 'single_host_origin',
	  'scope': 'profile email'
	});
	gapi.signin.render('google-signin-s', {
	  'callback': 'onSignInCallback',
	  'clientid': g_cid,
	  'cookiepolicy': 'single_host_origin',
	  'scope': 'profile email'
	});
	gapi.signin.render('google-signup', {
	  'callback': 'onSignInCallback',
	  'clientid': g_cid,
	  'cookiepolicy': 'single_host_origin',
	  'scope': 'profile email'
	});
}
  
function handleResponse(resp) {
	if (!resp.error) {	
		var primaryEmail;
		for (var i=0; i < resp.emails.length; i++) {
		  if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
		}
			doSignupGModal(resp, primaryEmail);			
	}
}
 
function doSignupGModal(resp, primaryEmail) {
	//init
	$("#g-signup-picture").val('');
	$("#g-signup-username").val('');	
	$("#g-signup-existing-username").val('');
	$("#g-signup-existing-username-locked").val('');
	$("#g-signup-existing-password").val('');
	$("#g-signup-existing-password-locked").val('');	
	$("#g-signup-usepp").prop("checked", false);
	
	//get values
	if (resp.displayName!='') {
		$("#g-signup-title").text(resp.displayName);
	} else {
		$("#g-signup-title").text(primaryEmail);	
	}
	$("#g-signup-id").val(resp.id);
	$("#g-signup-email").val(primaryEmail);	
	$("#g-signup-email-label").text(primaryEmail);
	$("#g-signup-first-name").val(resp.name.givenName);
	$("#g-signup-last-name").val(resp.familyName);
	$("#g-signup-gender").val(resp.gender);
	$("#g-signup-age-min").val('');
	$("#g-signup-picture-block").hide();

	if (resp.image.isDefault == false) {
		$("#g-signup-picture-img").attr("src",resp.image.url.split("?")[0]);
		$("#g-signup-picture").val(resp.image.url.split("?")[0]);
		$("#g-signup-picture-block").show();
		$("#g-signup-usepp").prop("checked", true);
	}

	$('.nav-tabs a[href="#g-signup-new"]').tab('show');
	$.post(base_url + '/ajax/g_signup', { email: primaryEmail, fname: resp.name.givenName, lname: resp.familyName, id: resp.id },
		function (response) {					
		if (response.status == 1) {
			if (response.existing == 1) {
				$("#g-signup-submit-new").hide();						
				$("#g-signup-submit-existing").show();	
				$("#g-signup-tabs").hide();
				$("#g-signup-single").show();
				$("#g-signup-existing-username-locked").val(response.username);								
			} else {				
				$("#g-signup-submit-existing").hide();
				$("#g-signup-submit-new").show();
				$("#g-signup-tabs").show();
				$("#g-signup-single").hide();								
				$("#g-signup-username").val(response.username);
				checkGUserName(response.username);
			}
			if (response.connected == 1) {
				window.location.replace(base_url + current_url);
			} else {
				$('#g-signup-modal').modal('show');
			}
		}
	}, "json");

}

function checkGUserName (username) {
$.post(base_url + '/ajax/signup_check_username', { username: username },
	function (response) {
		if (response.status == 1) {
			if (response.valid == 1) {
				$('#g-signup-submit-new').prop('disabled', false);
			} else {				
				$('#g-signup-submit-new').prop('disabled', true);
			}
		$("#g-signup-username-check").html(response.msg);
		}
	}, "json");
}	


$(document).ready(function(){
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href") // activated tab
		if (target == "#g-signup-existing") {
			$("#g-signup-submit-existing").show();			
			$("#g-signup-submit-new").hide();
		} else if (target == "#g-signup-new") {
			$("#g-signup-submit-new").show();						
			$("#g-signup-submit-existing").hide();
		}
	});
	
	$("#g-signup-username").keyup(function(){
		var username = $("#g-signup-username").val();
		checkGUserName(username);
  	});
	
    $(".btn-google").click(function(event) {
        event.preventDefault();
    });	
});
  
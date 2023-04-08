$(document).ready(function(){

	$("#template").select2(); 
	$("#language").select2(); 
	$("#mailer").select2();
	$("#mailer").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#smtp_prefix").select2();
	$("#smtp_prefix").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#max_col").select2();
	$("#max_col").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#min_col").select2();
	$("#min_col").select2 ('container').find ('.select2-search').addClass ('hidden');	

	$("#mailer").change(function() {
		if ($("#mailer").val() == 'mail') {
			$("#sendmail-group").hide();
			$("#smtp-group").hide();
		}	else if ($("#mailer").val() == 'sendmail') {
			$("#sendmail-group").show();
			$("#smtp-group").hide();
		} else if ($("#mailer").val() == 'smtp') {
			$("#sendmail-group").hide();
			$("#smtp-group").show();
		}
	});	

	$('input[type=radio][name=smtp_auth]').change(function() {
		if ( this.value == 1) {
			$("#smtp-a-group").show();
		}	else {
			$("#smtp-a-group").hide();
		}
	});	

}); 
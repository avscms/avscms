$(document).ready(function(){
    $("body").on('click', "a[id='remember_account']", function(event) {
        event.preventDefault();
		$("#submit_forgot").fadeIn();
	});
}); 
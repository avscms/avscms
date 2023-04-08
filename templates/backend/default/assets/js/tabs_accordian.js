/* Webarch Admin Dashboard 
/* This JS is only for DEMO Purposes - Extract the code that you need
-----------------------------------------------------------------*/	
$(document).ready(function() {	
	//Accordians
	$('.panel-group').collapse({
		toggle: false
	})	

/***** Tabs *****/
	//Normal Tabs - Positions are controlled by CSS classes
    $('#tab-01 a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
  
    $('#tab-2 a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
	$('#tab-2 li:eq(1) a').tab('show'); 
	  
	$('#tab-3 a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
	$('#tab-3 li:eq(2) a').tab('show'); 
	  
	$('#tab-4 a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	  
	$('#tab-5 a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	  
	});
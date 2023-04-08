/* Webarch Admin Dashboard 
/* This JS is only for DEMO Purposes - Extract the code that you need
-----------------------------------------------------------------*/	
//Cool ios7 switch - Beta version
//Done using pure Javascript
if(!$('html').hasClass('lte9')) { 
var Switch = require('ios7-switch')
        , checkbox = document.querySelector('.ios')
        , mySwitch = new Switch(checkbox);
 mySwitch.toggle();
      mySwitch.el.addEventListener('click', function(e){
        e.preventDefault();
        mySwitch.toggle();
      }, false);
//creating multiple instances
var Switch2 = require('ios7-switch')
        , checkbox = document.querySelector('.iosblue')
        , mySwitch2 = new Switch2(checkbox);

      mySwitch2.el.addEventListener('click', function(e){
        e.preventDefault();
        mySwitch2.toggle();
      }, false);
}
$(document).ready(function(){
	  //Dropdown menu - select2 plug-in
	  $("#source").select2();
	  
	  //Multiselect - Select2 plug-in
	  $("#multi").val(["Jim","Lucy"]).select2();
	  
	  //Date Pickers
	  $('.input-append.date').datepicker({
				autoclose: true,
				todayHighlight: true
	   });
	 
	 $('#dp5').datepicker();
	 
	 $('#sandbox-advance').datepicker({
			format: "dd/mm/yyyy",
			startView: 1,
			daysOfWeekDisabled: "3,4",
			autoclose: true,
			todayHighlight: true
    });
	
	//Time pickers
	$('.clockpicker ').clockpicker({
        autoclose: true
    });
	//Color pickers
	$('.my-colorpicker-control').colorpicker()
	
	//Input mask - Input helper
	$(function($){
	   $("#date").mask("99/99/9999");
	   $("#phone").mask("(999) 999-9999");
	   $("#tin").mask("99-9999999");
	   $("#ssn").mask("999-99-9999");
	});
	
	//Autonumeric plug-in - automatic addition of dollar signs,etc controlled by tag attributes
	$('.auto').autoNumeric('init');
	
	//HTML5 editor
	$('#text-editor').wysihtml5();
	
	//Drag n Drop up-loader
	$("div#myId").dropzone({ url: "/file/post" });
	
	//Single instance of tag inputs  -  can be initiated with simply using data-role="tagsinput" attribute in any input field
	$('#source-tags').tagsinput({
		typeahead: {
			source: ['Amsterdam', 'Washington', 'Sydney', 'Beijing', 'Cairo']
		}	
	});
});
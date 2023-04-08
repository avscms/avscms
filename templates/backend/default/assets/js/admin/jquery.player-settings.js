$(document).ready(function(){
	
	$("#logo_position").select2();
	$("#logo_position").select2 ('container').find ('.select2-search').addClass ('hidden');
	var percentSlider = $('#logo_opacity').slider();
	var sliderTooltip = $('.tooltip .tooltip-inner');
	//function to change the tooltip value to required format
	var _changeTooltipFormat = function(){
		sliderTooltip.text(sliderTooltip.text()+'%');
	}
	//change tooltip format on initial load
	_changeTooltipFormat();

	//on slide event 
	percentSlider.on('slide', function () {
	   $('#percent').attr('value',percentSlider.data('slider').getValue());
	   //change tooltip value format 
	   _changeTooltipFormat();
		$("#logo").css("opacity", (percentSlider.data('slider').getValue()/100));	   
	});

	$("#logo").css("opacity", (percentSlider.data('slider').getValue()/100));
});
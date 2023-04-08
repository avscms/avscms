$(document).ready(function(){

    $("body").on('click', ".change-language", function(event) {    	
		event.preventDefault();
		$("input[id='language']").val($(this).attr('id'));
		$("#languageSelect").submit();
	});

	$('[data-toggle="tooltip"]').tooltip({ trigger:'hover' });
	
    $("a[id='search_select']").click(function(event) {
        event.preventDefault();
		var search_type = $('#search_type').val();
		if (search_type == 'videos' || search_type == '') {
			$('#search_type').val('photos');
			$("a[id='search_select']").html('<i class="fas fa-camera"></i>');
			$('#search_query').attr('placeholder',search_a);
			$('#search_form').attr('action', '/search/photos');	
			$("a[id='search_select_xs']").html('<i class="fas fa-camera"></i>');
			$('#search_query_xs').attr('placeholder',search_a);
			$('#search_form_xs').attr('action', '/search/photos');		
			$('#eac-container-search_query').css('display', 'none');
			$('#eac-container-search_query_xs').css('display', 'none');									
		} else if (search_type == 'photos') {
			$('#search_type').val('users');			
			$("a[id='search_select']").html('<i class="fas fa-user"></i>');	
			$('#search_query').attr('placeholder',search_u);			
			$('#search_form').attr('action', '/search/users');		
			$("a[id='search_select_xs']").html('<i class="fas fa-user"></i>');	
			$('#search_query_xs').attr('placeholder',search_u);			
			$('#search_form_xs').attr('action', '/search/users');	
			$('#eac-container-search_query').css('display', 'none');
			$('#eac-container-search_query_xs').css('display', 'none');						
		} else {
			$('#search_type').val('videos');
			$("a[id='search_select']").html('<i class="fas fa-video"></i>');
			$('#search_query').attr('placeholder',search_v);			
			$('#search_form').attr('action', '/search/videos');			
			$("a[id='search_select_xs']").html('<i class="fas fa-video"></i>');
			$('#search_query_xs').attr('placeholder',search_v);			
			$('#search_form_xs').attr('action', '/search/videos');	
			$('#eac-container-search_query').css('display', 'block');
			$('#eac-container-search_query_xs').css('display', 'block');											
		}
    });	
	
    $("a[id='search_select_xs']").click(function(event) {
        event.preventDefault();
		var search_type = $('#search_type').val();
		if (search_type == 'videos' || search_type == '') {
			$('#search_type').val('photos');
			$("a[id='search_select']").html('<i class="fas fa-camera"></i>');
			$('#search_query').attr('placeholder',search_a);
			$('#search_form').attr('action', '/search/photos');	
			$("a[id='search_select_xs']").html('<i class="fas fa-camera"></i>');
			$('#search_query_xs').attr('placeholder',search_a);
			$('#search_form_xs').attr('action', '/search/photos');	
			$('#eac-container-search_query').css('display', 'none');
			$('#eac-container-search_query_xs').css('display', 'none');					
		} else if (search_type == 'photos') {
			$('#search_type').val('users');			
			$("a[id='search_select']").html('<i class="fas fa-user"></i>');	
			$('#search_query').attr('placeholder',search_u);			
			$('#search_form').attr('action', '/search/users');		
			$("a[id='search_select_xs']").html('<i class="fas fa-user"></i>');	
			$('#search_query_xs').attr('placeholder',search_u);			
			$('#search_form_xs').attr('action', '/search/users');
			$('#eac-container-search_query').css('display', 'none');
			$('#eac-container-search_query_xs').css('display', 'none');							
		} else {
			$('#search_type').val('videos');
			$("a[id='search_select']").html('<i class="fas fa-video"></i>');
			$('#search_query').attr('placeholder',search_v);			
			$('#search_form').attr('action', '/search/videos');			
			$("a[id='search_select_xs']").html('<i class="fas fa-video"></i>');
			$('#search_query_xs').attr('placeholder',search_v);			
			$('#search_form_xs').attr('action', '/search/videos');	
			$('#eac-container-search_query').css('display', 'block');
			$('#eac-container-search_query_xs').css('display', 'block');						
		}
    });	

	var search_options = {
		data: suggestion_arr,
		getValue: "name",

		template: {
			type: "custom",
			method: function(value, item) {
				return value + ' <span class="eac-total">'+ item.type +'</span>';
			}
		},	
		list: {
			maxNumberOfElements: 15,
			match: {
				enabled: true
			},
			onClickEvent: function() {
				$(".easy-autocomplete-container:visible").closest("form").submit();
			}			
		}
	};

	$("#search_query").easyAutocomplete(search_options);		
	$("#search_query_xs").easyAutocomplete(search_options);	

	$.each( alert_messages, function( key, value ) {
	  alertBottom(value, 'success', 8000);
	});
	$.each( alert_errors, function( key, value ) {
	  alertBottom(value, 'error', 8000);
	});	
	
});

$('#videos-dropdown').on('mouseover', function(){
	$('#videos-dropdown-link').addClass('is-hover');
}).on('mouseout', function(){
	$('#videos-dropdown-link').removeClass('is-hover');
})

$('#categories-dropdown').on('mouseover', function(){
	$('#categories-dropdown-link').addClass('is-hover');
}).on('mouseout', function(){
	$('#categories-dropdown-link').removeClass('is-hover');
})

$('#more-dropdown').on('mouseover', function(){
	$('#more-dropdown-link').addClass('is-hover');
}).on('mouseout', function(){
	$('#more-dropdown-link').removeClass('is-hover');
})

function alertBottom (exp, type, expire) {
	type = type || 'undefined';	
	expire = expire || 4000;
	if (type == 'error') {
		exp = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' + exp + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	} else if (type == 'success') {
		exp = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + exp + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>';
	}
	if (expire > 0) {
		$(exp).prependTo('#alerts_bottom').delay(expire).queue(function() { $(this).remove(); });
	} else {
		$(exp).prependTo('#alerts_bottom');
	}
}

function toggleDropdown (e) {
  const _d = $(e.target).closest('.dropdown'),
    _m = $('.dropdown-menu', _d);
  setTimeout(function(){
    const shouldOpen = e.type !== 'click' && _d.is(':hover');
    _m.toggleClass('show', shouldOpen);
    _d.toggleClass('show', shouldOpen);
    $('[data-toggle="dropdown"]', _d).attr('aria-expanded', shouldOpen);
  }, e.type === 'mouseleave' ? 300 : 0);
}

$('body')
  .on('mouseenter mouseleave','.dropdown',toggleDropdown)
  .on('click', '.dropdown-menu a', toggleDropdown);

$('.navbar .dropdown-toggle').click(function(e) {
  if ($(document).width() > 768) {
    e.preventDefault();

    var url = $(this).attr('href');

       
    if (url !== '#') {
    
      window.location.href = url;
    }

  }
});
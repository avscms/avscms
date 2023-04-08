function gbandwidth(id){
	var val = document.getElementById(id).value
	if(val == '1'){
		document.getElementById('gbandw').style.display = "block";
		var val_tmp = document.getElementById('gselbandw').value;
		if (val_tmp == '-1') val_tmp = '';
		document.getElementById('gbandwi').value = val_tmp;
	} else{
		document.getElementById('gbandw').style.display = "none";
		document.getElementById('gbandwi').value = '-1';
	}
}
function fbandwidth(id){
	var val = document.getElementById(id).value
	if(val == '1'){
		document.getElementById('fbandw').style.display = "block";
		var val_tmp = document.getElementById('fselbandw').value;
		if (val_tmp == '-1') val_tmp = '';
		document.getElementById('fbandwi').value = val_tmp;
	} else{
		document.getElementById('fbandw').style.display = "none";
		document.getElementById('fbandwi').value = '-1';
	}
}
function pbandwidth(id){
	var val = document.getElementById(id).value
	if(val == '1'){
		document.getElementById('pbandw').style.display = "block";
		var val_tmp = document.getElementById('pselbandw').value;
		if (val_tmp == '-1') val_tmp = '';
		document.getElementById('pbandwi').value = val_tmp;
	} else{
		document.getElementById('pbandw').style.display = "none";
		document.getElementById('pbandwi').value = '-1';
	}
}

$(document).ready(function(){
	$("#private_msgs").select2();
	$("#private_msgs").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#session_driver").select2();
	$("#session_driver").select2 ('container').find ('.select2-search').addClass ('hidden');

	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'ban_id';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
		document.getElementById('display_items').innerText = '10';
		document.getElementById('display').value = '10';
		
		$("input[id*='filter_']" ).each(function() {
			var id = $(this).attr('id');
			var split = id.split('_');
			var filter_name = split[1];		
			$(this).val("");
			$(this).removeClass("filter-active");
			$("i[id='filter_remove_" + filter_name + "']").hide();
		});
	});	

    $("body").on('click', "i[id*='filter_remove_']", function(event) {
        event.preventDefault();
		var id = $(this).attr('id');
		var split = id.split('_');
		var filter_name = split[2];
		$("input[name='" + filter_name + "']").val('');
		$("input[name='" + filter_name + "']").removeClass("filter-active");
		$(this).hide();
    });

	$("input[id*='filter_']" ).each(function() {
		var id = $(this).attr('id');
		var split = id.split('_');
		var filter_name = split[1];		
		$(this).on('input', function() {
			if($(this).val() != '') {
				$("i[id='filter_remove_" + filter_name + "']").show();
				$(this).addClass("filter-active");
			} else {
				$("i[id='filter_remove_" + filter_name + "']").hide();
				$(this).removeClass("filter-active");
			}
		});
	});		
	
});
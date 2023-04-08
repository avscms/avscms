$(document).ready(function(){
	$("#adv_device").select2(); 
	$("#adv_device").select2 ('container').find ('.select2-search').addClass ('hidden');	
	
	$('#check_all_categories').change(function() {
		var checkboxes = $(this).closest('form').find(':checkbox');
		if($(this).is(':checked')) {
			checkboxes.prop('checked', true);
		} else {
			checkboxes.prop('checked', false);
		}
	});	
});
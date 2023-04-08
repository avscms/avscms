$(document).ready(function(){

	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'id';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
	});
	$("#preset").select2();
	$("#preset").select2 ('container').find ('.select2-search').addClass ('hidden');	
	$("#ios").select2();
	$("#ios").select2 ('container').find ('.select2-search').addClass ('hidden');	
	
	$("#thumbs_tool").select2();
	$("#thumbs_tool").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#meta_tool").select2();
	$("#meta_tool").select2 ('container').find ('.select2-search').addClass ('hidden');
	
	$("#flv_encodepass").select2();
	$("#flv_encodepass").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#flv_ovc_profile").select2();
	$("#flv_ovc_profile").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#flv_ref_type").select2();
	$("#flv_ref_type").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#flv_resize_base").select2();
	$("#flv_resize_base").select2 ('container').find ('.select2-search').addClass ('hidden');

	$("#hd_encodepass").select2();
	$("#hd_encodepass").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#hd_ovc_profile").select2();
	$("#hd_ovc_profile").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#hd_ref_type").select2();
	$("#hd_ref_type").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#hd_resize_base").select2();
	$("#hd_resize_base").select2 ('container').find ('.select2-search').addClass ('hidden');		
	
	$("#iphone_encodepass").select2();
	$("#iphone_encodepass").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#iphone_ovc_profile").select2();
	$("#iphone_ovc_profile").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#iphone_ref_type").select2();
	$("#iphone_ref_type").select2 ('container').find ('.select2-search').addClass ('hidden');
	$("#iphone_resize_base").select2();
	$("#iphone_resize_base").select2 ('container').find ('.select2-search').addClass ('hidden');	
	
	$('input[type=radio][name=flv_convert]').change(function() {
		if ( this.value == 1) {
			$("#flv-c-group").show();
		}	else {
			$("#flv-c-group").hide();
		}
	});	

	$('input[type=radio][name=hd_convert]').change(function() {
		if ( this.value == 1) {
			$("#hd-c-group").show();
		}	else {
			$("#hd-c-group").hide();
		}
	});		

	$('input[type=radio][name=iphone_convert]').change(function() {
		if ( this.value == 1) {
			$("#iphone-c-group").show();
		}	else {
			$("#iphone-c-group").hide();
		}
	});		
	
	$("#flv_ref_type").change(function() {
		if ($("#flv_ref_type").val() == 'standard') {
			$("#fvbtr").hide();
		}	else {
			$("#fvbtr").show();
		}
	});
	
	$("#hd_ref_type").change(function() {
		if ($("#hd_ref_type").val() == 'standard') {
			$("#hdbtr").hide();
		}	else {
			$("#hdbtr").show();
		}
	});	

	$("#iphone_ref_type").change(function() {
		if ($("#iphone_ref_type").val() == 'standard') {
			$("#iphonebtr").hide();
		}	else {
			$("#iphonebtr").show();
		}
	});
	
}); 

                     

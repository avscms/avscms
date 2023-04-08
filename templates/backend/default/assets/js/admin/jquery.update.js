$( document ).ready(function() {
	$(".nextBtnStep2").hide();
	$(".nextBtnStep3").hide();
	$(".nextBtnStep4").hide();
	
	var updating_page = $(".update_page").val();

	if (updating_page == 'step2') {
		var file_zip = $(".file_version").val();
		var randomNumber = Math.random();
		$("#step2_updating_text").append("Downloading "+file_zip+" ...\n"); 		
		setTimeout(
		  function() 
		  {
				$.ajax({
					url: base_url+ '/ajax/admin_update',
					data: { action: "download_update", filename : file_zip, r:randomNumber} ,
					type: 'POST',
					async: false,
					cache: false,
					timeout: 30000,
					dataType: "json",
					success: function(response) {
						if (response.status == '1'){
						$("#step2_updating_text").append(response.msg+"\n"); 
							setTimeout(
							function() 
							{	
							   $("#step2_updating_text").append("Extrating "+file_zip+" ...\n"); 
							   extracting_update(file_zip);
							}, 3000);						  
						} else {
							$("#step2_updating_text").append(response.msg+"\n"); 	
						}				
					}
				});
		  }, 5000);		
		
		
	}
	
	if (updating_page == 'step3') {
		$("#step3_updating_text").append("Checking for update_sql.php ...\n");
		setTimeout(
		  function() 
		  {
				$.ajax({
					url: base_url+ '/ajax/admin_update',
					data: { action: "check_sql", r:randomNumber} ,
					type: 'POST',
					async: false,
					cache: false,
					timeout: 30000,
					dataType: "json",
					success: function(response) {
						if (response.status == '1'){
						$("#step3_updating_text").append(response.msg+"\n"); 
							setTimeout(
							function() 
							{	
							   $("#step3_updating_text").append("Running update_sql.php ...\n"); 
							   update_sql();
							}, 3000);						  
						} else {
							$("#step3_updating_text").append(response.msg+"\n"); 
							$(".nextBtnStep4").show();
						}				
					}
				});			  
			  
		  }, 5000);		
		
		
				
	}
	
	$("#agreed").on('change', function() {
		if(this.checked) {
			$(".nextBtnStep2").show();
		} else {
			$(".nextBtnStep2").hide();
		}
	});	
});

function extracting_update(file_zip){
	var randomNumber = Math.random();
	$.ajax({
		url: base_url+ '/ajax/admin_update',
		data: { action: "extract_update", filename : file_zip, r:randomNumber},
		type: 'POST',
		async: false,
		cache: false,
		timeout: 30000,
		dataType: "json",
		success: function(response) {
			if (response.status == '1'){				
				setTimeout(
				function() 
				{	
					$("#step2_updating_text").append(response.msg+"\n"); 
					$(".nextBtnStep3").show();
				}, 3000);				
			} else {
				$("#step2_updating_text").append(" - [FAILED]\n");
				$("#step2_updating_text").append(response.msg+"\n"); 	
			}				
		}
	});	
}

function update_sql(){
	var randomNumber = Math.random();
	$.ajax({
		url: base_url+ '/ajax/admin_update',
		data: { action: "update_sql", r:randomNumber},
		type: 'POST',
		async: false,
		cache: false,
		timeout: 30000,
		dataType: "json",
		success: function(response) {
			var themsg = response.msg;
			themsg = themsg.replace(/<br>/g, '\n');
			setTimeout(
			function() 
			{	
				$("#step3_updating_text").append(themsg+"\n"); 
				$(".nextBtnStep4").show();
			}, 3000);				
		}
	});	
}
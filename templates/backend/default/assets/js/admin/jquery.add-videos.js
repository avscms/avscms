$(document).ready(function(){

	$("#category").select2();
	//$("#category").select2 ('container').find ('.select2-search').addClass ('hidden');

	if (grabbing) {
		var intervalId = window.setInterval(function(){
			$.post(base_url + '/ajax/check_size', { path: path },
				function (response) {
					if (response.size) {
						var progress = Math.ceil((100 * response.size) / filesize);
						document.getElementById("download_progress").style.width = progress + "%";
						if (progress >= 100) {
							//window.clearInterval(intervalId);
						}
						if (response.sd_size != 0) {
							document.getElementById("sd_video").textContent = response.sd_size;
							$( "#sd_video_c" ).fadeIn();
						}
						if (response.mobile_size != 0) {
							document.getElementById("mobile_video").textContent = response.mobile_size;
							$( "#mobile_video_c" ).fadeIn();						
						}
						if (response.hd_size != 0) {
							document.getElementById("hd_video").textContent = response.hd_size;
							$( "#hd_video_c" ).fadeIn();
						}
						if (response.thumbnails != 0) {
							document.getElementById("thumbnails").textContent = response.thumbnails;
							$( "#thumbnails_c" ).fadeIn();
						}					
						if (response.ready) {
							$( "#g_ready" ).fadeIn();
							window.clearInterval(intervalId);
						}
						if (response.failed) {
							$( "#g_failed" ).fadeIn();
							window.clearInterval(intervalId);
						}
					} else {
						if (response.failed) {
							$( "#g_failed" ).fadeIn();
							window.clearInterval(intervalId);
						}						
					}
			}, "json"); 
		}, 1000);
	}
});
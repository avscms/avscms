$(document).ready(function(){
    $("img[id*='select_tmb_']").click(function(event) {
        event.preventDefault();
        var click_id    = $(this).attr('id');
        var id_split    = click_id.split('_');
		var vid			= id_split[2];
        var thumb       = id_split[3];
        for( var i=1; i<=20; i++ ) {
            if ( i == thumb ) {
				$(this).removeClass("tmb");
				$(this).addClass("tmb-active");
            } else {
				if ($("img[id='select_tmb_" + vid + "_" + i + "']").hasClass("tmb-active")) {
					$("img[id='select_tmb_" + vid + "_" + i + "']").removeClass("tmb-active");
					$("img[id='select_tmb_" + vid + "_" + i + "']").addClass("tmb");
				}
            }
        }
		$("input[id='thumb']").val(thumb);
    });
});

var timers  = new Array;
var images  = new Array;
function changeThumb( id, url )
{
        document.getElementById(id).src = url;
}
function thumb_path( vid ) {
	var index = parseInt( (vid - 1) / max_thumb_folders );
	var tmb_folder = 'tmb';
	if ( index !== 0 ) {
		tmb_folder = 'tmb'+ index;
	}
	var path = base_url + '/media/videos/' + tmb_folder;
    return path;
}
$(document).ready(function() {
	
	$("body").on('mouseenter', "[id*='playvthumb_']", function(event) {
		var img = $(this).find('img:first');
		if (!img.hasClass("img-private")) {			
			var image_id    = $(this).attr("id");
			var id_split    = image_id.split('_');
			var video_id    = id_split[1];
			var video 		= $('<video style="width:100%; height:100%; position:absolute; top:0; left:0;" class="img-fluid" muted autoplay loop>');
			var content 	= '<source type="video/webm" src="'+thumb_path(video_id) + '/' + video_id + '/video.webm"></source>';
				content		= content + '<source type="video/mp4" src="'+thumb_path(video_id) + '/' + video_id + '/video.mp4"></source>';
				$(video).append(content);
				$(video).hide();
				var vloader = $('<span class="vloader">');
				var target = $(this).find('img:first');
				$(target).after($(video));$(video).after($(vloader));
				$( ".vloader" ).animate({ width: '100%',}, 2000, function() {$( ".vloader" ).fadeOut();});
				$("#thumbPlayer").css('visibility','visible');

				var vid = $(video)[0];
				vid.load();
				vid.oncanplay = function(){
					vid.play();
				};
				$(vid).on('play', function() {
					$(video).fadeIn(); 
				});
		}
	});
	$("body").on('mouseleave', "[id*='playvthumb_']", function(event) {
		var target = $(this).find('video');
		var img = $(this).find('img:first');
		$(target).remove();$(this).find('.vloader').remove(); $(img).show(); 
	});
	
    $("body").on('mouseover', "img[id*='rotate_']", function(event) {
        var image_id    = $(this).attr("id");
        var id_split    = image_id.split('_');
        var video_id    = id_split[1];
		var thumbs		= id_split[2];
		if (typeof thumbs == "undefined") {
			thumbs = 20;
		}
		
        for ( var i=1; i<=thumbs; i++ ) {
            var image_url = thumb_path(video_id) + '/' + video_id + '/' + i + '.jpg';
            images[i]     = new Image();
            images[i].src = image_url;
        }
        for ( var i=1; i<=thumbs; i++ ) {
            timers[i] = setTimeout("changeThumb('" + image_id + "','" + thumb_path(video_id) + '/' + video_id + '/' + i + '.jpg' + "')", i*50*10);
        }
    }).on('mouseout', "img[id*='rotate_']", function(event) {
        var image_id    = $(this).attr("id");
        var id_split    = image_id.split('_');
        var video_id    = id_split[1];
		var thumbs		= id_split[2];
		var def_thumb = id_split[3];		
		if (typeof thumbs == "undefined") {
			thumbs = 20;
		}

        for ( var i=1; i<=thumbs; i++ ) {
            if ( typeof timers[i] == "number" ) {
                clearTimeout(timers[i]);
            }
        }
		if ( $.isNumeric(def_thumb) )
			$(this).attr('src', thumb_path(video_id) + '/' + video_id + '/' + def_thumb + '.jpg');
		else
			$(this).attr('src', thumb_path(video_id) + '/' + video_id + '/1.jpg');
    });
});

var player = videojs('video');

player.videoJsResolutionSwitcher({
	default: player_resolution
});

if (typeof mysrc !== 'undefined' && mysrc.length > 0) {
    player.updateSrc(mysrc);
} 



if (player_logo == '1') {
	if (player_logo_redirect != '1') {
		player_logo_link = "#";
	}
	player.logobrand({
		image: player_logo_image, //image to use
		destination: player_logo_link, //destination when clicked
		position: player_logo_position,
		opacity: player_logo_opacity
	});	
}

if (player_pause_adv == '1' && aid != false) {
	var ad_div = document.createElement('div');
	ad_div.innerHTML = '<iframe class="ad-iframe" src="' + base_url + '/ads.php?id='  + aid +  '" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" onload="resizeIframe(this)" style="display: hidden; width: 0; height: 0;"></iframe>';
	var ad_ifrm = ad_div.firstChild;
     
	$("body").on('click', "button[id*='ad-resume']", function(event) {  
		event.preventDefault();
		if ( $( ".ad-controls" ).length ) {	
			$(".ad-controls").remove();
			player.el().removeChild(ad_ifrm);
			player.play();
		}
		
	});

	$("body").on('click', "button[id*='ad-close']", function(event) {  
		event.preventDefault();
		if ( $( ".ad-controls" ).length ) {		
			$(".ad-controls").remove();	
			player.el().removeChild(ad_ifrm);
		}
	});
	
	function resizeIframe(obj) {
		var w = obj.contentWindow.document.body.scrollWidth;
		var h =  obj.contentWindow.document.body.scrollHeight;
		var ml = -(w / 2);
		var mt = -(h / 2) - 14;	
		var ml_controls = -91;	
		var mt_controls = (h / 2) - 12;
		obj.style.width = w + 'px';
		obj.style.height = h + 'px';		
		obj.style.marginLeft = ml + 'px';
		obj.style.marginTop = mt + 'px';
		obj.style.display = 'block';	
		$('<div id="ad-controls" class="ad-controls" style="margin-left: ' + ml_controls + 'px; margin-top: ' + mt_controls + 'px;"><button id="ad-resume" class="ad-resume" title="Resume">&#9654;&nbsp;&nbsp;RESUME</button> <button id="ad-close" class="ad-close" title="Close Ad">&#10005;&nbsp;&nbsp;CLOSE</button></div>').insertBefore(obj);
	}
}

player.ready(function(){

	if (player_pause_adv == '1' && aid != false) {
		this.on("pause", function(){
			if (!this.seeking() && this.paused() && this.currentTime()> 1) {
				this.el().appendChild(ad_ifrm);
				display_ads = false;
			}
		});
		
		this.on("play", function(){
			if ( $( ".ad-controls" ).length ) {
				$(".ad-controls").remove();
				this.el().removeChild(ad_ifrm);
			}
		});
	}

	if (player_timeline_preview == '1') {
		var step = (video_duration / 20);
		var resize = 0.6;
		var thumb_w = Math.floor(256*resize);
		var thumb_h =  Math.floor(144*resize);
		this.thumbnails({
			0: {
				src: player_sprite,
				style: {
				  left: '-'+(Math.floor(thumb_w/2))+'px',
				  width: ''+(thumb_w*20)+'px',
				  height: ''+thumb_h+'px',
				  clip: 'rect(0, '+thumb_w+'px, '+thumb_h+'px, 0)'
				}
			},
			[Math.round(1*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (1*thumb_w))+'px',
				  clip: 'rect(0, '+((1+1)*thumb_w)+'px, '+thumb_h+'px, '+(1*thumb_w)+'px)'
				}
			},
			[Math.round(2*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (2*thumb_w))+'px',
				  clip: 'rect(0, '+((2+1)*thumb_w)+'px, '+thumb_h+'px, '+(2*thumb_w)+'px)'
				}
			},		
			[Math.round(3*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (3*thumb_w))+'px',
				  clip: 'rect(0, '+((3+1)*thumb_w)+'px, '+thumb_h+'px, '+(3*thumb_w)+'px)'
				}
			},		
			[Math.round(4*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (4*thumb_w))+'px',
				  clip: 'rect(0, '+((4+1)*thumb_w)+'px, '+thumb_h+'px, '+(4*thumb_w)+'px)'
				}
			},		
			[Math.round(5*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (5*thumb_w))+'px',
				  clip: 'rect(0, '+((5+1)*thumb_w)+'px, '+thumb_h+'px, '+(5*thumb_w)+'px)'
				}
			},		
			[Math.round(6*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (6*thumb_w))+'px',
				  clip: 'rect(0, '+((6+1)*thumb_w)+'px, '+thumb_h+'px, '+(6*thumb_w)+'px)'
				}
			},		
			[Math.round(7*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (7*thumb_w))+'px',
				  clip: 'rect(0, '+((7+1)*thumb_w)+'px, '+thumb_h+'px, '+(7*thumb_w)+'px)'
				}
			},		
			[Math.round(8*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (8*thumb_w))+'px',
				  clip: 'rect(0, '+((8+1)*thumb_w)+'px, '+thumb_h+'px, '+(8*thumb_w)+'px)'
				}
			},		
			[Math.round(9*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (9*thumb_w))+'px',
				  clip: 'rect(0, '+((9+1)*thumb_w)+'px, '+thumb_h+'px, '+(9*thumb_w)+'px)'
				}
			},		
			[Math.round(10*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (10*thumb_w))+'px',
				  clip: 'rect(0, '+((10+1)*thumb_w)+'px, '+thumb_h+'px, '+(10*thumb_w)+'px)'
				}
			},
			[Math.round(11*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (11*thumb_w))+'px',
				  clip: 'rect(0, '+((11+1)*thumb_w)+'px, '+thumb_h+'px, '+(11*thumb_w)+'px)'
				}
			},		
			[Math.round(12*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (12*thumb_w))+'px',
				  clip: 'rect(0, '+((12+1)*thumb_w)+'px, '+thumb_h+'px, '+(12*thumb_w)+'px)'
				}
			},		
			[Math.round(13*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (13*thumb_w))+'px',
				  clip: 'rect(0, '+((13+1)*thumb_w)+'px, '+thumb_h+'px, '+(13*thumb_w)+'px)'
				}
			},		
			[Math.round(14*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (14*thumb_w))+'px',
				  clip: 'rect(0, '+((14+1)*thumb_w)+'px, '+thumb_h+'px, '+(14*thumb_w)+'px)'
				}
			},		
			[Math.round(15*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (15*thumb_w))+'px',
				  clip: 'rect(0, '+((15+1)*thumb_w)+'px, '+thumb_h+'px, '+(15*thumb_w)+'px)'
				}
			},		
			[Math.round(6*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (16*thumb_w))+'px',
				  clip: 'rect(0, '+((16+1)*thumb_w)+'px, '+thumb_h+'px, '+(16*thumb_w)+'px)'
				}
			},		
			[Math.round(17*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (17*thumb_w))+'px',
				  clip: 'rect(0, '+((17+1)*thumb_w)+'px, '+thumb_h+'px, '+(17*thumb_w)+'px)'
				}
			},		
			[Math.round(18*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (18*thumb_w))+'px',
				  clip: 'rect(0, '+((18+1)*thumb_w)+'px, '+thumb_h+'px, '+(18*thumb_w)+'px)'
				}
			},		
			[Math.round(19*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (19*thumb_w))+'px',
				  clip: 'rect(0, '+((19+1)*thumb_w)+'px, '+thumb_h+'px, '+(19*thumb_w)+'px)'
				}
			},		
			[Math.round(20*step)]: {
				style: {
				  left: '-'+(Math.floor(thumb_w/2) + (20*thumb_w))+'px',
				  clip: 'rect(0, '+((20+1)*thumb_w)+'px, '+thumb_h+'px, '+(20*thumb_w)+'px)'
				}
			}		
		});		
	}
	
   $('.video-container').mousedown(function(event) {
      if(event.which === 3) {
         $('.video-container').bind('contextmenu',function () { return false; });
       }
       else {
         $('.video-container').unbind('contextmenu');
       }
   });	
   

});	
/*
 * Video.js logobrand
 * https://github.com/Mewte/videojs-logobrand
 *
 * Copyright (c) 2014 Mewte @ InstaSynch
 * Licensed under the MIT license
 */

(function(vjs) {

	// define some reasonable defaults
	var defaults = {
		image: '',
		destination: '#',
		position: 'top-right',
		opacity: '40'
	};
	// plugin initializer
	var logobrand = function(options) {		
		var settings = videojs.mergeOptions(defaults, options), player = this;
		
		if (settings.destination != '#') {
			var link = document.createElement("a");
				link.href = settings.destination;
				link.target = "_blank";
		} else {
			var link = document.createElement("span");
		}
				link.id = "vjs-logobrand-image-destination";		
		var image = document.createElement('img');
			image.id = 'vjs-logobrand-image-' + settings.position;
			//image.style.height = settings.height;
			//image.style.width = settings.width;
			image.style.opacity = (settings.opacity/100);			
			image.src = settings.image;
			link.appendChild(image);

		player.el().appendChild(link);
		
		this.loadImage = function(src){
			document.getElementById("vjs-logobrand-image-" + settings.position).src=src;
		};
		this.setDestination = function(href){
			document.getElementById("vjs-logobrand-image-destination").href = href;
		};
		return this;
	};	
	// register the plugin with video.js
	vjs.plugin('logobrand', logobrand);

}(window.videojs));

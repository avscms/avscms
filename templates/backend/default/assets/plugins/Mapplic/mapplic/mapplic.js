/**
 * Mapplic - Custom Interactive Map Plugin by @sekler
 * http://www.mapplic.com 
 */

(function($) {

	var Mapplic = function() {
		var self = this;

		self.o = {
			source: 'locations.json',
			height: 420,
			locations: true,
			minimap: true,
			sidebar: true,
			deeplinking: true,
			search: true,
			clearbutton: true,
			hovertip: true,
			fullscreen: false,
			developer: false,
			animate: true,
			maxscale: 4
		};

		self.init = function(el, params) {
			// Extend options
			self.o = $.extend(self.o, params);

			self.x = 0;
			self.y = 0;
			self.scale = 1;

			self.el = el.addClass('mapplic-element mapplic-loading').height(self.o.height);

			// Process JSON file
			$.getJSON(self.o.source, function(data) { // Success
				processData(data);
				self.el.removeClass('mapplic-loading');

				// Controls
				addControls();

			}).fail(function() { // Failure: couldn't load JSON file, or it is invalid.
				console.error('Couldn\'t load map data. (Make sure you are running the script through a server and not just opening the html file with your browser)');
				alert('Data file missing or invalid!');
			});

			return self;
		}

		// Tooltip
		function Tooltip() {
			this.el = null;
			this.shift = 6;
			this.drop = 0;

			this.init = function() {
				var s = this;

				// Construct
				this.el = $('<div></div>').addClass('mapplic-tooltip');
				$('<a></a>').addClass('mapplic-tooltip-close').attr('href', '#').click(function(e) {
					e.preventDefault();
					self.deeplinking.clear();
					s.hide();
				}).appendTo(this.el);
				this.image = $('<img>').addClass('mapplic-tooltip-image').hide().appendTo(this.el);
				this.title = $('<h4></h4>').addClass('mapplic-tooltip-title').appendTo(this.el);
				this.content = $('<div></div>').addClass('mapplic-tooltip-content').appendTo(this.el);
				this.desc = $('<div></div>').addClass('mapplic-tooltip-description').appendTo(this.content);
				this.link = $('<a>More</a>').addClass('mapplic-tooltip-link').attr('href', '#').hide().appendTo(this.el);
				$('<div></div>').addClass('mapplic-tooltip-triangle').prependTo(this.el);

				// Append
				self.map.append(this.el);
			}

			this.set = function(location) {
				if (location) {
					if (location.action == 'none') {
						this.el.stop().fadeOut(300);
						return;
					}

					var s = this;

					if (location.image) this.image.attr('src', location.image).show();
					else this.image.hide();

					if (location.link) this.link.attr('href', location.link).show();
					else this.link.hide();

					this.title.text(location.title);
					this.desc.html(location.description);

					// Shift
					var pinselect = $('.mapplic-pin[data-location="' + location.id + '"]');
					if (pinselect.length == 0) {
						this.shift = 6;
					}
					else this.shift = pinselect.height() + 6;

					// Loading & positioning
					$('img', this.desc).load(function() {
						s.position(location);
					});

					this.position(location);
				}
			}

			this.show = function(location) {
				if (location) {
					if (location.action == 'none') {
						this.el.stop().fadeOut(300);
						return;
					}

					var s = this;

					if (location.image) this.image.attr('src', location.image).show();
					else this.image.hide();

					if (location.link) this.link.attr('href', location.link).show();
					else this.link.hide();

					this.title.text(location.title);
					this.desc.html(location.description);

					// Shift
					var pinselect = $('.mapplic-pin[data-location="' + location.id + '"]');
					if (pinselect.length == 0) {
						this.shift = 6;
					}
					else this.shift = pinselect.height() + 6;

					// Loading & positioning
					$('img', this.desc).load(function() {
						s.position(location);
					});

					this.position(location);
				
					// Making it visible
					this.el.stop().fadeIn(200).show();
				}
			}

			this.position = function(location) {
				var x = location.x * 100;
					y = location.y * 100;
					mt = -this.el.outerHeight() - this.shift,
					ml = -this.el.outerWidth() / 2;
				this.el.css({
					left: x + '%',
					top: y + '%',
					marginTop: mt,
					marginLeft: ml
				});
				this.drop = this.el.outerHeight() + this.shift;
			}

			this.hide = function() {
				var s = this;
				
				this.el.stop().fadeOut(300, function() {
					s.desc.empty();
				});
			}
		}

		// Deeplinking
		function Deeplinking() {
			this.init = function() {
				// Check hash for location
				var id = location.hash.slice(1);
				if (id) {
					var locationData = getLocationData(id);

					self.tooltip.set(locationData);
					showLocation(id, 0);
					self.tooltip.show(locationData);
				}
				else zoomTo(0.5, 0.5, 1, 0);

				// Hashchange
				$(window).on('hashchange', function() {
					var id = location.hash.slice(1);

					if (id) {
						var locationData = getLocationData(id);

						self.tooltip.set(locationData);
						showLocation(id, 800);
						self.tooltip.show(locationData);
					}
				});
			}

			this.clear = function() {
				// if IE 6-8, else normal browsers
				if (history.pushState) history.pushState('', document.title, window.location.pathname);
				else window.location.hash = '';
			}
		}

		// HoverTooltip
		function HoverTooltip() {
			this.el = null;
			this.shift = 6;

			this.init = function() {
				var s = this;

				// Construct
				this.el = $('<div></div>').addClass('mapplic-tooltip mapplic-hovertip');
				this.title = $('<h4></h4>').addClass('mapplic-tooltip-title').appendTo(this.el);
				$('<div></div>').addClass('mapplic-tooltip-triangle').appendTo(this.el);

				// Events
				$(self.map).on('mouseover', '.mapplic-layer a', function() {
					var data = '';
					if ($(this).hasClass('mapplic-pin')) {
						data = $(this).data('location');
						s.shift = $(this).height() + 6;
					}
					else {
						data = $(this).attr('xlink:href').slice(1);
						s.shift = 6;
					}

					var location = getLocationData(data);
					if (location) s.show(location);
				}).on('mouseout', function() {
					s.hide();
				});

				self.map.append(this.el);
			}

			this.show = function(location) {
				this.title.text(location.title);

				var x = location.x * 100,
					y = location.y * 100,
					mt = -this.el.outerHeight() - this.shift,
					ml = -this.el.outerWidth() / 2;
				this.el.css({
					left: x + '%',
					top: y + '%',
					marginTop: mt,
					marginLeft: ml
				});

				this.el.stop().fadeIn(100);
			}

			this.hide = function() {
				this.el.stop().fadeOut(200);
			}
		}

		// Minimap
		function Minimap() {
			this.el = null;

			this.init = function() {
				this.el = $('<div></div>').addClass('mapplic-minimap').appendTo(self.container);
				this.el.css('height', this.el.width() * self.hw_ratio);
				this.el.click(function(e) {
					e.preventDefault();

					var x = (e.pageX - $(this).offset().left) / $(this).width(),
						y = (e.pageY - $(this).offset().top) / $(this).height();

					zoomTo(x, y, self.scale / self.fitscale, 100);
				});
			}

			this.addLayer = function(data) {
				var layer = $('<div></div>').addClass('mapplic-minimap-layer').addClass(data.id).appendTo(this.el);
				$('<img>').attr('src', data.minimap).addClass('mapplic-minimap-background').appendTo(layer);
				$('<div></div>').addClass('mapplic-minimap-overlay').appendTo(layer);
				$('<img>').attr('src', data.minimap).addClass('mapplic-minimap-active').appendTo(layer);
			}

			this.show = function(target) {
				$('.mapplic-minimap-layer:visible', this.el).hide();
				$('.mapplic-minimap-layer.' + target, this.el).show();
			}

			this.update = function(x, y) {
				var active = $('.mapplic-minimap-active', this.el);

				if (x === undefined) x = self.x;
				if (y === undefined) y = self.y;

				var width = Math.round(self.container.width() / self.contentWidth / self.scale * this.el.width()),
					height = Math.round(self.container.height() / self.contentHeight / self.scale * this.el.height()),
					top = Math.round(-y / self.contentHeight / self.scale * this.el.height()),
					left = Math.round(-x / self.contentWidth / self.scale * this.el.width()),
					right = left + width,
					bottom = top + height;

				active.css('clip', 'rect(' + top + 'px, ' + right + 'px, ' + bottom + 'px, ' + left + 'px)');
			}
		}

		// Sidebar
		function Sidebar() {
			this.el = null;
			this.list = null;

			this.init = function() {
				var s = this;

				this.el = $('<div></div>').addClass('mapplic-sidebar').appendTo(self.el);

				if (self.o.search) {
					var form = $('<form></form>').addClass('mapplic-search-form').submit(function() {
						return false;
					}).appendTo(this.el);
					self.clear = $('<button></button>').addClass('mapplic-search-clear').click(function() {
						input.val('');
						input.keyup();
					}).appendTo(form);
					var input = $('<input>').attr({'type': 'text', 'spellcheck': 'false', 'placeholder': 'Search for location...'}).addClass('mapplic-search-input').keyup(function() {
						var keyword = $(this).val();
						s.search(keyword);
					}).prependTo(form);
				}

				var listContainer = $('<div></div>').addClass('mapplic-list-container').appendTo(this.el);
				this.list = $('<ol></ol>').addClass('mapplic-list').appendTo(listContainer);
				this.notfound = $('<p></p>').addClass('mapplic-not-found').text('Nothing found. Please try a different search.').appendTo(listContainer);

				if (!self.o.search) listContainer.css('padding-top', '0');
			}

			this.addCategories = function(categories) {
				var list = this.list;

				$.each(categories, function(index, category) {
					var item = $('<li></li>').addClass('mapplic-list-category').addClass(category.id);
					var ol = $('<ol></ol>').css('border-color', category.color).appendTo(item);
					if (category.show == 'false') ol.hide();
					var link = $('<a></a>').attr('href', '#').attr('title', category.title).css('background-color', category.color).text(category.title).click(function(e) {
						ol.slideToggle(200);
						return false;
					}).prependTo(item);
					if (category.icon) $('<img>').attr('src', category.icon).addClass('mapplic-list-thumbnail').prependTo(link);
					$('<span></span>').text('0').addClass('mapplic-list-count').prependTo(link);
					list.append(item);
				});
			}

			this.addLocation = function(data) {
				var item = $('<li></li>').addClass('mapplic-list-location').addClass('mapplic-list-shown');
				var link = $('<a></a>').attr('href', '#' + data.id).appendTo(item);
				if (data.thumbnail) $('<img>').attr('src', data.thumbnail).addClass('mapplic-list-thumbnail').appendTo(link);
				$('<h4></h4>').text(data.title).appendTo(link)
				$('<span></span>').html(data.about).appendTo(link);
				var category = $('.mapplic-list-category.' + data.category);

				if (category.length) $('ol', category).append(item);
				else this.list.append(item);

				// Count
				$('.mapplic-list-count', category).text($('.mapplic-list-shown', category).length);
			}

			this.search = function(keyword) {
				if (keyword) self.clear.fadeIn(100);
				else self.clear.fadeOut(100);

				$('.mapplic-list li', self.el).each(function() {
					if ($(this).text().search(new RegExp(keyword, "i")) < 0) {
						$(this).removeClass('mapplic-list-shown');
						$(this).slideUp(200);
					} else {
						$(this).addClass('mapplic-list-shown');
						$(this).show();
					}
				});

				$('.mapplic-list > li', self.el).each(function() {
					var count = $('.mapplic-list-shown', this).length;
					$('.mapplic-list-count', this).text(count);
				});

				// Show not-found text
				if ($('.mapplic-list > li.mapplic-list-shown').length > 0) this.notfound.fadeOut(200);
				else this.notfound.fadeIn(200);
			}
		}

		// Developer tools
		function DevTools() {
			this.el = null;

			this.init = function() {
				this.el = $('<div></div>').addClass('mapplic-coordinates').appendTo(self.container);
				this.el.append('x: ');
				$('<code></code>').addClass('mapplic-coordinates-x').appendTo(this.el);
				this.el.append(' y: ');
				$('<code></code>').addClass('mapplic-coordinates-y').appendTo(this.el);

				$('.mapplic-layer', self.map).on('mousemove', function(e) {
					var x = (e.pageX - self.map.offset().left) / self.map.width(),
						y = (e.pageY - self.map.offset().top) / self.map.height();
					$('.mapplic-coordinates-x').text(parseFloat(x).toFixed(4));
					$('.mapplic-coordinates-y').text(parseFloat(y).toFixed(4));
				});
			}
		}

		// Clear Button
		function ClearButton() {
			this.el = null;
			
			this.init = function() {
				this.el = $('<a></a>').attr('href', '#').addClass('mapplic-clear-button').click(function(e) {
					e.preventDefault();
					self.deeplinking.clear();
					self.tooltip.hide();
					zoomTo(0.5, 0.5, 1);
				}).appendTo(self.container);
			}
		}

		// Full Screen
		function FullScreen() {
			this.el = null;

			this.init = function() {
				var s = this;
				this.element = self.el[0];

				$('<a></a>').attr('href', '#').attr('href', '#').addClass('mapplic-fullscreen-button').click(function(e) {
					e.preventDefault();

					if (s.isFull()) s.exitFull();
					else s.goFull();

				}).appendTo(self.container);
			}

			this.goFull = function() {
				if (this.element.requestFullscreen) this.element.requestFullscreen();
				else if(this.element.mozRequestFullScreen) this.element.mozRequestFullScreen();
				else if(this.element.webkitRequestFullscreen) this.element.webkitRequestFullscreen();
				else if(this.element.msRequestFullscreen) this.element.msRequestFullscreen();
			}

			this.exitFull = function() {
				if (document.exitFullscreen) document.exitFullscreen();
				else if(document.mozCancelFullScreen) document.mozCancelFullScreen();
				else if(document.webkitExitFullscreen) document.webkitExitFullscreen();
			}

			this.isFull = function() {
				if (window.innerHeight == screen.height) {
					return true;
				} else {
					return false;
				}
			}
		}

		// Functions
		var processData = function(data) {
			self.data = data;
			var nrlevels = 0;
			var shownLevel;

			self.container = $('<div></div>').addClass('mapplic-container').appendTo(self.el);
			self.map = $('<div></div>').addClass('mapplic-map').appendTo(self.container);

			self.levelselect = $('<select></select>').addClass('mapplic-levels-select');

			if (!self.o.sidebar) self.container.css('width', '100%');

			self.contentWidth = data.mapwidth;
			self.contentHeight = data.mapheight;

			self.hw_ratio = data.mapheight / data.mapwidth;
			if (data.mapheight / self.container.height() > data.mapwidth / self.container.width()) {
				self.min_width = self.container.width();
				self.min_height = self.container.width() * self.hw_ratio;
			}
			else {
				self.min_height = self.container.height();
				self.min_width = self.container.height() / self.hw_ratio;
			}

			self.map.css({
				'width': data.mapwidth,
				'height': data.mapheight
			});

			// Create minimap
			if (self.o.minimap) {
				self.minimap = new Minimap();
				self.minimap.init();
			}

			// Create sidebar
			if (self.o.sidebar) {
				self.sidebar = new Sidebar();
				self.sidebar.init();
				self.sidebar.addCategories(data.categories);
			}

			// Iterate through levels
			if (data.levels) {
				$.each(data.levels, function(index, value) {
					var source = value.map;
					var extension = source.substr((source.lastIndexOf('.') + 1)).toLowerCase();

					// Create new map layer
					var layer = $('<div></div>').addClass('mapplic-layer').addClass(value.id).hide().appendTo(self.map);
					switch (extension) {

						// Image formats
						case 'jpg': case 'jpeg': case 'png': case 'gif':
							$('<img>').attr('src', source).addClass('mapplic-map-image').appendTo(layer);
							break;

						// Vector format
						case 'svg':
							$('<div></div>').addClass('mapplic-map-image').load(source).appendTo(layer);
							break;

						// Other 
						default:
							alert('File type ' + extension + ' is not supported!');
					}

					// Create new minimap layer
					if (self.minimap) self.minimap.addLayer(value);

					// Build layer control
					self.levelselect.prepend($('<option></option>').attr('value', value.id).text(value.title));

					if (!shownLevel || value.show) {
						shownLevel = value.id;
					}
					
					/* Iterate through locations */
					$.each(value.locations, function(index, value) {
						var top = value.y * 100;
						var left = value.x * 100;

						if (value.pin != 'hidden') {
							if (self.o.locations) {
								var target = '#' + value.id;
								if (value.action == 'redirect') target = value.link;

								var pin = $('<a></a>').attr('href', target).addClass('mapplic-pin').css({'top': top + '%', 'left': left + '%'}).appendTo(layer);
								pin.attr('data-location', value.id);
								pin.addClass(value.pin);
							}
						}

						if (self.sidebar) self.sidebar.addLocation(value);
					});

					nrlevels++;
				});
			}

			// Pin animation
			if (self.o.animate) {
				$('.mapplic-pin').css('opacity', '0');
				window.setTimeout(animateNext, 200);
			}

			function animateNext() {
				var select = $('.mapplic-pin:not(.mapplic-animate):visible');

				//console.log('enter');

				if (select.length > 0) {
					select.first().addClass('mapplic-animate');
					window.setTimeout(animateNext, 200);
				}
				else {
					$('.mapplic-animate').removeClass('mapplic-animate');
					$('.mapplic-pin').css('opacity', '1');
				}
			}

			// COMPONENTS

			// Hover Tooltip
			if (self.o.hovertip) self.hovertip = new HoverTooltip().init();

			// Tooltip
			self.tooltip = new Tooltip();
			self.tooltip.init();

			// Developer tools
			if (self.o.developer) self.devtools = new DevTools().init();

			// Clear button
			if (self.o.clearbutton) self.clearbutton = new ClearButton().init();

			// Fullscreen
			if (self.o.fullscreen) self.fullscreen = new FullScreen().init();

			// Levels
			if (nrlevels > 1) {
				self.levels = $('<div></div>').addClass('mapplic-levels');
				var up = $('<a href="#"></a>').addClass('mapplic-levels-up').appendTo(self.levels);
				self.levelselect.appendTo(self.levels);
				var down = $('<a href="#"></a>').addClass('mapplic-levels-down').appendTo(self.levels);
				self.container.append(self.levels);
			
				self.levelselect.change(function() {
					var value = $(this).val();
					level(value);
				});
			
				up.click(function(e) {
					e.preventDefault();
					if (!$(this).hasClass('disabled')) level('+');
				});

				down.click(function(e) {
					e.preventDefault();
					if (!$(this).hasClass('disabled')) level('-');
				});
			}
			level(shownLevel);

			// Browser resize
			$(window).resize(function() {
				var wr = self.container.width() / self.contentWidth,
					hr = self.container.height() / self.contentHeight;

				if (wr > hr) self.fitscale = wr;
				else self.fitscale = hr;

				self.scale = normalizeScale(self.scale);
				self.x = normalizeX(self.x);
				self.y = normalizeY(self.y);

				moveTo(self.x, self.y, self.scale, 100);
			}).resize();

			// Deeplinking
			if (self.o.deeplinking) {
				self.deeplinking = new Deeplinking();
				self.deeplinking.init();
			}
		}

		var addControls = function() {
			var map = self.map,
				mapbody = $('.mapplic-map-image', self.map);

			document.ondragstart = function() { return false; } // IE drag fix

			// Drag & drop
			mapbody.on('mousedown', function(event) {
				map.stop();

				map.data('mouseX', event.pageX);
				map.data('mouseY', event.pageY);
				map.data('lastX', self.x);
				map.data('lastY', self.y);

				map.addClass('mapplic-dragging');

				self.map.on('mousemove', function(event) {
					var x = event.pageX - map.data('mouseX') + self.x;
						y = event.pageY - map.data('mouseY') + self.y;

					x = normalizeX(x);
					y = normalizeY(y);

					moveTo(x, y);
					map.data('lastX', x);
					map.data('lastY', y);
				});
			
				$(document).on('mouseup', function(event) {
					self.x = map.data('lastX');
					self.y = map.data('lastY');

					self.map.off('mousemove');
					$(document).off('mouseup');

					map.removeClass('mapplic-dragging');
				});
			});

			// Double click
			$(document).on('dblclick', '.mapplic-map-image', function(event) {
				var mapPos = self.map.offset();
				var x = (event.pageX - mapPos.left) / self.map.width();
				var y = (event.pageY - mapPos.top) / self.map.height();
				var z = self.map.width() / self.min_width * 2;

				zoomTo(x, y, z, 600);
			});

			// Mousewheel
			$('.mapplic-layer', this.el).bind('mousewheel DOMMouseScroll', function(event, delta) {
				event.preventDefault();

				var scale = self.scale;
				self.scale = normalizeScale(scale + scale * delta/5);

				self.x = normalizeX(self.x - (event.pageX - self.container.offset().left - self.x) * (self.scale/scale - 1));
				self.y = normalizeY(self.y - (event.pageY - self.container.offset().top - self.y) * (self.scale/scale - 1));

				moveTo(self.x, self.y, self.scale, 100);
			});

			// Touch support
			if (!('ontouchstart' in window || 'onmsgesturechange' in window)) return true;

			mapbody.on('touchstart', function(e) {
				var orig = e.originalEvent,
					pos = map.position();

				map.data('touchY', orig.changedTouches[0].pageY - pos.top);
				map.data('touchX', orig.changedTouches[0].pageX - pos.left);

				mapbody.on('touchmove', function(e) {
					e.preventDefault();
					var orig = e.originalEvent;
					var touches = orig.touches.length;

					if (touches == 1) {
						self.x = normalizeX(orig.changedTouches[0].pageX - map.data('touchX'));
						self.y = normalizeY(orig.changedTouches[0].pageY - map.data('touchY'));

						moveTo(self.x, self.y, self.scale, 100);
					}
					else {
						mapbody.off('touchmove');
					}
				});

				mapbody.on('touchend', function(e) {
					mapbody.off('touchmove touchend');
				});
			});
			
			// Pinch zoom
			var mapPinch = Hammer(self.map[0], {
				transform_always_block: true,
				drag_block_horizontal: true,
				drag_block_vertical: true
			});

			var scale=1, last_scale;

			mapPinch.on('touch transform', function(ev) {
				switch(ev.type) {
					case 'touch':
						last_scale = scale;
						break;

					case 'transform':
						var center = ev.gesture.center;
						scale = Math.max(1, Math.min(last_scale * ev.gesture.scale, 10));

						var oldscale = self.scale;
						self.scale = normalizeScale(scale * self.fitscale);

						self.x = normalizeX(self.x - (center.pageX - self.container.offset().left - self.x) * (self.scale/oldscale - 1));
						self.y = normalizeY(self.y - (center.pageY - self.container.offset().top - self.y) * (self.scale/oldscale - 1));

						moveTo(self.x, self.y, self.scale, 200);

						break;
				}
			});
		}

		var level = function(target) {
			switch (target) {
				case '+':
					target = $('option:selected', self.levelselect).removeAttr('selected').prev().prop('selected', 'selected').val();
					break;
				case '-':
					target = $('option:selected', self.levelselect).removeAttr('selected').next().prop('selected', 'selected').val();
					break;
				default:
					$('option[value="' + target + '"]', self.levelselect).prop('selected', 'selected');
			}

			var layer = $('.mapplic-layer.' + target, self.map);

			// Target layer is active
			if (layer.is(':visible')) return;

			// Hide Tooltip
			self.tooltip.hide();

			// Show target layer
			$('.mapplic-layer:visible', self.map).hide();
			layer.show();

			// Show target minimap layer
			if (self.minimap) self.minimap.show(target);

			// Update control
			var index = self.levelselect.get(0).selectedIndex,
				up = $('.mapplic-levels-up', self.levels),
				down = $('.mapplic-levels-down', self.levels);

			up.removeClass('disabled');
			down.removeClass('disabled');
			if (index == 0) {
				up.addClass('disabled');
			}
			else if (index == self.levelselect.get(0).length - 1) {
				down.addClass('disabled');
			}
		}

		var getLocationData = function(id) {
			var data = null;
			$.each(self.data.levels, function(index, layer) {
				$.each(layer.locations, function(index, value) {
					if (value.id == id) {
						data = value;
					}
				});
			});
			return data;
		}

		var showLocation = function(id, duration) {
			$.each(self.data.levels, function(index, layer) {
				$.each(layer.locations, function(index, value) {
					if (value.id == id) {
						var zoom = typeof value.zoom !== 'undefined' ? value.zoom : 4,		
							drop = self.tooltip.drop / self.contentHeight / zoom;

						level(layer.id);

						zoomTo(value.x, parseFloat(value.y) - drop, zoom, duration, 'easeInOutCubic');
					}
				});
			});
		};

		var normalizeX = function(x) {
			var minX = self.container.width() - self.contentWidth * self.scale;

			if (x > 0) x = 0;
			else if (x < minX) x = minX;

			return x;
		}

		var normalizeY = function(y) {
			var minY = self.container.height() - self.contentHeight * self.scale;

			if (y >= 0) y = 0;
			else if (y < minY) y = minY;

			return y;
		}

		var normalizeScale = function(scale) {
			if (scale < self.fitscale) scale = self.fitscale;
			else if (scale > self.o.maxscale) scale = self.o.maxscale;

			return scale;
		}

		var zoomTo = function(x, y, s, duration, easing) {
			duration = typeof duration !== 'undefined' ? duration : 400;

			self.scale = normalizeScale(self.fitscale * s);
			var scale = self.contentWidth * self.scale;

			self.x = normalizeX(self.container.width() * 0.5 - self.scale * self.contentWidth * x);
			self.y = normalizeY(self.container.height() * 0.5 - self.scale * self.contentHeight * y);

			moveTo(self.x, self.y, self.scale, duration, easing);
		}

		var moveTo = function(x, y, scale, d, easing) {
			if (scale !== undefined) {
				self.map.stop().animate({
					'left': x,
					'top': y,
					'width': self.contentWidth * scale,
					'height': self.contentHeight * scale
				}, d, easing);
			}
			else {
				self.map.css({
					'left': x,
					'top': y
				});
			}
			if (self.minimap) self.minimap.update(x, y);
		}
	};

	//  Create a jQuery plugin
	$.fn.mapplic = function(params) {
		var len = this.length;

		return this.each(function(index) {
			var me = $(this),
				key = 'mapplic' + (len > 1 ? '-' + ++index : ''),
				instance = (new Mapplic).init(me, params);

			me.data(key, instance).data('key', key);
		});
	};
})(jQuery);
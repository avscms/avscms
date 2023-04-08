// Purpose: functions shared between all supported browsers
window.onerror = wp_hide_error
var wp_version="2.2.4"
var image_action = false
var wp_thisRow = null
var wp_thisCell = null
var wp_thisTable = null
var wp_current_hyperlink = null
var wp_current_obj=null
var wp_debug_mode = false
var wp_inbase = false
// 222
var wp_donetext = null
var wp_ignore_next = false
// tag groups
var wp_inline_tags = /^(a|abbr|acronym|b|bdo|big|br|cite|code|dfn|em|font|i|img|kbd|label|q|s|samp|select|small|span|strike|strong|sub|sup|textarea|tt|u|var)$/i;
var wp_cant_have_children = /^(script|meta|link|input|br|hr|spacer|img|bgsound|embed|param|wbr|area|applet|object|basefont|style|title|comment|textarea|iframe)$/i;
var wp_cant_have_children_has_close_tag = /^(textarea|iframe|embed|object|applet)$/i;
var wp_boolean_attributes = /^(nowrap|ismap|declare|noshade|checked|disabled|readonly|multiple|selected|noresize|defer)$/i;
var wp_supported_blocks = /^(h1|h2|h3|h4|h5|h6|p|div|address|pre)$/i;
var wp_not_specified_ignore = /^(selected|coords|shape|type|value)$/i;
var wp_bogus_attributes = /^(_base_href|_moz_dirty|_moz_editor_bogus_node|_done)$/i;
var wp_attribute_allowed_empty = /^(alt|title|action|href|src|value)$/i;
var wp_attribute_case_must_lower = /^(align|valign|shape|type)$/i;
var wp_link_attributes = /^(src|href|action)$/i;
// 222
function wp_config () {
	this.lang = []
	this.useXHTML = false
	this.usep = false
	this.showbookmarkmngr = true
	this.subsequent = false
	//this.border_visible = 1 // now set through a PHP function
}
// 222
function wp_font_hack(node, obj) {
	var spans = node.getElementsByTagName("SPAN")
	var n = spans.length
	var j = 0
	for (var i = 0; i < n; i++) {
		if (spans[j]) {
			if (spans[j].className || spans[j].style.cssText.length > 1) {
				var newNode = obj.edit_object.document.createElement("FONT")
				var attributes = spans[j].attributes
				wp_add_attributes(newNode, attributes, spans[j])
				wp_font_hack(spans[j], obj)
				newNode.innerHTML = spans[j].innerHTML
				try {
					spans[j].parentNode.insertBefore(newNode, spans[j].nextSibling)
					spans[j].parentNode.removeChild(spans[j]);
				} catch (e) {
					j++
				}
			} else {
				j++
			}
		} else {
			j++
		}
	}
}
function wp_span_hack(node, obj) {
	var fonts = node.getElementsByTagName("FONT")
	var n = fonts.length
	var j = 0
	for (var i = 0; i < n; i++) {
		if (fonts[j]) {
			if (fonts[j].className || fonts[j].style.cssText.length > 1 && (!fonts[j].getAttribute('face') && !fonts[j].getAttribute('size') && !fonts[j].getAttribute('color')) ) {
				var newNode = obj.edit_object.document.createElement("SPAN")
				var attributes = fonts[j].attributes
				wp_add_attributes(newNode, attributes, fonts[j])
				wp_font_hack(fonts[j], obj)
				newNode.innerHTML = fonts[j].innerHTML
				try {
					fonts[j].parentNode.insertBefore(newNode, fonts[j].nextSibling)
					fonts[j].parentNode.removeChild(fonts[j]);
				} catch (e) {
					j++
				}
			} else {
				j++
			}
		} else {
			j++
		}
	}
}

function wp_add_attributes(node, attributes, oldNode, ignore_unique) {
	var l = attributes.length
	for (var j = 0; j < l; j++) {
		if (attributes[j].nodeName=='id' && ignore_unique) {
			continue;
		} else if (attributes[j].specified && attributes[j].nodeName!='class' && attributes[j].nodeName!='style') {
			node.setAttribute(attributes[j].nodeName, attributes[j].nodeValue, 0)
		} else if (attributes[j].nodeName=='class') {
			node.className = attributes[j].nodeValue
		} else if (attributes[j].nodeName=='style') {
			if (oldNode) {
				node.style.cssText = oldNode.style.cssText
			} else {
				node.style.cssText = attributes[j].nodeValue
			}
		}
	}
}
// end 222
function wp_closePopupTimer() {
	setTimeout("wp_closePopup()", 100);
}
// wp_stringbuilder, wp_gethtml, wp_fixAttibute, wp_fixText, wp_getAttributeValue and wp_appendNodeHTML are based on "getXhtml" by Erik Arvidsson available from http://webfx.eae.net/ used under license.
function wp_StringBuilder(sString) {
	this.append = function (sString) {
		this.length += (this._parts[this._current++] = String(sString)).length
		this._string = null
		return this
	}
	this.toString = function () {
		if (this._string != null)
			return this._string
		var s = this._parts.join("")
		this._parts = [s]
		this._current = 1
		this.length = s.length
		return this._string = s
	}
	this._current	= 0
	this._parts		= []
	this._string	= null
	if (sString != null)
		this.append(sString)
}
function wp_gethtml(node,obj) {
	var sb = new wp_StringBuilder
	// 222
	wp_inbase = false
	wp_donetext = null
	wp_ignore_next = false
	// 222
	var cn = node.childNodes
	var n = cn.length
	for (var i = 0; i < n; i++) {
		wp_appendNodeHTML(cn[i], sb, obj)
	}
	// 222
	if (obj.html_mode!=true && wp_is_ie) {
		wp_remove_done(node, obj)
	}
	// end 222
	var doctype = ''
	if (obj.useXHTML && !obj.snippit) {
		doctype =  '<?xml version="1.0" encoding="' + obj.encoding + '"?>\n'+obj.doctype+'\n'
	} else if (!obj.useXHTML && !obj.snippit) {
		doctype =  obj.doctype+'\n'
	}
	var code = doctype + sb.toString()
	code = code.replace(/\s\n/gi, '\n');
	return code.trim()
}// 222
function wp_remove_done(node, obj) {
	var body = false
	if (node.nodeName) {
		if (node.nodeName == 'BODY') {
			body = true
		}
	}
	if (body) {
		node.removeAttribute("_done", 1);
		node.innerHTML = node.innerHTML.replace(/ _done="true"/gi, '')
	} else {
		if (node._done) {
			node.removeAttribute("_done",1);
		}
		var cn = node.childNodes
		var n = cn.length
		for (var i = 0; i < n; i++) {
			if (cn[i]._done) {
				cn[i].removeAttribute("_done",1);
			}
			wp_remove_done(cn[i], obj);
		}
	}
}
function wp_quoteMeta(str) {
	str = str.replace(/\//gi, '\\/');
	str = str.replace(/\./gi, '\\.');
	return str;
}
// end 222
function wp_fixAttribute(value) {
	return String(value).replace(/\&/g, "&amp;").replace(/</g, "&lt;").replace(/\"/g, "&quot;")
}
function wp_fixText(text) {
	return String(text).replace(/\&/g, "&amp;").replace(/</g, "&lt;")
}
function wp_getAttributeValue(attrNode, elementNode, sb, obj) {
	var name = attrNode.nodeName.toLowerCase()
	if (wp_is_ie) {
		if ((name == 'selected') && (attrNode.nodeValue != true)) return
		if (!attrNode.specified && (!wp_not_specified_ignore.test(name) || (elementNode.nodeName == 'LI' && name == 'value') ) )
		return
	}
	if (wp_bogus_attributes.test(name)) {
		return
	}
	if (wp_boolean_attributes.test(name)) {
		var value = name
	} else {
		var value = attrNode.nodeValue
	}
	if (value == "" && (!wp_attribute_allowed_empty.test(name))) return
	if (name == "class" && value == "wp_none") return
	if (value == "null") return
	if (name != "style") {
		if (!isNaN(value)) {
			if (elementNode.nodeName == "IMG" || elementNode.nodeName == "TABLE" ) {
				if (name=='height' && elementNode.style.height) {
					var str = elementNode.style.height
					value = str.replace(/px/, '');
				} else if (name=='width' && elementNode.style.width) {
					var str = elementNode.style.width
					value = str.replace(/px/, '');
				}	else {
					value = elementNode.getAttribute(name, 2)
				}
			} else {
				value = elementNode.getAttribute(name, 2)
			}
		} else if (wp_attribute_case_must_lower.test(name)) {
			value = elementNode.getAttribute(name).toLowerCase()
		} else if (wp_link_attributes.test(name) && (obj.domain1 || value.search("#") != -1) ) {
			value = elementNode.getAttribute(name, 2)
			var string = document.location.toString();
			var string = string.split('#');
			var secure = new RegExp(wp_quoteMeta(string[0]),"gi");
			value = value.replace(secure, '')
		}
		sb.append(" " + name + "=\"" + wp_fixAttribute(value) + "\"")
	} 
}
function wp_appendNodeHTML(node, sb, obj) {
	switch (node.nodeType) {
		case 1:	// ELEMENT		
			if (node.nodeName == "!") {
				if ((node.text.search(/DOCTYPE/gi) != -1) || (node.text.search(/version=\"1.0\" encoding\=/gi) != -1)) {
					sb.append('')
				} else {
					sb.append(node.text)
				}
				break
			}
			var name = node.nodeName
			name = name.toLowerCase()
			// wp 222
			if (!name || name == '') {
				// childNodes
				var cs = node.childNodes
				l = cs.length
				for (var i = 0; i < l; i++) {
					wp_appendNodeHTML(cs[i], sb, obj)
				}
				break
			}
			if (name == '/embed') return
			// end wp 222
			if (wp_inbase == true && name == 'body') {
				break
			}	
			if (name == "base" && !wp_is_ie) {
				if (node.getAttribute('href') == obj.baseURLurl) {
					break
				}	
			} else if (name == "base") {
				wp_inbase = true
				// childNodes
				var cs = node.childNodes
				l = cs.length
				for (var i = 0; i < l; i++) {
					wp_appendNodeHTML(cs[i], sb, obj)
				}
				wp_inbase = false
				break
			}
			// 222 repition
			if (wp_ignore_next) {
				if (node.canHaveChildren && node.innerHTML == '') {
					wp_ignore_next = false
					break
				}
			}
			if (wp_is_ie) {
				if (node._done) {
					wp_ignore_next = true
					break;
				}
				node._done = true
			}
			// end 222
			if (name == "link" && obj.stylesheet != '') {
				var num = obj.stylesheet.length;
				var dobreak = false;
				for (var i=0; i < num; i++) {
					if (node.getAttribute('href') == obj.stylesheet[i]) {
						dobreak = true
						break
					}
				}
				if (dobreak) {
					break
				}
			}
			if (name == "meta") {
				if (node.getAttribute('name') ) {
					if (node.getAttribute('name').toLowerCase() == "generator" && wp_is_ie) {
						break
					}
				}
			}
			if (name == "img") {
				if ((node.getAttribute('name')) && (node.src.search(wp_directory+"/images/bookmark_symbol.gif") != -1)) {
					sb.append('<a name="'+node.getAttribute('name')+'"')
					if (obj.useXHTML) {
						sb.append(' id="'+node.getAttribute('name')+'"></a>')
					} else {
						sb.append('></a>')
					}
					break
				}
				if (!node.getAttribute("alt")) {
					node.setAttribute("alt", "")
				}
			}
			if (name == "area") {
				if (!node.getAttribute("alt")) {
					node.setAttribute("alt", "")
				}
			}
			if (!wp_inline_tags.test(name) && name != "html") {
				if (wp_is_ie) {
					sb.append("\n")
				} else if (name != 'tbody'
					&& name != 'thead'
					&& name != 'tfoot'
					&& name != 'tr'
					&& name != 'td') {
						sb.append("\n")
				}
			}
			// 222
			if (name == 'font' && !node.getAttribute('face') && !node.getAttribute('size') && !node.getAttribute('color')) {
				name="span"
			}
			// end 222
			if (((name == "span") || (name == "font")) && (node.style.cssText.length < 1))  {
				var attrs = node.attributes
				var l = attrs.length
				// IE5 fix: count specified attrs
				var n = 0
				for (var i = 0; i < l; i++) {
					if (attrs[i].specified) {
						n ++
					} 
				}
				if (wp_is_ie) { n1 = 1; } else { n1 = 0; }				
				// 222 font removal fix
				if (n == n1 || (n == (n1 + 1) && node.className == "wp_none") || (n == (n1 + 1) && node.face == "null")) {
					if (node.hasChildNodes()) {							
						// childNodes
						var cs = node.childNodes
						l = cs.length
						for (var i = 0; i < l; i++) {
							wp_appendNodeHTML(cs[i], sb, obj)
						}
					}
					break
				}
				// end 222
			}
			sb.append("<" + name)
			if (name == "html" && obj.useXHTML) {
				if (!node.getAttribute('xmlns')) {
					sb.append(' xmlns="http://www.w3.org/1999/xhtml"')
				}
				if (!node.getAttribute('xml:lang')) {
					sb.append(' xml:lang="' + obj.xhtml_lang.toLowerCase() + '"')
				}
				if (!node.getAttribute('lang')) {
					sb.append(' lang="' + obj.xhtml_lang.toLowerCase() + '"')
				}
			}
			// inline styles
			if (node.style.cssText.length > 1) {
				sb.append(' style="')
				var propArray = node.style.cssText.split(';')
				var l = propArray.length
				for (var i = 0; i < l; i++) {
					if (propArray[i].length > 1) {
						var propVal = propArray[i].split(':')
						if (obj.border_visible == 1) {
							if (propVal[1] != " null"
							&& propVal[1] != " wp_bogus_font"
							&& propVal[1] != " 1px dashed rgb(127, 124, 117)"
							&& propVal[1] != " #7f7c75 1px dashed"
							&& propVal[0].substr(0,5) != " mso-"
							&& propVal[0].substr(0,4) != "mso-") {
								sb.append(propVal[0].toLowerCase() + ':')
								sb.append(wp_fixAttribute(propVal[1]) + ';')
							}
						} else {
							if (propVal[1] != " null"
							&& propVal[1] != " wp_bogus_font") {							
								sb.append(propVal[0].toLowerCase() + ':')
								sb.append(wp_fixAttribute(propVal[1]) + ';')
							}
						}
					}
				}
				sb.append('"')
			}
			// attributes
			var attrs = node.attributes
			var l = attrs.length
			for (var i = 0; i < l; i++) {
				wp_getAttributeValue(attrs[i], node, sb, obj)
			}
			// wp 222 iframe fix
			if (!wp_is_ie) {
				if (!wp_cant_have_children.test(name)) {
					node.canHaveChildren = true
				} else {
					node.canHaveChildren = false
				}
			}
			if ((node.canHaveChildren || node.hasChildNodes() || wp_cant_have_children_has_close_tag.test(name) ) && name != 'basefont' && name != 'script' && name != 'style' && name != 'title') {
				sb.append(">")
				if (( ( (wp_is_ie && node.innerHTML == '') || (wp_is_ie && node.innerHTML == ' ') ) || node.innerHTML == '&nbsp;') && node.canHaveChildren) {
				// end 222
					sb.append('&nbsp;')
				} else {
					// childNodes
					var cs = node.childNodes
					l = cs.length
					for (var i = 0; i < l; i++) {
						wp_appendNodeHTML(cs[i], sb, obj)
					}
					if ((name == 'body') || (name == 'html') || (name == 'head')) {
						sb.append("\n")
					}
				}
				sb.append("</" + name + ">")
			} else if (name == "script") {
				sb.append(">" + node.text + "</" + name + ">")
			} else if (name == "style") {
				sb.append(">" + node.innerHTML.trim() + "</" + name + ">")
			} else if (name == "title" || name == "comment") {
				sb.append(">" + node.innerHTML + "</" + name + ">")
			} else if (obj.useXHTML) {
				sb.append(" />")
			} else { 
				sb.append(">")
			}
			if (name == 'br') {
				sb.append("\r")
			}
			break
		case 3:	// TEXT
			if (node.nodeValue) {
				// 222 repitition fix
				if (wp_donetext == node) {
					wp_donetext = null;
					break
				}
				if (wp_is_ie) {
					wp_donetext = node
				}
				// end 222
				if (node.nodeValue == '\n' ) break
				var str = node.nodeValue
				sb.append( wp_fixText( str.dblTrim() ))
			}
			break
		case 4:
			sb.append("<![CDA" + "TA[\n" + node.nodeValue + "\n]" + "]>")
			break
		case 8:
			if (wp_is_ie) {
				if ((node.text.search(/DOCTYPE/gi) != -1) || (node.text.search(/version=\"1.0\" encoding\=/gi) != -1)) {
					sb.append('')
				} else {
					sb.append("<!--" + node.nodeValue + "-->")
				}
			} else {
				if (node.nodeValue.substr(0, 4) == "[if ") {
					return
				} else {
					sb.append("<!--" + node.nodeValue + "-->")
				}
			}
			break
		case 9:	// DOCUMENT
			// childNodes
			var cs = node.childNodes
			l = cs.length
			for (var i = 0; i < l; i++) {
				wp_appendNodeHTML(cs[i], sb, obj)
			}
			break
		case 10:
			sb.append('')
			break
		default:
			if (wp_debug_mode) {
				sb.append("<!--\nUnsupported Node:\n\n" + "nodeType: " + node.nodeType + "\nnodeName: " + node.nodeName + "\n-->")
			}
	}
}
function wp_replace_bookmark (code) {
	code = code.replace(/<a name="([^"]+)[^>]+><\/a>/gi, "<img name=\"$1\" src=\"" + wp_directory + "/images/bookmark_symbol.gif\" contenteditable=\"false\" width=\"16\" height=\"13\" title=\"Bookmark: $1\" alt=\"Bookmark: $1\" border=\"0\">")
	code = code.replace(/<a name="([^"]+)[^>]+>&nbsp;<\/a>/gi, "<img name=\"$1\" src=\"" + wp_directory + "/images/bookmark_symbol.gif\" contenteditable=\"false\" width=\"16\" height=\"13\" title=\"Bookmark: $1\" alt=\"Bookmark: $1\" border=\"0\">")
	return code
}
// this project is getting so complex we need to block any errors that I may not have accounted for
function wp_hide_error(evt) {
	if (!wp_debug_mode) {
		if (evt.stopPropagation) {
			evt.stopPropagation()
			evt.preventDefault()
		}
		return true
	}
}
function wp_make_styles (obj) {
	var styles = ''
	if (obj.stylesheet != '') {
		var num = obj.stylesheet.length;
		for (var i=0; i < num; i++) {
			styles += '<link rel="stylesheet" href="'+obj.stylesheet[i]+'" type="text/css">'
		}
	}
	var stylesheets = obj.edit_object.document.getElementsByTagName('link')
	var l=stylesheets.length
	for (var i=0; i < l; i++) {
		if (stylesheets[i].href) {
			if (stylesheets[i].rel) {
				if (stylesheets[i].rel.toLowerCase() == "stylesheet") {
					styles += '<link rel="stylesheet" href="'+ stylesheets[i].href +'" type="text/css">'
				}
			} else if (stylesheets[i].type) {
				if (stylesheets[i].type.toLowerCase() == "text/css") {
					styles += '<link rel="stylesheet" href="'+ stylesheets[i].href +'" type="text/css">'
				}		
			}
		}
	}	
	var styleTags = obj.edit_object.document.getElementsByTagName('style')
	var l=styleTags.length
	for (var i=0; i < l; i++) {
		styles += '<style type="text/css">'+ styleTags[i].innerHTML +'</style>'
	}
	return styles
}
// 222
function wp_show_menu(obj, type, srcElement) {	
	var frame = document.getElementById(obj.name+"_"+type+"_frame")
	if (frame.style.display=="none") {
		wp_hide_menu(obj)
		wp_current_obj = obj
		parent.command = srcElement.id
		frameObj = eval(obj.name+"."+type+"_frame")
		try {
			if (!frameObj.written) {
			 var writeIt = true
			} else {
			 var writeIt = false
			}
		} catch (e) {
			 var writeIt = true
		}
		if (writeIt) {
			var frameDoc = eval(obj.name+"."+type+"_frame.document")
			var menu_code
			if (obj.styles == '') {
				obj.styles = wp_make_styles(obj)
			}
			if (wp_is_ie) {
				var border = "border: 1px solid #000000"
			} else {
				var border = ""
			}
			var head = '<style type="text/css">body {background-color:white; padding:0px; margin:0px; ' + border + '} .off { display:block; overflow:hidden; width:249px; border: 2px solid #eeeeee; cursor: pointer; cursor: hand; } .on { display:block; overflow:hidden; width:249px; border: 2px solid highlight; cursor: pointer; cursor: hand; } div {padding: 0px; margin: 1px 0px 0px 0px}</style><script type="text/javascript">function on (elm) {elm.className="on";} function off (elm) {elm.className="off";}</script></head>'
			var head2 = '<html><head><style type="text/css">body {background-color:white; padding:0px; margin:0px; color:black; ' + border + '} .off { display:block; overflow:hidden; width:270px; background-color:white; color:black; padding: 2px; cursor: pointer; cursor: hand; } .on { display:block; overflow:hidden; width:270px; background-color:highlight; color:highlighttext; padding: 2px; cursor: pointer; cursor: hand; } div {text-align:left; padding:0px; margin: 1px 0px 0px 0px}</style><script type="text/javascript">function on (elm) {elm.className="on";} function off (elm) {elm.className="off";}</script></head>'
			if (type=="font") {
				menu_code = obj.baseURL + '<html><head>' + obj.styles + head2 + '<style>div {font-size:16px}</style><body><div id="container" style="margin-top:0px; width:253px; overflow:hidden; left: 0px; top:0px; position:absolute;">'+ document.getElementById(obj.name+"_font-menu").innerHTML +'<div></body></html>'
			} else if (type=="size") {
				menu_code = obj.baseURL + '<html><head>' + obj.styles + head2 + '<body><div id="container" style="margin-top:0px; width:93px; overflow:hidden; left: 0px; top:0px; position:absolute;">'+ document.getElementById(obj.name+"_size-menu").innerHTML +'<div></body></html>'
			} else if (type=="format") {
				menu_code = obj.baseURL + '<html><head>' + head + obj.styles + '<body><div id="container" style="margin:0px; padding:0px; width:253px; overflow:hidden; left: 0px; top:0px; position:absolute;">'+ document.getElementById(obj.name+"_format-menu").innerHTML +'<div></body></html>'
			} else if (type=="class") {
				menu_code = obj.baseURL + '<html><head>' + head + obj.styles + '<body><div id="container" style="margin:0px; padding:0px; width:253px; overflow:hidden; left: 0px; top:0px; position:absolute;">'+ document.getElementById(obj.name+"_class-menu").innerHTML +'<div></body></html>'
			}
			frame.style.display="block"
			frameDoc.open()	
			frameDoc.write(menu_code)
			frameDoc.close()
			try {
			frameObj.written = true
			} catch (e) {
			}
			setTimeout("wp_set_menu_height("+obj.name+", '"+type+"')", 400)
		} else {
			frame.style.display="block"
		}
	} else {
		wp_hide_menu(obj)
	}
}
function wp_set_menu_height (obj, type) {
	try {
		maxHeight = 202
		var docHeight = document.getElementById(obj.name+'_editFrame').height
		//var docHeight = docHeight.replace(/px/, '')
		if (docHeight > 190) {
			maxHeight = docHeight - 12
		}
		var frame = document.getElementById(obj.name+"_"+type+"_frame")
		if (wp_is_ie) {
			var height = document.frames(obj.name+"_"+type+"_frame").document.getElementById('container').offsetHeight
		} else {
			var height = document.getElementById(obj.name+"_"+type+"_frame").contentWindow.document.getElementById('container').offsetHeight
		}
		if (height < maxHeight && height > 0) {
			frame.height = height + 2
		} else {
			frame.height = maxHeight
		}
	} catch (e) {
		return
	}
}
function wp_hide_menu(obj) {
	document.getElementById(obj.name+"_format_frame").style.display="none"
	document.getElementById(obj.name+"_class_frame").style.display="none"
	document.getElementById(obj.name+"_font_frame").style.display="none"
	document.getElementById(obj.name+"_size_frame").style.display="none"
}
// end 222
function wp_remove_attributes(collection, attribute) {
	var n = collection.length
	for (var i = 0; i < n; i++) {
		if (collection[i].getAttribute(attribute)) {
			if (collection[i].getAttribute(attribute) == 'null') {
				collection[i].removeAttribute(attribute)
			}
		}
	}
}
function wp_change_font_size(obj,size) {
	wp_hide_menu(obj)	
	obj.edit_object.focus()
	if (size == 'Default') {
		obj.edit_object.document.execCommand("RemoveFormat", false, null)
	} else {
		obj.edit_object.document.execCommand("FontSize", false, size)
	}
	/////
	if (size == 'null') {
		var fonts = obj.edit_object.document.getElementsByTagName("FONT")
		wp_remove_attributes(fonts, 'size')
	}
}
function wp_change_font(obj,font) {
	wp_hide_menu(obj)
	obj.edit_object.focus()
	if (font == 'Default') {
		obj.edit_object.document.execCommand("RemoveFormat", false, null)
	} else {
		obj.edit_object.document.execCommand("FontName", false, font)
	}
	////
	if (font == 'null') {
		var fonts = obj.edit_object.document.getElementsByTagName("FONT")
		wp_remove_attributes(fonts, 'face')
	}
}
function wp_change_format(obj,format) {
	wp_hide_menu(obj)
	obj.edit_object.focus()
	if (!wp_is_ie) {
		// add attributes back in because formatblock removes them in mozilla
		var sel = obj.edit_object.getSelection()
		var range = sel.getRangeAt(0)
		var container = range.startContainer
		var textNode = container
		container = textNode.parentNode
		var parentTag = wp_skipInline(container)
		// can't safley continue if this is not a supported tag for the formatblock command
		if (parentTag.tagName) {
			if ( !wp_supported_blocks.test(parentTag.tagName.toLowerCase() ) ) {
				obj.edit_object.document.execCommand("FormatBlock", false, format)
				return
			}
		}
		var attributes = parentTag.attributes
		obj.edit_object.document.execCommand("FormatBlock", false, format)
		container = textNode.parentNode
		// add attributes back	
		var parentTag = wp_skipInline(container)
		wp_add_attributes(parentTag, attributes)
	} else {
		obj.edit_object.document.execCommand("FormatBlock", false, format)
	}
}
function wp_colordialog(obj,srcElement, Action) {
	if (srcElement.className == "wpDisabled") {
		return	
	}
	var action = obj.openDialog(wp_directory + "selcolor.php?action="+Action+"&lang="+obj.instance_lang , 'modal', 296, 352)
}
// opens a modal dialoge, returns the window opject or return value in the case of modal windows.
function wp_docolor(obj,Action,color) {   
	obj.edit_object.focus()
	if (!wp_is_ie && color == '') {
		if (Action == 'hilitecolor') {
			color = 'rgb(127, 124, 117)'
		} else {
			color = 'null'
		}
	}
	if (Action == 'hilitecolor') {
		obj.edit_object.document.execCommand("usecss", false, false)
		obj.edit_object.document.execCommand('hilitecolor', false, color)
		obj.edit_object.document.execCommand("usecss", false, true)
	} else {
		obj.edit_object.document.execCommand(Action, false, color)
	}
	////
	if (!wp_is_ie) {
		if (Action == 'forecolor' && color == 'null' ) {
			var fonts = obj.edit_object.document.getElementsByTagName("FONT")
			wp_remove_attributes(fonts, 'color')
		} else if (Action == 'hilitecolor' && color == 'rgb(127, 124, 117)' ) {
			wp_remove_highlight(obj.edit_object.document.body, obj);
		}
	}
	obj.edit_object.focus()
}
function wp_remove_highlight(node, obj) {
	if (node.nodeType != 1) {
		return
	}
	var cn = node.childNodes
	var n = cn.length
	for (var i = 0; i < n; i++) {
		if (cn[i].style) {
				if (cn[i].style.backgroundColor == 'rgb(127, 124, 117)') {
					cn[i].style.backgroundColor = ''
				}
		}
		wp_remove_highlight(cn[i], obj);
	}
}
function wp_paste_word_html(obj) {
	var url = wp_directory + 'pastewin.php?lang='+obj.instance_lang
	var width = 400
	var height = 278
	wp_current_obj = obj
	var pasteWindow = window.open(url ,"pastewin", "dependent=yes,width="+width+"px,height="+height+"px,left="+((screen.width/2)-(width/2))+",top="+((screen.height/2)-(height/2)))
	pasteWindow.focus()
}
function wp_insert_smiley(obj,srcElement) {
	if (srcElement.className == "wpDisabled") {
		return	
	}
	obj.edit_object.focus()
	imgwin = obj.openDialog(wp_directory + 'smileys.php?lang='+obj.instance_lang ,'modal',380,301)
}
function wp_open_horizontal_rule_window(obj,srcElement) {
	if (srcElement.className == "wpDisabled") {
		return	
	}
	rulerwin = obj.openDialog(wp_directory + "insert_hr.php?lang="+obj.instance_lang ,'modal',260,212)
}
function wp_custom_object(obj,srcElement) {
	if (srcElement.className == "wpDisabled") {
		return	
	}
	var custom = obj.openDialog (wp_directory + "dialog_frame.php?window=custom.php&lang="+obj.instance_lang, 'modal',550,411)
}
function wp_open_special_characters_window(obj,srcElement) {
	if (srcElement.className == "wpDisabled") {
		return	
	}
	specchar = obj.openDialog(wp_directory + "special_characters.php?lang="+obj.instance_lang, 'modal',500,252)
}
function wp_findit(obj) {
	var findwin = obj.openDialog(wp_directory + "find.php?lang="+obj.instance_lang, 'modeless', 318, 146)
}
function wp_toggle_table_borders(obj,srcElement) {
	if (srcElement.className == "wpDisabled") {
		return	
	}
	if (obj.border_visible == 0) {
		wp_show_borders(obj)
	} else {
		wp_hide_borders(obj)
	}
}
function wp_show_borders(obj) {
	if (!obj) {
		obj = wp_current_obj
	}	
	var tables = obj.edit_object.document.getElementsByTagName('TABLE')
	var l=tables.length
	for (var i=0; i < l; i++) {
		if (tables[i].border == 0 || tables[i].border == null) {
			var tableCells = tables[i].getElementsByTagName('TD')
			var m=tableCells.length
			for (var j=0; j < m; j++) {
				if (wp_is_ie) {
					tableCells[j].runtimeStyle.border = "1px dashed #7F7C75"
				} else {
					tableCells[j].style.border = "1px dashed #7F7C75"
				}
			}
		}
	}
	obj.border_visible = 1
	var message = document.getElementById(obj.name + '_messages')
	if (message.innerHTML != obj.lng['guidelines_visible']) {
		message.innerHTML = obj.lng['guidelines_visible']
	}
	message.style.textDecoration = 'none'
}
function wp_hide_borders(obj) {
	var tableCells = obj.edit_object.document.getElementsByTagName('TD')
	var l=tableCells.length
	for (var i=0; i < l; i++) {
		if (wp_is_ie) {
			var rcsstext = tableCells[i].runtimeStyle.cssText
		} else {
			var rcsstext = tableCells[i].style.cssText
		}
		if (rcsstext.length > 1) {
			var propArray = rcsstext.split(';')
			var pl = propArray.length
			var icsstext = ''
			for (var j = 0; j < pl; j++) {
				if (propArray[j].length > 1) {
					var propVal = propArray[j].split(':')
					if (propVal[1] != " 1px dashed rgb(127, 124, 117)"
					&& propVal[1] != " #7f7c75 1px dashed") {							
						icsstext += propVal[0] + ':'
						icsstext += propVal[1] + ';'
					}
				}
			}
			if (wp_is_ie) {
				tableCells[i].runtimeStyle.cssText = icsstext
			} else {
				tableCells[i].style.cssText = icsstext
			}
		}
	}
	obj.border_visible = 0
	var message = document.getElementById(obj.name + '_messages')
	if (message.innerHTML != obj.lng['guidelines_hidden']) {
		message.innerHTML = obj.lng['guidelines_hidden']
	}
	message.style.textDecoration = 'none'
}
/////////////////////////////
// Fancy table editing stuff
/////////////////////////////
// table window
function wp_open_table_window(obj,srcElement) {	
	if (srcElement.className == "wpDisabled") {
		return	
	}
	if (wp_is_ie) {
		var height = 417
	} else {
		var height = 427
	}
	tblwin = obj.openDialog(wp_directory + "table.php?lang="+obj.instance_lang, 'modal', 440, height)
}
function wp_open_table_editor(obj) {
	if (wp_isInside(obj, 'TD')) {
		wp_getTable(obj)
		editTbl = obj.openDialog(wp_directory + 'edittable.php?lang='+obj.instance_lang, 'modal', 431, 516)
	} else {
		alert(obj.lng['place_cursor_in_table'])
	}
}
// adding or removing table rows
function wp_processRow(obj,action) {
	if (wp_isInside(obj, 'TD')) {
	wp_getTable(obj)
	var idx = 0
	var rowidx = 0
	var tr = wp_thisRow
	var numcells = tr.childNodes.length
	if (action == "choose") {
		choose = obj.openDialog(wp_directory + "addrow.php?lang="+obj.instance_lang ,'modal',270,150)
		return
	}
	if ((action == "") || (action == null)) {
		return
	}
	if (action == "addabove") {
		while (tr) {
			if (tr.tagName == "TR") {
				rowidx++
				tr = tr.previousSibling
			}
		}
		rowidx-=1
	} else {
		if (action == "addbelow") {
			while (tr) {
				if (tr.tagName == "TR") {
					rowidx++
					tr = tr.previousSibling
				}
			}
		}		
	}
	var tbl = wp_thisTable
	if (!tbl) {
		alert("Could not " + action + " row.")
		return
	}
	if ((action == "addabove") || (action == "addbelow"))  {
		var r = tbl.insertRow(rowidx)
		for (var i = 0; i < numcells; i++) {
			var c = r.appendChild(obj.edit_object.document.createElement("TD") )
			if (wp_thisCell.colSpan) {
				c.colSpan = wp_thisRow.childNodes[i].colSpan
			}
			c.width = wp_thisRow.childNodes[i].width
			c.vAlign = 'top'
			c.innerHTML = obj.tdInners
			if (obj.border_visible == 1) {
				wp_show_borders(obj)
			}
		}
	} else {
		if (wp_thisTable.getElementsByTagName('TR').length == 1) {
			return
		}
		while (tr) {
			if (tr.tagName == "TR") {
				rowidx++
				tr = tr.previousSibling
			}
		}
		rowidx -= 1
		tbl.deleteRow(rowidx)
		}
		wp_thisCell=null
		wp_thisRow=null
		wp_thisTable=null
	}
	obj.edit_object.focus()
}
// adding or removing a column
function wp_processColumn(obj,action) {
	if (wp_isInside(obj, 'TD')) {
	if (action == "choose") {
		choose = obj.openDialog(wp_directory + "addcolumn.php?lang="+obj.instance_lang ,'modal',270,150)
		return
	}
	//action='addleft'
	if ((action == "") || (action == null)) {
		return
	}
	wp_getTable(obj)
	// store cell index in a var because the cell will be
	// deleted when processing the first row
	var cellidx = wp_thisCell.cellIndex
	var tbl = wp_thisTable
	if (!tbl) {
		alert("Could not " + action + " column.")
		return
	}
	// now we have the table containing the cell
	this.wp_add_remove_columns(obj,tbl, cellidx, action)
	} 
	obj.edit_object.focus()
}
// function for processing columns
function wp_add_remove_columns(obj,tbl, cellidx, action) {
	if (!tbl.childNodes.length)
		return
		var n=tbl.childNodes.length
		for (var i = 0; i < n; i++) {
			if (tbl.childNodes[i].tagName == "TR") {
				var cell = tbl.childNodes[i].childNodes[ cellidx ]
				if (!cell)
					break // can't add cell after cell that doesn't exist
				if (action == "addleft") {
					cell.parentNode.insertBefore( obj.edit_object.document.createElement("TD"), cell)
				} else {
					if (action == "addright") {
						cell.parentNode.insertBefore( obj.edit_object.document.createElement("TD"), cell.nextSibling)
					} else {
					// check for rowspan
						if (cell.rowSpan > 1) {
							i += (cell.rowSpan - 1)
						}
						if (wp_thisRow.getElementsByTagName('TD').length == 1) {
							return
						}
						if (cell.colSpan < 2) { 
							tbl.childNodes[i].removeChild(cell)

						} else {
							cell.colSpan -= 1
						}
					}
				}
			} else {
			// keep looking for a "TR"
			this.wp_add_remove_columns(obj,tbl.childNodes[i], cellidx, action) 
		}
	}
	wp_reprocess_columns(obj)
}
// if there is no other way to split the cell just do it, otherwise (if it could be split vertical or horizontal) ask which way to do it
function wp_splitCell(obj) {
	if (wp_isInside(obj, 'TD')) {
		wp_getTable(obj)
		if ((wp_thisCell.colSpan < 2) && (wp_thisCell.rowSpan < 2)) {
			alert(obj.lng['only_split_merged_cells'])
		}
		if ((wp_thisCell.colSpan >= 2) && (wp_thisCell.rowSpan < 2)) {
			wp_unMergeRight(obj)
		} else if ((wp_thisCell.rowSpan >= 2) && (wp_thisCell.colSpan < 2)) {
			wp_unMergeDown(obj)
		} else if ((wp_thisCell.rowSpan >= 2) && (wp_thisCell.colSpan >= 2)) {
			choose = obj.openDialog(wp_directory + "unmrgcell.php?lang="+obj.instance_lang ,'modal',270,150)
			return
		} 
	}
}
function wp_mergeCell(obj) {
	if (wp_isInside(obj, 'TD')) {
		choose = obj.openDialog(wp_directory + "mrgcell.php?lang="+obj.instance_lang ,'modal',270,150)
		return
	}
}
// merge cells  
function wp_mergeRight(obj) {
	if (wp_isInside(obj, 'TD')) {
		wp_getTable(obj)
		if (!wp_thisCell.nextSibling) {
			alert(obj.lng['no_cell_right'])
			return
		}
		// don't allow user to merge rows with different rowspans
		if (wp_thisCell.rowSpan != wp_thisCell.nextSibling.rowSpan) {
			alert(obj.lng['different_row_spans'])
			return
		}
		if (wp_thisCell.nextSibling.innerHTML.toLowerCase() != obj.tdInners) {
			if (wp_thisCell.innerHTML.toLowerCase() == obj.tdInners) {
				wp_thisCell.innerHTML = wp_thisCell.nextSibling.innerHTML
			} else {
				wp_thisCell.innerHTML += wp_thisCell.nextSibling.innerHTML
			}
		}
		wp_thisCell.setAttribute("WIDTH", '', 0);
		wp_thisCell.nextSibling.setAttribute("WIDTH", '', 0)
		wp_thisCell.colSpan += wp_thisCell.nextSibling.colSpan
		wp_thisRow.removeChild(wp_thisCell.nextSibling)
		wp_thisCell=null
		wp_thisRow=null
		wp_thisTable=null
	}
	obj.edit_object.focus()
}
// spit cells
function wp_unMergeRight(obj) {
	if (wp_isInside(obj, 'TD')) {
		wp_getTable(obj)
		if (wp_thisCell.colSpan < 2) {
			alert(obj.lng['only_split_merged_cells'])	
		} else {
			wp_thisCell.colSpan = wp_thisCell.colSpan - 1
			var newCell = wp_thisCell.parentNode.insertBefore(obj.edit_object.document.createElement("TD"), wp_thisCell.nextSibling)
			newCell.rowSpan = wp_thisCell.rowSpan
			wp_thisCell.setAttribute("WIDTH", '', 0);
			newCell.setAttribute("WIDTH", '', 0)
			newCell.innerHTML = obj.tdInners
			newCell.vAlign = 'top'
		}
		if (obj.border_visible == 1) {
			wp_show_borders(obj)
		}
		wp_thisCell=null
		wp_thisRow=null
		wp_thisTable=null
	} 
	obj.edit_object.focus()
}
// merge with cell below
function wp_mergeDown(obj) {
	if (wp_isInside(obj, 'TD')) {
		wp_getTable(obj)
		var numrows = wp_thisTable.getElementsByTagName('TR').length
		var topRowIndex = wp_thisRow.rowIndex
		if (numrows - (topRowIndex + wp_thisCell.rowSpan) <= 0) {
			alert(obj.lng['different_column_spans']) 
			return
		}
		if (!wp_thisRow.nextSibling) {
			alert(obj.lng['no_cell_below']) 
			return
		}
		var bottomCell = wp_thisRow.parentNode.childNodes[ topRowIndex + wp_thisCell.rowSpan ].childNodes[ wp_thisCell.cellIndex ]
		var bottomRow = wp_thisRow.parentNode.childNodes[topRowIndex + wp_thisCell.rowSpan ]
		// don't allow merging rows with different colspans
		if (wp_thisCell.colSpan != bottomCell.colSpan) {
			alert(obj.lng['different_column_spans']) 
			return
		}
		// do the merge
		if (bottomCell.innerHTML.toLowerCase() != obj.tdInners) {
			if (wp_thisCell.innerHTML.toLowerCase() == obj.tdInners) {
				wp_thisCell.innerHTML = bottomCell.innerHTML
			} else {
				wp_thisCell.innerHTML += bottomCell.innerHTML
			}
		}
		wp_thisCell.setAttribute("HEIGHT", '', 0)
		wp_thisCell.rowSpan += bottomCell.rowSpan
		bottomRow.removeChild(bottomCell) 
		wp_thisCell=null
		wp_thisRow=null
		wp_thisTable=null
	}
	obj.edit_object.focus()
}
//  unMergeDown
function wp_unMergeDown(obj) {
	if (wp_isInside(obj, 'TD')) {
		wp_getTable(obj)
		if (wp_thisCell.rowSpan < 2) {
			alert(obj.lng['only_split_merged_cells'])
			return
		}
		var topRowIndex = wp_thisCell.parentNode.rowIndex
		// add a cell to the beginning of the next row
		var newCell = wp_thisRow.parentNode.childNodes[ topRowIndex + wp_thisCell.rowSpan - 1 ].appendChild( obj.edit_object.document.createElement("TD") )
		newCell.innerHTML = obj.tdInners
		newCell.vAlign = wp_thisCell.vAlign
		newCell.colSpan = wp_thisCell.colSpan
		wp_thisCell.rowSpan -= 1
		if (obj.border_visible == 1) {
			wp_show_borders(obj)
		}
		wp_thisCell=null
		wp_thisRow=null
		wp_thisTable=null
	}
	obj.edit_object.focus()
}
// fixes column widths, alignment and inserts spacers.
// should be called after doing any column manipulation
function wp_reprocess_columns(obj) {
	var nocolumns = 0
	var tableRows = wp_thisTable.getElementsByTagName('TR')
	var tableColumns = tableRows[0].getElementsByTagName('TD')
	// get the number of columns taking into account colspans
	var n=tableColumns.length
	for (var i=0; i < n; i++) {
			if (tableColumns[i].getAttribute('colSpan') >= 2) {
				nocolumns += tableColumns[i].getAttribute('colSpan')
			} else {
				nocolumns +=1
			}
	}
	// calculate the column widths
	var tdwidth = 100/nocolumns
	var tableCells = wp_thisTable.getElementsByTagName('TD')
	// now resize the columns, also insert spacers into cells with no inner html and fix text alignment
	var n=tableCells.length
	for (var i=0; i < n; i++) {
			if (tableCells[i].getAttribute('colSpan') < 2) {
				tableCells[i].width = tdwidth + '%'
			}
			if (tableCells[i].innerHTML == '') {
				tableCells[i].innerHTML = obj.tdInners
			}
			if ((tableCells[i].getAttribute('vAlign') == '') || (tableCells[i].getAttribute('vAlign') == null)) {
				tableCells[i].vAlign = 'top'
			}
	}
	if (obj.border_visible == 1) {
		wp_show_borders(obj)
	}
}
///////////////////////////
// Save functions //
///////////////////////////
// function to ensure updates are sent to the textarea before saving, should be called from the save button or the form in an onsubmit statement
function wp_submit_editors() {
	if (!this.wp_has_submitted) {
		submit_form()
	}
	this.wp_has_submitted = true;
}
function submit_form() {
	var editors = document.getElementsByTagName("TEXTAREA")
	for (var i=0; i<editors.length; i++) {
		if (editors[i].className == "wpHtmlEditArea") {
			wp_prepare_submission(editors[i])
		}
	}
	return true
}
function wp_prepare_submission(obj) {
	if (obj.html_mode==false) {
		wp_send_to_html(obj)
		var str = obj.html_edit_area.value
		if (str == '<p>&nbsp;</p>'
		|| str == '<div>&nbsp;</div>'
		|| str == '<div>\n<br></div>'
		|| str == '<div>\n<br /></div>'
		|| str == '<p>\n<br></p>'
		|| str == '<p>\n<br /></p>'
		|| str == '<br>'
		|| str == '<br />'
		|| str == '&nbsp;'
		|| str == '&nbsp;\n<br>'
		|| str == '&nbsp;\n<br />'
		) {
			obj.html_edit_area.value = ''
		}
		return true
	} else {
		return true
	}
}
// context menu mouse overs //
function wp_menuover(srcElement) {
	tds=srcElement.getElementsByTagName('TD')
	tds[0].className = "wpContextCellOneOver"
	tds[1].className = "wpContextCellTwoOver"
}
function wp_menuout(srcElement) {
	tds=srcElement.getElementsByTagName('TD')
	tds[0].className = "wpContextCellOne"
	tds[1].className = "wpContextCellTwo"
}
/////////////////////
// Tab view script //
/////////////////////
function wp_showDesign() {
	if (this.html_mode==true) {
		if (document.getElementById(this.name+'_designTab')) {
			document.getElementById(this.name+"_load_message").style.display ='block'
			setTimeout("wp_on_enter_tab_one("+this.name+")",1);
		}
	}
}
function wp_on_enter_tab_one(obj) {
	if (obj.html_mode==true) {	
		var tab_one = document.getElementById(obj.name+'_tab_one')
		if (wp_is_ie) {
			tab_one.style.display = 'block'
		} else {
			document.getElementById(obj.name+'_editFrame').style.width = '100%'
			tab_one.style.visibility = "visible"
			tab_one.style.height = ''
		}
		document.getElementById(obj.name+'_tab_two').style.display = "none"
		document.getElementById(obj.name+'_tab_three').style.display = "none"
		if (document.getElementById(obj.name+'_designTab'))
			document.getElementById(obj.name+'_designTab').className = "wpTButtonUp"
		
		if (document.getElementById(obj.name+'_sourceTab'))		
			document.getElementById(obj.name+'_sourceTab').className = "wpTButtonDown"
		
		if (document.getElementById(obj.name+'_previewTab'))
			document.getElementById(obj.name+'_previewTab').className = "wpTButtonDown"
			
		wp_send_to_edit_object(obj)
		obj.html_mode=false
		obj.preview_mode=false
	}
	document.getElementById(obj.name+"_load_message").style.display ='none'
	if (wp_is_ie)
		obj.edit_object.focus()
}
function wp_showCode() {
	if (this.html_mode==false || this.preview_mode==true) {
		if (document.getElementById(this.name+'_sourceTab')) {
			document.getElementById(this.name+"_load_message").style.display ='block'
			setTimeout("wp_on_enter_tab_two("+this.name+")",1);
		}
	}
}
function wp_on_enter_tab_two(obj) {
	if (obj.html_mode==false || obj.preview_mode==true) {
		wp_hide_menu(obj)
		var tab_one = document.getElementById(obj.name+'_tab_one')
		if (wp_is_ie) {
			tab_one.style.display = 'none'
		} else {
			document.getElementById(obj.name+'_editFrame').style.width = '0px'
			tab_one.style.visibility = "hidden"
			tab_one.style.height = '0px'
		}
		document.getElementById(obj.name+'_tab_two').style.display = "block"
		document.getElementById(obj.name+'_tab_three').style.display = "none"
		obj.html_edit_area.style.visibility = "visible" 
		if (document.getElementById(obj.name+'_designTab'))
 			document.getElementById(obj.name+'_designTab').className = "wpTButtonDown"
			
		if (document.getElementById(obj.name+'_sourceTab'))			
			document.getElementById(obj.name+'_sourceTab').className = "wpTButtonUp"
			
		if (document.getElementById(obj.name+'_previewTab'))
			document.getElementById(obj.name+'_previewTab').className = "wpTButtonDown"
			
		obj.html_mode=true
		if (obj.preview_mode==false) {
			wp_send_to_html(obj)
		}
		obj.preview_mode=false
	}
	document.getElementById(obj.name+"_load_message").style.display ='none'
	obj.html_edit_area.focus()
}
function wp_showPreview() {
	if (this.preview_mode==false) {
		if (document.getElementById(this.name+'_previewTab')) {
			document.getElementById(this.name+"_load_message").style.display ='block'
			setTimeout("wp_on_enter_tab_three("+this.name+")",1);
		}
	}
}
function wp_on_enter_tab_three(obj) {
	if (obj.preview_mode==false) {
		wp_hide_menu(obj)
		var tab_one = document.getElementById(obj.name+'_tab_one')
		if (wp_is_ie) {
			tab_one.style.display = 'none'
		} else {
			document.getElementById(obj.name+'_editFrame').style.width = '0px'
			tab_one.style.visibility = "hidden"
			tab_one.style.height = '0px'
		}
		document.getElementById(obj.name+'_tab_two').style.display = "none"
		document.getElementById(obj.name+'_tab_three').style.display = "block"
		if (document.getElementById(obj.name+'_designTab'))
 			document.getElementById(obj.name+'_designTab').className = "wpTButtonDown"
		
		if (document.getElementById(obj.name+'_sourceTab'))		
			document.getElementById(obj.name+'_sourceTab').className = "wpTButtonDown"
		
		if (document.getElementById(obj.name+'_previewTab'))
			document.getElementById(obj.name+'_previewTab').className = "wpTButtonUp"
			
		if (obj.html_mode==false) {
			wp_send_to_html(obj)
		}
		obj.html_mode=true
		obj.preview_mode=true
		wp_send_to_preview(obj)
	}
	document.getElementById(obj.name+"_load_message").style.display ='none'
	obj.previewFrame.focus()
}
function wp_on_mouse_down_tab(srcElement, obj) {
	//document.getElementById(obj.name+"_load_message").style.display ='block'
	if (srcElement.className != 'tbuttonUp')
		srcElement.className='wpTButtonMouseDown'
}
function wp_send_to_preview(obj, dontFocus) {
	obj.previewFrame.document.open()
	obj.previewFrame.document.write(obj.getPreviewCode())
	obj.previewFrame.document.close()
	if (!dontFocus) {
		obj.previewFrame.focus()
	}
}
function updateAllWysiwyg() {
	submit_form()
}
function updateAllHTML() {
	var editors = document.getElementsByTagName("TEXTAREA")
	for (var i=0; i<editors.length; i++) {
		if (editors[i].className == "wpHtmlEditArea") {
			wp_send_to_edit_object(editors[i])
		}
	}
}
function wp_InsertAtSelection(code) {
	wp_insert_code(this, code)
}
function wp_SetCode(code) {
	this.html_edit_area.value = code
	wp_send_to_edit_object(this)
}
function wp_GetSelectedText() {
	var selectedText
	if (wp_is_ie) {
		selectedText = this.edit_object.document.selection.createRange().text
	} else {
		selectedText = this.edit_object.getSelection().getRangeAt(0)
	}
	return selectedText
}
function wp_GetCode() {
	if (this.html_mode==false) {
		wp_send_to_html(this)
	} 
	return this.html_edit_area.value
}
function wp_GetPreviewCode() {
	if (this.html_mode==false) {
		wp_send_to_html(this)
	}
	var str = this.baseURL;
	if (this.stylesheet != '') {
		var num = this.stylesheet.length;
		for (var i=0; i < num; i++) {
			str += '<link rel="stylesheet" href="' + this.stylesheet[i] + '" type="text/css">'
		}
	}
	return str + this.html_edit_area.value
}
function wp_Focus() {
	if (wp_is_ie) {
		var previewFrame = document.frames(this.name+'_previewFrame')
	} else {
		var previewFrame = document.getElementById(this.name+'_previewFrame').contentWindow
	}
	if (this.html_mode==true) {
		this.html_edit_area.focus()
	} else if (this.preview_mode == true) {
		previewFrame.focus()
	} else {
		this.edit_object.focus()
	}
	return true;
}
function wp_initAll() {
	var editors = document.getElementsByTagName("TEXTAREA")
	for (var i=0; i<editors.length; i++) {
		if (editors[i].className == "wpHtmlEditArea") {
			wp_editor(editors[i],eval("config_"+editors[i].id))
		}
	}
}
function wp_updateHTML() {
	if (this.html_mode==false) {
		wp_send_to_html(this)
	}
}
function wp_updateWysiwyg() {
	wp_send_to_edit_object(this)
}
// wp 222
if (window.addEventListener) {
	window.addEventListener('load', wp_initAll, false)
} else if (window.attachEvent) {
	window.attachEvent('onload', wp_initAll)
} else {
	window.onload = wp_initAll
}
// end wp 222
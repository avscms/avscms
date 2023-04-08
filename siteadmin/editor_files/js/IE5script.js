// Purpose: functions specific to Internet Explorer
function wp_divReturn(obj) {
	var sel = obj.edit_object.document.selection.createRange()
	parentTag = wp_skipInline(sel)
	if (parentTag.tagName == "TD"
	|| parentTag.tagName == "THEAD"
	|| parentTag.tagName == "TFOOT" 
	|| parentTag.tagName == "BODY"
	|| parentTag.tagName == "HTML" 
	|| parentTag.tagName == "P") {
		obj.edit_object.document.execCommand("FormatBlock", false, "<div>")
	}
	return true
}
function wp_skipInline(sel) {
	var foo = sel.parentElement()
	var tagName = foo.tagName
	while((wp_inline_tags.test(tagName)) && (tagName!="HTML")) {
		foo = foo.parentElement
		tagName = foo.tagName
	}
	return foo
}
function wp_editor(obj,config) {
	// Strings:
	obj.name = config.name
	obj.instance_lang = config.instance_lang
	obj.encoding = config.encoding
	obj.xhtml_lang = config.xhtml_lang
	obj.baseURLurl = config.baseURLurl
	obj.baseURL = config.baseURL
	obj.doctype = config.doctype
	obj.charset = config.charset
	if (config.domain1) {
		obj.domain1 = config.domain1
		obj.domain2 = config.domain2
	}
	obj.instance_img_dir = config.instance_img_dir
	obj.instance_doc_dir = config.instance_doc_dir
	obj.imagewindow = config.imagewindow
	obj.links = config.links
	obj.custom_inserts = config.custom_inserts
	obj.stylesheet = config.stylesheet
	obj.styles = ''
	obj.color_swatches = config.color_swatches
	// lang
	obj.lng = config.lang
	//integers:
	obj.imenu_height = config.imenu_height
	obj.bmenu_height = config.bmenu_height
	obj.smenu_height = config.smenu_height
	obj.tmenu_height = config.tmenu_height
	obj.border_visible = config.border_visible
	// booleen
	obj.usep = config.usep
	if (obj.usep) {
		obj.tdInners = '<p>&nbsp;</p>';
	} else {
		obj.tdInners = '<div>&nbsp;</div>';
	}
	obj.showbookmarkmngr = config.showbookmarkmngr
	obj.snippit = true
	obj.html_mode=false
	obj.preview_mode=false
	obj.safe = true
	obj.initfocus = false
	obj.subsequent =config.subsequent
	obj.useXHTML = config.useXHTML
	// methods
	obj.getCode = wp_GetCode
	obj.getPreviewCode = wp_GetPreviewCode
	obj.setCode = wp_SetCode
	obj.insertAtSelection = wp_InsertAtSelection
	obj.getSelectedText = wp_GetSelectedText
	obj.moveFocus = wp_Focus
	obj.openDialog = wp_openDialog
	obj.showPreview = wp_showPreview
	obj.showCode = wp_showCode
	obj.showDesign = wp_showDesign
	obj.updateHTML = wp_updateHTML
	obj.updateWysiwyg = wp_updateWysiwyg
	// objects:
	// 222 frame position fix
	obj.format_frame = document.frames(obj.name+"_format_frame")
	obj.class_frame = document.frames(obj.name+"_class_frame")
	obj.font_frame = document.frames(obj.name+"_font_frame")
	obj.size_frame = document.frames(obj.name+"_size_frame")
	obj.format_frame.written = false
	obj.class_frame.written = false
	obj.font_frame.written = false
	obj.size_frame.written = false
	// end 222
	obj.font_face = eval("document.all."+obj.name+"_font_face")
	obj.font_size = eval("document.all."+obj.name+"_font_size")
	obj.format_list = eval("document.all."+obj.name+"_format_list")
	obj.class_menu = eval("document.all."+obj.name+"_class_menu")
	obj.html_edit_area = eval("document.getElementById('"+obj.name+"')")
	var tbar=eval("document.getElementById('"+obj.name+"_tab_one')")
	var tbarimages = document.getElementById(obj.name+"_tab_one").getElementsByTagName('IMG')
	obj.tbarimages = tbarimages
	obj.tbarlength = tbarimages.length
	obj.edit_object = document.frames(obj.name+"_editFrame")
	obj.editFrame = obj.edit_object
	obj.previewFrame = document.frames(obj.name+"_previewFrame")
	// submit_form
	var container = document.getElementById(obj.name+"_container")
	var node = container.parentElement;
	while(node.tagName != 'FORM' && node.tagName != "BODY" && node.tagName != "HTML") {
		node= node.parentElement;
	}
	if (node.tagName == 'FORM') {
		node.attachEvent('onsubmit', wp_submit_editors)
	}
	// end
	if (!wp_is_ie50) {
		var table = document.getElementById(obj.name+"_toolbar1")
		var n = table.all.length
		for (i=0; i<n; i++) {
			table.all[i].unselectable = "on"
		}
		var table = document.getElementById(obj.name+"_toolbar2")
		var n = table.all.length
		for (i=0; i<n; i++) {
			table.all[i].unselectable = "on"
		}
		var tab_table = document.getElementById(obj.name+'_tab_table')
		var n=tab_table.all.length
		for (i=0; i<n; i++) {
			tab_table.all[i].unselectable = "on"
		}
		var hidden = document.getElementById(obj.name+'_hidden')
		var n=hidden.all.length
		for (i=0; i<n; i++) {
			hidden.all[i].unselectable = "on"
		}
	}
	obj.edit_object.document.designMode="on"
	wp_next(obj)
}
function wp_next (obj) {
	// baseURL	
	var str = obj.html_edit_area.value
	// 222 fix to ensure script and form tags are not removed in snippit mode
	if (str.search(/<body/gi) != -1) {
		obj.snippit = false
		str2 = obj.doctype
		if (obj.baseURL != '') {
			str2+=obj.baseURL
		}
		str = str2 + str
	} else {
		obj.snippit = true
		str2 = obj.doctype+'<html><head>'+obj.charset
		if (obj.baseURL != '') {
			str2+=obj.baseURL
		} 
		str = str2 + '</head><body>' + str + '</body></html>'
	}
	// end 222
	try {
		obj.edit_object.document.open()
	} catch (e) {
		document.location.reload()
	}
	obj.edit_object.document.write(str)
	obj.edit_object.document.close()
	obj.edit_object.document.execCommand("2D-Position", true, true)
	obj.edit_object.document.execCommand("LiveResize", true, true)
	obj.edit_object.document.execCommand("MultipleSelection", true, true)
	if (obj.stylesheet != '') {
		var num = obj.stylesheet.length;
		for (var i=0; i < num; i++) {
			obj.edit_object.document.createStyleSheet(obj.stylesheet[i])
		}
	}
	// detect keypress
	obj.edit_object.document.onkeydown = function () {
		// make the enter keypress use <div> instead of <p> as the default.
		if (obj.edit_object.event.keyCode == 13) { // ENTER
			//var sel=obj.edit_object.document.selection.createRange()
			if ((obj.html_mode==false) && (obj.safe) && (!obj.usep) && (obj.edit_object.document.selection.type != "Control")) {
				wp_divReturn(obj)
			}
		} else
		// make the tab key create tabs rather moving the focus away from the editor, which just pisses off people who are used to MS Word.
		if (obj.edit_object.event.keyCode == 9) { // TAB
			if ((obj.html_mode==false) && (obj.safe)) {
				var sel = obj.edit_object.document.selection.createRange() 
				sel.pasteHTML(' &nbsp;&nbsp;&nbsp; ')
				return false
			}
		} else 
		// arrow key selection fix
		if (obj.edit_object.event.keyCode == 39 || obj.edit_object.event.keyCode == 37) {
			wp_set_button_states(obj)
		}
	}
	if (!wp_is_ie50) {
		// context menus
		obj.edit_object.document.oncontextmenu = function () {
			if (obj.safe) {
				wp_current_obj = obj
				var sel=obj.edit_object.document.selection.createRange()
				if (obj.edit_object.document.selection.type == "Control") {
					if (sel(0).tagName == "IMG") {
						if ((sel(0).getAttribute('name')) && (sel(0).src.search(wp_directory+"/images/bookmark_symbol.gif") != -1)) {
							var menu = document.getElementById(obj.name+"_bookmarkMenu")
							oHeight = obj.bmenu_height + 2
							oWidth=230
						} else {
							var menu = document.getElementById(obj.name+"_imageMenu")
							oHeight = obj.imenu_height + 2
							oWidth=230
						}
					} else {
						if (sel(0).tagName == "TABLE") {
							var menu = document.getElementById(obj.name+"_standardMenu")
							oHeight = obj.smenu_height + 2
							oWidth=230
						} else {
							return false
						}
					}
				} else {					
					if (wp_isInside(obj, 'TD')) {
						var menu = document.getElementById(obj.name+"_tableMenu")
						oHeight = obj.tmenu_height + 2
						oWidth=270
					} else {
						var menu = document.getElementById(obj.name+"_standardMenu")
						oHeight = obj.smenu_height + 2
						oWidth=230
					} 
				}
				// make inactive menu items disabled
				var menuRows = menu.getElementsByTagName('TR')
				if (menu == document.getElementById(obj.name+"_tableMenu")) {
					wp_getTable(obj, sel)
				}
				var n=menuRows.length
				for (var i=0; i < n; i++) {
					var cmd = menuRows[i].cid
					menuRows[i].getElementsByTagName('TD')[0].getElementsByTagName('IMG')[0].style.filter = "progid:DXImageTransform.Microsoft.MaskFilter() progid:DXImageTransform.Microsoft.MaskFilter(color=#AAAAAA)"				
					if (cmd == 'unmergeright') {
						if (wp_thisCell.colSpan >= 2) {
							menuRows[i].disabled=false
							menuRows[i].getElementsByTagName('TD')[0].getElementsByTagName('IMG')[0].style.filter = ""
						} else {
							menuRows[i].disabled=true
						}
					} else if (cmd == 'mergeright') {
						if ((!wp_thisCell.nextSibling) || (wp_thisCell.rowSpan != wp_thisCell.nextSibling.rowSpan)) {
							menuRows[i].disabled=true
						} else {
							menuRows[i].disabled=false
							menuRows[i].getElementsByTagName('TD')[0].getElementsByTagName('IMG')[0].style.filter = ""
						}
					} else if (cmd == 'mergebelow') {
						var numrows = wp_thisTable.getElementsByTagName('TR').length
						var topRowIndex = wp_thisRow.rowIndex
						if ((!wp_thisRow.nextSibling) || (numrows - (topRowIndex + wp_thisCell.rowSpan) <= 0)) {
							menuRows[i].disabled=true
						} else {
							menuRows[i].disabled=false
							menuRows[i].getElementsByTagName('TD')[0].getElementsByTagName('IMG')[0].style.filter = ""
						}
					} else if (cmd == 'unmergebelow') {
						if (wp_thisCell.rowSpan < 2) {
							menuRows[i].disabled=true
						} else {
							menuRows[i].disabled=false
							menuRows[i].getElementsByTagName('TD')[0].getElementsByTagName('IMG')[0].style.filter = ""
						}
					} else {				
						if (obj.edit_object.document.queryCommandEnabled(cmd)) {
							menuRows[i].disabled=false
							menuRows[i].getElementsByTagName('TD')[0].getElementsByTagName('IMG')[0].style.filter = ""
						} else {
							menuRows[i].disabled=true
						}
					}
				}
				// now actually make the menus
				var oPopUpBody = wp_oPopUp.document.body
				var evnt = obj.edit_object.event
				wp_oPopUp.document.createStyleSheet(wp_directory+'editor_theme.css');
				oPopUpBody.innerHTML = menu.innerHTML
				oPopUpBody.onmouseup = wp_closePopupTimer
				wp_oPopUp.show(evnt.screenX, evnt.screenY, oWidth, oHeight)
				//document.body.onmouseup = closePopup
				return false
			} else {
				return true
			}
		}
	}
	if (document.attachEvent) {
		eval(obj.name+".edit_object.document.attachEvent('onmouseup', wp_"+obj.name+"_mouseUpHandler, true)")
	} else {
		eval(obj.name+".edit_object.document.onmouseup = wp_"+obj.name+"_mouseUpHandler")
	}
	if (obj.border_visible == 1) {
		wp_show_borders(obj) 
	} else {
		wp_hide_borders(obj)
	}
	// 222
	wp_font_hack(obj.edit_object.document.body, obj);
	// end 222
	// the editor is now ready to use
	document.getElementById(obj.name+"_load_message").style.display ='none'
}
function wp_mouseUpHandler(obj, evt) {
	wp_set_button_states(obj)
	wp_hide_menu(obj)
	wp_current_obj = obj
}
// functions for sending html between edit_object and the textarea
function  wp_send_to_html(obj) {
	if (obj.html_edit_area.value.search(/<body/gi) != -1) {
		obj.snippit = false
		obj.html_edit_area.value = wp_gethtml(obj.edit_object.document,obj)
	} else {
		obj.snippit = true
		obj.html_edit_area.value = wp_gethtml(obj.edit_object.document.body,obj)
	}
	var str=obj.html_edit_area.value
	RegExp.multiline = true
	if (obj.domain1 && obj.domain2) {
		str = str.replace(obj.domain1, '$1"')
		str = str.replace(obj.domain2, '$1"')
	}
	//str = str.replace(/<div><\/div>/gi, "<div>&nbsp;</div>")
	//str = str.replace(/<p><\/p>/gi, "<p>&nbsp;</p>")
	str = str.replace(/ style=\"\"/gi, "")
	obj.html_edit_area.value = str 
}
function wp_send_to_edit_object(obj) { 
	str = obj.html_edit_area.value;
	str = wp_replace_bookmark (str)
	str = str.replace(/<%([^%]+)%>/gi, "<!--asp$1-->")
	str = str.replace(/<br><\/br>/gi, "<br />")
	obj.html_edit_area.value = str
	wp_next(obj)
	if (obj.border_visible == 1) {
		wp_show_borders(obj) 
	} 
	obj.styles = wp_make_styles (obj)
	obj.format_frame.written = false
	obj.class_frame.written = false
	obj.font_frame.written = false
	obj.size_frame.written = false
}
function wp_closePopup() {
  if (wp_oPopUp) {
		wp_oPopUp.hide()
	}
}
// Catch and execute the commands sent from the buttons and tools
function wp_callFormatting(obj,sFormatString) {
	obj.edit_object.focus()
	if (wp_is_ie50) {
		obj.edit_object.document.execCommand(sFormatString)
	} else {
		document.execCommand(sFormatString)
	}
	wp_set_button_states(obj)
}
function wp_change_class(obj,classname) {	
	wp_hide_menu(obj)
	obj.edit_object.focus()
	var sel = obj.edit_object.document.selection.createRange() 
	if (sel.text == '') {
		return;
	}
	var foo = sel.parentElement();
	//wp_font_hack(obj.edit_object.document, obj)
	if (classname == 'wp_none') {
		while(!foo.className&&foo.tagName!="HTML") {
			foo = foo.parentElement;
		}
		if (foo.getAttribute('class') != 'wp_none' && foo.getAttribute('class') != '') {
			foo.className = classname;
		}
	}
	if (obj.edit_object.document.selection.type == "Control") {
		sel(0).setAttribute('class', classname)	
	} else {
		obj.edit_object.document.execCommand("FontName", false, 'wp_bogus_font')
		var spans = obj.edit_object.document.getElementsByTagName('SPAN')
		var fonts = obj.edit_object.document.getElementsByTagName('FONT')
		wp_set_class(spans, classname, true)
		wp_set_class(fonts, classname, true)
	}
	wp_span_hack(obj.edit_object.document, obj)
} 
function wp_set_class(arr, classname, fontCheck) {
	var l = arr.length
	for (var i=0; i < l; i++) {
		if (fontCheck) {
			if (arr[i].style.fontFamily) {
				if (arr[i].style.fontFamily == 'wp_bogus_font') {
					arr[i].className = classname
					arr[i].style.fontFamily = ''
					// do children
					var spans = arr[i].getElementsByTagName('SPAN')
					var fonts = arr[i].getElementsByTagName('FONT')
					wp_set_class(spans, classname, false)
					wp_set_class(fonts, classname, false)
				}
			}
			if (arr[i].getAttribute("face")) {
				if (arr[i].getAttribute("face") == 'wp_bogus_font') {
					arr[i].removeAttribute('face')
					arr[i].className = classname
					// do children
					var spans = arr[i].getElementsByTagName('SPAN')
					var fonts = arr[i].getElementsByTagName('FONT')
					wp_set_class(spans, classname, false)
					wp_set_class(fonts, classname, false)
				}
			} 
		} else if (arr[i].getAttribute('class') != 'wp_none' && arr[i].getAttribute('class') != '') {
			if (arr[i].getAttribute('class') == classname) {
				arr[i].className = 'wp_none'
			} else {
				arr[i].className = classname;
			}
		}
	}
}
// lets try to make a custom hyperlink window!!
function wp_open_hyperlink_window(obj,srcElement) {
	var data = wp_generic_link_window_function (obj, srcElement)
	if (data) {
		var thisTarget = data['target']
		var thisTitle = data['title']
		var szURL= wp_directory +  "dialog_frame.php?target="+thisTarget+"&title="+thisTitle+"&lang="+obj.instance_lang+"&window="+wp_directory+"hyperlink.php"
		linkwin = obj.openDialog (szURL ,'modal',650,394)
	}
}
// link to a document
function wp_open_document_window(obj,srcElement) {
	var data = wp_generic_link_window_function (obj, srcElement)
	if (data) {
		var szURL= wp_directory + "dialog_frame.php?window="+wp_directory+"document.php&instance_doc_dir="+obj.instance_doc_dir+"&lang="+obj.instance_lang
		docwin = obj.openDialog(szURL ,'modal',730,466)
	}
}
function wp_generic_link_window_function (obj,srcElement) {
	if (srcElement.className == "wpDisabled") {
		return	
	}
	var sel = obj.edit_object.document.selection.createRange()
	if ((sel.text == '') && (!wp_isInside(obj, 'A'))) {
		alert(obj.lng['select_hyperlink_text'])
		return
	}
	var thisTarget = ""
	var thisTitle = ""
	// check if hyperlink exists and if so populate the link dialog so that user can edit the existing link
	if (obj.edit_object.document.selection.type == "Control") {
		if (sel(0).tagName == "IMG") {
			this_href = sel(0).parentNode
		} else {
			return
		}
	} else {	
		this_href = sel.parentElement()
	}
	while(this_href.tagName!="A"&&this_href.tagName!="HTML") {
			this_href = this_href.parentElement
	}
	if (this_href.tagName == "A") {
		var thisLink = this_href.getAttribute("HREF", 2)
		wp_current_hyperlink = thisLink
		if (this_href.getAttribute("target")) {
			thisTarget = this_href.getAttribute("target")
		}
		if (this_href.getAttribute("title")) {
			thisTitle = this_href.getAttribute("title")
		}
	} else {
		wp_current_hyperlink = ''
	}
	return {'target': thisTarget,  'title': thisTitle}
}
// this creates the hyperlink html from data sent from the hyperlink window
function wp_hyperlink(obj,iHref,iTarget,iTitle) {
	// if no link data sent then unlink any existing link
	if (iHref=="") { 
			wp_callFormatting(obj, "Unlink")
			obj.edit_object.focus()
			return
	} else if(iHref=="file://") { 
			wp_callFormatting(obj, "Unlink")
			obj.edit_object.focus()
			return
	} else if(iHref=="http://") { 
			wp_callFormatting(obj, "Unlink")
			obj.edit_object.focus()
			return
	} else if(iHref=="https://") { 
			wp_callFormatting(obj, "Unlink")
			return
	} else if(iHref=="mailto:") { 
			wp_callFormatting(obj, "Unlink")
			obj.edit_object.focus()
			return
	} else { 
		var sel = obj.edit_object.document.selection.createRange()
		// create link
		sel.execCommand("CreateLink",false,iHref)
		// add target inf
		if (obj.edit_object.document.selection.type == "Control") {
			var sel = obj.edit_object.document.selection.createRange()
			if (sel(0).tagName == "IMG") {
				this_href = sel(0).parentNode
				sel(0).border = 0
			}
		} else {
			this_href = sel.parentElement()
		}
		while(this_href.tagName!="A"&&this_href.tagName!="HTML") {
			this_href = this_href.parentElement
		}
		if (this_href.tagName == "A") {
			if (iTarget != '' || this_href.target != '') {
				this_href.target=iTarget
			}
			if (iTitle != '' || this_href.title != '') {
				this_href.title=iTitle
			}
		}
	}
	obj.edit_object.focus()
}
// insert image
function wp_open_image_window(obj,srcElement) {
	if (srcElement.className == "wpDisabled") {
		return	
	}
	obj.edit_object.focus()
	var szURL
	// detect if an image is selected and if it is populate image dialoge
	if (obj.edit_object.document.selection.type == "Control") {
		var sel = obj.edit_object.document.selection.createRange()
		if (sel(0).tagName == "IMG") {
			if ((sel(0).getAttribute('name')) && (sel(0).src.search(wp_directory+"/images/bookmark_symbol.gif") != -1)) {
				szURL= wp_directory + obj.imagewindow + "?lang="+obj.instance_lang
			} else {
				var image = sel(0).getAttribute('src', 2)
				if (sel(0).style.height) {
					str = sel(0).style.height
					var height = str.replace(/px/, '')
				} else {
					var height = sel(0).getAttribute('height', 2)
				}
				if (sel(0).style.width) {
					str = sel(0).style.width
					var width = str.replace(/px/, '')
				}	else {
					var width = sel(0).getAttribute('width', 2)
				}
				var alt = sel(0).getAttribute('alt')
				var align = sel(0).getAttribute('align')
				var mtop = sel(0).style.marginTop 
				var mbottom = sel(0).style.marginBottom 
				var mleft = sel(0).style.marginLeft 
				var mright = sel(0).style.marginRight 
				var thisIHeight = sel(0).getAttribute('height')
				var iborder = sel(0).getAttribute('border')
				szURL= wp_directory + 'dialog_frame.php' + '?image=' + image +'&width=' + width +'&height=' + height + '&alt=' + alt + '&align=' + align + '&mtop=' + mtop + '&mbottom=' + mbottom + '&mleft=' + mleft + '&mright=' + mright + '&border=' + iborder + "&lang="+obj.instance_lang +"&window="+wp_directory+"imageoptions.php" 
			}
		} else {
			return
		}
	} else {
		szURL= wp_directory + 'dialog_frame.php?window=' + wp_directory + obj.imagewindow + "&instance_img_dir="+obj.instance_img_dir+"&lang="+obj.instance_lang 
	}
	imgwin = obj.openDialog(szURL ,'modal',730,466)
}
// create the image html
function wp_create_image_html(obj,iurl, iwidth, iheight, ialign, ialt, iborder, imargin) {
	if (iurl == ""){
		return
	}
	obj.edit_object.focus()
	if (document.getElementById(obj.name+'_class_menu-text').innerHTML != "Class")
		document.getElementById(obj.name+'_class_menu-text').innerHTML = "Class"
	var sel = obj.edit_object.document.selection.createRange()
	sel.execCommand("InsertImage",false, iurl)
	if (obj.edit_object.document.selection.type == "Control") {
		var sel = obj.edit_object.document.selection.createRange()
		if (sel(0).tagName == "IMG") {
			if ((iwidth != '') && (iheight!='') && (iwidth != 0) && (iheight!=0) && (iheight!=null)) {
				if (iheight.search("%") != -1) {
					sel(0).style.height = iheight
					sel(0).height = iheight
				} else {
					sel(0).setAttribute("height",  iheight)
					sel(0).style.height = ''
				}
				if (iwidth.search("%") != -1) {
					sel(0).style.width = iwidth
					sel(0).width = iwidth
				} else {
					sel(0).setAttribute("width", iwidth)
					sel(0).style.width = ''
				}
			}
			if ((ialign != '') && (ialign!=0) && (ialign!=null)) {
				sel(0).align = ialign
			}
			if ((iborder != '') && (iborder!=null)) {
				sel(0).border = iborder
			}
			sel(0).alt = ialt
			sel(0).title = ialt
			if ((imargin != '') && (imargin!=null)) {
				sel(0).style.margin = imargin
			}
			//sel(0).src = sel(0).src
		}
	}
	obj.edit_object.focus()
}
// create the horizontal rule html
function wp_create_hr(obj,code) {
	if (code == ""){
		return
	}
	var sel = obj.edit_object.document.selection.createRange()
	obj.edit_object.focus()
	sel.pasteHTML(code)
}
function wp_insert_code(obj,code) {
	if ((code != "") && (code != null)) {
		obj.edit_object.focus()
		if (obj.edit_object.document.selection.type == "Control") {
			obj.edit_object.document.execCommand('delete')
		}
		obj.edit_object.document.selection.createRange().pasteHTML(code)
	}
	if (obj.border_visible == 1) {
		wp_show_borders(obj)
	}
	obj.edit_object.focus()
}
function wp_open_bookmark_window(obj,srcElement) {	
	if (srcElement.className == "wpDisabled") {
		return	
	}
	var arr = ''
	if (obj.edit_object.document.selection.type == "Control") {
		var sel = obj.edit_object.document.selection.createRange()
		if (sel(0).tagName == "IMG") {
			if ((sel(0).getAttribute('name')) && (sel(0).src.search(wp_directory+"/images/bookmark_symbol.gif") != -1)) {
				arr= sel(0).name
			}
		} 
	}
	bookwin = obj.openDialog(wp_directory + "bookmark.php?bookmark="+arr+"&lang="+obj.instance_lang, 'modal', 300, 106)
}
function wp_create_bookmark (obj,name) {
	if ((name != '') && (name!= null)) {
		wp_insert_code(obj,'<img name="'+name+'" src="' + wp_directory + '/images/bookmark_symbol.gif" contenteditable="false" width="16" height="13" alt="Bookmark: '+name+'" title="Bookmark: '+name+'" border="0">')
	}
}
function wp_isInside(obj, tag) {
	sel = obj.edit_object.document.selection.createRange()
	//if (sel.type == "Control") {
		//return false
	//}
	if (!obj.edit_object.document.queryCommandEnabled("InsertHorizontalRule")) {
		return false
	}
	var thisTag = sel.parentElement()
	while(thisTag.tagName!=tag&&thisTag.tagName!="HTML") {
			thisTag = thisTag.parentElement
	}
	if (thisTag.tagName == tag) {
		return true
	} else {
		return false
	}
}
////////////////////////////
// Table editing features //
////////////////////////////
// finds the current table, row and cell and puts them in global variables that the other table functions and the table editing window can use.
// requires the current selection
function wp_getTable(obj, sel) {
	if (sel == null) {
		sel = obj.edit_object.document.selection.createRange()
	}
	wp_thisCell = sel.parentElement()
	while(wp_thisCell.tagName!="TD"&&wp_thisCell.tagName!="HTML") {
			wp_thisCell = wp_thisCell.parentElement
	}
	wp_thisRow = wp_thisCell
	while(wp_thisRow.tagName!="TR"&&wp_thisRow.tagName!="HTML") {
		wp_thisRow = wp_thisRow.parentElement
	}
	wp_thisTable = wp_thisRow
	while(wp_thisTable.tagName!="TABLE"&&wp_thisTable.tagName!="HTML") {
			wp_thisTable = wp_thisTable.parentElement
	}
}
// creates the table html for the insert table window
function wp_insertTable(obj,rows,cols,attrs) {
	obj.edit_object.focus()
	// generate column widths
	var tdwidth = 100/cols
	tdwidth +="%"
		var code = "<table" + attrs + ">\r\n"
		for (var i = 0; i < rows; i++) {
			code += "\t<tr>\r\n"
			for (var j = 0; j < cols; j++) {
				// spacers are autoinserted to ensure table displays as expected. column widths are also set.
				code += "\t\t<td valign=\"top\" width=\"" + tdwidth + "\">"+obj.tdInners+"</td>\r\n"
			}
			code += "\t</tr>\r\n"
		}
		code += "</table>\r\n"
	var sel = obj.edit_object.document.selection.createRange()
	sel.pasteHTML(code)
	if (obj.border_visible == 1) {
		wp_show_borders(obj)
	}
	obj.edit_object.focus()
}
/////////////////////////
// CSS style functions //
/////////////////////////
// these fucntions are still a little messey!!!!!!
// mouse over button style
function wp_m_over(element, obj) {
	if (obj.initfocus == false) {
		return
	}
	var cmd = element.getAttribute("cid")
	if (element.className=="wpDisabled") {
		return
	}
	if ((cmd=="edittable") || (cmd=="splitcell")) {
		cmd="inserthorizontalrule"
	}
	if (cmd == "border") {
		if (obj.border_visible) {
			element.className="wpLatchedOver"
		} else {
			element.className="wpOver"
		}
		return
	} else if (cmd=="ignore") {
		element.className="wpOver"
		return	
	} else if ((cmd=="undo") ||  (cmd=="redo")) {
		element.className="wpOver"
		return
	} else if (obj.edit_object.document.queryCommandState(cmd)) {
		element.className="wpLatchedOver"
		return
	}
	element.className="wpOver"
}
// mouse out button style
function wp_m_out(element, obj) {
	if (obj.initfocus == false) {
		return
	}
	var cmd = element.getAttribute("cid")
	if (element.className=="wpDisabled") {
		return
	}
	if ((cmd=="edittable") || (cmd=="splitcell")) {
		cmd="inserthorizontalrule"
	}
	if (cmd == "border") {
		if (obj.border_visible) {
			element.className="wpLatched"
		} else {
			element.className="wpReady"
		}
		return
	} else if (cmd=="ignore") {
		element.className="wpReady"
		return	
	} else if ((cmd=="undo") ||  (cmd=="redo")) {
		element.className="wpReady"
		return
	} else if (!obj.edit_object.document.queryCommandEnabled(cmd)) {
		element.className="wpDisabled"
		return
	} else if (obj.edit_object.document.queryCommandState(cmd)) {
		element.className="wpLatched"
		return
	}
	element.className="wpReady"
}
// mouse down button style
function wp_m_down(element, obj) {
	if (obj.initfocus == false) {
		obj.edit_object.focus();
		obj.initfocus = true;
	}
	if (element.className == "wpDisabled") {
		return
	}
	element.className="wpDown"
}
// mouse up button style
function wp_m_up(element, obj) {
	var style=element.className
	if (style=="wpDisabled") {
		return
	} else {
		if (style=="wpLatched") {
			return
		}
	}
	element.className="wpOver"
}
///////////////////////
// Set button states //
///////////////////////
// This changes the states of buttons everytime the selection changes, so that buttons that cannot be used based on the current user selection appear disabled.
// this is the crappiest slowest function in zeusedit, it really needs an overhaul!!
function wp_set_button_states(obj) {
	obj.initfocus = true
	var sel=obj.edit_object.document.selection.createRange()
	var inside_link = wp_isInside(obj, 'A')
	var inside_table = wp_isInside(obj, 'TD')
	if (inside_table) {
		var wp_thisCell = sel.parentElement()
		while(wp_thisCell.tagName!="TD"&&wp_thisCell.tagName!="HTML") {
			wp_thisCell = wp_thisCell.parentElement
		}
	}	
	// evalute and set the toolbar button states
	for(var i = 0; i < obj.tbarlength; i++) {
		var pbtn = obj.tbarimages(i)
		if ((pbtn.type=="btn")) {
			var cmd = pbtn.getAttribute("cid")
			if (!obj.safe) {
				pbtn.className="wpDisabled"
			} else if ((cmd=="edittable") || (cmd == 'splitcell')) {
			// table editing buttons
				if (inside_table) {
					if (cmd == 'splitcell') {
						if ((wp_thisCell.rowSpan >= 2) || (wp_thisCell.colSpan >=2)) {
							pbtn.className="wpReady"
						} else {
							pbtn.className="wpDisabled"
						}
					} else {
						pbtn.className="wpReady"
					}
				} else {
					pbtn.className="wpDisabled"
				}
			} else if (cmd == "border") {
				if (obj.border_visible) {
					pbtn.className="wpLatched"
				} else {
					pbtn.className="wpReady"
				}
			} else if (cmd=="createlink") {
				if ((inside_link) || (sel.text != '')) {
					pbtn.className="wpReady"
				} else {
					pbtn.className="wpDisabled"
				}
			} else if ((cmd=="undo") ||  (cmd=="redo")) {
					pbtn.className="wpReady"
			} else if (obj.edit_object.document.queryCommandState(cmd)) {
				pbtn.className="wpLatched"
			} else if (!obj.edit_object.document.queryCommandEnabled(cmd)) {
				pbtn.className="wpDisabled"
			} else {	
				pbtn.className="wpReady"
			}
		}
	}
	var font_face_value = obj.edit_object.document.queryCommandValue('FontName')
	var font_size_value = obj.edit_object.document.queryCommandValue('FontSize')
	var format_list_value = obj.edit_object.document.queryCommandValue('FormatBlock')
	if (obj.edit_object.document.selection.type == "Control") {
		var class_menu_value = ''
	} else {
		var foo = sel.parentElement()
		while(!foo.className&&foo.tagName!="HTML") {
			foo = foo.parentElement
		}
		var class_menu_value = foo.className
	}
	wp_set_list_text ('font-face', font_face_value, 'font', obj)
	wp_set_list_text ('font_size', font_size_value, 'size', obj)
	wp_set_list_text ('format_list', format_list_value, 'format', obj)
	var class_menu_text = document.getElementById(obj.name+'_class_menu-text')
	if (class_menu_value) {
		if (class_menu_value == "wp_none") {
			if (class_menu_text.innerHTML != obj.lng['class'])
				class_menu_text.innerHTML = obj.lng['class']
		} else if (class_menu_text.innerHTML != class_menu_value) {
			class_menu_text.innerHTML = class_menu_value
		}
	} else {
		if (class_menu_text.innerHTML != obj.lng['class'])
			class_menu_text.innerHTML = obj.lng['class']
	}
}
function wp_set_list_text (list, value, lang, obj) {
	var list_text = document.getElementById(obj.name+'_'+list+'-text')
	if (value) {
		if (list_text.innerHTML != value)
			list_text.innerHTML = value
	} else {
		if (list_text.innerHTML != obj.lng[lang])
			list_text.innerHTML = obj.lng[lang]
	}
}
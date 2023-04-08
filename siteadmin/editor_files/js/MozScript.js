// Purpose: functions specific to Gecko based browsers that support Midas
var wp_is_ie50 = false;
function wp_keyHandler (obj, evt) {
	var keyCode = (evt.which || evt.charCode || evt.keyCode)
	if (obj.edit_object.getSelection) {
		if (!evt.shiftKey) {
			if (keyCode == 13) {
				wp_divReturn(obj, evt)
			} else if (keyCode == 8) {
				wp_remove_first_br(obj)
			}
		} else if (keyCode == 39 || keyCode == 37) {
			wp_set_button_states(obj)
		}
	}
}
function wp_mouseUpHandler(obj, evt) {
	wp_hide_menu(obj); 
	wp_set_button_states(obj); 
	wp_current_obj = obj; 
	wp_select_fix(obj, evt); 
}
function wp_context(obj, evnt) {
	var sel1 = window.getSelection()
	sel1.removeAllRanges()
	wp_closePopup()
	wp_current_obj = obj;
	var range = obj.edit_object.getSelection().getRangeAt(0)
	var container = range.startContainer
	var pos = range.startOffset
	var imageNode = null
	var tableNode = null
	var canLink = true
	var inside_link = wp_isInside(obj, 'A')
	if (range == '' && container.nodeType != 1 && !inside_link) {
		canLink = false
	}
	if (container.tagName) {
		var images = container.getElementsByTagName('IMG');
		var cn = container.childNodes
		if (cn[pos]) {
			if (cn[pos].tagName == 'IMG') {
				imageNode = cn[pos]
			}
		}
	}	
	if (imageNode) {
		if ((imageNode.getAttribute('name')) && (imageNode.src.search(wp_directory+"/images/bookmark_symbol.gif") != -1)) {
			var menu = document.getElementById(obj.name+"_bookmarkMenu")
			oWidth=230
			oHeight = obj.bmenu_height + 2
		} else {
			var menu = document.getElementById(obj.name+"_imageMenu")
			oWidth=230
			oHeight = obj.imenu_height + 2
		}
	} else if (wp_isInside(obj, 'TD')) {
		var menu = document.getElementById(obj.name+"_tableMenu")
		oWidth=270
		oHeight = obj.tmenu_height + 2
		wp_getTable(obj)
	} else {
		var menu = document.getElementById(obj.name+"_standardMenu")
		oWidth=230
		oHeight = obj.smenu_height + 2
	}
	// make inactive menu items disabled
	var menuRows = menu.getElementsByTagName('TR')
	var n=menuRows.length
	if (n >= 1) {
		for (var i=0; i < n; i++) {
			var cmd = menuRows[i].getAttribute('cid')
			tds=menuRows[i].getElementsByTagName('TD')
			tds[0].className = "wpContextCellOne"
			tds[1].className = "wpContextCellTwo"
			if (cmd=="createlink") {
				if (!canLink) {
					menuRows[i].disabled = true
					tds[1].style.color = 'threedshadow'
				} else {
					menuRows[i].disabled = false
					tds[1].style.color = ''
				}
			} else if (cmd == 'unmergeright') {
				if (wp_thisCell.colSpan < 2) {
					menuRows[i].disabled = true
					tds[1].style.color = 'threedshadow'
				} else {
					menuRows[i].disabled = false
					tds[1].style.color = ''
				}
			} else if (cmd == 'mergeright') {
				if ((!wp_thisCell.nextSibling) || (wp_thisCell.rowSpan != wp_thisCell.nextSibling.rowSpan)) {
					menuRows[i].disabled = true
					tds[1].style.color = 'threedshadow'
				} else {
					menuRows[i].disabled = false
					tds[1].style.color = ''
				}
			} else if (cmd == 'mergebelow') {
				var numrows = wp_thisTable.getElementsByTagName('TR').length
				var topRowIndex = wp_thisRow.rowIndex
				if ((!wp_thisRow.nextSibling) || (numrows - (topRowIndex + wp_thisCell.rowSpan) <= 0)) {
					menuRows[i].disabled = true
					tds[1].style.color = 'threedshadow'
				} else {
					menuRows[i].disabled = false
					tds[1].style.color = ''
				}
			} else if (cmd == 'unmergebelow') {
				if (wp_thisCell.rowSpan < 2) {
					menuRows[i].disabled = true
					tds[1].style.color = 'threedshadow'
				} else {
					menuRows[i].disabled = false
					tds[1].style.color = ''
				}
			} else {
				try {				
					if (!obj.edit_object.document.queryCommandEnabled(cmd)) {
						menuRows[i].disabled = true
						tds[1].style.color = 'threedshadow'
					} else {
						menuRows[i].disabled = false
						tds[1].style.color = ''
					}
				} catch (e) {
					menuRows[i].disabled = false
					tds[1].style.color = ''
				}
			}
		}
		// now actually make the menus	
		var frame = document.getElementById(obj.name+'_editFrame')
		position = wp_getElementPosition(frame)
		var topPos
		var leftPos
		var scrollLeft = document.body.scrollLeft + document.documentElement.scrollLeft
		var scrollTop = document.body.scrollTop + document.documentElement.scrollTop
		availHeight = window.innerHeight + scrollTop
		availWidth = window.innerWidth + scrollLeft
		var clientX = evnt.clientX + position['left']
		var clientY = evnt.clientY + position['top']
		if (clientX + oWidth > availWidth) {
			leftPos = availWidth - oWidth - 2
		} else {
			leftPos = clientX
		}
		if (clientY + oHeight > availHeight) {
			topPos = availHeight - oHeight
		} else {
			topPos = clientY
		}
		menu.style.position = 'absolute'
		menu.style.left = leftPos+'px'
		menu.style.top = topPos+'px'
		menu.style.width = oWidth+'px'
		menu.style.display='block'
		document.addEventListener('mouseup', wp_closePopupTimer, true)
	}
	evnt.stopPropagation()
	evnt.preventDefault()
}
function wp_closePopup(objname) {
	var editors = document.getElementsByTagName("TEXTAREA")
	for (var i=0; i<editors.length; i++) {
		if (editors[i].className == "wpHtmlEditArea") {
			document.getElementById(editors[i].id+"_bookmarkMenu").style.display = 'none'
			document.getElementById(editors[i].id+"_imageMenu").style.display = 'none'
			document.getElementById(editors[i].id+"_standardMenu").style.display = 'none'
			document.getElementById(editors[i].id+"_tableMenu").style.display = 'none'
			document.getElementById(editors[i].id+"_standardMenu").style.display = 'none'
		}
	}
}
// removes those br tags that mozilla adds when you backspace through a node
function wp_remove_first_br (obj, evt) {
	var sel = obj.edit_object.getSelection()
	var range = sel.getRangeAt(0)
	var startContainer = range.startContainer
	var container = startContainer.parentNode
	// find the parent node	
	var node = wp_skipInline(container)
	// traverse the node backwards to find the last br
	if (node.firstChild) {
		if (node.firstChild.nodeType == 3) {
			if (node.firstChild.nextSibling) {
					node = node.firstChild.nextSibling
			}
		}
		while (node.firstChild && node.firstChild.nodeType == 1) {
			node = node.firstChild;
		}
		// if more than one br assume it's meant to be there otherwise remove it
		var previousTag = ''
		if (node.nextSibling) {
			nextTag = node.nextSibling.nodeName
			if (node.nodeName == 'BR' && nextTag != 'BR') {
				node.parentNode.removeChild(node)
			}
		}
	}
}
// non-br returns
function wp_divReturn(obj, evt) {
	if (wp_isInside(obj, 'LI')) {
		return;
	}
	var sel = obj.edit_object.getSelection()
	var range = sel.getRangeAt(0)
	var startContainer = range.startContainer
	var container = startContainer.parentNode
	// find the parent node	
	var parentTag = wp_skipInline(container)
	var endContainer = range.endContainer
	var endNode1 = endContainer.parentNode
	// determine the tag that the parent node replacement (before node) should be
	var beforeTag; var afterTag; var addAttributes = false; var attributes; var className; var cssText;
	if (parentTag.tagName) {
		// if a supported block get attributes
		if (wp_supported_blocks.test(parentTag.tagName)) {
			addAttributes = true
			attributes = parentTag.attributes
		}
		if (parentTag.tagName != 'P' && wp_supported_blocks.test(parentTag.tagName)) {
			beforeTag = parentTag.tagName
		} else if (obj.usep) {
			beforeTag = 'P'
		} else if (!wp_supported_blocks.test(parentTag.tagName)) {
			beforeTag = 'DIV'
		} else {
			beforeTag = 'DIV'
			// replace with div tag then continue
			obj.edit_object.document.execCommand("FormatBlock", false, "div")
		}
	} else if (obj.usep) {
		beforeTag = 'P'
	} else {
		beforeTag = 'DIV'
	}
	// determine the tag that the new after node should be (adjust this later)
	var afterTag = beforeTag
	// make sure we overwrite the selection
	if (container != endNode1) {
		obj.edit_object.document.execCommand('Delete', false, null)
	}
	// create and find ranges to cut
	var rngbefore = obj.edit_object.document.createRange()		
	var rngafter = obj.edit_object.document.createRange()
	rngbefore.setStart(sel.anchorNode, sel.anchorOffset);	
	rngafter.setStart(sel.focusNode, sel.focusOffset);
	rngbefore.collapse(true);					
	rngafter.collapse(true);
	var direct = rngbefore.compareBoundaryPoints(rngbefore.START_TO_END, rngafter) < 0;
	var startNode = direct ? sel.anchorNode : sel.focusNode;
	var startOffset = direct ? sel.anchorOffset : sel.focusOffset;
	var endNode = direct ? sel.focusNode : sel.anchorNode;
	var endOffset = direct ? sel.focusOffset : sel.anchorOffset;
	// find parent blocks
	var startBlock = wp_skipInline(startNode);
	var endBlock = wp_skipInline(endNode);
	// find start and end points
	var startCut = startNode;
	var endCut = endNode;
	while ((startCut.previousSibling && startCut.previousSibling.nodeName != beforeTag) || (startCut.parentNode && startCut.parentNode != startBlock && startCut.parentNode.nodeType != 9)) {
		startCut = startCut.previousSibling ? startCut.previousSibling : startCut.parentNode;
	}
	while ((endCut.nextSibling && endCut.nextSibling.nodeName != afterTag) || (endCut.parentNode && endCut.parentNode != endBlock && endCut.parentNode.nodeType != 9)) {
		endCut = endCut.nextSibling ? endCut.nextSibling : endCut.parentNode;
	}
	// get the contents for each new tag
	rngbefore.setStartBefore(startCut);
	rngbefore.setEnd(startNode,startOffset);
	var beforeContents = rngbefore.cloneContents()
	rngafter.setEndAfter(endCut);
	rngafter.setStart(endNode,endOffset);
	var afterContents = rngafter.cloneContents()
	// test to see if after tag will be empty and if so change to p or div
	if (!wp_has_content(afterContents )) {
		if (obj.usep) {
			afterTag = 'p'
		} else {
			afterTag = 'div'
		}
	}
	// create the new elements
	var newbefore = obj.edit_object.document.createElement(beforeTag);
	var newafter = obj.edit_object.document.createElement(afterTag);
	// place content into the new tags
	newbefore.appendChild(beforeContents)
	newafter.appendChild(afterContents)
	// fill tags if empty
	wp_fill_content(newbefore)
	wp_fill_content(newafter)
	// add attributes
	if (addAttributes) {
		wp_add_attributes(newbefore, attributes)
		wp_add_attributes(newafter, attributes, false, true)
	}
	// make a range around everything
	var rngSurround = obj.edit_object.document.createRange();
	if (!startCut.previousSibling && startCut.parentNode.nodeName == beforeTag) {
		rngSurround.setStartBefore(startCut.parentNode);
	} else {
		rngSurround.setStart(rngbefore.startContainer, rngbefore.startOffset)
	}
	if (!endCut.nextSibling && endCut.parentNode.nodeName == beforeTag) {
		rngSurround.setEndAfter(endCut.parentNode);
	} else {
		rngSurround.setEnd(rngafter.endContainer, rngafter.endOffset)
	}
	// delete old tag
	rngSurround.deleteContents();
	// insert the two new tags
	rngSurround.insertNode(newafter)
	rngSurround.insertNode(newbefore)
	// scroll to the new cursor position
	var scrollTop = obj.edit_object.document.body.scrollTop + obj.edit_object.document.documentElement.scrollTop
	var scrollLeft = obj.edit_object.document.body.scrollLeft + obj.edit_object.document.documentElement.scrollLeft
	var scrollBottom = document.getElementById(obj.name+'_editFrame').style.height
	scrollBottom = scrollBottom.replace(/px/i, '')
	var frameHeight = scrollBottom
	scrollBottom = scrollTop + parseInt(scrollBottom)
	var afterposition = wp_getElementPosition(newafter)
	if (afterposition['top'] > scrollBottom - 25) {
		obj.edit_object.scrollTo(afterposition['left'], afterposition['top'] - parseInt(frameHeight) + 25)
	} else {
		obj.edit_object.scrollBy(afterposition['left'] - scrollLeft, 0)
	}
	// move the cursor
	while (newafter.firstChild && wp_inline_tags.test(newafter.firstChild.nodeName)) {
		newafter = newafter.firstChild;
	}
	if (newafter.firstChild && newafter.firstChild.nodeType == 3) {
		newafter = newafter.firstChild
	}
	var rngCaret = obj.edit_object.document.createRange()
	rngCaret.setStart(newafter, 0);
	rngCaret.collapse(true)
	sel = obj.edit_object.getSelection()
	sel.removeAllRanges()
	sel.addRange(rngCaret)
	// stop browser default action
	evt.stopPropagation()
	evt.preventDefault()
}
// determins the absolute position of an element
function wp_getElementPosition(elem) {
    var offsetTrail = elem;
    var offsetLeft = 0;
    var offsetTop = 0;
    while (offsetTrail) {
        offsetLeft += offsetTrail.offsetLeft;
        offsetTop += offsetTrail.offsetTop;
        offsetTrail = offsetTrail.offsetParent;
    }
    return {left:offsetLeft, top:offsetTop};
}
// finds first block level tag surrounding a given node
function wp_skipInline(foo) {
	while (foo.parentNode && (foo.nodeType != 1 || wp_inline_tags.test(foo.tagName))) {
		foo = foo.parentNode;
	}
	return foo
}
// returns true if a node contains text content, if node contains only empty tags return false.
function wp_has_content(node) {
	if (node.firstChild) {
		var istChild = node.firstChild;
		var val;
		while (istChild) {
			if (istChild.nodeType == 1 && !wp_inline_tags.test(istChild.nodeName)) {
				return true;
			} else if (istChild.nodeType == 3 && istChild.nodeValue.trim() != '') {
				return true;
			} else if ((val = wp_has_content(istChild)) != false) {
				return val;
			}
			istChild = istChild.nextSibling;
		}
	}
	return false
}
// adds white space to a node with no text nodes
function wp_fill_content(node) {
	if (!wp_has_content(node)  ) {
		//node.innerHTML = node.innerHTML.trim()
		while (node.firstChild && node.firstChild.nodeType == 1) {
			node = node.firstChild;
		}
		node.innerHTML = '&nbsp;'
	}
}
// moves cursor to beginning of tags that contain only &nbsp;
function wp_select_fix(obj, evt) {
	var sel = obj.edit_object.getSelection()
	var range = sel.getRangeAt(0)
	var startContainer = range.startContainer
	var endContainer = range.endContainer
	var startNode = startContainer.parentNode
	var endNode = endContainer.parentNode
	if (startNode != endNode) {
		return
	} else {
		while (startNode.firstChild && wp_inline_tags.test(startNode.firstChild.nodeName)) {
			startNode = startNode.firstChild;
		}
		if (startNode.innerHTML == '&nbsp;' && startNode.firstChild && startNode.firstChild.nodeType == 3) {
			startNode = startNode.firstChild
			var rngCaret = obj.edit_object.document.createRange();
			rngCaret.setStart(startNode, 0);
			rngCaret.collapse(true);
			sel = obj.edit_object.getSelection();
			sel.removeAllRanges();
			sel.addRange(rngCaret);
		}
	}
}
// returns true if inside an li tag
function wp_isInside (obj, tag) {
	var sel = obj.edit_object.getSelection()
  var range = sel.getRangeAt(0)
	var container = range.startContainer
	if (container.nodeType != 1) {
		var textNode = container
    container = textNode.parentNode
	}
	thisTag = container
	while(thisTag.tagName!=tag&&thisTag.tagName!="BODY") {
			thisTag = thisTag.parentNode
	}
	if (thisTag.tagName == tag) {
		return true
	} else {
		return false
	}
}
// constructor
function wp_editor(obj,config) {
	// strings:
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
	// integers
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
	obj.html_edit_area = document.getElementById(obj.name)
	obj.format_list=document.getElementById(obj.name+'_format_list')
	obj.font_face=document.getElementById(obj.name+'_font_face')
	obj.font_size=document.getElementById(obj.name+'_font_size')
	obj.class_menu=document.getElementById(obj.name+'_class_menu')
	obj.foo = obj.html_edit_area.value
	// 222 frame position fix
	obj.format_frame = document.getElementById(obj.name+"_format_frame").contentWindow
	obj.class_frame = document.getElementById(obj.name+"_class_frame").contentWindow
	obj.font_frame = document.getElementById(obj.name+"_font_frame").contentWindow
	obj.size_frame = document.getElementById(obj.name+"_size_frame").contentWindow
	try {
		obj.format_frame.written = false
		obj.class_frame.written = false
		obj.font_frame.written = false
		obj.size_frame.written = false
	} catch (e) {
	}
	// ens 222
	var tbar=eval("document.getElementById('"+obj.name+"_tab_one')")
	var tbarimages = document.getElementById(obj.name+"_tab_one").getElementsByTagName('IMG')
	obj.tbarimages = tbarimages
	obj.tbarlength = tbarimages.length
	obj.safe = true
	obj.edit_object = document.getElementById(obj.name+'_editFrame').contentWindow
	obj.editFrame = obj.edit_object
	obj.previewFrame = document.getElementById(obj.name+"_previewFrame").contentWindow
	// submit_form
	var container = document.getElementById(obj.name+"_container")
	var node = container.parentNode;
	while(node.tagName != 'FORM' && node.tagName != "BODY" && node.tagName != "HTML") {
		node= node.parentNode;
	}
	if (node.tagName == 'FORM') {
		node.addEventListener('submit', wp_submit_editors, false)
	}
	// end	
	var str = ''
	if (str.search(/<body/gi) != -1) {
		obj.snippit = false
		str = obj.doctype
		if (obj.baseURL != '') {
			str += obj.baseURL
		}
		if (obj.stylesheet != '') {
			var num = obj.stylesheet.length;
			for (var i=0; i < num; i++) {
				str += '<link rel="stylesheet" href="'+obj.stylesheet[i]+'" type="text/css">'
			}
		}
	} else {
		obj.snippit = true
		str = obj.doctype+'<html><head><title></title>'+obj.charset
		if (obj.baseURL != '') {
			str += obj.baseURL
		}
		if (obj.stylesheet != '') {
			var num = obj.stylesheet.length;
			for (var i=0; i < num; i++) {
				str += '<link rel="stylesheet" href="'+obj.stylesheet[i]+'" type="text/css">'
			}
		}
		str += '</head><body></body></html>'
	}
	try {
		obj.edit_object.document.open()
	} catch (e) {
		obj.edit_object.document.close()
		wp_fail(obj)
		return
	}
	obj.edit_object.document.write(str)
	obj.edit_object.document.close()
	obj.edit_object.stop()
	if (obj.html_edit_area.value.search(/<body/gi) != -1) {
		obj.snippit = false
	} else {
		obj.snippit = true
	}
	wp_load_data(obj.name)
}
function wp_load_data(name) {
	var obj = document.getElementById(name)
	if (obj.edit_object.document.body) {
		wp_send_to_edit_object(obj, true)
	} else {
		setTimeout("wp_load_data('"+name+"')",100)
	}
}
function wp_enable_designMode(obj) {
	try {
		obj.edit_object.document.designMode = "on"
	} catch (e) {
		wp_fail(obj)
		return
	}
	try {
		obj.edit_object.document.execCommand("usecss", false, true)
	} catch (e) {
		wp_fail(obj)
		return
	}	
}
function wp_next(obj) {
	wp_send_to_edit_object(obj)
}
function wp_fail(obj) {
		document.getElementById(obj.name+'_tab_one').style.display = "none"
		document.getElementById(obj.name+'_tab_two').style.display = "block"
		document.getElementById(obj.name+'_tab_three').style.display = "none"
		document.getElementById(obj.name+'_tab_table').style.display="none"
		obj.html_edit_area.style.visibility = "visible"		
		obj.html_edit_area.value = obj.foo
		obj.html_mode=true
		document.getElementById(obj.name+'_load_message').style.display ='none'
		if (obj.subsequent == false) {
			alert(obj.lng['upgrade'])
		}
}
function wp_insertNodeAtSelection(win, insertNode) {
	var sel = win.getSelection()
	var range = sel.getRangeAt(0)
	sel.removeAllRanges()
	range.deleteContents()
	var container = range.startContainer
	var pos = range.startOffset
	range=document.createRange()
	if (container.nodeType==3 && insertNode.nodeType==3) {
		container.insertData(pos, insertNode.nodeValue)
		range.setEnd(container, pos+insertNode.length)
		range.setStart(container, pos+insertNode.length)
	} else {
		var afterNode
		if (container.nodeType==3) {
			var textNode = container
			container = textNode.parentNode
			var text = textNode.nodeValue
			var textBefore = text.substr(0,pos)
			var textAfter = text.substr(pos)
			var beforeNode = document.createTextNode(textBefore)
			var afterNode = document.createTextNode(textAfter)
			container.insertBefore(afterNode, textNode)
			container.insertBefore(insertNode, afterNode)
			container.insertBefore(beforeNode, insertNode)
			container.removeChild(textNode)
		} else {
			afterNode = container.childNodes[pos]
			container.insertBefore(insertNode, afterNode)
		}
		if (insertNode.tagName) {
			if (insertNode.tagName == 'IMG') {
				range.selectNode(insertNode)
			} else {
				range.setEnd(afterNode, 0)
				range.setStart(afterNode, 0)
			}
		} else {
			range.setEnd(afterNode, 0)
			range.setStart(afterNode, 0)
		}		
	}
	sel = win.getSelection();
	sel.removeAllRanges();
	sel.addRange(range)
	//sel.addRange(rngCaret);
	win.focus()
}
// functions for sending html between edit_object and the textarea
function wp_send_to_html(obj) {
	var str1 = obj.edit_object.document.body.innerHTML
	str1 = str1.replace(/\&nbsp;/gi, '<!-- WP_SPACEHOLDER -->');
	str1 = str1.replace(/<<(.*?)>>/gi, "<$1>")
	str1 = str1.replace(/<\/<(.*?)>>/gi, "</$1>")
	str1 = str1.replace(/<>/gi, "")
	str1 = str1.replace(/<\/>/gi, "")
	obj.edit_object.document.body.innerHTML = str1	
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
	str = str.replace(/ type=\"_moz\"/gi, '')
	str = str.replace(/ style=\"\"/gi, "")
	str = str.replace(/<\!-- WP_SPACEHOLDER -->/gi, '&nbsp;');
	str = str.replace(/<b>/gi, '<strong>');
	str = str.replace(/<b /gi, '<strong ');
	str = str.replace(/<\/b>/gi, '</strong>');
	str = str.replace(/<i>/gi, '<em>');
	str = str.replace(/<i /gi, '<em ');
	str = str.replace(/<\/i>/gi, '</em>');
	str = str.replace(/<p><\/p>/gi, '');
	str = str.replace(/<div><\/div>/gi, '');
	str = str.replace(/([a-zA-Z0-9\.,:;\!])\n<br[^>]+><\/(p|div|h1|h2|h3|h4|h5|h6)>/gi, '$1</$2>');
	str = str.replace(/<(p|div|h1|h2|h3|h4|h5|h6)([^>]+)>\n<br[^>]+><\/(p|div|h1|h2|h3|h4|h5|h6)>/gi, '<$1$2>&nbsp;</$3>');
	obj.html_edit_area.value = str 
}
function wp_send_to_edit_object(obj, init) {
	obj.html_edit_area.value = wp_replace_bookmark (obj.html_edit_area.value) 
	var str = obj.html_edit_area.value
	str = str.replace(/<strong>/gi, '<b>');
	str = str.replace(/<strong /gi, '<b ');
	str = str.replace(/<\/strong>/gi, '</b>');
	str = str.replace(/<em>/gi, '<i>');
	str = str.replace(/<em /gi, '<i ');
	str = str.replace(/<\/em>/gi, '</i>');
	str = str.replace(/<%([^%]+)%>/gi, "<!--asp$1-->");
	str = str.replace(/<\?php([^\?]+)\?>/gi, "<!--p$1-->");
	obj.html_edit_area.value = str
	if (obj.html_edit_area.value.search(/<body/gi) != -1) {
		obj.snippit = false
	} else {
		obj.snippit = true
	}
	if ((!obj.snippit) && (obj.html_edit_area.value != '')) {
		var str = obj.html_edit_area.value
		// we cannot write to the document again in Mozilla or we could crash the browser so we need to be creative.
		var htmlseparator = new RegExp("<html[^>]*?>","gi")
		var bodyseparator = new RegExp("<body[^>]*?>","gi")
		var htmlsplit=str.split(htmlseparator)
		var bodysplit=str.split(bodyseparator)
		var headsplit = str.split(/<head>/gi)
		var head = ''
		var html = ''
		var bodyc = ''
		// 222 - body attributes 
		var arrsplit=str.split(/<body/gi);
		var bodytag = obj.edit_object.document.getElementsByTagName('BODY')
		// remove all existing body attributes
		var attrs = bodytag[0].attributes
		var l = attrs.length
		for (var i = 0; i < l; i++) {
			bodytag[0].setAttribute(attrs[i].nodeName, '')
		}
		if (arrsplit.length>0) {
			var arrsplit2=arrsplit[1].split(">");
			var attribute_array = arrsplit2[0].split('" ')
			var n = attribute_array.length
			for (i=0; i<n; i++) {
				if (attribute_array[i].search("=") != -1) {
					var attribute = attribute_array[i].split("=")
					var elm = attribute[0].trim().replace(/"/gi,'')
					var val = attribute[1].trim().replace(/"/gi,'')
					bodytag[0].setAttribute( elm, val, 0 )
				}
			}
		}
		// end 222
		if (headsplit.length>1) {
			var head2 = headsplit[1].split(/<\/head>/gi)
			head = head2[0]
		} 
		if (bodysplit.length>1) {
			var body2 = bodysplit[1].split(/<\/body>/gi)
			bodyc = body2[0]
		} 
		obj.edit_object.document.body.innerHTML = bodyc
		// head contents
		var headtag = obj.edit_object.document.getElementsByTagName('HEAD')
		var headcontent = obj.baseURL;
		if (obj.stylesheet != '') {
			var num = obj.stylesheet.length;
			for (var i=0; i < num; i++) {
				headcontent += '<link rel="stylesheet" href="'+obj.stylesheet[i]+'" type="text/css">'
			}
		}
		headcontent += head
		headtag[0].innerHTML = headcontent
	} else {
		var headtag = obj.edit_object.document.getElementsByTagName('HEAD')
		var headcontent = obj.charset + obj.baseURL
		if (obj.stylesheet != '') {
			var num = obj.stylesheet.length;
			for (var i=0; i < num; i++) {
				headcontent += '<link rel="stylesheet" href="'+obj.stylesheet[i]+'" type="text/css">'
			}
		}
		headtag[0].innerHTML = headcontent
		obj.edit_object.document.body.innerHTML = obj.html_edit_area.value
	}
	if (obj.border_visible == 1) {
		obj.edit_object.document.onload =  wp_show_borders(obj)
	} else {
		obj.edit_object.document.onload =  wp_hide_borders(obj)
	}
	obj.styles = wp_make_styles (obj)
	try {
		obj.format_frame.written = false
		obj.class_frame.written = false
		obj.font_frame.written = false
		obj.size_frame.written = false
	} catch (e) {
	}
	if (obj.html_mode==false) {
		try {
			obj.edit_object.focus()
		} catch (e) {
		}
	}
	// wp 222
	wp_font_hack(obj.edit_object.document.body, obj)
	// wp 222
	eval(obj.name+".edit_object.document.addEventListener('mouseup', wp_"+obj.name+"_mouseUpHandler, true)")
	eval(obj.name+".edit_object.document.addEventListener('mousedown', wp_closePopup, true)")
	eval(obj.name+".edit_object.document.addEventListener('keypress', wp_"+obj.name+"_keyHandler, true)")
	eval(obj.name+".edit_object.document.addEventListener('contextmenu', wp_"+obj.name+"_contextHandler, true)")
	if (init) {
		wp_enable_designMode(obj)
	}
	document.getElementById(obj.name+'_load_message').style.display ='none'
}
// Catch and execute the commands sent from the buttons and tools
function wp_callFormatting(obj,sFormatString) {
	obj.edit_object.focus()
	if (sFormatString == "CreateLink") {
	  var szURL = prompt("Enter a URL:", "")
		obj.edit_object.document.execCommand("CreateLink",false,szURL)
	} else {
		obj.edit_object.document.execCommand(sFormatString, false, null)
	}
	wp_set_button_states(obj)
}
function wp_change_class(obj,classname) {
	wp_hide_menu(obj)
	var sel = obj.edit_object.getSelection()
 	var range = sel.getRangeAt(0)
	if (sel == '') {
		return;
	}
	var container = range.startContainer
	if (classname == 'wp_none') {	
		var foo = container.parentNode;
		while(!foo.className&&foo.tagName!="BODY"&&foo.tagName!="HTML") {
			foo = foo.parentNode;
		}
		if (foo.getAttribute('class') != 'wp_none' && foo.getAttribute('class') != '') {
			foo.className = classname;
		}
	}
	obj.edit_object.document.execCommand("FontName", false, 'wp_bogus_font')
	var spans = obj.edit_object.document.getElementsByTagName('SPAN')
	var fonts = obj.edit_object.document.getElementsByTagName('FONT')
	wp_set_class(spans, classname, true)
	wp_set_class(fonts, classname, true)
	obj.edit_object.focus()
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
		var szURL=wp_directory + "hyperlink.php?target="+thisTarget+"&title="+thisTitle + "&lang="+obj.instance_lang
		linkwin = obj.openDialog(szURL ,"modal",650,396)
	}
}
// link to a document
function wp_open_document_window(obj,srcElement) {
	var data = wp_generic_link_window_function (obj, srcElement)
	if (data) {
		var szURL=wp_directory + "document.php?instance_doc_dir="+obj.instance_doc_dir+"&lang="+obj.instance_lang
		docwin = obj.openDialog(szURL ,"modal",730,466)
	}
}
function wp_generic_link_window_function (obj, srcElement) {
	var sel = obj.edit_object.getSelection()
 	var range = sel.getRangeAt(0)
	var container = range.startContainer
	if ((range == '') && (container.nodeType != 1) && (!wp_isInside(obj, 'A'))) {
		alert(obj.lng['select_hyperlink_text'])
		return
	}
	var thisTarget = ""
	var thisTitle = ""
	if (wp_isInside(obj, 'A')) {
		var container = range.startContainer
		if (container.nodeType != 1) {
			var textNode = container
				container = textNode.parentNode
		}
		thisA = container
		while(thisA.tagName!="A"&&thisA.tagName!="BODY") {
				thisA = thisA.parentNode
		}
		if (thisA.tagName == "A") {
			var thisLink = thisA.getAttribute("HREF", 2)
			wp_current_hyperlink = thisLink
			if (thisA.getAttribute("target")) {
				thisTarget = thisA.getAttribute("target")
			}
			if (thisA.getAttribute("title")) {
				thisTitle = thisA.getAttribute("title")
			}
		} else {
			wp_current_hyperlink = ''
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
			obj.edit_object.focus()
			return
	} else if(iHref=="mailto:") { 
			wp_callFormatting(obj, "Unlink")
			obj.edit_object.focus()
			return
	} else { 
		var range = obj.edit_object.getSelection().getRangeAt(0)
		var container = range.startContainer
		var pos = range.startOffset
		var imageNode = null
		if (container.tagName) {
		var images = container.getElementsByTagName('IMG');
		var cn = container.childNodes
			if (cn[pos]) {
				if (cn[pos].tagName == 'IMG') {
					cn[pos].setAttribute('border', 0);
				}
			}
		}
		if (wp_isInside(obj, 'A')) {
			var sel = obj.edit_object.getSelection()
			var range = sel.getRangeAt(0)
			var container = range.startContainer
			if (container.nodeType != 1) {
				var textNode = container
				container = textNode.parentNode
			}
			thisA = container
			while(thisA.tagName!="A"&&thisA.tagName!="BODY") {
					thisA = thisA.parentNode
			}
			if (thisA.tagName == "A") {
				thisA.setAttribute('href',iHref)
				thisA.setAttribute('target',iTarget)
				thisA.setAttribute('title',iTitle)
			} 
		} else {
			obj.edit_object.document.execCommand("CreateLink",false,'WP_TEMP_LINK_'+iHref)
			var links = obj.edit_object.document.getElementsByTagName('A')
			var l=links.length
			for (var i=0; i < l; i++) {
				if (links[i].getAttribute('href')) {
					if (links[i].getAttribute('href').search('WP_TEMP_LINK_') != -1) {
						links[i].setAttribute('href',iHref)
						if (iTitle != '') {
							links[i].setAttribute('title',iTitle)
						}
						if (iTarget != '') {
							links[i].setAttribute('target',iTarget)
						}
						var sel = obj.edit_object.getSelection()
						var range = sel.getRangeAt(0)
						sel.removeAllRanges()
					}
				}
			}
		}
	}
	obj.edit_object.focus()
}
// insert image
function wp_open_image_window(obj) {
	var szURL
	var range = obj.edit_object.getSelection().getRangeAt(0)
	var container = range.startContainer
	var pos = range.startOffset
	var imageNode = null
	if (container.tagName) {
		var images = container.getElementsByTagName('IMG');
		var cn = container.childNodes
		if (cn[pos]) {
			if (cn[pos].tagName == 'IMG') {
				imageNode = cn[pos]
			}
		}
	}
	if (imageNode) {
		if ((imageNode.getAttribute('name')) && (imageNode.src.search(wp_directory+"/images/bookmark_symbol.gif") != -1)) {
			szURL= wp_directory + obj.imagewindow + "?lang="+obj.instance_lang
		} else {
			var str = ''
			var image = imageNode.getAttribute('src', 2)
			if (imageNode.style.height) {
				str = imageNode.style.height
				var height = str.replace(/px/, '')
			} else {
				var height = imageNode.getAttribute('height')
			}
			if (imageNode.style.width) {
				str = imageNode.style.width
				var width = str.replace(/px/, '')
			}	else {
				var width = imageNode.getAttribute('width')
			}
			var alt = imageNode.getAttribute('alt')
			var align = imageNode.getAttribute('align')
			var mtop = imageNode.style.marginTop 
			var mbottom = imageNode.style.marginBottom 
			var mleft = imageNode.style.marginLeft 
			var mright = imageNode.style.marginRight 
			var iborder = imageNode.getAttribute('border')
			szURL= wp_directory + 'imageoptions.php' + '?image=' + image +'&width=' + width +'&height=' + height + '&alt=' + alt + '&align=' + align + '&mtop=' + mtop + '&mbottom=' + mbottom + '&mleft=' + mleft + '&mright=' + mright + '&border=' + iborder + "&lang="+obj.instance_lang 
		}
	} else {
		szURL= wp_directory + obj.imagewindow + "?instance_img_dir="+obj.instance_img_dir+"&lang="+obj.instance_lang 
	}
	imgwin = obj.openDialog(szURL ,"modal",730,466)
}
// create the image html
function wp_create_image_html(obj, iurl, iwidth, iheight, ialign, ialt, iborder, imargin) {
	if (iurl == ""){
		return
	}
	obj.edit_object.focus()
	img = obj.edit_object.document.createElement("img")
	img.setAttribute("src", iurl)
	if ((iwidth != '') && (iheight!='') && (iwidth != 0) && (iheight!=0) && (iheight!=null)) {
		img.setAttribute("width", iwidth)
		img.setAttribute("height", iheight)
	}
	if ((ialign != '') && (ialign!=0) && (ialign!=null)) {
		img.setAttribute("align", ialign)
	}
	if ((iborder != '') && (iborder!=null)) {
		img.setAttribute("border", iborder)
	}
	img.setAttribute("alt", ialt)
	img.setAttribute("title", ialt)
	if ((imargin != '') && (imargin!=null)) {
		img.setAttribute("style", 'margin:'+imargin)
	}
	//img.src=img.src
	wp_insertNodeAtSelection(obj.edit_object, img)
	imgwin.close()
	obj.edit_object.focus()
}
// create the horizontal rule html
function wp_create_hr(obj,align, color, size, width,percent2) {
	obj.edit_object.focus()
	hr = obj.edit_object.document.createElement("hr")
	if (align!='') {
		hr.setAttribute("align", align)
	}	
 	if (color != "") {
 		hr.setAttribute("color", color)
		hr.style.backgroundColor = color
		hr.setAttribute("noshade", "noshade")
	} 
	if (size != "") {
 		hr.setAttribute("size", size)
	}
	if (width != "") {
 		hr.setAttribute("width", width+percent2)
	}
	wp_insertNodeAtSelection(obj.edit_object, hr)
	obj.edit_object.focus()
}
function wp_insert_code(obj,code) {
	if ((code != "") && (code != null)) {
		obj.edit_object.focus()
		span = obj.edit_object.document.createElement("SPAN")
		span.innerHTML = code
		wp_insertNodeAtSelection(obj.edit_object, span)
	}
	if (obj.border_visible == 1) {
		wp_show_borders(obj)
	}
	obj.edit_object.focus()
}
function wp_open_bookmark_window(obj,srcElement) {	
	var szURL
	var range = obj.edit_object.getSelection().getRangeAt(0)
	var container = range.startContainer
	var pos = range.startOffset
	var imageNode = null
	var arr= ''
	if (container.tagName) {
		var images = container.getElementsByTagName('IMG')
		var cn = container.childNodes
		if (cn[pos]) {
			if (cn[pos].tagName == 'IMG') {
				imageNode = cn[pos]
				if ((imageNode.getAttribute('name')) && (imageNode.src.search(wp_directory+"/images/bookmark_symbol.gif") != -1)) {
					arr = imageNode.name
				}
			}
		}
	}
	bookwin = obj.openDialog(wp_directory + "bookmark.php?bookmark="+arr+"&lang="+obj.instance_lang, "modal", 300, 106)
}
function wp_create_bookmark (obj,name) {
	if ((name != '') && (name!= null)) {
		img = obj.edit_object.document.createElement("img")
		img.setAttribute('src', wp_directory + '/images/bookmark_symbol.gif')
		img.setAttribute('name', name)
		img.setAttribute('width', 16)
		img.setAttribute('height', 13)
		img.setAttribute('alt', 'Bookmark: ' + name)
		img.setAttribute('title', 'Bookmark: ' + name)
		img.setAttribute('border', 0)
		wp_insertNodeAtSelection(obj.edit_object, img)
	}
}
////////////////////////////
// Table editing features //
////////////////////////////
// finds the current table, row and cell and puts them in global variables that the other table functions and the table editing window can use.
// requires the current selection
function wp_getTable(obj) {
	var sel = obj.edit_object.getSelection()
 	var range = sel.getRangeAt(0)
	var container = range.startContainer
	if (container.nodeType != 1) {
		var textNode = container
    	container = textNode.parentNode
	}
	wp_thisCell = container
	while(wp_thisCell.tagName!="TD"&&wp_thisCell.tagName!="BODY") {
		wp_thisCell = wp_thisCell.parentNode
	}
	wp_thisRow = wp_thisCell
	while(wp_thisRow.tagName!="TR"&&wp_thisRow.tagName!="BODY") {
		wp_thisRow = wp_thisRow.parentNode
	}
	wp_thisTable = wp_thisRow
	while(wp_thisTable.tagName!="TABLE"&&wp_thisTable.tagName!="BODY") {
			wp_thisTable = wp_thisTable.parentNode
	}
}
// edit table window
// creates the table html for the insert table window
function wp_insertTable(obj,rows,cols,width,percent1, height,percent2,  border, bordercolor, bgcolor, cellpadding, cellspacing, bCollapse) {
	//edit_object.focus()
		// generate column widths
	table = obj.edit_object.document.createElement("table")
	if (border!='') {
		table.setAttribute("border", border)
	}	
 	if (bordercolor != "") {
 		table.setAttribute("bordercolor", bordercolor)
	} 
	if (cellpadding != "") {
 		table.setAttribute("cellpadding", cellpadding)
	}
	if (cellspacing != "") {
 		table.setAttribute("cellspacing", cellspacing)
	}
 	if (bgcolor != "") {
 		table.setAttribute("bgcolor", bgcolor)
	}
 	if (width != "") {
 		table.setAttribute("width", width+percent1)
	}
 	if (height != "") {
 		table.setAttribute("height", height+percent2)
	}
 	if (bCollapse == true) {
 		table.style.borderCollapse = "collapse"
	}
	var tdwidth = 100/cols
	tdwidth +="%"
	for (var i = 0; i < rows; i++) {
		row = obj.edit_object.document.createElement("tr")
    for (var j = 0; j < cols; j++) {
			cell = obj.edit_object.document.createElement("td")
			cell.setAttribute("valign", 'top')
			cell.setAttribute("width", tdwidth)
			cell.innerHTML = obj.tdInners
			row.appendChild(cell)
  	}
    table.appendChild(row)
	}
	obj.edit_object.focus()
	wp_insertNodeAtSelection(obj.edit_object, table)
	if (obj.border_visible == 1) {
		wp_show_borders(obj)
	}
	wp_send_to_html(obj)
	wp_send_to_edit_object(obj)
}
/////////////////////////
// CSS style functions //
/////////////////////////
// mouse over button style
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
	} else {
		try {
			 if (obj.edit_object.document.queryCommandState(cmd)) {
				element.className="wpLatchedOver"
				return
			}
		} catch (e) {
			element.className="wpOver"
			return
		}
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
	} else {
		try {
			if (!obj.edit_object.document.queryCommandEnabled(cmd)) {
				element.className="wpDisabled"
				return
			} else if (obj.edit_object.document.queryCommandState(cmd)) {
				element.className="wpLatched"
				return
			}
		} catch (e) {	
			element.className="wpReady"
			return
		}
	}
	element.className="wpReady"
}
// mouse down button style
function wp_m_down(element, obj) {
	wp_closePopup();
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
	var imageSelected = false
	var range = obj.edit_object.getSelection().getRangeAt(0)
	var container = range.startContainer
	var pos = range.startOffset
	var canLink = true
	var inside_link = wp_isInside(obj, 'A')
	if (range == '' && container.nodeType != 1 && !inside_link) {
		canLink = false
	}
	var imageNode = null
	if (container.tagName) {
		var images = container.getElementsByTagName('IMG');
		var cn = container.childNodes
		if (cn[pos]) {
			if (cn[pos].tagName == 'IMG') {
				imageNode = cn[pos]
			}
		}
	}
	if (imageNode) {
		imageSelected = true
	}
	var inside_table = wp_isInside(obj, 'TD')
	if (inside_table) {
		var wp_thisCell = container.parentNode
		while(wp_thisCell.tagName!="TD"&&wp_thisCell.tagName!="HTML") {
			wp_thisCell = wp_thisCell.parentNode
		}
	}	
	// evalute and set the toolbar button states
	for(var i = 0; i < obj.tbarlength; i++) {
		var pbtn = obj.tbarimages[i]
		var type = pbtn.getAttribute("type")
		if (type) {
			var cmd = pbtn.getAttribute("cid")
			if ((cmd=="edittable") || (cmd == 'splitcell')) {
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
			} else if (cmd=="createlink") {
				if (canLink) {
					pbtn.className="wpReady"
				} else {
					pbtn.className="wpDisabled"
				}
			} else if ((cmd=="undo") ||  (cmd=="redo")) {
					pbtn.className="wpReady"
			} else {
				try {
					if (obj.edit_object.document.queryCommandState(cmd)) {
						pbtn.className="wpLatched"
					} else if (!obj.edit_object.document.queryCommandEnabled(cmd)) {
						pbtn.className="wpDisabled"
					} else {	
						pbtn.className="wpReady"
					}
				} catch (e) {	
					pbtn.className="wpReady"
				}
			}
		}
	}
	var font_face_value = obj.edit_object.document.queryCommandValue('FontName')
	var font_size_value = obj.edit_object.document.queryCommandValue('FontSize')
	var format_list_value = obj.edit_object.document.queryCommandValue('FormatBlock')
	format_list_value = translate_format(format_list_value) 
	if (imageSelected) {
		var class_menu_value = ''
	} else {
		var foo = container.parentNode
		if (foo.tagName) {
			while(!foo.className&&foo.tagName!="BODY"&&foo.tagName!="HTML"&&foo.tagName) {
				foo = foo.parentNode
			}
			var class_menu_value = foo.className
		} else {
			var class_menu_value = ''
		}
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
function translate_format(str) {
	if (wp_supported_blocks.test(str) ) {
		str = str.replace(/h([0-9])/gi, "Heading $1")
		str = str.replace(/\bp\b/gi, "Normal")
		str = str.replace(/div/gi, "Normal")
		str = str.replace(/pre/gi, "Formatted")
		str = str.replace(/address/gi, "Address")
	} else if (str == "x") {
		str = "Format"
	}
	return str
}
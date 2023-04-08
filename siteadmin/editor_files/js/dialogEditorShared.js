// Purpose: functions shared between the editor and the dialog windows
// 222
String.prototype.trim=function () {
   return this.replace(/^\s+|\s+$/g,"")
}
String.prototype.dblTrim=function () {
   return this.replace(/^\s{2,}|\s{2,}$/g," ")
}
// end 222
var wp_is_ie = document.all? true: false
function wp_openDialog(url, modal, width, height, features) {
	try {
		var editor = obj
	} catch (e) {
		var editor = this
		wp_current_obj = this
	}
	if (!features) {
		features = ''
	}
	if (wp_is_ie) {
		var nWidth = width + 6
		var nHeight = height + 25
		var params = 'dialogWidth:'+nWidth+'px;dialogHeight:'+ nHeight + 'px;help:no;'
		features = features.replace(/\,/gi, ';')
		features = features.replace(/\=/gi, ':')
		features = features.replace(/scrollbars/gi, 'scroll')
		features = features.replace(/left/gi, 'dialogLeft')
		features = features.replace(/top/gi, 'dialogTop')
		features = features.replace(/width/gi, 'dialogWidth')
		features = features.replace(/height/gi, 'dialogHeight')
		if ((features.search('scroll')) == -1) {
			params += "scroll:no;"
		}
		if (features.search('status') == -1) {
			params += "status:no;"
		} 
		params += features
		if (modal == 'modeless') {
			var win = window.showModelessDialog(url, window, params)
		} else {
			var win = window.showModalDialog(url, window, params)
		}
		if (editor.name) {
			if (document.getElementById(editor.name + "_editFrame")) {
				editor.edit_object.focus()
			}
		}
	} else {
		var name = url.split('?');
		var params = ''
		if (features.search('left') == -1) {
			params = "left="+((screen.width/2)-(width/2))+","
		}
		if (features.search('top') == -1) {
			params += "top="+((screen.height/2)-(height/2))+","
		}
		if (modal == 'modeless') {
			var win = window.open(url, name[0], "dependent=yes,width="+width+"px,height="+height+"px,"+features+","+params)
		} else {
			var win = window.open(url, name[0], "modal=yes,width="+width+"px,height="+height+"px,"+features+","+params)
		}
	}
	return win
}
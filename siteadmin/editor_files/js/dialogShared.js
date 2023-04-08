// Purpose: functions shared between all dialog windows
var wp_current_obj = null
if (window.dialogArguments) {
	obj = dialogArguments.wp_current_obj
	wp_current_obj = obj
	parentWindow = dialogArguments
} else if (parent.window.dialogArguments) {
	obj = parent.window.obj
	wp_current_obj = obj
	parentWindow = parent.window.parentWindow
} else if (window.opener) {
	obj = window.opener.wp_current_obj
	wp_current_obj = obj
	parentWindow = window.opener
} else if (parent.window.opener) {
	obj = parent.window.obj
	wp_current_obj = obj
	parentWindow = parent.window.parentWindow
} else {
	obj = null
	wp_current_obj = null
	parentWindow = null
}
function colordialog(Action) {
	colorwin = wp_openDialog(parentWindow.wp_directory+"selcolor.php?action="+Action+"&lang=" + obj.instance_lang ,'modal' , 296, 352)
}
function onClose() {
	if (parentWindow.wp_directory) {
		obj.edit_object.focus()
	}
}
function hideLoadMessage() {
	document.getElementById('dialogLoadMessage').style.display = 'none'
}
function showLoadMessage() {
	document.getElementById('dialogLoadMessage').style.display = 'block'
}
function formStop() {
	return false
}
//window.onerror = hide_error;
function hide_error() {
	if (!parentWindow.wp_debug_mode) {
		return true;
	}
}
function make_url_with_base (url) {
	if (obj) {
		if (obj.baseURLurl) {
			if (obj.baseURLurl != '') {
				var str = url.toLowerCase()
				var base = obj.baseURLurl;
				if ( str.substr(0,7) != 'http://' && str.substr(0,8) != 'https://' ) {
					if (str.substr(0,1) == '/') {
						if (base.substr(0,1) != '/') {
							if (base.substr(base.length-1,1) != '/') {
								var check1 = base + '/';
								var check = check1.replace(/((http|https):\/\/[^\/]+)\//gi, '/');
								if (check == '/') {
									base = base + '/';
								} else {
									base = base+'/../';
								}
							}							
							var domain2 = base.replace(/((http|https):\/\/[^\/]+)\//gi, '/');						
							domain = base.substr(0, base.length-domain2.length)
							url = domain + url;
						}
					} else {
						if (base.substr(base.length-1,1) != '/') {
							var check1 = base + '/';
							var check = check1.replace(/((http|https):\/\/[^\/]+)\//gi, '/');
							if (check == '/') {
								base = base + '/';
							} else {
								base = base+'/../';
							}
						}
						url = base + url;
					}
				}
			}
		}
	}
	return url;
}
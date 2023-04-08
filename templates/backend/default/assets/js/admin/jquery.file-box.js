function getFile(d){
   document.getElementById(d).click();
}
 
function sub(obj,dn,dn_none){
	var fileTr = '';
	for (var i = 0; i < obj.files.length; ++i) {
		var file = obj.files.item(i).name;
		var fileName = file.split("\\");
		fileTr = fileTr + fileName[fileName.length-1] + ' '; 
	}		
	if (obj.files.length > 1)
		fileTr = '(' + obj.files.length + ') ' + fileTr;

	if (fileTr != '')
		{document.getElementById(dn).innerHTML = fileTr;}
	else
		{document.getElementById(dn).innerHTML = document.getElementById(dn_none).value;}
}
$(document).ready(function(){
	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'id';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
		document.getElementById('display_items').innerText = '20';
		document.getElementById('display').value = '20';		
	});
});
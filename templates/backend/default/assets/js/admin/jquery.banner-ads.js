$(document).ready(function(){
	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'a.adv_id';
		document.getElementById('order_items').innerText = 'Descending';
		document.getElementById('order').value = 'DESC';
	});
});
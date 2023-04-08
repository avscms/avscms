$(document).ready(function(){
	$( "#reset_search" ).click(function() {
		document.getElementById('sort_items').innerText = 'ID';
		document.getElementById('sort').value = 'advgrp_id';
		document.getElementById('order_items').innerText = 'Ascending';
		document.getElementById('order').value = 'ASC';
	});
});
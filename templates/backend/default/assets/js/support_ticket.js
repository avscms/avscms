
/* Webarch Admin Dashboard 
/* This JS is only for DEMO Purposes - Extract the code that you need
-----------------------------------------------------------------*/ 
$(document).ready(function(){	
/** Text Editor **/
//$('#message').wysihtml5();	

/** Events **/
$('#btn-new-ticket').click( function() {
	$('#new-ticket-wrapper').slideToggle("fast","linear")
})

$('#btn-close-ticket').click( function() {
	$('#new-ticket-wrapper').slideToggle("fast","linear")
});

$('#new-ticket-form').validate({
                focusInvalid: false, 
                ignore: "",
                rules: {
                    txtSubject: {
                        minlength: 2,
                        required: true
                    },
                    txtDept: {
						minlength: 2,
                        required: true,
                    },
                    txtMessage: {
                        required: true
                    }
                },

                invalidHandler: function (event, validator) {
					//display error alert on form submit    
                },

                errorPlacement: function (label, element) { // render error placement for each input type   
					$('<span class="error"></span>').insertAfter(element).append(label)
                    var parent = $(element).parent();
                    parent.removeClass('success-control').addClass('error-control');  
                },

                highlight: function (element) { // hightlight error inputs
                    var parent = $(element).parent();
                    parent.removeClass('success-control').addClass('error-control'); 
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
					var parent = $(element).parent();
					parent.removeClass('error-control').addClass('success-control'); 
                },

			    submitHandler: function(form) {
					$('#new-ticket-wrapper').slideToggle("fast","linear");
				}
            });	

	$('.grid .actions a.remove').on('click', function () {
            var removable = jQuery(this).parents(".grid");
            if (removable.next().hasClass('grid') || removable.prev().hasClass('grid')) {
                jQuery(this).parents(".grid").remove();
            } else {
                jQuery(this).parents(".grid").parent().remove();
            }
    });

     $('.grid .clickable').on('click', function () {
          var el = jQuery(this).parents(".grid").children(".grid-body");
		  el.slideToggle(200);
    });		
});
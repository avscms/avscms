$(document).ready(function(){
    $("#captcha_reload").click(function(event){
        event.preventDefault();
        $("#captcha_image").attr('src', base_url + "/captcha" + '/' + Math.random());
    });
    $("#check_username").click(function(event){ 
        event.preventDefault(); 
        $.post(base_url + "/ajax/check_username", { username: $('#signup_username').val() }, 
            function (response) { $("#username_check_response").html(response + '<br>'); $("#username_check_response").fadeIn(); 
        }); 
    });	
});

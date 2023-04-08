var post_timers         = new Array();
var pic                 = 2;
var pht                 = 2;
function destroy( selector )
{
    $(selector).fadeOut();
}

function admin_response(selector, content)
{
    $(selector).html(content);
    $(selector).fadeIn();
    if ( typeof post_timers[0] == "number" ) {
        clearTimeout(post_timers[0]);
    }
    post_timers[0] = setTimeout("destroy('" + selector + "')", 3000);
}

function static_read(page)
{
    $.post(base_url + '/ajax/static_read', { page: page },
    function(response) {
        $("input[id='static_page']").val(page);
        $("h3[id='static_edit']").text('Editing: ' + page + '.tpl');
        $("textarea[id='page_content']").val(response);        
    });
}

function static_write()
{
    var page    = $("input[id='static_page']").val();
    var content = $("textarea[id='page_content']").val();
    $.post(base_url + '/ajax/static_write', { page: page, html: content },
    function(response) {
        if ( response == '1' ) {
            admin_response('#messagebox', 'Successfully saved static page!');
        } else {
            admin_response('#errorbox', 'Failed to save static page!');
        }
    });
    
}

$(document).ready(function() {
    $("img[id*='change_tmb_']").click(function(event) {
        event.preventDefault();
        var click_id    = $(this).attr('id');
        var id_split    = click_id.split('_');
        var vkey        = id_split[2];
        var thumb       = id_split[3];
        for( var i=1; i<=20; i++ ) {
            if ( i == thumb ) {
                $(this).css('border-color', '#ff4800');
            } else {
                $("img[id='change_tmb_" + vkey + "_" + i + "']").css('border-color', '#ccc');
            }
        }
        $("input[id='" + vkey + "']").val(thumb);
    });
    
    $("input[id='edit_video_advanced'],input[id='edit_user_advanced'],input[id='edit_game_advanced']").click(function() {
        var val = $(this).val();
        if ( val == '-- Show Advanced --' ) {
            $('#advanced').fadeIn();
            $(this).val('-- Hide Advanced --');
        } else {
            $('#advanced').fadeOut();
            $(this).val('-- Show Advanced --');
        }
    });
    
    $("input[id='edit_user_password']").click(function() {
        var val = $(this).val();
        if ( val == '-- Change Password --' ) {
            $("#password").fadeIn();
            $(this).val('-- Hide Password --');
        } else {
            $("#password").fadeOut();
            $(this).val('-- Change Password --');
        }
    });
    
    $("a[id*='static_page_']").click(function(event) {
        event.preventDefault();
        var click_id    = $(this).attr('id');
        var id_split    = click_id.split('_');
        var page        = id_split[2];
        static_read(page);
    });
    
    $("a[id='add_new_image']").click(function(event) {
        event.preventDefault();
        var pCODE   = '<div id="image_container_' + pic + '">';
        var pCODE   = pCODE + '<label for="image_' + pic + '" style="width: 20%;">File: </label>';
        var pCODE   = pCODE + '<input name="image_' + pic + '" type="file" id="image_' + pic + '"> &nbsp; ';
        var pCODE   = pCODE + '<a href="#remove_image_' + pic + '" id="remove_image_' + pic + '">remove</a>';
        var pCODE   = pCODE + '<div id="error_image_' + pic + '" class="error" style="display: none"></div>';
        var pCODE   = pCODE + '</div>';
        var pDIV  = document.createElement("div");
        $(pDIV).html(pCODE);
        $('#add_image_container').before(pDIV);
        pic++;
    });
    
    $("a[id*='remove_image_']").livequery('click', function(event) {
        event.preventDefault();
        var click_id        = $(this).attr('id');
        var id_split        = click_id.split('_');
        var remove_id       = 'image_container_' + id_split[2];
        var remove_image    = $('#' + remove_id);
        $(remove_image).html('');
        $(remove_image).fadeOut();
    });
    
    $("input[id='submit_add']").click(function() {
        var error       = false;
        var image_first = $("input[id='image_1']").val();
        
        if ( image_first == '' ) {
            error       = true;
            alert('error_image_1');    
            $('#error_image_1').html('Please select a image!');
            $('#error_image_1').fadeIn();
        } else {
            $('#error_image_1').fadeOut();
        }
        
        if ( !error ) {
            jQuery.each($("input[id*='image_']"), function() {
                var image_id    = $(this).attr('id');                
                var filename    = $(this).val();
                var extension   = filename.slice(filename.indexOf(".")).toLowerCase();
                var error_msg   = '#error_image_' + image_id;
                if ( extension != '.jpg' && extension != '.jpeg' && extension != '.png' && extension != '.gif' && extension != '.bmp' ) {
                    error       = true;
                    $(error_msg).html('Invalid image extension. Allowed extensions: jpg, jpeg, gif, png and bmp!');
                    $(error_msg).fadeIn();
                } else {
                    var visible = $(error_msg).is(':visible');
                    if ( visible ) {
                        $(error_msg).hide();
                    }
                }
    
            });
        }
        
        if ( error ) {
            return false;
        }
    });
    
    $("input[id*='_check_all']").click(function() {
        var input_id = $(this).attr('id');
        var id_split = input_id.split('_');
        var type     = id_split[0];
        var checkboxes = $("input[id*='" + type + "_checkbox_']");
        if ( $(this).attr('checked') == false ) {
            jQuery.each($(checkboxes), function() {
                $(this).attr('checked', false);
            });
        } else {
            jQuery.each($(checkboxes), function() {
                $(this).attr('checked', true);
            });
        }
    });
    
    $("a[id='add_more_photos']").click(function(event) {
        event.preventDefault();
        var pCODE   = '<div id="image_container_' + pht + '">';
        var pCODE   = pCODE + '<label for="photo_' + pht + '">File: </label>';
        var pCODE   = pCODE + '<input name="photo_' + pht + '" type="file" id="photo_' + pht + '" />&nbsp;<a href="#remove_photo" id="remove_photo_' + pht + '">Remove Photo</a><br />';
        var pCODE   = pCODE + '<label for="caption_' + pht + '">Caption: </label>';
        var pCODE   = pCODE + '<input name="caption_' + pht + '" type="text" value="" maxlength="100" id="caption_1" class="large" /><br />';
        var pCODE   = pCODE + '</div>';
        var pDIV  = document.createElement("div");
        $(pDIV).html(pCODE);
        $('#upload_photo_container').before(pDIV);
        pht++;
    });
    
    $("a[id*='remove_photo_']").livequery('click', function(event) {
        event.preventDefault();
        var click_id        = $(this).attr('id');
        var id_split        = click_id.split('_');
        var remove_id       = '#image_container_' + id_split[2];
        var remove_selector = $(remove_id);
        $(remove_id).html('');
        $(remove_id).fadeOut();
    });
});

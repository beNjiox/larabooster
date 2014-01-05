
$(document).ready(function($) {

    /* --- add --- */
    
    $(".add_color").on('click', function(){
        var context = $(this).attr('data-context');
        var color   = $('.add_color_input_'+context).val();        

        $.ajax({
            url: '/api/' + context,
            type: 'POST',
            data: {
                code: color
            },
        })
        .done(function() {
            $new_color_el = $($("#color_item_tmpl").html().replace(/_CODE_/g, color));
            if ($(".alert_" + context).length != 0 )
                $(".alert_" + context).fadeOut();
            $(".list_"+context).prepend($new_color_el)
            $new_color_el.fadeOut().fadeIn();
            $('.add_color_input_'+context).val("");
        })
        .fail(function(resp) {
            alert("An error happened: [_ERROR_]".replace('_ERROR_', resp.responseJSON.msg));
        })
    });

    /* --- delete --- */

    $("body").on('click', '.delete_color', function(){

        var color   = $(this).data('color');
        var context = $(this).data('context');
        console.log ("attempting to remove " + color + " from " + context);
        $el_to_hidden = $(this).parent();

        if (confirm("You are attempting to delete the color _COLOR_. Confirm?".replace('_COLOR_', color)))
        {
            $.ajax({
                url: '/api/' + context,
                type: 'DELETE',
                data: {
                    code: color
                }
            })
            .done(function(){
                $el_to_hidden.fadeOut();
            });
        }

    });

});
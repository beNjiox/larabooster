
$(document).ready(function($) {

    /* --- add --- */
    
    $(".add_color").on('click', function(){
        var context = $(this).attr('data-context');
        var color   = $('.add_color_input_'+context).val();        

        if (color.length == 0)
        {
            alert("Please fill the input!")
            return ;
        }

        $.ajax({
            url: '/api/' + context,
            type: 'POST',
            data: {
                code: color
            },
        })
        .done(function() {
            $new_color_el = $($("#color_item_tmpl").html().replace(/_CODE_/g, color));
            console.log ("["+context+"][POST ADD - Before insert] : How many items? " + $(".list_"+context+" div.color_code").length);
            if ($(".list_"+context+" div.color_code").length == 0)
            {
                $(".alert_" + context).hide();
                
            }
            $(".list_"+context).prepend($new_color_el).show();            
            $('.add_color_input_'+context).val("");
            console.log ("["+context+"][POST ADD - After insert] : How many items? " + $(".list_"+context+" div.color_code").length);
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
            console.log(".list_"+context+" div.color_code");
            console.log ("["+context+"][POST DELETE - Before remove] : How many items? " + $(".list_"+context+" div.color_code").length);
            $.ajax({
                url: '/api/' + context,
                type: 'DELETE',
                data: {
                    code: color
                }
            })
            .done(function(){
                $el_to_hidden.hide().remove();
                console.log(".list_"+context+" div.color_code");
                console.log($(".list_"+context+" div.color_code").length);

                if ($(".list_"+context+" div.color_code").length == 0)
                {
                    console.log ("Display alert_"+context);
                    $(".alert_" + context).fadeToggle();
                }
                console.log ("["+context+"][POST DELETE - After remove] : How many items? " + $(".list_"+context+" div.color_code").length);
            });
        }

    });

});
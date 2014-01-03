$(document).ready(function($) {
    
    $(".add_color").bind('click', function(){
        var context = $(this).attr('data-context');
        var color   = $('.add_color_input_'+context).val();        

        console.log ("context = " + context + " -> value = " + color);

        $.ajax({
            url: '/api/' + context + '/add',
            type: 'POST',
            data: {
                code: color,
                name: 'none'
            },
        })
        .done(function() {
            $el = $('<span> ' + color + '</span><div style="float:right;width:30px;height:30px;background:'+color+'"></div>');
            $(".list_"+context).prepend($el);
            $('.add_color_input_'+context).val("");
        })
        .fail(function() {
            alert("An error happened!");
        })
    });

});
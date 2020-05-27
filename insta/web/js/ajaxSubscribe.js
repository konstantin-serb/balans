$(document).ready(function() {
    $('a.btnSubscribe').click(function(){
        var button = $(this);
        var params = {
            'id' : $(this).attr('data-id')
        };

        $.post('/user/profile/ajax-subscribe', params, function() {
            button.addClass('button-none');
        });
        return false;
    });
});
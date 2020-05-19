$(document).ready(function () {
    $('a.button-like').click(function() {
        var button = $(this);
        var params = {
            'id' : $(this).attr('data-id')
        };
        $.post('/articles/news/like', params, function(data){
            if (data.success){
                button.hide();
                button.siblings('.button-unlike').show();
                button.siblings('.likes-count').html(data.likesCount);
            }
        });
    });
});
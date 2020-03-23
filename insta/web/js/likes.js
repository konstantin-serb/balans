$(document).ready(function () {
    $('a.button-like').click(function(){
        var button = $(this);
        // var count1 = document.getElementsByClassName('likes-count');
        var params = {
            'id':$(this).attr('data-id')
        };
        $.post('/post/default/like', params, function (data) {
            if(data.success){
                button.hide();
                button.siblings('.button-unlike').show();
                button.siblings('.likes-count').html(data.likesCount);
                // count1.innerHTML = (data.likesCount);

            }
        });
        return false;
    });

    $('a.button-unlike').click(function(){
        var button = $(this);
        // var count1 = document.getElementsByClassName('likes-count');
        var params = {
            'id':$(this).attr('data-id')
        };
        $.post('/post/default/unlike', params, function (data) {
            if(data.success){
                // count1.innerHTML = (data.likesCount);
                button.hide();
                button.siblings('.button-like').show();
                button.siblings('.likes-count').html(data.likesCount);
            }
        });
        return false;
    });
});
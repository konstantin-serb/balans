$(document).ready(function() {
    creatComment();
});

function creatComment()
{
    $(document).on('click', '#addCommentsButton', function() {
        var modalWindow = document.querySelector('.modalWindow');
        var params = {
            comment: $('#maincommentform-comment').val(),
            articlesId: $(this).attr('article-id'),
            userId: $(this).attr('user-id')
        };

        $.ajax({
            url: '/articles/news/add-comment',
            method: 'post',
            data: {params},

            success: function (data) {
                if(data.success == true){
                    $('form').trigger('reset');
                    modalWindow.style.display = 'none';
                    commentView(params);
                }
            }
        });
    });
}

function commentView(params)
{
    var params = params;
    $.ajax({
        url: '/articles/news/get-comments',
        method: 'post',
        data: {params},
        success: function(data){
            if (data.success == true) {

                $('#comments').html(data.html);
            }
        }
    });

}
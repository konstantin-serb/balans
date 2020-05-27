$(document).ready(function() {
    deleteComment();
});

function deleteComment() {
    $(document).on('click', '#submitButton', function () {
        var params = {
            id : $(this).attr('data-id'),
            userId : $(this).attr('data-userId'),
            postId: $(this).attr('post-id'),
            commentAuthorId : $(this).attr('data-commentAuthor')
        };

        $.ajax({
            url: '/post/default/delete-comment',
            method: 'post',
            data: {params},
            success: function(data){
                if (data.success == true) {
                    commentView(params)
                }
            }
        });
    });
}

function commentView(params) {
    var params = params;
    $.ajax({
        url: '/post/default/comment',
        method: 'post',
        data: {params},
        success: function (data) {
            if (data.success == true) {
                $('#comments').html(data.html);
            }
        }
    });
}






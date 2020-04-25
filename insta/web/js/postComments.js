$(document).ready(function () {
    creatComment();

});

function creatComment() {
    $(document).on('click', '#addCommentsButton', function () {
        var modalWindow = document.querySelector('.modalWindow');
        var params = {
            comment: $('#commentaddform-comment').val(),
            postId: $(this).attr('data-id'),
            userId: $(this).attr('user-id')
        };


        $.ajax({
            url: '/post/default/add-comment',
            method: 'post',
            data: {params},

            success: function (data) {
                if (data.success == true) {
                    $('form').trigger('reset');
                    modalWindow.style.display = 'none';
                    commentView(params);
                }
            }

        });
    })
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
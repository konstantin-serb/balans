$(document).ready(function () {
    deleteMessage();
});

function deleteMessage() {
    $(document).on('click', '#btn-del', function () {
        var params = {
            id : $(this).attr('data-DelId')
        };

        $.ajax(
            {
                url:'/user/profile/delete-message',
                method: 'post',
                data: {params},
                success:function (data)
                {
                    if(data.success == true) {
                         view();
                    }
                }
            });
    });
}

function view() {
    $.ajax(
        {
            url:'/user/profile/message-view',
            method:'post',
            success:function (data)
            {
                $('#messagesReport').html(data.html);
            }
        }
    );
}























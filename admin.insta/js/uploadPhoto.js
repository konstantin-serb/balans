$(document).ready(function () {
    deletePhoto();

});

function deletePhoto() {
    $(document).on('click', '.btnDelete', function() {
        var photoId = $(this).attr('data-id');
        var postId = $(this).attr('post-id');
        $.ajax(
            {
                url:'/articles/delete-photo',
                method:'post',
                data: {photoId:photoId, postId:postId},
                success:function (data) {
                    if (data.success == true) {
                        $("#images").html(data.html);
                    }
                }
            }
        );
    })
}
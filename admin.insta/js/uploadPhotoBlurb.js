$(document).ready(function () {
    deletePhoto();
    deleteVertPhoto();

});

function deletePhoto() {
    $(document).on('click', '.btnDelete', function() {
        var photoId = $(this).attr('data-id');
        var postId = $(this).attr('post-id');
        $.ajax(
            {
                url:'/blurb/blurb/delete-photo',
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


function deleteVertPhoto() {
    $(document).on('click', '.btnDeleteVert', function() {
        var photoId = $(this).attr('data-id');
        var postId = $(this).attr('post-id');
        $.ajax(
            {
                url:'/blurb/blurb/delete-vertphoto',
                method:'post',
                data: {photoId:photoId, postId:postId},
                success:function (data) {
                    if (data.success == true) {
                        $("#images-vert").html(data.html);
                    }
                }
            }
        );
    })
}
// /footer/info/delete-photo
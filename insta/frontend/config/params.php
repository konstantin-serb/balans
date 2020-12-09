<?php
return [
    'adminEmail' => 'admin@example.com',
    'maxFileSize' => 1024 * 1024 *6,

    'storageUri' => '/uploads/',
    'postPicture' => [
        'maxWidth' => 1024,
        'maxHeight' => 768,
    ],

    // Параметры для добавления картинки в посты, пользователями сети
    'paramsUploadPictureFromUserPosts' => [
        'width' => 900,
        'height' => 900,
        'method' => 'auto',
        'quality' => 85,
    ],

    // Параметры для добавления фотографии пользователя
    'paramsUploadUserPhoto' => [
        'width' => 500,
        'height' => 500,
        'method' => 'crop',
        'quality' => 90,
    ],

    'feedPostLimit' => 200,

    // Параметры возврата картинок блога в frontend
    // При каждой синхронизации сервера менять
    'adminWeb' => 'http://admin.insta.com/',
//    'adminWeb' => 'http://admin.insta.i-des.net/',

    'blurb' => 'http://admin.insta.com/uploads/',
//    'blurb' => 'http://admin.insta.i-des.net/uploads/',

];




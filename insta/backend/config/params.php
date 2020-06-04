<?php
return [
    'adminEmail' => 'admin@example.com',
    'storageUri' => 'http://insta.com/uploads/',
//    'storageUri' => 'http://insta.i-des.net/uploads/',
    'storageAdmin' => 'http://admin.insta.com/uploads/',
//    'storageAdmin' => 'http://admin.insta.i-des.net/uploads/',
    'maxFileSize' => 1024 * 1024 *10,

    // Параметры для добавления картинки в статьи блога
    'pictureParamsForArticles' => [
        'width' => 600,
        'height' => 450,
        'method' => 'crop',
        'quality' => 90,
    ],

    'ordinareParamsForArticles' => [
        'width' => 1000,
        'height' => 900,
        'method' => 'auto',
        'quality' => 90,
    ],

    //Горизонтальная реклама
    'blurbHorizontal' => [
        'width' => 1200,
        'height' => 300,
        'method' => 'crop',
        'quality' => 90,
    ],

    //Вертикальная реклама
    'blurbVertical' => [
        'width' => 330,
        'height' => 840,
        'method' => 'crop',
        'quality' => 90,
    ],
];

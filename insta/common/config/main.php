<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'storage' => [
            'class' => 'frontend\components\Storage',
        ],
        'storagePostPicture' => [
            'class' => 'frontend\components\StoragePostPicture',
        ],
    ],
];

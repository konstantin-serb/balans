<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');


function debug($string)
{
    echo '<pre>';
    var_dump($string);
    echo '</pre>';
}

function printer($string)
{
    echo '<pre>';
    print_r($string);
    echo '</pre>';
}


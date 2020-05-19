<?php

use yii\bootstrap\Modal;

$this->color = $color;

$this->registerJsFile('@web/js/modalTest.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);
?>

<section>
    <h1>Modal</h1>
<!--    --><?php
//    Modal::begin([
//        'header' => '<h2>Title</h2>',
//        'toggleButton' => [
//            'label' => 'Modal window',
//        ],
//        'footer' => 'Bottom window',
//    ]);
//    echo 'content';
//
//    Modal::end();
//    ?>
</section>

<section>
    <button id="myBtn10" class="tesButton" data-id="10">Открыть окно</button>


    <div id="myModal10" class="modal">


        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Шапка модального окна</h2>
            </div>
            <div class="modal-body">
                <p>Какой-то текст в теле модального окна</p>
                <p>Ещё другой текст...</p>
            </div>
            <div class="modal-footer">
                <h3>Футер модального окна</h3>
            </div>
        </div>

    </div>
</section>


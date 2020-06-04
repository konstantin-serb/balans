<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blurbs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blurb-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Blurb', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
            'customer',
//            'text:ntext',
            'url:ntext',
            'description',
            //'status',
            'insert',
            'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

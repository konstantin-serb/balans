<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Articles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Footer articles', ['/footer/info/index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
//            'text:ntext',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => function($article) {
                    if (strlen($article->description) > 100) {
                        $points = '...';
                    } else {
                        $points = '';
                    }
                    return Yii::$app->stringHelper->getShort($article->description, 100) . $points;
                },
            ],
            //            'image',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($article) {
                    return Html::img($article->getImage(), ['width' => '100%']);
                },
            ],
            'date:datetime',
            //'likes:ntext',
            //'likes_count',
            //'status',
            [
                    'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($article) {
                    if ($article->status == 0) {
                        return Html::tag('span', 'Не видно на сайте', ['style' => 'color:red;']);
                    }
                    return Html::tag('span', 'Видно на сайте', ['style' => 'color:blue;']);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

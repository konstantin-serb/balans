<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($post) {
                    return Html::a($post->id, ['view', 'id' => $post->id]);
                },
            ],
            'user_id',
//            'filename',
            [
                'attribute' => 'filename',
                'format' => 'raw',
                'value' => function ($post) {
                    return Html::img($post->getImage(), ['width' => '130px']);
                },
            ],
            'description:ntext',
            'created_at:datetime',
            //'updated_at',
            'status',
            'complaints:ntext',
            'complaints_count',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} &nbsp; {approve} &nbsp; {delete}',
                'buttons' => [
                        'approve' => function ($url, $post) {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['approve', 'id' => $post->id]);
                        },
                ],
            ],
        ],
    ]); ?>


</div>

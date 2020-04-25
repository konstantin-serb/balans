<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="articles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'text:ntext',
//            'image',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($article) {
                    return Html::img($article->getImage());
                },
            ],
            'date:datetime',
//            'likes:ntext',
//            'likes_count',
            //'status',
            [
                    'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                if($model->status == 0) {
                    return 'Не видно на сайте';
                } else if($model->status == 1) {
                    return 'Видно на сайте';
                }

                }
            ],
        ],
    ]) ?>

</div>

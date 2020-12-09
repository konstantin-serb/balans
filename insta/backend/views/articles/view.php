<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Articles */
/* @var $articlesPicture \backend\models\PostsImage */
/* @var $picture \backend\models\PostsImage */


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="articles-view">

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
            'date:datetime',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == 0) {
                        return 'Не видно на сайте';
                    } else if ($model->status == 1) {
                        return 'Видно на сайте';
                    }

                }
            ],
        ],
    ]) ?>
    <!--    <div class="titlePhoto">-->
    <!--        <img src="--><? //=$model->getImage()?><!--" class="photo">-->
    <!--    </div>-->
    <div class="articleView">
        <h1><?= $model->title ?></h1>

        <p>
            <?= $model->text ?>
        </p>
        <br><br>
        <hr>
        <h3>Описание к статье</h3>
        <p>
            <?= $model->description ?>
        </p>
    </div>

</div>

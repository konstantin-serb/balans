<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'picture',
            [
                'attribute' => 'picture',
                'format' => 'raw',
                'value' => function ($user) {
                    return Html::img($user->getImage(), ['width' => '150px']);
                }
            ],
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            'status',
            'created_at:date',
            'updated_at:datetime',
            //'verification_token',
//            'about:ntext',
            [
                'attribute' => 'roles',
                'value' => function ($user) {
        return implode(',', $user->getRoles());
                }
            ],
            [
                'attribute' => 'about',
                'format' => 'raw',
                'value' => function ($user) {
                    return Yii::$app->stringHelper->getShort($user->about, 50);
                }
            ],
            'type',
            'nickname',

            //'likes:ntext',
//            [
//                'attribute' => 'likes',
//                'format' => 'raw',
//                'value' => function ($user) {
//                    printer(unserialize($user->likes));
//                }
//            ],
            'rating',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

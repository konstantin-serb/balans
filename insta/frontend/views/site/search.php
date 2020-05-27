<?php

$this->color = $color;
$this->title = 'Search';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<section class="searchUser">
    <div class="wrap">
        <div class="searchForm" style="text-align: center;">
            <h1>Search</h1>
            <br>
            <?php $form = ActiveForm::begin()?>
            <?= $form->field($model, 'keyWord')->textInput()->label('Введите имя или фамилию для поиска')?>
            <br><br>

            <?=Html::submitButton('Искать', ['class' => 'btn btn-default'])?>
            <br><br>
            <?php ActiveForm::end()?>
        </div>
        <?php if($result != false):?>
            <?php foreach($result as $user):?>
            <div class="itemSearch">
                <a href="<?=\yii\helpers\Url::to(['/user/profile/view', 'nickname' => $user['id']])?>"
                style="color: #666;">
                    <div class="searchFlex">
                        <div class="minAvatar" style="padding:0;">
                            <img class="mimiatiura"
                                 src="<?=\frontend\models\User::getUserPhoto2($user['id'])?>">

                        </div>
                        <div class="name"><?=$user['username']?></div>
                    </div>


                </a>
            </div>
            <?php endforeach;?>
        <?php else:?>
        <p><br>Поиск не дал результатов:</p>
        <?php endif;?>
    </div>
</section>

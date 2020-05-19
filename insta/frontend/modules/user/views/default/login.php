<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

/* @var $color \frontend\modules\user\controllers\DefaultController */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

$this->color = $color;
?>

<section class="login">
    <h2>LOGIN</h2>
    <h4>Войдите в свой аккаунт и жизнь заиграет красками</h4>
    <div class="wrap">


        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
<!--        --><?//= $form->field($model, 'rememberMe')->checkbox() ?>
        <br>
        <?= Html::submitButton('LOGIN', ['class' => 'submit', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>

    </div>
</section>

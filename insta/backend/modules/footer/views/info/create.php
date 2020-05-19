<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\modules\footer\models\forms\FooterAddForm */

$this->title = 'Создание новой статьи для футера';
$this->params['breadcrumbs'][] = ['label' => 'Info Footers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-footer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin()?>

    <?=$form->field($model, 'articleName')->textInput()?>

    <?=$form->field($model, 'text')->textarea(['rows' => 30])?>

    <?=$form->field($model, 'description')->textarea(['rows' => 8])?>

    <div>
        <?=Html::submitButton('Create',['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end()?>

</div>

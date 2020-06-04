<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\blurb\models\Blurb */

$this->title = 'Create Blurb';
$this->params['breadcrumbs'][] = ['label' => 'Blurbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blurb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="blurb-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'customer')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'url')->textInput() ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'insert')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'sort')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>

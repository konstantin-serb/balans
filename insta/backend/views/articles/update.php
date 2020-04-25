<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Articles */
/* @var $modelUpdate \backend\models\forms\ArticlesUpdateForm */

$this->title = 'Update Articles: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="articles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $modelUpdate->title = $model->title;
    $modelUpdate->text = $model->text;
    $modelUpdate->status = $model->status;
    ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelUpdate, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelUpdate, 'text')->textarea(['rows' => 12]) ?>


    <img src="<?=$model->getImage($model->image)?>" width="500">
    <?= $form->field($modelUpdate, 'picture')->fileInput() ?>

    <?= $form->field($modelUpdate, 'status')->dropDownList([
            0 => 'Не видно на сайте',
            1 => 'Видно на сайте',
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

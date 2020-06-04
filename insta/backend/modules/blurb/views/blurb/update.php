<?php

use dosamigos\fileupload\FileUpload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\blurb\models\Blurb */
/* @var $modelPicture \frontend\models\forms\PictureForm */
/* @var $modelPictureVert \backend\modules\blurb\models\forms\VerticalPictureForm */
/* @var $articlesPicture \backend\models\PostsImage */
/* @var $articlesPictureVert \backend\models\PostsImage */

$this->title = 'Update Blurb: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blurbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$this->registerJsFile('@web/js/uploadPhotoBlurb.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

?>



<div class="row">
    <div class="col-md-12">
        <h3>Добавить горизонтальный банер</h3>
        <?= FileUpload::widget([
            'model' => $modelPicture,
            'attribute' => 'picture',
            'url' => ['uploadimages-horizontal', 'name' => $model->insert], // your url, this is just for demo purposes,
            'options' => ['accept' => 'image/*'],
            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {                             
              if(data.result.success) {
                  $("#images").html(data.result.html);
              }
        }',

            ],
        ]); ?>
    </div>
    <div class="col-md-12">
        <h3>Добавить вертикальный банер</h3>
        <?= FileUpload::widget([
            'model' => $modelPictureVert,
            'attribute' => 'picture',
            'url' => ['uploadimages-vertical', 'name' => $model->insert], // your url, this is just for demo purposes,
            'options' => ['accept' => 'image/*'],
            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {                             
              if(data.result.success) {
                  $("#images-vert").html(data.result.html);
              }
        }',

            ],
        ]); ?>
    </div>
</div>

<br>
<div id="images">
    <br>
    <div class="row">
        <?php foreach ($articlesPicture as $picture):?>
            <div class="col-md-12 pictureAdd">
                <img class="addedPictures" src="<?=$picture->getImage()?>">

                <?=$picture->path?>

                <br>
                <a class="btn btn-danger btnDelete" post-id="<?=$picture->id?>" data-id="<?=$picture->id?>">Удалить</a>
            </div>
            <hr>
        <?php endforeach;?>
    </div>
</div>


<div id="images-vert">
    <br>
    <div class="row">
        <?php foreach ($articlesPictureVert as $picture):?>
            <div class="col-md-12 pictureAdd">
                <img class="addedPicturesVert" src="<?=$picture->getImage()?>">

                <?=$picture->path?>

                <br>
                <a class="btn btn-danger btnDeleteVert" post-id="<?=$picture->id?>" data-id="<?=$picture->id?>">Удалить</a>
            </div>
            <hr>
        <?php endforeach;?>
    </div>
</div>
<div class="blurb-form" style="margin-top:20px;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'url')->textInput() ?>

    <?= $form->field($model, 'photo')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insert')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use dosamigos\fileupload\FileUpload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Articles */
/* @var $modelUpdate \backend\models\forms\ArticlesUpdateForm */
/* @var $modelPicture \frontend\models\forms\PictureForm */
/* @var $articlesPicture \backend\models\PostsImage */
/* @var $picture \backend\models\PostsImage */

$this->title = 'Update Articles: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$this->registerJsFile('@web/js/uploadPhoto.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

?>
<div class="articles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $modelUpdate->title = $model->title;
    $modelUpdate->text = $model->text;
    $modelUpdate->description = $model->description;
    $modelUpdate->status = $model->status;
    ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelUpdate, 'title')->textInput(['maxlength' => true])->label('Заголовок статьи') ?>

    <div class="row">
        <div class="col-md-4">
            <h3>Текущее изображение заголовка статьи</h3>
            <img src="<?=$model->getImage($model->image)?>" >
            <?= $form->field($modelUpdate, 'picture')->fileInput()->label('Заменить изображение') ?>
            &lt;div class="central"&gt;<br>
            &lt;img src="<?=Yii::$app->params['storageAdmin']?><wbr><?=$model->image?>"style="" alt="photo"&gt;
            <br>&lt;/div&gt;
        </div>
        <div class="col-md-8">
            <h3>Добавить изображения в статью...</h3>
            <?= FileUpload::widget([
                'model' => $modelPicture,
                'attribute' => 'picture',
                'url' => ['uploadimages', 'postId' => $model->id], // your url, this is just for demo purposes,
                'options' => ['accept' => 'image/*'],
                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {                             
              if(data.result.success) {
                  $("#images").html(data.result.html);
              }
        }',

                ],
            ]); ?>


            <div class="images" id="images">
                <div class="row">
                    <?php foreach ($articlesPicture as $picture):?>
                        <div class="col-md-12 pictureAdd">
                            <img class="addedPictures" src="<?=$picture->getImage()?>">
                            &lt;div class="central"&gt;<br>
                            &lt;img src="<?=Yii::$app->params['storageAdmin']?><wbr><?=$picture->path?>"style="" alt="photo"&gt;
                            <br>&lt;/div&gt;
                            <br>
                            <a class="btn btn-danger btnDelete" post-id="<?=$model->id?>" data-id="<?=$picture->id?>">Удалить</a>
                        </div>
                    <hr>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>



    <br><br>
    <?= $form->field($modelUpdate, 'text')->textarea(['rows' => 20])->label('Текст статьи') ?>

    <?= $form->field($modelUpdate, 'description')->textarea(['rows' => 12])->label('Короткий текст') ?>

    <?= $form->field($modelUpdate, 'status')->dropDownList([
            0 => 'Не видно на сайте',
            1 => 'Видно на сайте',
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

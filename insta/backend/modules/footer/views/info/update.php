<?php

use dosamigos\fileupload\FileUpload;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\footer\models\InfoFooter */
/* @var $update \backend\modules\footer\models\forms\FooterUpdateForm */

$this->title = 'Update Info Footer: ' . $model->article_name;
$this->params['breadcrumbs'][] = ['label' => 'Info Footers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$this->registerJsFile('@web/js/uploadPhotoFooter.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

?>
<div class="info-footer-update">

    <h3>Добавить изображения в статью...</h3>
    <?= FileUpload::widget([
        'model' => $modelPicture,
        'attribute' => 'picture',
        'url' => ['uploadimages', 'name' => $model->article_name], // your url, this is just for demo purposes,
        'options' => ['accept' => 'image/*'],
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {                             
              if(data.result.success) {
                  $("#images").html(data.result.html);
              }
        }',

        ],
    ]); ?>

    <div id="images">
        <br>
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

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <?php $form = ActiveForm::begin()?>
        <?=$form->field($update, 'articleName')->textInput()?>
        <?=$form->field($update, 'text')->textarea(['rows'=>20])?>
        <?=$form->field($update, 'description')->textarea(['rows'=>8])?>

        <?=Html::submitButton('Update', ['class' => 'btn btn-primary'])?>

        <?php ActiveForm::end()?>
    </div>



</div>

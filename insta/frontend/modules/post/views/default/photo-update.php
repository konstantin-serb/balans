<?php
/**
 * @var $color \frontend\modules\post\controllers\DefaultController--actionUpdate();
 * @var $id \frontend\modules\post\controllers\DefaultController--actionUpdate();
 * @var $imageModel \frontend\modules\post\models\forms\ImageEditForm
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->color = $color;

$this->registerJsFile('@web/js/script.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);
?>

<section class="addPost">
    <div class="addWrap">
    <h2>Update image post #<?=$id;?></h2>


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    
    <h3> SELECT PICTURE</h3>
            <div class="wrap-button">
                <div class="button ">
    <?=$form->field($imageModel, 'picture')->fileInput()?>
                </div>
            </div>

    <div class="wrap-button">
    <button>Update</button>
    </div>

    <?php ActiveForm::end()?>
    </div>
</section>

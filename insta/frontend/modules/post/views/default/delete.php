<?php
/**
 * @var $color \frontend\modules\post\controllers\DefaultController--actionDelete();
 * @var $id \frontend\modules\post\controllers\DefaultController--actionDelete();
 * @var $model \frontend\models\Post;
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->color = $color;

$this->registerJsFile('@web/js/script.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);
?>

<section class="delPost">
    <div class="addWrap">
        <br>
        <h2><?=Yii::t('my page', 'Delete post')?></h2>
        <div class="wrap-button" id="delPost">
            <div class="button button-round cancel red">
                <a href="javascript:history.back()" class="" href="create.html"><?=Yii::t('my page', 'CANCEL')?></a>
            </div>
        </div>
        <div class="aWrap" id="UpdatePost">

        <img class="" src="<?=$model->getImage()?>" >

        </div>
        <br><br>
        
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <div class="text">
            <p>
                <?php echo Html::encode($model->description) ?>
            </p>
        </div>


    
 <div class="wrap-button">
    <button><?=Yii::t('my page', 'Delete')?></button>
   
    </div>

    <?php ActiveForm::end()?>

    </div>
</section>

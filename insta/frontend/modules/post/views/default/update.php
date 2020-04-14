<?php
/**
 * @var $color \frontend\modules\post\controllers\DefaultController--actionUpdate();
 * @var $id \frontend\modules\post\controllers\DefaultController--actionUpdate();
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

<section class="addPost">
    <div class="addWrap">
        <h2>Update post #<?=$id;?></h2>
        <div class="wrap-button">
            <div class="button button-round cancel magenta">
                <a href="javascript:history.back()" class="" href="create.html">CANCEL</a>
            </div>
        </div>
        <div class="aWrap">
            <a class="updatePost" href="<?=Url::to(['/post/default/photo-update', 'id' => $id])?>">
        <img class="" src="<?=$model->getImage()?>" >
    </a>
        </div>
        <br><br>
        
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            
            <?php $editForm->description = $model->description;
                    $editForm->status = $model->status;?>
        
            <?=$form->field($editForm, 'description')->textarea(['rows'=>10])?>
        <div class="r-button">
        <?=$form->field($editForm, 'status')
            ->radioList([1 => 'all', 2=> 'only friends', 3=>'only me'])?>
        </div>
    
 <div class="wrap-button">
    <button>Update</button>
   
    </div>

    <?php ActiveForm::end()?>

    </div>
</section>

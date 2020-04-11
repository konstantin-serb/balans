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

?>

<section class="postUpdate">
    <h2>Update post #<?=$id;?></h2>
    <a class="" href="<?=Url::to(['/post/default/photo-update', 'id' => $id])?>">
    <img src="<?=$model->getImage()?>" width="200">
    </a>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<!--    --><?//=$form->field($model, 'filename')->fileInput()?>
    <?=$form->field($model, 'description')?>
<!--    --><?//=Html::submitButton('update')?>
    <button>submit</button>

    <?php ActiveForm::end()?>

</section>

<?php
/**
 * @var $color \frontend\modules\post\controllers\DefaultController--actionUpdate();
 * @var $id \frontend\modules\post\controllers\DefaultController--actionUpdate();
 * @var $imageModel \frontend\modules\post\models\forms\ImageEditForm
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->color = $color;

?>

<section class="postUpdate">
    <h2>Update image post #<?=$id;?></h2>


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?=$form->field($imageModel, 'picture')->fileInput()?>


    <button>submit</button>

    <?php ActiveForm::end()?>

</section>

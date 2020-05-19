<?php
/**
 * @var $model \frontend\models\User
 * @var $color \frontend\modules\user\controllers\DefaultController
 * @var $updateForm \frontend\modules\user\models\UpdateForm
 *
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Page for editing user data';
$this->color = $color;

$updateForm->username = $model->username;
$updateForm->nickname = $model->nickname;
$updateForm->about = $model->about;

?>


<section class="dataUpdate">
    <h1><?=$this->title?></h1>
    <h4 style="text-align: center">On this page you can edit some of your data</h4>

    <div class="formUpdate" style="max-width:800px; margin: 20px auto">
        <div class="wrap" style="text-align: center;">
            <?php $form = ActiveForm::begin()?>

            <?=$form->field($updateForm, 'username')->textInput()?>

            <?=$form->field($updateForm, 'nickname')->textInput()?>

            <?=$form->field($updateForm, 'about')->textarea(['rows'=>'8'])?>

            <?=$form->field($updateForm, 'currentPassword')->passwordInput()?>

            <?=$form->field($updateForm, 'password')->label('New password')?>

            <div class="wrap-button">
                <button><?=Yii::t('my page', 'Update')?></button>
            </div>


            <?php ActiveForm::end()?>
        </div>
    </div>

</section>

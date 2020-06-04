<?php
/**
 * @var $model \frontend\modules\post\models\forms\PostForm
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

if (!empty($color))
    $this->color = $color;
?>

<?php $form = ActiveForm::begin(); ?>

<section class="addPost">
    <div class="addWrap">
        <br><br>
        <div class="wrap-button">
            <div class="button button-round cancel red">
                <a href="javascript:history.back()" class="" href="create.html"><?= Yii::t('my page', 'CANCEL') ?></a>
            </div>
        </div>
        <br>
        <h2><?= Yii::t('my page', 'CREATE POST') ?></h2>
        <hr>
        <h3><?= Yii::t('my page', 'SELECT PICTURE') ?></h3>
        <div class="wrap-button">
            <div class="button button-round">
                <?= $form->field($model, 'picture')->fileInput() ?>
            </div>
        </div>


        <div class="textArea">
            <?= $form->field($model, 'description')->textarea()->label(Yii::t('my page', 'DESCRIPTION')) ?>
        </div>
        <div class="r-button">
            <?php $model->status = 1; ?>
            <?= $form->field($model, 'status')->radioList([
                1 => Yii::t('my page', 'All'),
                2 => Yii::t('my page', 'Only friends'),
                3 => Yii::t('my page', 'Only me')])
                ->label(Yii::t('my page', 'Post will see:')) ?>
        </div>

        <div class="wrap-button">

            <a class="red"><?= Html::submitButton(Yii::t('my page', 'Create')) ?></a>

        </div>
        <?php ActiveForm::end() ?>
        <hr>
        <br><br>
        <div class="wrap-button">
            <div class="button button-round cancel red">
                <a href="javascript:history.back()" class="" href="create.html"><?= Yii::t('my page', 'CANCEL') ?></a>
            </div>
        </div>
        <br>
    </div>
</section>
<?php if(!empty($horizontalBlurb)):?>
    <section>
        <div class="blurb horizontal">
            <a href="http:\\<?=$horizontalBlurb->url?>" target="_blank">
                <div class="blurb-content">
                    <p class="fig">
                        <img src="<?=Yii::$app->params['blurb'].$horizontalBlurb->photo?>">

                    </p>
                    <div class="text">
                        <?=$horizontalBlurb->text?>
                    </div>

                </div>

            </a>
        </div>
    </section>
<?php endif;?>



<?php
/**
 * @var $model \frontend\modules\post\models\forms\PostForm
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

if (!empty($color))
    $this->color = $color;
?>

<?php $form = ActiveForm::begin();?>






<section class="addPost">
    <div class="addWrap">
        <br><br>
        <div class="wrap-button">
            <div class="button button-round cancel red">
                <a href="javascript:history.back()" class="" href="create.html">CANCEL</a>
            </div>
        </div>
        <br>
        <h2>CREATE POST</h2>
        <hr>
            <h3> SELECT PICTURE</h3>
            <div class="wrap-button">
                <div class="button button-round">
                    <?=$form->field($model, 'picture')->fileInput()?>
                </div>
            </div>



            <div class="textArea">
                <?=$form->field($model, 'description')->textarea()?>
            </div>
        <div class="r-button">
            <?php $model->status = 1;?>
            <?=$form->field($model, 'status')->radioList([1 => 'all', 2=> 'only friends', 3=>'only me'])?>
        </div>

            <div class="wrap-button">

                    <a class="red" ><?=Html::submitButton('Create')?></a>

            </div>
        <?php ActiveForm::end()?>
        <hr>
        <br><br>
        <div class="wrap-button">
            <div class="button button-round cancel red">
                <a href="javascript:history.back()" class="" href="create.html">CANCEL</a>
            </div>
        </div>
        <br>
    </div>
</section>
<section class="blurbHoriz">
    <div class="blurb horizontal">
        <h4>Здесь может быть ваша реклама</h4>
    </div>
</section>



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

<!--            <h3>Пост будут видеть:</h3>-->
<!--            <div class="visible">-->
<!--                <div class="r-button">-->
<!--                    <input style="width:22px; height:22px;" class="rbtn" type="radio" name="option" id="radio1" />-->
<!--                    <label for="radio1">All</label>-->
<!--                </div>-->
<!--                <div class="r-button">-->
<!--                    <input style="width:22px; height:22px;" class="rbtn" type="radio" name="option" id="radio2" />-->
<!--                    <label for="radio2">Friends</label>-->
<!--                </div>-->
<!--                <div class="r-button">-->
<!--                    <input style="width:22px; height:22px;" class="rbtn" type="radio" name="option" id="radio3" />-->
<!--                    <label for="radio3">Only dier friends</label>-->
<!--                </div>-->
<!--                <div class="r-button">-->
<!--                    <input style="width:22px; height:22px;" class="rbtn" type="radio" name="option" id="radio4" checked />-->
<!--                    <label for="radio4">Only I</label>-->
<!--                </div>-->
<!--            </div>-->
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



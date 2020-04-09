<?php


use yii\widgets\ActiveForm;

?>

<h1>Create picture</h1>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
    <?=$form->field($model, 'imageFile')->fileInput()?>
<button>Submit</button>
<?php ActiveForm::end();?>


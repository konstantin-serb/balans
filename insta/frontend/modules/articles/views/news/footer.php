<?php
/**
 * @var $footerContent \backend\modules\footer\models\InfoFooter;
 */

$this->registerJsFile('@web/js/script.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);
$this->title = 'Balans | '.$footerContent->article_name;

$this->color = $color;


?>

<section>
    <div>
        <?=$footerContent->text?>
    </div>
</section>

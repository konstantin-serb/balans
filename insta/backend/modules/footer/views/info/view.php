<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\footer\models\InfoFooter */

$this->title = $model->article_name;
$this->params['breadcrumbs'][] = ['label' => 'Info Footers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="info-footer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>
    <div>
        <p><?=$model->text?></p>
    </div>
</div>

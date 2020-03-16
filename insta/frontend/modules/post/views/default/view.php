<?php
/**
 * @var $post \frontend\models\Post;
 */

use yii\helpers\Html;
?>

<div class="post-default-index">

    <div class="row">
        <div class="col-md-12">
            <?php if($post->user):?>
            <p>Avthor: <?=$post->user->username?></p>
            <?php endif;?>
            <img src="<?php echo Html::encode($post->getImage())?>">
        </div>
        <div class="col-md-12">
            <?php echo Html::encode($post->description)?>
        </div>
    </div>
</div>


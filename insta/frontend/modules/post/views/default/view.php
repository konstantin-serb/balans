<?php
/**
 * @var $post \frontend\models\Post;
 * @var $currentUser \frontend\models\User

 */

use yii\helpers\Html;
?>

<div class="post-default-index">

    <div class="row">
        <div class="col-md-12">
            <?php if($post->user):?>
            <p>Avthor: <?=$post->user->username?></p>
            <?php endif;?>
            <img src="<?php echo Html::encode($post->getImage())?>"><br><br>
        </div>

        <div class="col-md-12">
            <?php echo Html::encode($post->description)?>
        </div>
        <div class="col-md-12">
            Likes: <span id="count1" class="likes-count"><?php echo $post->countLikes(); ?></span>
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <a href="#" class="btn btn-primary button-like <?=($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""?>" data-id="<?php echo $post->id?>">
            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>
        <a href="#" class="btn btn-danger button-unlike <?=($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"?>" data-id="<?=$post->id?>">
            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>
    </div>
</div>




<?php
$this->registerJsFile('@web/js/likes.js', [
     'depends' => \yii\web\JqueryAsset::class,
]);

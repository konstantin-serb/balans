<?php

/** @var $this yii\web\View
 * @var $feedItems \frontend\models\Post
 * @var $feedItem \frontend\models\Post
 * @var $currentUser \frontend\models\User
 * @var $friends \frontend\controllers\SiteController
 * @var $users \frontend\models\User
 * @var $user \frontend\models\User
 */


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'Лента друзей';
?>

<div class="main-page">
    <div class="row">

        <div class="col-md-12">
            <h1>Лента ваших друзей: </h1>
        </div>


        <?php if ($feedItems): ?>
            <?php foreach ($feedItems as $feedItem): ?>
                <div class="col-md-3" >
                    <div class="imageBlock">
                        <div class="topBlock">
                            <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($feedItem->user_id)])?>">
                                <p>
                                    <img class="avtorPicture" src="<?=$feedItem->authorPhoto($feedItem->user_id)?>" width="70" height="70">
                                    &nbsp;&nbsp;<span><?=$feedItem->authorName($feedItem->user_id)?></span>
                                </p>
                            </a>
                            <a style="color:black;text-decoration: none;" href="<?=Url::to(['/post/default/view', 'id' => $feedItem->id])?>">
                                <img src="/uploads/<?=$feedItem->filename?>">
                                <p>
                                    <?=HtmlPurifier::process($feedItem->description)?>
                                </p>

                        </div>
                        <div class="bottomBlock">

                            </a>
                            <p>

                                <a href="#" class="button-like <?php echo ($currentUser->likesPost($feedItem->id)) ? "display-none" : ""; ?>" data-id="<?php echo $feedItem->id; ?>"  data-id="<?php echo $feedItem->id?>">
                                    <i class="fa fa-lg fa-heart-o"></i>&nbsp;
                                </a>
                                <a href="#" class="button-unlike <?php echo ($currentUser->likesPost($feedItem->id)) ? "" : "display-none"; ?>" data-id="<?=$feedItem->id?>">
                                    <i class="fa fa-lg fa-heart"></i>&nbsp;
                                </a>
                                <span id="count1" class="likes-count" data-id="<?php echo $feedItem->id; ?>"><?=$feedItem->countLikes()?></span>
                                <span class="date" style="float:right;"><?=Yii::$app->formatter->asDatetime($feedItem->created_at)?></span>
                            </p>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-12">
            <h4>Чтобы получать ленту друзей, подпишитесь на пользователей: </h4>
            <?php foreach($users as $user):?>
                <a style="color:black;" href="<?= Url::to(['/user/profile/view', 'nickname' => ($user->nickname) ? $user->nickname : $user->getId()]) ?>">
                    <?=$user->username?>&nbsp;&nbsp;&nbsp;&nbsp;
                </a>
            <?php endforeach;?>
        </div>
    </div>
</div>

<?php
$this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);



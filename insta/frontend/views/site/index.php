<?php

/** @var $this yii\web\View
 * @var $feedItems \frontend\models\Feed
 * @var $feedItem \frontend\models\Feed
 * @var $currentUser \frontend\models\User
 * @var $friends \frontend\controllers\SiteController
 * @var $users \frontend\models\User
 * @var $user \frontend\models\User
 */


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'КостинГрам';
?>

<div class="row">

        <h1>Лента ваших друзей: </h1>

    <?php if ($feedItems): ?>
        <?php foreach ($feedItems as $feedItem): ?>
            <div class="col-md-6">
                <a  href="<?= Url::to(['/user/profile/view', 'nickname' => ($feedItem->author_nickname) ? $feedItem->author_nickname : $feedItem->author_id]) ?>">
                    <img src="<?= $feedItem->author_picture ?>" width="50" height="auto">

                    <?= Html::encode($feedItem->author_name) ?>
                </a>
                <br>
                <br>
                <a style="color:black;text-decoration: none;" href="<?=Url::to(['/post/default/view', 'id' => $feedItem->post_id])?>">
                    <img src="<?= Yii::$app->storage->getFile($feedItem->post_filename)?>">
                    <p>
                        <?=HtmlPurifier::process($feedItem->post_description)?>
                    </p>
                    <p>
                        <?=Yii::$app->formatter->asDatetime($feedItem->post_created_at)?>
                    </p>
                    <p>


                    </p>

                </a>

                Likes: <span id="count1" class="likes-count" data-id="<?php echo $feedItem->post_id; ?>"><?=$feedItem->countLikes()?></span><br><br>
                    <a href="#" class="btn btn-primary button-like <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "display-none" : ""; ?>" data-id="<?php echo $feedItem->post_id; ?>"  data-id="<?php echo $feedItem->post_id?>">
                        Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                    </a>
                    <a href="#" class="btn btn-danger button-unlike <?php echo ($currentUser->likesPost($feedItem->post_id)) ? "" : "display-none"; ?>" data-id="<?=$feedItem->post_id?>">
                        Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                    </a>


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

<?php
$this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);



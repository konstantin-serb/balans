<?php

/** @var $this yii\web\View
 * @var $feedItems \frontend\models\Post
 * @var $feedItem \frontend\models\Post
 * @var $currentUser \frontend\models\User
 * @var $friends \frontend\controllers\SiteController
 * @var $users \frontend\models\User
 * @var $user \frontend\models\User
 * @var $color \frontend\controllers\SiteController
 */


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'Лента друзей';
$this->color = $color;
?>

    <section>
        <div class="blurb horizontal">
            <h4>Здесь может быть ваша реклама</h4>
        </div>
    </section>
    <section class="main-content">
        <div class="wrap">
            <h2><?=Yii::t('newsFeed', 'NEWS FEED')?></h2>
            <div class="posts">
                <?php if ($feedItems): ?>
                    <?php foreach($feedItems as $feedItem):?>
                        <div class="item-wrap">
                            <div class="item">
                                <div class="top userTop">
                                    <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($feedItem->user_id)]) ?>">
                                        <div class="authorPhoto">
                                            <img class="autPhoto" src="<?= $feedItem->authorPhoto($feedItem->user_id) ?>">
                                        </div>
                                        <span class="autopName"><?= $feedItem->authorName($feedItem->user_id) ?></span>
                                        <?php if($feedItem->status ==2):?>
                                            <i class="fas fa-user-friends userPage" ></i>
                                        <?php endif;?>
                                    </a>
                                </div>
                                <div class="photo">
                                    <a href="<?= Url::to(['/post/default/view', 'id' => $feedItem->id,'#' => 'photoPost']) ?>" title="Подробнее...">
                                        <div class="pictureWrap">
                                            <img class="contentPhoto" src="/uploads/<?= $feedItem->filename ?>"
                                                 alt="" title="">
                                        </div>
                                    </a>
                                    <p>
                                        <?= HtmlPurifier::process($feedItem->description) ?>
                                    </p>
                                </div>
                                <hr>
                                <div class="bottom">
                                    <div class="likes">
                                        <a href="#"
                                           class="button-like <?php echo ($currentUser->likesPost($feedItem->id)) ? "display-none" : ""; ?>"
                                           data-id="<?php echo $feedItem->id; ?>" data-id="<?php echo $feedItem->id ?>">
                                            <i class="far fa-heart"></i>&nbsp;
                                        </a>
                                        <a href="#"
                                           class="button-unlike <?php echo ($currentUser->likesPost($feedItem->id)) ? "" : "display-none"; ?>"
                                           data-id="<?= $feedItem->id ?>">
                                            <i class="fas fa-heart"></i>&nbsp;
                                        </a>


                                        <span id="count1" class="likes-count"                                                                                    data-id="<?php echo $feedItem->id; ?>">
                                            <?= $feedItem->countLikes() ?>
                                        </span>
                                    </div>
                                    <div class="comments">
                                        <i class="far fa-comment-alt"></i> <?=$feedItem->countComments?>
                                    </div>
                                    <div class="date">
                                        <?= Yii::$app->formatter->asDate($feedItem->created_at) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section>
        <div class="main-page">



            <div class="row">
                <div class="col-md-12">
                    <h4>Чтобы получать ленту друзей, подпишитесь на пользователей: </h4>
                    <?php foreach ($users as $user): ?>
                        <a style="color:black;"
                           href="<?= Url::to(['/user/profile/view', 'nickname' => ($user->nickname) ? $user->nickname : $user->getId()]) ?>">
                            <?= $user->username ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>


<?php
$this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);



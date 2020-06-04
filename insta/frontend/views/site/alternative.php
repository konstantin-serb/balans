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

<?php if(!empty($horizontalBlurb)):?>
    <section>
        <div class="blurb horizontal">
            <a href="http:\\<?=$horizontalBlurb->url?>" target="_blank">
                <div class="blurb-content">
                    <p class="fig">
                        <img src="<?=Yii::$app->params['blurb'].$horizontalBlurb->photo?>">

                    </p>
                    <div class="text">
                        <?=$horizontalBlurb->text?>
                    </div>

                </div>

            </a>
        </div>
    </section>
<?php endif;?>
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
                                        <a href="<?=Url::to(['/post/default/view', 'id' => $feedItem->id,'#' => 'comments'])?>"
                                           style="color:#555;">
                                        <i class="far fa-comment-alt"></i> <?=$feedItem->countComments?>
                                        </a>
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

    

<?php
$this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);



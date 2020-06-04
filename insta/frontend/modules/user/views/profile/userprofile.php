<?php

/**
 * @var $user \frontend\models\User
 * @var $currentUser \frontend\models\User
 * @var $modelPicture \frontend\models\forms\PictureForm
 * @var $posts \frontend\models\Post
 * @var $post \frontend\models\Post
 * @var $pagination \frontend\models\Post
 * @var $color \frontend\modules\user\controllers\ProfileController
 * @var $title \frontend\modules\user\controllers\ProfileController
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->color = $color;
$this->title = $title;


$this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);
$this->registerJsFile('@web/js/script.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/myModal.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/ajaxSubscribe.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);
?>


<section class="about">
    <div class="aboutWrap">
        <h2><?=Yii::t('my page', '{username}\'s USER PAGE', [
                'username' => Html::encode($user->username)
            ]);?></h2>
        <div class="top">
            <div class="left">
                <div class="photo">
                    <img src="<?= $user->getPicture() ?>">
                </div>
                <div class="info">
                    <div class="name"><b><?=Yii::t('my page', 'Name')?>:</b> <?= Html::encode($user->username) ?></div>
                    <div class="nickname"><b>nickname:</b> <?= Html::encode($user->nickname) ?></div>
                    <div class="infoTime"><b><?=Yii::t('my page', 'On site, with')?>:</b> <?= Yii::$app->formatter->asDate($user->created_at) ?>
                    </div>
                    <div class="counts"><b><a><?= $user->rating ?> <?=Yii::t('my page', 'posts')?>
                                | &nbsp;
                            <a style="cursor:pointer;" href="myModalFollower-<?=$user->id?>" data-toggle="myModal" data-target="#myModalFollower-<?=$user->id?>">
                                <?=$user->countFollowers() . ' ' . Yii::t('my page', 'subscribers')?>
                            </a>
                            |
                            <a style="cursor:pointer;" href="myModalSubscriber-<?=$user->id?>" data-toggle="myModal" data-target="#myModalSubscriber-<?=$user->id?>">
                                <?=Yii::t('my page', 'subscribed to {followers} users', [
                                    'followers' => $user->countSubscribers()
                                ])?>
                            </a>
                            |
                            <a style="cursor:pointer;" href="myModalMutual-<?=$user->id?>" data-toggle="myModal" data-target="#myModalMutual-<?=$user->id?>">
                                <?php if ($currentUser && $currentUser->getMutualSubscriptionsTo($user) != null): ?>
                                <?= $currentUser->countMutualFriends($user) ?>
                            <?=Yii::t('my page', 'mutual friends')?>
                            </a>
                            <?php else:?>
                            Нет общих друзей
                        </a>
                        <?php endif; ?>
                        </b>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="rectangularButton button">
                    <?php if ($currentUser): ?>
                        <?php if (!$currentUser->equals($user)): ?>
                            <?php if ($currentUser->isFollowers($user)) : ?>
                                <a href="<?= Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]) ?>"
                                   class="<?= $color ?>"><?=Yii::t('my page', 'UNSUBSCRIBE')?></a>
                            <?php else: ?>
                                <a href="<?= Url::to(['/user/profile/subscrire', 'id' => $user->getId()]) ?>"
                                   class="<?= $color ?>"><?=Yii::t('my page', 'SUBSCRIBE')?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <!--                    <a class="--><? //=$color?><!--" href="#">ПОДПИСАТЬСЯ</a>-->
                </div>

            </div>
        </div>
        <div class="text">
            <p><b>Информация обо мне:</b> <?= HtmlPurifier::process($user->about) ?></p>
        </div>
    </div>
</section>
<section class="myModal-section">
    <!---------------------------------modalFollowers--------------------------------------->
    <div id="myModalFollower-<?=$user->id?>" class="myModal">
        <div class="myModal-dialog">
            <div class="myModal-content">
                <div class="myModal-header">
                    <h3 class="myModal-title" >
                        <?=Yii::t('my page' , 'FOLLOWED TO')?>:</h3>
                    <a href="#" title="Закрыть" class="modalClose" data-close="myModal">
                        &times;
                    </a>
                </div>
                <div class="myModal-body" style="padding: 15px 10px;">
                    <?php foreach($user->getFollowers() as $subscriber):?>
                        <a href="<?=Url::to(['/user/profile/view', 'nickname' => $subscriber['id']])?>">
                            <div class="UserBlock">
                                <div class="minAvatar" style="padding:0;">
                                    <img class="mimiatiura"
                                         src="<?=\frontend\models\User::getUserPhoto2($subscriber['id'])?>">
                                </div>
                                <span class="item">
                                                            <?=Html::encode($subscriber['username'])?>
                                                        </span>
                            </div>

                            <?php if (!$currentUser->isFollowersId($subscriber['id'])) : ?>
                                <div class="subscribeButton">
                                    <a style="cursor:pointer" data-id="<?=$subscriber['id']?>"
                                       class="btnSubscribe btn btn-default">
                                        <?=Yii::t('my page', 'Subscribe')?>
                                    </a>
                                </div>
                            <?php endif;?>


                        </a>
                        <hr>
                    <?php endforeach;?>
                    <br>
                    <a href="#" title="Закрыть" class="btn btn-default" data-close="myModal">
                        <?=Yii::t('my page', 'CANCEL')?>
                    </a>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------endModalFollowers------------------------------------->


    <!---------------------------------modalSubscriber--------------------------------------->
    <div id="myModalSubscriber-<?=$user->id?>" class="myModal">
        <div class="myModal-dialog">
            <div class="myModal-content">
                <div class="myModal-header">
                    <h3 class="myModal-title" >
                        <?=Yii::t('my page' , 'SUBSCRIBED TO')?>:</h3>
                    <a href="#" title="Закрыть" class="modalClose" data-close="myModal">
                        &times;
                    </a>
                </div>
                <div class="myModal-body" style="padding: 15px 10px;">
                    <?php foreach($user->getSubscriptions() as $subscriber):?>
                        <a href="<?=Url::to(['/user/profile/view', 'nickname' => $subscriber['id']])?>">
                            <div class="UserBlock">
                                <div class="minAvatar" style="padding:0;">
                                    <img class="mimiatiura"
                                         src="<?=\frontend\models\User::getUserPhoto2($subscriber['id'])?>">
                                </div>
                                <span class="item">
                                                            <?=Html::encode($subscriber['username'])?>
                                                        </span>
                            </div>

                            <?php if (!$currentUser->isFollowersId($subscriber['id'])) : ?>
                                <div class="subscribeButton">
                                    <a style="cursor:pointer" data-id="<?=$subscriber['id']?>"
                                       class="btnSubscribe btn btn-default">
                                        <?=Yii::t('my page', 'Subscribe')?>
                                    </a>
                                </div>
                            <?php endif;?>


                        </a>
                        <hr>
                    <?php endforeach;?>
                    <br>
                    <a href="#" title="Закрыть" class="btn btn-default" data-close="myModal">
                        <?=Yii::t('my page', 'CANCEL')?>
                    </a>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------endModalFollowers------------------------------------->

    <!---------------------------------modalMutual--------------------------------------->
    <div id="myModalMutual-<?=$user->id?>" class="myModal">
        <div class="myModal-dialog">
            <div class="myModal-content">
                <div class="myModal-header">
                    <h3 class="myModal-title" >
                        <?=Yii::t('my page' , 'MUTUAL FRIENDS')?>:</h3>
                    <a href="#" title="Закрыть" class="modalClose" data-close="myModal">
                        &times;
                    </a>
                </div>
                <div class="myModal-body" style="padding: 15px 10px;">
                    <?php if($currentUser->getMutualSubscriptionsTo($user)):?>
                    <?php foreach($currentUser->getMutualSubscriptionsTo($user) as $subscriber):?>
                        <a href="<?=Url::to(['/user/profile/view', 'nickname' => $subscriber['id']])?>">
                            <div class="UserBlock">
                                <div class="minAvatar" style="padding:0;">
                                    <img class="mimiatiura"
                                         src="<?=\frontend\models\User::getUserPhoto2($subscriber['id'])?>">
                                </div>
                                <span class="item">
                                                            <?=Html::encode($subscriber['username'])?>
                                                        </span>
                            </div>

                            <?php if (!$currentUser->isFollowersId($subscriber['id'])) : ?>
                                <div class="subscribeButton">
                                    <a style="cursor:pointer" data-id="<?=$subscriber['id']?>"
                                       class="btnSubscribe btn btn-default">
                                        <?=Yii::t('my page', 'Subscribe')?>
                                    </a>
                                </div>
                            <?php endif;?>
                        </a>
                        <hr>
                    <?php endforeach;?>
                    <?php else:?>
                    У вас нет общих друзей
                    <?php endif;?>

                    <br>
                    <a href="#" title="Закрыть" class="btn btn-default" data-close="myModal">
                        <?=Yii::t('my page', 'CANCEL')?>
                    </a>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------endModalMutual------------------------------------->


</section>
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

<section class="newsFeed">
    <div class="wrap">
        <h2><?=Yii::t('my page', 'POSTS')?></h2>
        <br><br>
        <div class="posts">
            <?php foreach ($posts as $post): ?>
                <div class="item-wrap">
                    <div class="item">
                        <div class="top userTop">
                            <div class="authorPhoto">
                                <img class="autPhoto" src="<?= $user->getPicture() ?>">
                            </div>
                            <span class="autopName">&nbsp;&nbsp;<?= $post->user->username ?></span>
                            <?php if($post->status ==2):?>
                            <i class="fas fa-user-friends userPage" ></i>
                            <?php endif;?>
                        </div>
                        <div class="photo">
                            <a href="<?= Url::to(['/post/default/view', 'id' => $post->id, '#' => 'photoPost']) ?>">
                                <div class="pictureWrap">
                                    <img class="contentPhoto" src="<?php echo Html::encode($post->getImage()) ?>" alt=""
                                         title="">
                                </div>
                            </a>
                            <p>
                                <?php echo Html::encode($post->description) ?>
                            </p>
                        </div>
                        <hr>
                        <div class="bottom">
                            <div class="likes">
                                <a href="#"
                                   class="button-like <?php echo ($currentUser->likesPost($post->id)) ? "display-none" : ""; ?>"
                                   data-id="<?php echo $post->id; ?>" data-id="<?php echo $post->id ?>">
                                    <i class="far fa-heart"></i>&nbsp;
                                </a>
                                <a href="#"
                                   class="button-unlike <?php echo ($currentUser->likesPost($post->id)) ? "" : "display-none"; ?>"
                                   data-id="<?= $post->id ?>">
                                    <i class="fas fa-heart"></i>&nbsp;
                                </a>


                                <span id="count1" class="likes-count" data-id="<?php echo $post->id; ?>">
                                            <?= $post->countLikes() ?>
                                        </span>
                            </div>
                            <div class="comments">
                                <a href="<?=Url::to(['/post/default/view', 'id' => $post->id,'#' => 'comments'])?>"
                                   style="color:#555;">
                                    <i class="far fa-comment-alt"></i> <?=$post->countComments?>
                                </a>
                            </div>
                            <div class="date">
                                2020 15mart
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <div class="paginationWrap">
                <?php // display pagination
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
            </div>

        </div>
    </div>
</section>


<!-- Modal -->
<div id="myModal3" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Общие друзья</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>







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
                    <div class="counts"><b><?= $user->rating ?> <?=Yii::t('my page', 'posts')?> |
                            <?php
                            Modal::begin([
                                'size' => 'modal-lg',
                                'header' => '<h2>Followers</h2>',
                                'toggleButton' => [
                                    'label' => $user->countFollowers() . ' ' . Yii::t('my page', 'subscribers'),
                                    'tag' => 'a',
                                    'style' => 'cursor:pointer;'
                                ],
//                                            'footer' => 'Bottom window',
                            ]);
                            foreach ($user->getFollowers() as $follower) {
                                echo '<a href="' .
                                    Url::to(['/user/profile/view', 'nickname' => $follower['id']])
                                    . '">' . Html::encode($follower['username']) . '</a>' . '<br>';
                            }

                            Modal::end();
                            ?>

                            |
                            <a href="#" data-toggle="modal" data-target="#myModal">
                                <?php
                                Modal::begin([
                                    'size' => 'modal-lg',
                                    'header' => '<h2>Subscribers</h2>',
                                    'toggleButton' => [
                                        'label' => Yii::t('my page', 'subscribed to {followers} users', [
                                            'followers' => $user->countSubscribers()
                                        ]),
                                        'tag' => 'a',
                                        'style' => 'cursor:pointer;'
                                    ],
//                                            'footer' => 'Bottom window',
                                ]);
                                foreach ($user->getSubscriptions() as $subscriber) {
                                    echo '<a href="' .
                                        Url::to(['/user/profile/view', 'nickname' => $subscriber['id']])
                                        . '">' . Html::encode($subscriber['username']) . '</a>' . '<br>';
                                }

                                Modal::end();
                                ?>
                            </a>
                            |
                            <?php if ($currentUser && $currentUser->getMutualSubscriptionsTo($user) != null): ?>
                                <?= $currentUser->countMutualFriends($user) ?>
                            <?php endif; ?>
                            <?php
                            Modal::begin([
                                'size' => 'modal-lg',
                                'header' => Yii::t('my page', 'Mutual friends').':',
                                'toggleButton' => [
                                    'label' => Yii::t('my page', 'mutual friends'),
                                    'tag' => 'a',
                                    'style' => 'cursor:pointer;'
                                ],

                            ]);
                            if ($currentUser && $currentUser->getMutualSubscriptionsTo($user) != null) {
                                foreach ($currentUser->getMutualSubscriptionsTo($user) as $item) {
                                    echo '<a href="' . Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]) . '">';
                                    echo Html::encode($item['username']);
                                    echo '</a>'.'<br>';
                                }
                            }
                            Modal::end();
                            ?>
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
<section class="blurbHoriz">
    <div class="blurb horizontal">
        <h4>Здесь может быть ваша реклама</h4>
    </div>
</section>
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
                                <i class="far fa-comment-alt"></i> <?= $post->countComments ?>
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







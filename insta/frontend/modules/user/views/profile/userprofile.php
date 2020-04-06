<?php

/**
 * @var $user \frontend\models\User
 * @var $currentUser \frontend\models\User
 * @var $modelPicture \frontend\models\forms\PictureForm
 * @var $posts \frontend\models\Post
 * @var $color \frontend\modules\user\controllers\ProfileController
 * @var $title \frontend\modules\user\controllers\ProfileController
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

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
        <h2>СТРАНИЦА ПОЛЬЗОВАТЕЛЯ: <?= Html::encode($user->username) ?></h2>
        <div class="top">
            <div class="left">
                <div class="photo">
                    <img src="<?= $user->getPicture() ?>">
                </div>
                <div class="info">
                    <div class="name"><b>Name:</b> <?= Html::encode($user->username) ?></div>
                    <div class="nickname"><b>nickname:</b> <?= Html::encode($user->nickname) ?></div>
                    <div class="infoTime"><b>на сайте с:</b> 2020 15 mart.</div>
                    <div class="counts"><b>x постов |
                            <a href="#" data-toggle="modal" data-target="#myModal2">
                                <?= $user->countFollowers() ?> подписчиков
                            </a>
                            |
                            <a href="#" data-toggle="modal" data-target="#myModal">
                                на <?= $user->countSubscribers() ?> подписан
                            </a>
                            |
                            <a href="#" data-toggle="modal" data-target="#myModal3">
                                <?php if ($currentUser && $currentUser->getMutualSubscriptionsTo($user) != null): ?>
                                    <?= $currentUser->countMutualFriends($user) ?>
                                <?php endif; ?>
                                общих друзей</b>
                        </a>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="rectangularButton button">
                    <?php if ($currentUser): ?>
                        <?php if (!$currentUser->equals($user)): ?>

                            <?php if ($currentUser->isFollowers($user)) : ?>
                                <a href="<?= Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]) ?>"
                                   class="<?= $color ?>">ОТПИСАТЬСЯ</a>
                            <?php else: ?>
                                <a href="<?= Url::to(['/user/profile/subscrire', 'id' => $user->getId()]) ?>"
                                   class="<?= $color ?>">ПОДПИСАТЬСЯ</a>
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
        <h2>POSTS</h2>
        <br><br>
        <div class="posts">
            <?php foreach ($posts as $post): ?>
                <div class="item-wrap">
                    <div class="item">
                        <div class="top">
                            <div class="authorPhoto">
                                <img class="autPhoto" src="<?= $user->getPicture() ?>">
                            </div>
                            <span class="autopName">&nbsp;&nbsp;<?= $post->user->username ?></span>
                        </div>
                        <div class="photo">
                            <a href="<?= Url::to(['/post/default/view', 'id' => $post->id]) ?>">
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


                                <span id="count1" class="likes-count"                                                                                    data-id="<?php echo $post->id; ?>">
                                            <?= $post->countLikes() ?>
                                        </span>
                            </div>
                            <div class="comments">
                                <i class="far fa-comment-alt"></i> 0
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
                <a href="#" class="<?= $color ?>">
                    <div class="box left">&lt;</div>
                </a>
                <a href="#" class="<?= $color ?>">
                    <div class="box pageNumber">1</div>
                </a>
                <a href="#" class="<?= $color ?>">
                    <div class="box active pageNumber">2</div>
                </a>
                <a href="#" class="<?= $color ?>">
                    <div class="box pageNumber">3</div>
                </a>
                <a href="#" class="<?= $color ?>">
                    <div class="box right">&gt;</div>
                </a>
            </div>
        </div>
    </div>
</section>

<!--<p>Email: <b>--><? //= Html::encode($user->email) ?><!--</b></p>-->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Subscriptions</h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php if ($user->getSubscriptions() != null): ?>
                        <?php foreach ($user->getSubscriptions() as $subscription): ?>
                            <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($subscription['nickname']) ? $subscription['nickname'] : $subscription['id']]) ?>"><?= Html::encode($subscription['username']) ?>
                            </a>
                            <br>
                        <?php endforeach; ?>
                    <?php else: ?>
                <h5>Ни на одного не подписан</h5>
                <?php endif; ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<!-- Modal -->
<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Followers</h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php if ($user->getFollowers() != null): ?>
                        <?php foreach ($user->getFollowers() as $follower): ?>
                            <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]) ?>"><?= Html::encode($follower['username']) ?>
                            </a>
                            <br>
                        <?php endforeach; ?>
                    <?php else: ?>
                <h5>На него никто не подписан</h5>
                <?php endif; ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


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
                    <?php if ($currentUser && $currentUser->getMutualSubscriptionsTo($user) != null): ?>
                        <?php foreach ($currentUser->getMutualSubscriptionsTo($user) as $item): ?>
                            <div class="col-md-12">
                                <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]) ?>">
                                    <?= Html::encode($item['username']) ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>







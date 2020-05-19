<?php

/**
 * @var $user \frontend\models\User
 * @var $currentUser \frontend\models\User
 * @var $modelPicture \frontend\models\forms\PictureForm
 * @var $posts \frontend\models\Post
 * @var $post \frontend\models\Post
 * @var $color \frontend\modules\user\controllers\ProfileController
 * @var $title \frontend\modules\user\controllers\ProfileController
 * @var $message \frontend\models\CommentReport
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use dosamigos\fileupload\FileUpload;
use yii\widgets\LinkPager;

$this->color = $color;
$this->title = $title;

$this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

?>

<section class="addPostButton">
    <div class="addPostsWrap">
        <h2><?=Yii::t('my page', 'HELLO')?>, <?= Html::encode($currentUser->username) ?>!</h2>
        <div class="message">
            <?php if($message):?>
            <a class="button-message active" href="<?=Url::to(['/user/profile/my-messages/', 'id' => Yii::$app->user->identity->getId()])?>">
                <?=Yii::t('my page', 'You have new posts')?>
            </a>
            <?php else:?>
                <a class="button-message" href="<?=Url::to(['/user/profile/my-messages/', 'id' => Yii::$app->user->identity->getId()])?>">
                    <?=Yii::t('my page', 'You have no new posts')?>
                </a>
            <?php endif;?>
        </div>
        <br>


    </div>
</section>
<section class="about">
    <div class="aboutWrap">
        <div class="top">
            <div class="left">
                <div class="photo">
                    <img id="profile-picture" src="<?= Html::encode($currentUser->getPicture()) ?>">
                </div>
                <div class="info">
                    <div class="name"><b><?=Yii::t('my page', 'Name')?>:</b> <?= Html::encode($currentUser->username) ?></div>
                    <div class="nickname"><b>nickname:</b> <?= Html::encode($currentUser->nickname) ?></div>
                    <div class="infoTime"><b><?=Yii::t('my page', 'On site, with')?>:</b> <?= Html::encode(Yii::$app->formatter->asDate($currentUser->created_at)) ?></div>
                    <div class="counts"><b><?=$currentUser->rating?> <?=Yii::t('my page', 'posts')?> |
                            <?php
                            Modal::begin([
                                'size' => 'modal-lg',
                                'header' => '<h2>Followers</h2>',
                                'toggleButton' => [
                                    'label' => $user->countFollowers() . ' ' . Yii::t('my page', 'subscribers'),
                                    'tag' => 'a',
                                    'style' => 'cursor:pointer;'
                                ],

                            ]);
                            foreach ($user->getFollowers() as $follower) {
                                echo '<a href="' .
                                    Url::to(['/user/profile/view', 'nickname' => $follower['id']])
                                    . '">' . Html::encode($follower['username']) . '</a>' . '<br>';
                            }

                            Modal::end();
                            ?>
                            |
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
                        </b></div>
                </div>
            </div>
            <div class="right">
<!--                <h3>Изменить фото</h3>-->
                <div class="rectangularButton button">

                    <a class="<?= $color; ?> addUserPhoto" >

                        <?= FileUpload::widget([
                            'model' => $modelPicture,
                            'attribute' => 'picture',

                            'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
                            'options' => ['accept' => 'image/*'],
                            'clientEvents' => [
                                'fileuploaddone' => 'function(e, data) {                             
              if(data.result.success) {
                  $("#profile-image-success").show();
                  $("#profile-image-fail").hide();
                  $("#profile-picture").attr("src", data.result.pictureUri);
              } else {
                  $("#profile-image-fail").html(data.result.errors.picture).show();
                  $("#profile-image-success").hide();
              }
        }',

                            ],
                        ]); ?>

                        <?=Yii::t('my page', 'Change profile photo')?>
                    </a>
                </div>
                <div class="rectangularButton button">
                    <a class="<?= $color; ?>" href="<?=Url::to(['/user/default/update','nickname' => $currentUser->getNickname()])?>"><?=Yii::t('my page', 'To change the data')?></a>
                </div>
            </div>
        </div>
        <div class="text">
            <p><b><?=Yii::t('my page', 'Information about me')?>:</b> <?= Html::encode($currentUser->about) ?></p>
        </div>
    </div>
</section>
<section class="blurbHoriz">
    <div class="blurb horizontal">
        <h4>Здесь может быть ваша реклама</h4>
    </div>
</section>
<section class="newsFeed myPage">
    <h3><?=Yii::t('my page', 'Would you like to add a new post')?>?</h3>
    <div class="wrap-button">
        <div class="button button-round">
            <a class="<?= $color; ?>" href="<?=Url::to(['/post/default/create'])?>">
                <?=Yii::t('my page', 'ADD POST')?></a>
        </div>
    </div>
    <br>
    <hr>
    <div class="wrap">
        <h2><?=Yii::t('my page', 'MY POSTS')?>:</h2>
        <br><br>
        <!--        <h3>posts with the most likes:</h3>-->
        <div class="posts" id="currentUserPosts">
            <?php foreach ($posts as $post):?>
            <div class="item-wrap">
                <div class="item <?php
                if ($post->status == 2){
                    echo 'friends';
                } elseif($post->status == 3){
                    echo 'onlyMe';
                }
                ?>">
                    <div class="top">
                        <div class="tools">
                            <?php if($post->status == 1):?>
                            <a><i class="fas fa-globe-africa" style="color:mediumseagreen"></i></a>
                            <?php elseif($post->status == 2): ?>
                            <i class="fas fa-user-friends" style="color:deepskyblue"></i>
                            <?php elseif($post->status == 3):?>
                            <i class="fas fa-lock" style="color:orangered"></i>
                            <?php endif;?>
                            
                            <a href="<?=Url::to(['/post/default/update', 'id'=>$post->id, '#' => 'UpdatePost'])?>" title="update"><i class="fas fa-wrench"></i></a>
                            <a href="<?=Url::to(['/post/default/delete', 'id' => $post->id, '#' => 'delPost'])?>" title="delete"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>

                    <div class="photo">
                        <a href="<?= Url::to(['/post/default/view', 'id' => $post->id, '#' => 'photoPost']) ?>">
                            <div class="pictureWrap">
                                <img class="contentPhoto" src="<?=Html::encode($post->getImage())?>" alt=""
                                     title="posts Picture">
                            </div>
                        </a>
                        <p>
                            <?=Html::encode($post->description)?>
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
                            <i class="far fa-comment-alt"></i> <?=$post->countComments?>
                        </div>
                        <div class="date">
                            <?=Yii::$app->formatter->asDate($post->created_at)?>
                        </div>
                    </div>
                </div>
            </div>
            <?endforeach;?>
        </div>
        <div class="myPageView pagination">
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







<?php

/**
 * @var $user \frontend\models\User
 * @var $currentUser \frontend\models\User
 * @var $modelPicture \frontend\models\forms\PictureForm
 * @var $posts \frontend\models\Post
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use dosamigos\fileupload\FileUpload;

?>
<img id="profile-picture" src="<?= $user->getPicture() ?>" style="width: 250px;">
<br><br>
<div class="alert alert-success display-none" id="profile-image-success">Profile image updated</div>
<div class="alert alert-danger display-none" id="profile-image-fail"></div>

<?php if($currentUser):?>
<?php if($currentUser->equals($user)):?>
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

<?php endif;?>
<?php endif;?>

<h2><?= Html::encode($user->username) ?></h2>
<p>Nickname: <b><?= Html::encode($user->nickname) ?></b></p>
<p>Email: <b><?= Html::encode($user->email) ?></b></p>
<p><b>Немного о себе:</b><br><span style="color:darkblue;"><?= HtmlPurifier::process($user->about) ?></span></p>
<hr>


    <?php if ($currentUser): ?>
        <?php if(!$currentUser->equals($user)):?>

        <?php if ($currentUser->isFollowers($user)) : ?>
            <a href="<?= Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]) ?>" class="btn btn-danger">Отписаться</a>
        <?php else: ?>
            <a href="<?= Url::to(['/user/profile/subscrire', 'id' => $user->getId()]) ?>" class="btn btn-primary">Подписаться</a>
        <?php endif; ?>
        <br><br>
    <?php endif; ?>
<?php endif;?>


<?php
//if ($currentUser) {
//    dumper($currentUser->isFollowers($user));
//}
?>


<a href="#" data-toggle="modal" data-target="#myModal">Subscriptions (<?= $user->countSubscribers() ?>)</a>
<a href="#" data-toggle="modal" data-target="#myModal2">Followers (<?= $user->countFollowers() ?>)</a>
<?php if ($currentUser && $currentUser->getMutualSubscriptionsTo($user) != null): ?>
    <a href="#" data-toggle="modal" data-target="#myModal3">Общие друзья (<?= $currentUser->countMutualFriends($user) ?>
        )</a>
<?php endif; ?>
<hr>

<div class="row">
<?php foreach($posts as $post):?>

    <div class="col-md-4">
        <?php if($post->user):?>
            <p>
                <a href="<?=\yii\helpers\Url::to(['/user/profile/view', 'nickname' => $user->getNickname()])?>">
                    Avthor: <?=$post->user->username?>
                </a>
            </p>
        <?php endif;?>
        <a href="<?=Url::to(['/post/default/view', 'id' => $post->id])?>">
            <img src="<?php echo Html::encode($post->getImage())?>">
        </a>
        <br><br>
        <?php echo Html::encode($post->description)?>
        <br>
        Likes: <span id="count1" class="likes-count"><?php echo $post->countLikes(); ?></span>
        <br>
        <hr>
    </div>
<?php endforeach;?>
</div>



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







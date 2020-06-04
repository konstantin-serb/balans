<?php

/** @var $this yii\web\View
 * @var $articles \frontend\models\Articles
 * @var $article \frontend\models\Articles
 * @var $commentModel \frontend\modules\articles\models\forms\MainCommentForm
 * @var $comments \frontend\modules\articles\models\MainComments
 * @var $currentUser \frontend\models\User
 */


use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = $article->title;
$this->color = $color;

//$this->registerJsFile('@web/js/script.js', [
//    'depends' => \yii\web\JqueryAsset::class,
//]);

$this->registerJsFile('@web/js/postsLikes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/modal.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/articlesComment.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/myModal.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/ajaxSubscribe.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

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
<section class="single">
    <div class="wrap">
        <h2><?= $article->title ?></h2>

        <div class="content">
            <p>
                <?= $article->text ?>
            </p>
            <hr>
            <div class="bottom">
                <div class="likes">
                    <a
                            class="button-like <?php echo $article->isLikesBy(Yii::$app->user->identity->getId()) ? "display-none" : ""; ?>"
                            data-id="<?= $article->id ?>">
                        <i class="far fa-heart"></i>&nbsp;
                    </a>
                    <a
                            class="button-unlike <?php echo $article->isLikesBy(Yii::$app->user->identity->getId()) ? "" : "display-none"; ?>"
                            data-id="<?= '' ?>">
                        <i class="fas fa-heart"></i>&nbsp;
                    </a>
                    <span id="count1" class="likes-count" data-id="<?php echo '' ?>">
                                            <?php echo $article->likes_count ? $article->likes_count : 0 ?>
                                        </span>
                </div>
                <div class="comments">
                    <i class="far fa-comment-alt"></i> <?= $commentCount ?>
                </div>
                <div class="date">
                    <?= Yii::$app->formatter->asDate($article->date) ?>
                </div>
            </div>
            <hr>
        </div>
    </div>
</section>

<section class="postComments articles">

    <h2>COMMENTS:</h2>

    <div class="addComment">
        <div class="addCommentWrap">
            <div class="cancel wrap-button">
                <div class="button button-round cancel green">
                    <a id="buttonComment"><?= Yii::t('post', 'ADD COMMENT') ?></a>
                </div>
            </div>
        </div>
    </div>
    <div id="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div class="commentInfo">
                    <div class="userPhoto">
                        <a href="<?= Url::to(['/user/profile/view',
                            'nickname' => $comment->user->getNickname()]) ?>">
                            <img src="<?= $comment->user->getPicture() ?>" style="text-align: center; display: block;
    height: 100%; max-width: unset; margin: 0 auto;">
                        </a>
                    </div>
                    <div class="dataBlock">
                        <div class="name-info">
                            <div class="name"><a class="" style="
                                <?php
                                if ($comment->user_id == $currentUser->id) {
                                    echo 'color:red;';
                                }
                                ?>
                                        " href="<?= Url::to(['/user/profile/view',
                                    'nickname' => $comment->user->getNickname()]) ?>">
                                    <?= Html::encode($comment->user->username) ?>:</a></div>
                            <div class="info">
                                <div class="posts"><?= $comment->user->rating ?> <?= Yii::t('my page', 'posts') ?> </div>
                                |
                                <div class="followers">
                                    <a href="myModalFollower-<?=$comment->user->id?>" style="cursor:pointer;" data-toggle="myModal" data-target="#myModalFollower-<?=$comment->user->id?>"><?=$comment->user->countFollowers().' '.Yii::t('my page', 'subscribers')?></a>
                                </div>
                                |
                                <div class="subscriber">
                                    <a href="myModalUser-<?=$comment->user->id?>" style="cursor:pointer;" data-toggle="myModal" data-target="#myModalUser-<?=$comment->user->id?>"><?=Yii::t('my page', 'subscribed to {followers} users', [
                                            'followers' => $comment->user->countSubscribers()
                                        ])?></a>
                                </div>
                                <!--                            <div class="friends"><a href="#"> общих друзей</a></div>-->
                            </div>
                        </div>
                        <div class="nickname">
                            <b><?= Yii::t('post', 'nickname') ?>
                                :</b> <?= Html::encode(($comment->user->nickname) ? $comment->user->nickname : Yii::t('post', 'No nickname')) ?>
                        </div>
                        <div class="userDate">
                            <b><?= Yii::t('post', 'Comment added') ?>
                                :</b> <?= Yii::$app->formatter->asDatetime($comment->created_at) ?>
                        </div>
                    </div>
                </div>
                <div class="commentText">
                    <p style="
                    <?php if ($comment->user_id == $currentUser->id) {
                        echo 'color:red; font-weight:bold;';
                    }
                    ?> ">

                        <i><?= Html::encode($comment->comment) ?></i>
                    </p>
                </div>
                <hr>
            </div>
        <div class="myModal-section">

            <!---------------------------------modalSubscribers--------------------------------------->
            <div id="myModalUser-<?=$comment->user->id?>" class="myModal">
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
                            <?php foreach($comment->user->getSubscriptions() as $subscriber):?>
                                <a href="
                                                            <?=Url::to(['/user/profile/view', 'nickname' => $subscriber['id']])?>">
                                    <div class="UserBlock">
                                        <div class="minAvatar" style="padding:0;">
                                            <img class="mimiatiura" src="
                                                                    <?=\frontend\models\User::getUserPhoto2($subscriber['id'])?>"
                                                 style=""
                                            >
                                        </div>
                                        <p style="padding-top:10px;">
                                            <?=Html::encode($subscriber['username'])?>
                                        </p>
                                    </div>

                                    <?php if (!$currentUser->isFollowersId($subscriber['id'])) : ?>
                                        <div class="subscribeButton">
                                            <a style="cursor:pointer" data-id="<?=$subscriber['id']?>" class="btnSubscribe btn btn-default">
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
            <!--------------------------------endModalSubscribers------------------------------------->


            <!---------------------------------modalFollowers--------------------------------------->
            <div id="myModalFollower-<?=$comment->user->id?>" class="myModal">
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
                            <?php foreach($comment->user->getFollowers() as $subscriber):?>
                                <a href="
                                                            <?=Url::to(['/user/profile/view', 'nickname' => $subscriber['id']])?>">
                                    <div class="UserBlock">
                                        <div class="minAvatar" style="padding:0;">
                                            <img class="mimiatiura" src="
                                                                    <?=\frontend\models\User::getUserPhoto2($subscriber['id'])?>"
                                                 style=""
                                            >
                                        </div>
                                        <p style="padding-top:10px;">
                                            <?=Html::encode($subscriber['username'])?>
                                        </p>
                                    </div>

                                    <?php if (!$currentUser->isFollowersId($subscriber['id'])) : ?>
                                        <div class="subscribeButton">
                                            <a style="cursor:pointer" data-id="<?=$subscriber['id']?>" class="btnSubscribe btn btn-default">
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

        </div>
        <?php endforeach; ?>

        </div>

    </div>
    <div class="mainPage pagination">
        <div class="paginationWrap">
            <?php // display pagination
            echo LinkPager::widget([
                'pagination' => $pagination,
            ]);
            ?>
        </div>
</section>
<br>
<hr>

<!---------------------------------modal1--------------------------------------->
<div class="modalWindow">
    <div class="modalWrapper">
        <div class="modalHeader">
            <span class="closeBtn">&times;</span>
            <h3><?= Yii::t('post', 'Add new comment') ?></h3>
        </div>
        <div class="modalBody">
            <?php $form = ActiveForm::begin() ?>
            <div class="textArea">
                <?= $form->field($commentModel, 'comment')->textarea(['rows' => 8])->label('Add comment...') ?>
            </div>
        </div>
        <div class="modalFooter">
            <div class="wrap-button">
                <div class="button">
                    <a id="addCommentsButton" class="green" article-id="<?= $article->id ?>"
                       user-id="<?= Yii::$app->user->identity->getId() ?>">
                        <?= Yii::t('post', 'ADD COMMENT') ?>
                    </a>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
<!--------------------------------endModal1------------------------------------->

<section class="main-content newsList">
    <div class="wrap">
        <h2>NEEWS</h2>
        <div class="posts">
            <?php foreach ($articles as $art): ?>
                <div class="item-wrap">
                    <div class="item">
                        <div class="top">
                            <h4>
                                <a href="<?= Url::to(['/articles/news/view', 'id' => $art->id]) ?>"><?= $art->title ?></a>
                            </h4>
                        </div>
                        <div class="photo">
                            <a href="<?= Url::to(['/articles/news/view', 'id' => $art->id]) ?>">
                                <div class="pictureWrap">
                                    <img class="contentPhoto" src="<?= $art->getImage() ?>"
                                         alt="" title="">
                                </div>
                            </a>
                        </div>
                        <div class="text">
                            <p>
                                <?php
                                if (strlen($art->description) >= 100) {
                                    echo Yii::$app->stringHelper->getShort($art->description, 100) . '...';
                                }
                                ?>
                            </p>
                        </div>
                        <hr>
                        <div class="bottom">
                            <div class="likes">
                                <a
                                        class="button-like <?php echo $art->isLikesBy(Yii::$app->user->identity->getId()) ? "display-none" : ""; ?>"
                                        data-id="<?= $art->id ?>">
                                    <i class="far fa-heart"></i>&nbsp;
                                </a>
                                <a
                                        class="button-unlike <?php echo $art->isLikesBy(Yii::$app->user->identity->getId()) ? "" : "display-none"; ?>"
                                        data-id="<?= '' ?>">
                                    <i class="fas fa-heart"></i>&nbsp;
                                </a>
                                <span id="count1" class="likes-count" data-id="<?php echo '' ?>">
                                            <?php echo $art->likes_count ? $art->likes_count : 0 ?>
                                        </span>
                            </div>
                            <div class="comments">
                                <a href="<?=Url::to(['/articles/news/view', 'id'=>$art->id, '#' => 'comments'])?>"
                                style="color:#666;">
                                <i class="far fa-comment-alt"></i>
                                <?=\frontend\modules\articles\models\MainComments::CommentCount($art->id)?>
                                </a>
                            </div>
                            <div class="date">
                                <?= Yii::$app->formatter->asDate($art->date) ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2><a href="<?= Url::to(['/articles/news/index']) ?>">MORE NEEWS...</a></h2>
    </div>
</section>







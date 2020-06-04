<?php
/**
 * @var $post \frontend\models\Post;
 * @var $currentUser \frontend\models\User
 * @var $color \frontend\modules\post\controllers\DefaultController
 * @var $commentModel \frontend\models\forms\CommentAddForm
 * @var $comments \frontend\models\Comment
 * @var $comment \frontend\models\Comment
 * @var $commentsCount \frontend\models\Comment
 */


use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'view post #' . $post->id;
$this->color = $color;


$this->registerJsFile('@web/js/script.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/modal.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/editComment.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/postComments.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/ajaxSubscribe.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/myModal.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

?>

    <section class="onePost">
        <div class="wrapPost" id="photoView">
            <div class="wrap-button">
                <div class="button button-round cancel yellow">
                    <a href="javascript:history.back()"><?= Yii::t('post', 'BACK') ?></a>
                </div>
            </div>
            <h2><?= Yii::t('post', 'POST VIEW') ?></h2>
            <div class="authorInfo">
                <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($post->user->getNickname())]) ?>" class="">
                    <div class="author">
                        <div class="photo">
                            <img src="<?= Html::encode($post->user->getPicture()) ?>">
                        </div>
                        <div class="box">
                            <div class="authorN">
                                <b><?= Yii::t('post', 'Author') ?>:</b>
                            </div>
                            <div class="name"><b><?= $post->user->username ?></b></div>
                        </div>
                    </div>
                </a>

            </div>
            <hr>
            <div class="photo" id="photoPost">
                <div class="postPhoto" name="postPhoto">
                    <img src="<?php echo Html::encode($post->getImage()) ?>">
                </div>
            </div>
            <div class="text">
                <p>
                    <?php echo Html::encode($post->description) ?>
                </p>
            </div>
            <hr>
            <div class="postInfo">
                <div class="item likes">
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
                <div class="item comments">
                    <a href="#"><i class="fas fa-comment-alt"></i></a> <?= $commentsCount ?>
                </div>
                <div class="item date">
                    <b><?= Yii::t('post', 'create') ?>
                        :</b> <?= Html::encode(Yii::$app->formatter->asDatetime($post->created_at)) ?>
                </div>

                <?php if (Yii::$app->user->identity->getId() != $post->user_id): ?>
                    <div class="reportPost">
                        <?php if (!$post->isReported(Yii::$app->user->identity)): ?>
                            <a class="btn btn-danger button-complain"
                               data-id="<?= $post->id ?>" href="#"><?= Yii::t('post', 'Report post') ?>
                                <i class="fas fa-redo-alt icon-preloader" style="display:none;"></i>
                            </a>
                        <?php else: ?>
                            <span><?= Yii::t('post', 'Post has been reported') ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($post->updated_at)): ?>
                    <div class="item date">
                        <b><?= Yii::t('post', 'update') ?>
                            :</b> <?= Html::encode(Yii::$app->formatter->asDatetime($post->updated_at)) ?>
                    </div>
                <?php endif; ?>
            </div>
            <hr>
        </div>
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
                    <?= $form->field($commentModel, 'comment')->textarea(['autofocus']) ?>
                </div>
            </div>
            <div class="modalFooter">
                <div class="wrap-button">
                    <div class="button">
                        <a id="addCommentsButton" class="yellow" data-id="<?= $post->id ?>"
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
    <section class="postComments">

        <h2>COMMENTS:</h2>

        <div class="addComment">
            <div class="addCommentWrap">
                <div class="cancel wrap-button">
                    <div class="button button-round cancel yellow">
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
                                        echo 'color:#FF7B00;';
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
                                            <?php
                                            Modal::begin([

                                            ]);
                                            foreach ($comment->user->getFollowers() as $follower) {
                                                echo '<a href="' .
                                                    Url::to(['/user/profile/view', 'nickname' => $follower['id']])
                                                    . '">' . Html::encode($follower['username']) . '</a>' . '<br>';
                                            }

                                            Modal::end();
                                            ?>

                                        </a></div>
                                    |
                                    <div class="subscriber">
                                    <a href="myModalUser-<?=$comment->user->id?>" style="cursor:pointer;" data-toggle="myModal" data-target="#myModalUser-<?=$comment->user->id?>"><?=Yii::t('my page', 'subscribed to {followers} users', [
                                                        'followers' => $comment->user->countSubscribers()
                                                    ])?></a>
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

                                        </div>
                                </div>
                            </div>
                            <div class="nickname">
                                <b><?= Yii::t('post', 'nickname') ?>:</b>
                                <?= Html::encode(($comment->user->nickname) ? $comment->user->nickname : Yii::t('post', 'No nickname')) ?>
                            </div>
                            <div class="userDate">
                                <b><?= Yii::t('post', 'Comment added') ?>:</b> <?= Yii::$app->formatter->asDatetime($comment->created_at) ?>
                            </div>
                        </div>
                        <div class="editButtons">
                            <?php if ($comment->user_id == $currentUser->getId()): ?>
                                <a class="deleteCommentButton" data-toggle="myModal" data-target="#myModal-<?=$comment->id?>" title="delete comment">&times;</a>
                                <!---------------------------------modalEdit--------------------------------------->
                                <div id="myModal-<?=$comment->id?>" class="myModal">
                                    <div class="myModal-dialog">
                                        <div class="myModal-content">
                                            <div class="myModal-header">
                                                <h3 class="myModal-title" style="color:#555;">Удаление комментария</h3>
                                                <a href="#" title="Закрыть" class="modalClose" data-close="myModal">&times;</a>
                                            </div>
                                            <div class="myModal-body">
                                                <p style="color:#666;">Вы действительно хотите удалить этот комментарий:</p>
                                                <br>
                                                <?=$comment->comment?>
                                                <br><br>
                                                <a href="#" id="submitButton" data-commentAuthor="<?=$comment->user_id?>" data-userId="<?=$currentUser->getId()?>" post-id="<?=$post->id?>" data-id="<?=$comment->id?>" class="btn btn-danger" data-close="myModal">Да</a>
                                                <a href="#" title="Закрыть" class="btn btn-info" data-close="myModal">Нет, я передумал</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--------------------------------endModalEdit------------------------------------->
                            <?php elseif ($post->user_id == $currentUser->getId()): ?>
                                <a class="deleteCommentButton" data-toggle="myModal" data-target="#myModal-<?=$comment->id?>" title="delete comment">&times;</a>
                                <!---------------------------------modalEdit--------------------------------------->
                                <div id="myModal-<?=$comment->id?>" class="myModal">
                                    <div class="myModal-dialog">
                                        <div class="myModal-content">
                                            <div class="myModal-header">
                                                <h3 class="myModal-title" style="color:#555;">Удаление комментария</h3>
                                                <a href="#" title="Закрыть" class="modalClose" data-close="myModal">&times;</a>
                                            </div>
                                            <div class="myModal-body">
                                                <p style="color:#666;">Вы действительно хотите удалить этот комментарий:</p>
                                                <br>
                                                <?=$comment->comment?>
                                                <br><br>
                                                <a href="#" id="submitButton" data-commentAuthor="<?=$comment->user_id?>" data-userId="<?=$currentUser->getId()?>" post-id="<?=$post->id?>" data-id="<?=$comment->id?>" class="btn btn-danger" data-close="myModal">Да</a>
                                                <a href="#" title="Закрыть" class="btn btn-info" data-close="myModal">Нет, я передумал</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--------------------------------endModalEdit------------------------------------->
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="commentText">
                        <p <?php
                        if ($comment->user->id == $post->user->id) {
                            echo 'style="color:#FF7B00;"';
                        }
                        ?>
                            <?php if ($comment->user->id == $currentUser->id) {
                                echo 'style="color:red; font-weight:bold;"';
                            } ?>
                        >
                            <i>
                                <?= Html::encode($comment->comment) ?></i>
                        </p>
                    </div>
                    <hr>
                </div>
            <?php endforeach; ?>
            <!--            <div class="pagination">-->
            <!--                <div class="paginationWrap">-->
            <!--                    <a href="#" class="yellow">-->
            <!--                        <div class="box left">&lt;</div>-->
            <!--                    </a>-->
            <!--                    <a href="#" class="yellow">-->
            <!--                        <div class="box pageNumber">1</div>-->
            <!--                    </a>-->
            <!--                    <a href="#" class="yellow">-->
            <!--                        <div class="box active pageNumber">2</div>-->
            <!--                    </a>-->
            <!--                    <a href="#" class="yellow">-->
            <!--                        <div class="box pageNumber">3</div>-->
            <!--                    </a>-->
            <!--                    <a href="#" class="yellow">-->
            <!--                        <div class="box right">&gt;</div>-->
            <!--                    </a>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>

    </section>


<?php
$this->registerJsFile('@web/js/complain.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);




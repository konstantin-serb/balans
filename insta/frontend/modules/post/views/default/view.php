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

$this->registerJsFile('@web/js/postComments.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

?>

    <section class="onePost">
        <div class="wrapPost" id="photoView">
            <div class="wrap-button">
                <div class="button button-round cancel yellow">
                    <a href="javascript:history.back()"><?=Yii::t('post', 'BACK')?></a>
                </div>
            </div>
            <h2><?=Yii::t('post', 'POST VIEW')?></h2>
            <div class="authorInfo">
                <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($post->user->getNickname())]) ?>" class="">
                    <div class="author">
                        <div class="photo">
                            <img src="<?= Html::encode($post->user->getPicture()) ?>">
                        </div>
                        <div class="box">
                            <div class="authorN">
                                <b><?=Yii::t('post', 'Author')?>:</b>
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
                    <a href="#"><i
                                class="fas fa-heart"></i></a> <?= (!empty($post->postLikes->count1)) ? $post->postLikes->count1 : 0 ?>
                    <a href="#"></a>
                </div>
                <div class="item comments">
                    <a href="#"><i class="fas fa-comment-alt"></i></a> <?=$commentsCount?>
                </div>
                <div class="item date">
                    <b><?=Yii::t('post',  'create')?>:</b> <?= Html::encode(Yii::$app->formatter->asDatetime($post->created_at)) ?>
                </div>

                <?php if(Yii::$app->user->identity->getId() != $post->user_id):?>
                <div class="reportPost">
                    <?php if(!$post->isReported(Yii::$app->user->identity)):?>
                    <a class="btn btn-danger button-complain" 
                       data-id="<?=$post->id?>" href="#"><?=Yii::t('post', 'Report post')?>
                        <i class="fas fa-redo-alt icon-preloader" style="display:none;"></i>
                    </a>
                    <?php else:?>
                    <span><?=Yii::t('post','Post has been reported')?></span>
                    <?php endif;?>
                </div>
                <?php endif;?>

                <?php if (!empty($post->updated_at)): ?>
                    <div class="item date">
                        <b><?=Yii::t('post', 'update')?>:</b> <?= Html::encode(Yii::$app->formatter->asDatetime($post->updated_at)) ?>
                    </div>
                <?php endif; ?>
            </div>
            <hr>
        </div>
    </section>
    <section class="blurbHoriz">
        <div class="blurb horizontal">
            <h4>Здесь может быть ваша реклама</h4>
        </div>
    </section>

    <!---------------------------------modal1--------------------------------------->
    <div class="modalWindow">
        <div class="modalWrapper">
            <div class="modalHeader">
                <span class="closeBtn">&times;</span>
                <h3><?=Yii::t('post', 'Add new comment')?></h3>
            </div>
            <div class="modalBody">
                <?php $form = ActiveForm::begin()?>
                <div class="textArea">
                    <?=$form->field($commentModel, 'comment')->textarea(['autofocus'])?>
                </div>
            </div>
            <div class="modalFooter">
                <div class="wrap-button">
                    <div class="button">
                        <a id="addCommentsButton" class="yellow" data-id="<?=$post->id?>" user-id="<?=Yii::$app->user->identity->getId()?>">
                            <?=Yii::t('post','ADD COMMENT')?>
                        </a>
                    </div>
                </div>
                <?php ActiveForm::end()?>
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
                        <a id="buttonComment"><?=Yii::t('post', 'ADD COMMENT')?></a>
                    </div>
                </div>
            </div>
        </div>

        <div id="comments">
            <?php foreach($comments as $comment):?>
                <div class="comment">
                    <div class="commentInfo">
                        <div class="userPhoto">
                            <a href="<?=Url::to(['/user/profile/view',
                                'nickname' => $comment->user->getNickname()])?>">
                                <img src="<?=$comment->user->getPicture()?>" style="text-align: center; display: block;
    height: 100%; max-width: unset; margin: 0 auto;">
                            </a>
                        </div>
                        <div class="dataBlock">
                            <div class="name-info">
                                <div class="name"><a class="" <?php
                                    if($comment->user->id == $post->user->id){
                                        echo 'style="color:#FF7B00;"';
                                    }
                                    ?> href="<?=Url::to(['/user/profile/view',
                                        'nickname' => $comment->user->getNickname()])?>">
                                        <?=Html::encode($comment->user->username)?>:</a></div>
                                <div class="info">
                                    <div class="posts"><?=$comment->user->rating?> <?=Yii::t('my page', 'posts')?></div>
                                    <div class="followers"><a href="#"><?=$comment->user->countFollowers()?> <?=Yii::t('my page', 'subscribers')?></a></div>
                                    <div class="subscriber"><a href="#">
                                            <?=Yii::t('my page', 'subscribed to {followers} users',[
                                                'followers' => $comment->user->countSubscribers()
                                            ])?>
                                        </a></div>
                                    <!--                            <div class="friends"><a href="#"> общих друзей</a></div>-->
                                </div>
                            </div>
                            <div class="nickname">
                                <b><?=Yii::t('post', 'nickname')?>:</b> <?=Html::encode(($comment->user->nickname) ? $comment->user->nickname : Yii::t('post', 'No nickname'))?>
                            </div>
                            <div class="userDate">
                                <b><?=Yii::t('post', 'Comment added')?>:</b> <?=Yii::$app->formatter->asDatetime($comment->created_at)?>
                            </div>
                        </div>
                    </div>
                    <!--            <hr>-->
                    <div class="commentText">
                        <p <?php
                        if($comment->user->id == $post->user->id){
                            echo 'style="color:#FF7B00;"';
                        }
                        ?>
                            <?php if($comment->user->id == $currentUser->id){
                                echo 'style="color:red; font-weight:bold;"';
                            }?>
                        >
                            <i>
                                <?=Html::encode($comment->comment)?></i>
                        </p>
                    </div>
                    <hr>
                </div>
            <?php endforeach;?>
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




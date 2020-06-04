<?php

/**
 * @var $user \frontend\models\User
 * @var $currentUser \frontend\models\User
 * @var $modelPicture \frontend\models\forms\PictureForm
 * @var $posts \frontend\models\Post
 * @var $post \frontend\models\Post
 * @var $color \frontend\modules\user\controllers\ProfileController
 * @var $title \frontend\modules\user\controllers\ProfileController
 * @var $messages \frontend\models\CommentReport
 * @var $oneMessage \frontend\models\CommentReport
 */


use yii\helpers\Url;

$this->color = $color;

$this->registerJsFile('@web/js/messagesControl.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

?>

<h1>My messages</h1>


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

<section id="messagesReport">
    <?php if ($messages): ?>
        <section class="commentMessages">
            <div class="wrap">
                <h2>Новые комментарии к вашим постам:</h2>
                <br>
                <table class="table table-condensed">
                    <tr>
                        <th>Post photo:</th>
                        <th>Message</th>
                        <th>date</th>
                        <th>action</th>
                    </tr>
                    <?php foreach ($messages as $oneMessage): ?>
                        <tr>
                            <td><a href="<?=Url::to(['/post/default/view/', 'id' => $oneMessage->post_id, '#' => 'photoView'])?>">
                                    <img src="<?=$oneMessage->getPostImage($oneMessage->post_id)?>" class="" style="width:100px;">
                                </a>
                            </td>
                            <td>Пользователь <a href="<?=Url::to(['/user/profile/view/', 'nickname' => $oneMessage->commentator])?>">
                                    <b><?=$oneMessage->getUserName($oneMessage->commentator)?></b>
                                </a>
                                добавил комментарий:
                                <a href="<?=Url::to(['/post/default/view/', 'id' => $oneMessage->post_id, '#' => 'comments'])?>">
                                    "<b><?=$oneMessage->comment?></b>"
                                </a>
                            </td>
                            <td><?=Yii::$app->formatter->asDatetime($oneMessage->created_at)?></td>
                            <td><a class="dell" id="btn-del" data-DelId="<?=$oneMessage->id?>">
                                    <span class="deleteMessage">&times;</span>
                                </a>
                                <a class="approve" id="btn-approve" data-id="<?=$oneMessage->id?>">
<!--                                    <span class="glyphicon glyphicon-ok"></span>-->
                            </td>
                            </a>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>
    <?php endif; ?>
</section>










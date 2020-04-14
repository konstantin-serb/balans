<?php
/**
 * @var $post \frontend\models\Post;
 * @var $currentUser \frontend\models\User
 * @var $color \frontend\modules\post\controllers\DefaultController
 */


use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'view post #' . $post->id;
$this->color = $color;


$this->registerJsFile('@web/js/script.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

$this->registerJsFile('@web/js/likes.js', [
    'depends' => \yii\web\JqueryAsset::class,
]);

?>

    <section class="onePost">
        <div class="wrapPost">
            <div class="wrap-button">
                <div class="button button-round cancel yellow">
                    <a href="javascript:history.back()">BACK</a>
                </div>
            </div>
            <h2>POST VIEW</h2>
            <div class="authorInfo">
                <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($post->user->getNickname())]) ?>" class="">
                    <div class="author">
                        <div class="photo">
                            <img src="<?=Html::encode($post->user->getPicture())?>">
                        </div>
                        <div class="box">
                            <div class="authorN">
                                <b>Author:</b>
                            </div>
                            <div class="name"><b><?=$post->user->username?></b></div>
                        </div>
                    </div>
                </a>

            </div>
            <hr>
            <div class="photo">
                <div class="postPhoto" name="postPhoto">
                    <img src="<?php echo Html::encode($post->getImage())?>">
                </div>
            </div>
            <div class="text">
                <p>
                    <?php echo Html::encode($post->description)?>
                </p>
            </div>
            <hr>
            <div class="postInfo">
                <div class="item likes">
                    <a href="#"><i class="fas fa-heart"></i></a> <?=(!empty($post->postLikes->count1)) ? $post->postLikes->count1 : 0?><a href="#"></a>
                </div>
                <div class="item comments">
                    <a href="#"><i class="fas fa-comment-alt"></i></a> 15
                </div>
                <div class="item date">
                    <b>create:</b> <?=Html::encode(Yii::$app->formatter->asDatetime($post->created_at))?>
                </div>
                <?php if(!empty($post->updated_at)):?>
                <div class="item date">
                    <b>update:</b> <?=Html::encode(Yii::$app->formatter->asDatetime($post->updated_at))?>
                </div>
                <?php endif;?>
            </div>
            <hr>
        </div>
    </section>
    <section class="blurbHoriz">
        <div class="blurb horizontal">
            <h4>Здесь может быть ваша реклама</h4>
        </div>
    </section>
    <section class="postComments">
        <div class="cancel wrap-button">
            <div class="button button-round cancel yellow">
                <a href="javascript:history.back()">BACK</a>
            </div>
        </div>
        <h2>COMMENTS:</h2>
        <div class="comment">
            <div class="commentInfo">
                <div class="userPhoto">
                    <a href="#">
                        <img src="img/c6381b92-6b73-4f58-b6c3-4a6927bf5eab.jpg">
                    </a>
                </div>
                <div class="dataBlock">
                    <div class="name-info">
                        <div class="name"><a href="#">Пупкин Степан:</a></div>
                        <div class="info">
                            <div class="posts">16 постов</div>
                            <div class="followers"><a href="#">15 подписчиков</a></div>
                            <div class="subscriber"><a href="#">на 10 подписан</a></div>
                            <div class="friends"><a href="#">5 общих друзей</a></div>
                        </div>
                    </div>
                    <div class="nickname">
                        <b>nickname:</b> @stepanPupkin
                    </div>
                    <div class="userDate">
                        <b>Комментарий оставлен:</b> 2020 15 mart.
                    </div>
                </div>
            </div>
            <div class="commentText">
                <p>
                    Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей
                    деятельности способствует подготовки и реализации форм развития. Задача организации, в особенности же
                    постоянный количественный рост и сфера нашей активности влечет за собой процесс внедрения и модернизации
                    новых предложений. Не следует, однако забывать, что постоянное информационно-пропагандистское обеспечение
                    нашей деятельности позволяет оценить значение системы обучения кадров, соответствует насущным потребностям.
                    Равным образом постоянный количественный рост и сфера нашей активности в значительной степени обуславливает
                    создание существенных финансовых и административных условий. Равным образом сложившаяся структура
                    организации позволяет оценить значение соответствующий условий активизации.
                </p>
            </div>
            <hr>
        </div>
        <div class="comment">
            <div class="commentInfo">
                <div class="userPhoto">
                    <a href="#">
                        <img src="img/c6381b92-6b73-4f58-b6c3-4a6927bf5eab.jpg">
                    </a>
                </div>
                <div class="dataBlock">
                    <div class="name-info">
                        <div class="name"><a href="#">Пупкин Степан:</a></div>
                        <div class="info">
                            <div class="posts">16 постов</div>
                            <div class="followers"><a href="#">15 подписчиков</a></div>
                            <div class="subscriber"><a href="#">на 10 подписан</a></div>
                            <div class="friends"><a href="#">5 общих друзей</a></div>
                        </div>
                    </div>
                    <div class="nickname">
                        <b>nickname:</b> @stepanPupkin
                    </div>
                    <div class="userDate">
                        <b>Комментарий оставлен:</b> 2020 15 mart.
                    </div>
                </div>
            </div>
            <div class="commentText">
                <p>
                    Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей
                    деятельности способствует подготовки и реализации форм развития. Задача организации, в особенности же
                    постоянный количественный рост и сфера нашей активности влечет за собой процесс внедрения и модернизации
                    новых предложений. Не следует, однако забывать, что постоянное информационно-пропагандистское обеспечение
                    нашей деятельности позволяет оценить значение системы обучения кадров, соответствует насущным потребностям.
                    Равным образом постоянный количественный рост и сфера нашей активности в значительной степени обуславливает
                    создание существенных финансовых и административных условий. Равным образом сложившаяся структура
                    организации позволяет оценить значение соответствующий условий активизации.
                </p>
            </div>
            <hr>
        </div>
        <div class="comment">
            <div class="commentInfo">
                <div class="userPhoto">
                    <a href="#">
                        <img src="img/c6381b92-6b73-4f58-b6c3-4a6927bf5eab.jpg">
                    </a>
                </div>
                <div class="dataBlock">
                    <div class="name-info">
                        <div class="name"><a href="#">Пупкин Степан:</a></div>
                        <div class="info">
                            <div class="posts">16 постов</div>
                            <div class="followers"><a href="#">15 подписчиков</a></div>
                            <div class="subscriber"><a href="#">на 10 подписан</a></div>
                            <div class="friends"><a href="#">5 общих друзей</a></div>
                        </div>
                    </div>
                    <div class="nickname">
                        <b>nickname:</b> @stepanPupkin
                    </div>
                    <div class="userDate">
                        <b>Комментарий оставлен:</b> 2020 15 mart.
                    </div>
                </div>
            </div>
            <div class="commentText">
                <p>
                    Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей
                    деятельности способствует подготовки и реализации форм развития. Задача организации, в особенности же
                    постоянный количественный рост и сфера нашей активности влечет за собой процесс внедрения и модернизации
                    новых предложений. Не следует, однако забывать, что постоянное информационно-пропагандистское обеспечение
                    нашей деятельности позволяет оценить значение системы обучения кадров, соответствует насущным потребностям.
                    Равным образом постоянный количественный рост и сфера нашей активности в значительной степени обуславливает
                    создание существенных финансовых и административных условий. Равным образом сложившаяся структура
                    организации позволяет оценить значение соответствующий условий активизации.
                </p>
            </div>
            <hr>
        </div>
        <div class="comment">
            <div class="commentInfo">
                <div class="userPhoto">
                    <a href="#">
                        <img src="img/c6381b92-6b73-4f58-b6c3-4a6927bf5eab.jpg">
                    </a>
                </div>
                <div class="dataBlock">
                    <div class="name-info">
                        <div class="name"><a href="#">Пупкин Степан:</a></div>
                        <div class="info">
                            <div class="posts">16 постов</div>
                            <div class="followers"><a href="#">15 подписчиков</a></div>
                            <div class="subscriber"><a href="#">на 10 подписан</a></div>
                            <div class="friends"><a href="#">5 общих друзей</a></div>
                        </div>
                    </div>
                    <div class="nickname">
                        <b>nickname:</b> @stepanPupkin
                    </div>
                    <div class="userDate">
                        <b>Комментарий оставлен:</b> 2020 15 mart.
                    </div>
                </div>
            </div>
            <div class="commentText">
                <p>
                    Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей
                    деятельности способствует подготовки и реализации форм развития. Задача организации, в особенности же
                    постоянный количественный рост и сфера нашей активности влечет за собой процесс внедрения и модернизации
                    новых предложений. Не следует, однако забывать, что постоянное информационно-пропагандистское обеспечение
                    нашей деятельности позволяет оценить значение системы обучения кадров, соответствует насущным потребностям.
                    Равным образом постоянный количественный рост и сфера нашей активности в значительной степени обуславливает
                    создание существенных финансовых и административных условий. Равным образом сложившаяся структура
                    организации позволяет оценить значение соответствующий условий активизации.
                </p>
            </div>
            <hr>
        </div>
        <div class="comment">
            <div class="commentInfo">
                <div class="userPhoto">
                    <a href="#">
                        <img src="img/c6381b92-6b73-4f58-b6c3-4a6927bf5eab.jpg">
                    </a>
                </div>
                <div class="dataBlock">
                    <div class="name-info">
                        <div class="name"><a href="#">Пупкин Степан:</a></div>
                        <div class="info">
                            <div class="posts">16 постов</div>
                            <div class="followers"><a href="#">15 подписчиков</a></div>
                            <div class="subscriber"><a href="#">на 10 подписан</a></div>
                            <div class="friends"><a href="#">5 общих друзей</a></div>
                        </div>
                    </div>
                    <div class="nickname">
                        <b>nickname:</b> @stepanPupkin
                    </div>
                    <div class="userDate">
                        <b>Комментарий оставлен:</b> 2020 15 mart.
                    </div>
                </div>
            </div>
            <div class="commentText">
                <p>
                    Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей
                    деятельности способствует подготовки и реализации форм развития. Задача организации, в особенности же
                    постоянный количественный рост и сфера нашей активности влечет за собой процесс внедрения и модернизации
                    новых предложений. Не следует, однако забывать, что постоянное информационно-пропагандистское обеспечение
                    нашей деятельности позволяет оценить значение системы обучения кадров, соответствует насущным потребностям.
                    Равным образом постоянный количественный рост и сфера нашей активности в значительной степени обуславливает
                    создание существенных финансовых и административных условий. Равным образом сложившаяся структура
                    организации позволяет оценить значение соответствующий условий активизации.
                </p>
            </div>
            <hr>
        </div>

        <div class="pagination">
            <div class="paginationWrap">
                <a href="#" class="yellow">
                    <div class="box left">&lt;</div>
                </a>
                <a href="#" class="yellow">
                    <div class="box pageNumber">1</div>
                </a>
                <a href="#" class="yellow">
                    <div class="box active pageNumber">2</div>
                </a>
                <a href="#" class="yellow">
                    <div class="box pageNumber">3</div>
                </a>
                <a href="#" class="yellow">
                    <div class="box right">&gt;</div>
                </a>
            </div>
        </div>

    </section>
    <section class="addComment">
        <div class="addCommentWrap">
            <form method="post">
                <h2>ADD COMMENT:</h2>
                <div class="textArea">
                    <textarea rows="10"></textarea>
                </div>
                <div class="wrap-button">
                    <div class="button">
                        <a class="yellow" href="#">ADD COMMENT</a>
                    </div>
                </div>
            </form>
        </div>
    </section>



<div class="post-default-index">

    <div class="row">
        <div class="col-md-12">
            <?php if($post->user):?>
            <p>Avthor: </p>
            <?php endif;?>
            <img src=""><br><br>
        </div>

        <div class="col-md-12">

        </div>
        <div class="col-md-12">
            Likes: <span id="count1" class="likes-count"><?php echo $post->countLikes(); ?></span>
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <a href="#" class="btn btn-primary button-like <?=($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""?>" data-id="<?php echo $post->id?>">
            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>
        <a href="#" class="btn btn-danger button-unlike <?=($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"?>" data-id="<?=$post->id?>">
            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>
    </div>
</div>




<?php

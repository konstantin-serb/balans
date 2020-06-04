<?php
/**
 * @var $color \frontend\controllers\SiteController
 * @var $title \frontend\controllers\SiteController
 * @var $bestPosts \frontend\models\Post
 * @var $post \frontend\models\Post
 * @var $bestAuthors User
 * @var $bestAuthor User
 * @var $newbiesAuthors User
 * @var $newbiesAuthor User
 * @var $articles \frontend\models\Articles
 * @var $article \frontend\models\Articles
 * @var $articleFirst \frontend\models\Articles
 * @var $horizontalBlurb \frontend\models\Blurb
 */


use frontend\models\User;
use yii\helpers\Url;

$this->color = $color;
$this->title = $title;
?>

<?php if (!empty($horizontalBlurb)): ?>
    <section>
        <div class="blurb horizontal">
            <a href="http:\\<?= $horizontalBlurb->url ?>" target="_blank">
                <div class="blurb-content">
                    <p class="fig">
                        <img src="<?= Yii::$app->params['blurb'] . $horizontalBlurb->photo ?>">

                    </p>
                    <div class="text">
                        <?= $horizontalBlurb->text ?>
                    </div>

                </div>

            </a>
        </div>
    </section>
<?php endif; ?>
<?php if (!empty($articles)): ?>
    <section class="mainBlog">
        <div class="news">
            <h2><a href="<?= Url::to(['/articles/news/index']) ?>"><?= Yii::t('home', 'NEWS') ?></a></h2>
            <div class="Blogwrap">
                <div class="newsBlock">
                    <div class="leftBlock">
                        <h3>
                            <a href="<?= Url::to(['/articles/news/view', 'id' => $articleFirst->id]) ?>">
                                <?= $articleFirst->title ?>
                            </a>
                        </h3>

                        <div class="firstArticlePhoto">
                            <div class="wrap-image">
                                <a href="<?= Url::to(['/articles/news/view', 'id' => $articleFirst->id]) ?>">
                                    <img class="contentPhoto" src="<?= $articleFirst->getImage($articleFirst->image) ?>"
                                         alt=""
                                         title="">
                                </a>
                            </div>


                        </div>

                        <p>
                            <?= $articleFirst->description ?>
                        </p>
                        <hr>
                        <div class="bottom">
                            <div class="likes">
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <a
                                            class="button-like <?php echo $articleFirst->isLikesBy(Yii::$app->user->identity->getId()) ? "display-none" : ""; ?>"
                                            data-id="<?= $articleFirst->id ?>">
                                        <i class="far fa-heart"></i>&nbsp;
                                    </a>
                                    <a
                                            class="button-unlike <?php echo $articleFirst->isLikesBy(Yii::$app->user->identity->getId()) ? "" : "display-none"; ?>"
                                            data-id="<?= '' ?>">
                                        <i class="fas fa-heart"></i>&nbsp;
                                    </a>
                                <?php endif; ?>
                                <?php if (Yii::$app->user->isGuest): ?>
                                    <i class="far fa-heart"></i>&nbsp;
                                <?php endif; ?>
                                <span id="count1" class="likes-count" data-id="<?php echo '' ?>">
                                            <?php echo $articleFirst->likes_count ? $articleFirst->likes_count : 0 ?>
                                        </span>
                            </div>
                            <div class="comments">
                                <a href="<?= Url::to(['/articles/news/view', 'id' => $articleFirst->id, '#' => 'comments']) ?>">
                                    <i class="far fa-comment-alt"></i> <?= \frontend\modules\articles\models\MainComments::CommentCount($articleFirst->id) ?>
                                </a>
                            </div>
                            <div class="date">
                                <?= Yii::$app->formatter->asDatetime($articleFirst->date) ?>
                            </div>
                        </div>

                    </div>
                    <div class="rightBlock">
                        <?php foreach ($articles as $article): ?>
                            <div class="blogsItem">
                                <h3>
                                    <a href="<?= Url::to(['/articles/news/view', 'id' => $articleFirst->id]) ?>">
                                        <?= $article->title ?>
                                    </a>
                                </h3>
                                <a href="<?= Url::to(['/articles/news/view', 'id' => $article->id]) ?>">
                                    <div class="wrap">
                                        <div class="innerPhoto">
                                            <img src="<?= $article->getImage($article->image) ?>" alt="" title="">
                                        </div>
                                        <div class="innerText">
                                            <?= $article->description ?>
                                        </div>
                                    </div>
                                </a>
                                <hr>
                                <div class="bottom">
                                    <div class="likes">
                                        <?php if (!Yii::$app->user->isGuest): ?>
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
                                        <?php endif; ?>
                                        <?php if (Yii::$app->user->isGuest): ?>
                                            <i class="far fa-heart"></i>&nbsp;
                                        <?php endif; ?>
                                        <span id="count1" class="likes-count" data-id="<?php echo '' ?>">
                                            <?php echo $article->likes_count ? $article->likes_count : 0 ?>
                                        </span>
                                    </div>
                                    <div class="comments">

                                        <a href="<?= Url::to(['/articles/news/view', 'id' => $article->id, '#' => 'comments']) ?>">
                                            <i class="far fa-comment-alt"></i> <?= \frontend\modules\articles\models\MainComments::CommentCount($article->id) ?>
                                        </a>
                                    </div>
                                    <div class="date">
                                        <?= Yii::$app->formatter->asDatetime($article->date) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (!empty($verticalBlurb)): ?>
                    <div class="blurb vertical">
                        <a href="http:\\<?= $verticalBlurb->url ?>" target="_blank">
                            <div class="blurb-content">
                                <p class="fig">
                                    <img src="<?= Yii::$app->params['blurb'] . $verticalBlurb->photo ?>">

                                </p>
                                <div class="text">
                                    <?= $verticalBlurb->text ?>
                                </div>

                            </div>

                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
    <?php if (!empty($verticalHorizontalBlurb)): ?>
    <section>
        <div class="blurb horizontal vertical-horizontal">
            <a href="http:\\<?= $verticalHorizontalBlurb->url ?>" target="_blank">
                <div class="blurb-content">
                    <p class="fig">
                        <img src="<?= Yii::$app->params['blurb'] . $verticalHorizontalBlurb->photo ?>">

                    </p>
                    <div class="text">
                        <?= $verticalHorizontalBlurb->text ?>
                    </div>

                </div>

            </a>
        </div>
    </section>
    <?php endif; ?>
<?php endif; ?>
<?php if (!Yii::$app->user->isGuest): ?>
    <section class="newsFeed">
        <div class="wrap">
            <h2><?= Yii::t('home', 'MOST POPULAR') ?></h2>
            <h3><?= Yii::t('home', 'posts with the most likes') ?>:</h3>
            <div class="posts">
                <?php foreach ($bestPosts as $post): ?>
                    <div class="item-wrap">
                        <div class="item">
                            <div class="top">
                                <a href="<?= Url::to(['/user/profile/view', 'nickname' => $post->user_id]) ?>">
                                    <div class="authorPhoto">
                                        <img class="autPhoto" src="<?= $post->authorPhoto($post->user_id) ?>">
                                    </div>
                                    <span class="autopName">&nbsp;&nbsp;<?= $post->authorName($post->user_id) ?></span>
                                </a>
                            </div>
                            <div class="photo">
                                <a href="<?= Url::to(['/post/default/view', 'id' => $post->id, '#' => 'photoPost']) ?>"
                                   title="Подробнее...">
                                    <div class="pictureWrap">
                                        <img class="contentPhoto" src="<?= $post->getImage() ?>" alt=""
                                             title="">
                                    </div>
                                </a>
                                <p>
                                    <?= $post->description ?>
                                </p>
                            </div>
                            <hr>
                            <div class="bottom">
                                <div class="likes">
                                    <i class="far fa-heart"></i> <?= $post->countLikes() ?>
                                </div>
                                <div class="comments">
                                    <i class="far fa-comment-alt"></i> <?= $post->getCountComments() ?>
                                </div>
                                <div class="date">
                                    <?= Yii::$app->formatter->asDate($post->created_at) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section class="hallOfFame">
        <div class="wrap">
            <h2><?= Yii::t('home', 'HALL OF FAME') ?></h2>
            <h3 class="white"><?= Yii::t('home', 'The users who created the most posts') ?>:</h3>
            <div class="posts">
                <?php foreach ($bestAuthors as $bestAuthor): ?>
                    <div class="item-wrap">
                        <div class="itemUser">
                            <div class="nameAutor">
                                <a href="<?= Url::to(['/user/profile/view', 'nickname' => $bestAuthor->getNickname()]) ?>">
                                    <h3><?= $bestAuthor->username ?></h3>
                                </a>
                            </div>
                            <div class="photo">
                                <div class="pictureWrap">
                                    <a href="<?= Url::to(['/user/profile/view', 'nickname' => $bestAuthor->getNickname()]) ?>"
                                       title="<?= $bestAuthor->username ?>"><img class="contentPhoto"
                                                                                 src="<?= $bestAuthor->getPicture() ?>"
                                                                                 alt=""
                                                                                 title=""></a>
                                </div>
                                <div class="about-text">
                                    <p>
                                        <?= $bestAuthor->about ?>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="bottom">
                                <div class="countPosts">
                                    Posts: <?= $bestAuthor->rating ?>
                                </div>
                                <div class="likes">
                                    <!--                            <a href="#" title="subscribe"><i class="fas fa-heart active"></i></a> <a href="#" title="followers">30</a>-->
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- ----------------Modal--------------------->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Modal window!</p>
            </div>
        </div>

        <!---------------------end Modal------------------->
    </section>
    <!--<button id="myBtn">Open Modal</button>-->

    <section class="newBies">
        <div class="wrap">
            <h2><?= Yii::t('home', 'NEWBIES') ?></h2>
            <h3><?= Yii::t('home', 'Last join us') ?>:</h3>
            <div class="posts">
                <?php foreach ($newbiesAuthors as $newbiesAuthor): ?>
                    <div class="item-wrap">
                        <div class="itemUser">
                            <div class="nameAutor">
                                <a href="<?= Url::to(['/user/profile/view', 'nickname' => $newbiesAuthor->getNickname()]) ?>">
                                    <h3><?= $newbiesAuthor->username ?></h3>
                                </a>
                            </div>
                            <div class="photo">
                                <div class="pictureWrap">
                                    <a href="<?= Url::to(['/user/profile/view', 'nickname' => $newbiesAuthor->getNickname()]) ?>"
                                       title=""><img class="contentPhoto" src="<?= $newbiesAuthor->getPicture() ?>"
                                                     alt=""
                                                     title=""></a>
                                </div>
                                <div class="about-text">
                                    <p>
                                        <?= \yii\helpers\Html::encode($newbiesAuthor->about) ?>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="bottom">
                                <div class="countPosts">
                                    <?= Yii::t('home', 'Posts') ?>: <?= $newbiesAuthor->rating ?>
                                </div>
                                <div class="likes">
                                    <!--                            <a href="#" title="subscribe"><i class="fas fa-heart active"></i></a> <a href="#" title="followers">30</a>-->
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (Yii::$app->user->isGuest): ?>
    <section class="homeRegister">
        <div class="regWrap">
            <h2><?= Yii::t('home', 'SIGNUP') ?></h2>
            <h3><?= Yii::t('home', 'For those who want to join!') ?></h3>
            <div class="wrap-button">
                <div class="button button-round">
                    <a class="<?= $color ?>" href="<?= Url::to(['/user/default/signup']) ?>">SIGNUP</a>
                </div>
            </div>


        </div>
    </section>
<?php endif;

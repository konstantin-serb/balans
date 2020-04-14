<?php
/**
 * @var $color \frontend\controllers\SiteController
 * @var $title \frontend\controllers\SiteController
 * @var $bestAuthors User
 * @var $bestAuthor User
 * @var $newbiesAuthors User
 * @var $newbiesAuthor User
 */


use frontend\models\User;
use yii\helpers\Url;

$this->color = $color;
$this->title = $title;
?>

<section>
    <div class="blurb horizontal">
        <h4>Здесь может быть ваша реклама</h4>
    </div>
</section>
<section class="mainBlog">
    <div class="news">
        <h2>NEWS</h2>
        <div class="Blogwrap">
            <div class="newsBlock">
                <div class="leftBlock">
                    <h3>Title posts of the blog</h3>
                    <a href="#">
                        <div class="photo">
                            <div class="">
                                <div class="wrap-image">
                                    <img class="contentPhoto" src="/img/f83e70800d582414f80a189965f62d48964b.jpg" alt=""
                                         title="">
                                </div>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium corporis dolore ea
                                error eum eveniet hic, id porro quas rem....
                            </p>
                        </div>
                    </a>
                    <hr>
                    <div class="bottom">
                        <div class="likes">
                            <i class="fas fa-heart active"></i> 3
                        </div>
                        <div class="comments">
                            <i class="far fa-comment-alt"></i> 0
                        </div>
                        <div class="date">
                            2020 15mart
                        </div>
                    </div>

                </div>
                <div class="rightBlock">
                    <div class="blogsItem">
                        <h3>Title 1 posts of the blog</h3>
                        <a href="#">
                            <div class="wrap">
                                <div class="innerPhoto">
                                    <img src="/img/293e3936d0bd3adccb1e0f491716d6dcf122.jpg" alt="" title="">
                                </div>
                                <div class="innerText"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Accusantium corporis dolore ea
                                    error eum eveniet hic, id porro quas rem....
                                </div>
                            </div>
                        </a>
                        <hr>
                        <div class="bottom">
                            <div class="likes">
                                <i class="far fa-heart"></i> 0
                            </div>
                            <div class="comments">
                                <i class="far fa-comment-alt"></i> 0
                            </div>
                            <div class="date">
                                2020 15mart
                            </div>
                        </div>
                    </div>
                    <div class="blogsItem">
                        <h3>Title 2 posts of the blog</h3>
                        <a href="#">
                            <div class="wrap">
                                <div class="innerPhoto">
                                    <img src="/img/f83e70800d582414f80a189965f62d48964b.jpg" alt="" title="">
                                </div>
                                <div class="innerText"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Accusantium corporis dolore ea
                                    error eum eveniet hic, id porro quas rem....
                                </div>
                            </div>
                        </a>
                        <hr>
                        <div class="bottom">
                            <div class="likes">
                                <i class="fas fa-heart"></i> 3
                            </div>
                            <div class="comments">
                                <i class="far fa-comment-alt"></i> 0
                            </div>
                            <div class="date">
                                2020 15mart
                            </div>
                        </div>
                    </div>
                    <div class="blogsItem">
                        <h3>Title 3 posts of the blog</h3>
                        <a href="#">
                            <div class="wrap">
                                <div class="innerPhoto">
                                    <img src="/img/0d4c32d4ac6fe538cb6c8e8836e1c3f8e656.jpg" alt="" title="">
                                </div>
                                <div class="innerText"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Accusantium corporis dolore ea
                                    error eum eveniet hic, id porro quas rem....
                                </div>
                            </div>
                        </a>
                        <hr>
                        <div class="bottom">
                            <div class="likes">
                                <i class="far fa-heart"></i> 0
                            </div>
                            <div class="comments">
                                <i class="far fa-comment-alt"></i> 0
                            </div>
                            <div class="date">
                                2020 15mart
                            </div>
                        </div>
                    </div>
                    <div class="blogsItem">
                        <h3>Title 4 posts of the blog</h3>
                        <a href="#">
                            <div class="wrap">
                                <div class="innerPhoto">
                                    <img src="/img/4c5f57df1c0d0b1106277096fb5040288ab6.jpg" alt="" title="">
                                </div>
                                <div class="innerText"> Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Accusantium corporis dolore ea
                                    error eum eveniet hic, id porro quas rem....
                                </div>
                            </div>
                        </a>
                        <hr>
                        <div class="bottom">
                            <div class="likes">
                                <i class="fas fa-heart active"></i> 3
                            </div>
                            <div class="comments">
                                <i class="far fa-comment-alt active"></i> 0
                            </div>
                            <div class="date">
                                2020 15mart
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="blurb vertical">
                <h4>Здесь может быть ваша реклама</h4>
            </div>
        </div>
    </div>
</section>
<?php if(!Yii::$app->user->isGuest):?>
<section class="newsFeed">
    <div class="wrap">
        <h2>MOST POPULAR</h2>
        <h3>posts with the most likes:</h3>
        <div class="posts">
            <?php foreach($bestPosts as $post):?>
            <div class="item-wrap">
                <div class="item">
                    <div class="top">
                        <a href="<?=Url::to(['/user/profile/view', 'nickname' => $post['user_id']])?>">
                            <div class="authorPhoto">
                                <img class="autPhoto" src="
                                <?php
                                if (!empty(User::getUserPhoto($post['user_id']))) {
                                    echo '/uploads/'.User::getUserPhoto($post['user_id']);
                                } else {
                                    echo '/img/profile_default_image.jpg';
                                }
                                ?>">
                            </div>
                            <span class="autopName">&nbsp;&nbsp;<?=User::getUserName($post['user_id'])?></span>
                        </a>
                    </div>
                    <div class="photo">
                        <a href="<?=Url::to(['/post/default/view', 'id' => $post['id']])?>" title="Подробнее...">
                            <div class="pictureWrap">
                                <img class="contentPhoto" src="/uploads/<?=$post['filename']?>" alt=""
                                     title="">
                            </div>
                        </a>
                        <p>
                            <?=$post['description']?>
                        </p>
                    </div>
                    <hr>
                    <div class="bottom">
                        <div class="likes">
                            <i class="far fa-heart"></i> <?=$post['count1']?>
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
            <?php endforeach;?>
        </div>
    </div>
</section>
<section class="hallOfFame">
    <div class="wrap">
        <h2>HALL OF FAME</h2>
        <h3 class="white">The users who created the most posts:</h3>
        <div class="posts">
            <?php foreach($bestAuthors as $bestAuthor): ?>
            <div class="item-wrap">
                <div class="itemUser">
                    <div class="nameAutor">
                        <a href="<?=Url::to(['/user/profile/view', 'nickname' => $bestAuthor->getNickname()])?>">
                            <h3><?=$bestAuthor->username?></h3>
                        </a>
                    </div>
                    <div class="photo">
                        <div class="pictureWrap">
                            <a href="<?=Url::to(['/user/profile/view', 'nickname' => $bestAuthor->getNickname()])?>" title="<?=$bestAuthor->username?>"><img class="contentPhoto" src="<?=$bestAuthor->getPicture()?>" alt=""
                                                                title=""></a>
                        </div>
                        <div class="about-text">
                            <p>
                                <?=$bestAuthor->about?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="bottom">
                        <div class="countPosts">
                            Posts: <?=$bestAuthor->rating?>
                        </div>
                        <div class="likes">
<!--                            <a href="#" title="subscribe"><i class="fas fa-heart active"></i></a> <a href="#" title="followers">30</a>-->
                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach;?>
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
        <h2>NEWBIES</h2>
        <h3>Last join us:</h3>
        <div class="posts">
            <?php foreach($newbiesAuthors as $newbiesAuthor):?>
            <div class="item-wrap">
                <div class="itemUser">
                    <div class="nameAutor">
                        <a href="<?=Url::to(['/user/profile/view', 'nickname' => $newbiesAuthor->getNickname()])?>">
                            <h3><?=$newbiesAuthor->username?></h3>
                        </a>
                    </div>
                    <div class="photo">
                        <div class="pictureWrap">
                            <a href="<?=Url::to(['/user/profile/view', 'nickname' => $newbiesAuthor->getNickname()])?>" title=""><img class="contentPhoto" src="<?=$newbiesAuthor->getPicture()?>" alt=""
                                                                title=""></a>
                        </div>
                        <div class="about-text">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium corporis dolore ea
                                error eum eveniet hic, id porro quas rem....
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="bottom">
                        <div class="countPosts">
                            Posts: <?=$newbiesAuthor->rating?>
                        </div>
                        <div class="likes">
<!--                            <a href="#" title="subscribe"><i class="fas fa-heart active"></i></a> <a href="#" title="followers">30</a>-->
                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</section>
<?php endif;?>

<?php if(Yii::$app->user->isGuest):?>
<section class="homeRegister">
    <div class="regWrap">
        <h2>SIGNUP</h2>
        <h3>For those who want to join!</h3>
        <div class="wrap-button">
            <div class="button button-round">
                <a class="<?=$color?>" href="<?=Url::to(['/user/default/signup'])?>">SIGNUP</a>
            </div>
        </div>


    </div>
</section>
<?php endif;

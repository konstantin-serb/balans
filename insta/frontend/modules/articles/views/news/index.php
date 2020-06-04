<?php

/** @var $this yii\web\View
 * @var $articles \frontend\models\Articles
 * @var $article \frontend\models\Articles
 */


use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'News';
$this->color = $color;

$this->registerJsFile('@web/js/script.js', [
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


<section class="main-content newsList">
    <div class="wrap">
        <h2>NEEWS</h2>
        <div class="posts">
            <?php foreach ($articles as $article): ?>
                <div class="item-wrap">
                    <div class="item">
                        <div class="top">
                            <h4><a href="<?=Url::to(['/articles/news/view', 'id' => $article->id])?>"><?= $article->title ?></a></h4>
                        </div>
                        <div class="photo">
                            <a href="<?=Url::to(['/articles/news/view', 'id' => $article->id])?>">
                                <div class="pictureWrap">
                                    <img class="contentPhoto" src="<?=$article->getImage()?>"
                                         alt="" title="">
                                </div>
                            </a>
                        </div>
                        <div class="text">
                            <p>
                                <?php

                                if(strlen($article->description) >= 100){
                                echo Yii::$app->stringHelper->getShort($article->description, 100).'...';
                                }
                                ?>
                            </p>
                        </div>
                        <hr>
                        <div class="bottom">
                            <div class="likes">
                                <a
                                        class="button-like <?php echo $article->isLikesBy(Yii::$app->user->identity->getId()) ? "display-none" : ""; ?>"
                                        data-id="<?=$article->id?>">
                                    <i class="far fa-heart"></i>&nbsp;
                                </a>
                                <a
                                        class="button-unlike <?php echo $article->isLikesBy(Yii::$app->user->identity->getId()) ? "" : "display-none"; ?>"
                                        data-id="<?= '' ?>">
                                    <i class="fas fa-heart"></i>&nbsp;
                                </a>
                                <span id="count1" class="likes-count"                                                                                    data-id="<?php echo '' ?>">
                                            <?php echo $article->likes_count ? $article->likes_count : 0?>
                                        </span>
                            </div>
                            <div class="comments">
                                <a href="<?=Url::to(['/articles/news/view', 'id'=>$article->id, '#' => 'comments'])?>"
                                   style="color:#666;">
                                    <i class="far fa-comment-alt"></i>
                                    <?=\frontend\modules\articles\models\MainComments::CommentCount($article->id)?>
                                </a>
                            </div>
                            <div class="date">
                                <?=Yii::$app->formatter->asDate($article->date)?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>







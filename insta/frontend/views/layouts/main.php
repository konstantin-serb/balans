<?php

/* @var $this \yii\web\View */

/* @var $content string */


use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use frontend\assets\FontAwesomeAsset;
use common\widgets\Alert;

FontAwesomeAsset::register($this);
AppAsset::register($this);



if (!empty($this->color)) {
    $color = $this->color;
} else {
    $color = 'red';
}

if (empty($this->params['countMessage'])) {
    $this->params['countMessage'] = '';
}

if (empty($this->params['pageActive'])) {
    $this->params['pageActive'] = '';
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Rancho&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rancho|Roboto&display=swap" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<body class="<?= $color ?>">

<section class="logo">
    <div class="wrap">
        <div class="logoType">
            <a href="<?= Url::to(['/site/index']) ?>">
                <img src="/img/logo.png">
            </a>
            <h1 class="<?= $color ?>">BalancE</h1>
        </div>
    </div>
    <div class="slovo">
        <p class="slogan"><?= Yii::t('menu', 'Photograph and lay out!') ?></p>
        <div class="forma">
            <?= Html::beginForm(['/site/language']) ?>
            <a href="<?=Url::to(['/site/search'])?>" class="searchIcon"
               style="color:<?=$color?>; margin-right: 8px;font-size:20px;">
                <i class="fas fa-search-plus"></i>
            </a>
            <?= Html::dropDownList('language', Yii::$app->language, [
                'en-US' => 'English',
                'ru-RU' => 'Русский',
            ]) ?>
            <?= Html::submitButton('Change') ?>
            <?= Html::endForm() ?>
        </div>
    </div>


    <hr class="hruka">
</section>




<section class="main-menu">
    <div class="wrap-menu <?= $color ?>">
        <menu>
            <ul>
                <a class="<?= $color ?>
                <?php if ($this->params['pageActive'] == 'home') {
                    echo 'active';
                } ?>
" href="<?= Url::to(['/site/index']) ?>">
                    <li><?= Yii::t('menu', 'HOME') ?></li>
                </a>
                <a class="<?= $color ?>
                <?php if ($this->params['pageActive'] == 'newsFeed') {
                    echo 'active';
                } ?>
" href="<?= Url::to(['/site/news-feed']) ?>">
                    <li><?= Yii::t('menu', 'NEWS FEED') ?></li>
                </a>

                <?php if (Yii::$app->user->isGuest): ?>
                    <a class="<?= $color ?>
                    <?php if ($this->params['pageActive'] == 'signup') {
                        echo 'active';
                    } ?>
" href="<?= Url::to(['/user/default/signup']) ?>">
                        <li>SIGNUP</li>
                    </a>
                    <a class="<?= $color ?>
                    <?php if ($this->params['pageActive'] == 'login') {
                        echo 'active';
                    } ?>
" href="<?= Url::to(['/user/default/login']) ?>">
                        <li>LOGIN</li>
                    </a>
                <?php else: ?>
                    <li>
                        <div class="">
                            <a class="<?= $color ?>
 <?php if ($this->params['pageActive'] == 'myPage') {
                                echo 'active';
                            } ?>"
                               href="<?= Url::to(['/user/profile/my-page', 'nickname' => Yii::$app->user->identity->getNickname()]) ?>">
                                <div class="myPageLabel

"><?= Yii::t('menu', 'MY PAGE') ?>
                                    <?php if ($this->params['countMessage']): ?>
                                        <div class="countReport">
                                            <?= $this->params['countMessage'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </a>

                        </div>
                    </li>
                    <li>
                        <?php echo Html::beginForm(['/user/default/logout'], 'post') ?>
                        <?= Html::submitButton(
                            Yii::t('menu', 'LOGOUT ({username})', [
                                'username' => Yii::$app->user->identity->username,
                            ]), ['class' => $color . ' logout']) ?>
                        <?php echo Html::endForm(); ?>
                    </li>
                <?php endif; ?>

            </ul>
        </menu>
    </div>
    <hr class="hruka">
</section>

<? //= Alert::widget() ?>
<?= $content ?>

<footer class="<?= $color ?>">
    <section>
        <div class="left inner-wrap">
            <p><a href="<?=Url::to(['/articles/news/footer-view', 'name' => 'about'])?>"><?= Yii::t('menu', 'ABOUT THE PROJECT') ?></a></p>
            <p><a href="<?=Url::to(['/articles/news/footer-view', 'name' => 'terms'])?>"><?= Yii::t('menu', 'TERMS OF USE') ?></a></p>
            <p><a href="<?=Url::to(['/articles/news/footer-view', 'name' => 'contacts'])?>"><?= Yii::t('menu', 'CONTACTS') ?></a></p>
        </div>
        <div class="center inner-wrap">
            <p><a href="http://i-des.net" target="_blank">i-des.net</a></p>
            <p><a >konstant.s18@gmail.com</a></p>
            <p><a ><?= Yii::t('menu', 'TBILISI') ?> 2020г.</a></p>
        </div>
        <div class="right inner-wrap">
            <p><a href="<?=Url::to(['/articles/news/footer-view', 'name' => 'advertising'])?>"><?= Yii::t('menu', 'ADVERTISING ON THE WEBSITE') ?></a></p>
            <p><a href="<?=Url::to(['/articles/news/footer-view', 'name' => 'collaborate'])?>"><?= Yii::t('menu', 'COLLABORATION') ?></a></p>
            <p><a href="<?=Url::to(['/articles/news/footer-view', 'name' => 'other'])?>"><?= Yii::t('menu', 'OUR OTHER PROJECTS') ?></a></p>
        </div>
    </section>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>














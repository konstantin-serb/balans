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

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
    <p class="slogan">Снимай и выкладывай!</p>
    <hr class="hruka">
</section>
<section class="main-menu">
    <div class="wrap-menu <?= $color ?>">
        <menu>
            <ul>
                <a class="<?= $color ?> active" href="<?= Url::to(['/site/index']) ?>">
                    <li>HOME</li>
                </a>
                <a class="<?= $color ?>" href="<?= Url::to(['/site/news-feed']) ?>">
                    <li>NEWS FEED</li>
                </a>

                <?php if (Yii::$app->user->isGuest): ?>
                    <a class="<?= $color ?>" href="<?= Url::to(['/user/default/signup']) ?>">
                        <li>SIGNUP</li>
                    </a>
                    <a class="<?= $color ?>" href="<?= Url::to(['/user/default/login']) ?>">
                        <li>LOGIN</li>
                    </a>
                <?php else: ?>
                    <a class="<?= $color ?>" href="<?=Url::to(['/user/profile/my-page','nickname' => Yii::$app->user->identity->getNickname()])?>">
                        <li>MY PAGE</li>
                    </a>
                    <li>
                        <?php echo Html::beginForm(['/user/default/logout'], 'post') ?>
                        <?= Html::submitButton('LOGOUT (' . Yii::$app->user->identity->username . ')', ['class' =>  $color . ' logout' ]) ?>
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
            <p><a href="#">О ПРОЕКТЕ</a></p>
            <p><a href="#">ПРАВИЛА ИСПОЛЬЗОВАНИЯ</a></p>
            <p><a href="#">КОНТАКТЫ</a></p>
        </div>
        <div class="center inner-wrap">
            <p><a href="#">i-des.net</a></p>
            <p><a href="#">konstant.s18@gmail.com</a></p>
            <p><a href="#">ТБИЛИСИ 2020г.</a></p>
        </div>
        <div class="right inner-wrap">
            <p><a href="#">РЕКЛАМА НА САЙТЕ</a></p>
            <p><a href="#">СОТРУДНИЧЕСТВО</a></p>
            <p><a href="#">НАШИ ДРУГИЕ ПРОЕКТЫ</a></p>
        </div>
    </section>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>














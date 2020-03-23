<?php

namespace frontend\controllers;

use frontend\models\Feed;
use frontend\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Faker\Factory;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
//    public function actionIndex()
//    {
//        if(Yii::$app->user->isGuest) {
//            return $this->redirect(['/user/default/login']);
//        }
//
//        $users = User::find()->orderBy('id desc')->all();
//
//        $currentUser = Yii::$app->user->identity;
//        $limit = Yii::$app->params['feedPostLimit'];
//        $postFeed = $currentUser->getFeed($limit);
//
//
//
//        return $this->render('index', [
//            'feedItems' => $postFeed,
//            'currentUser' => $currentUser,
//            'users' => $users,
//        ]);
//    }

    public function actionIndex()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        $users = User::find()->orderBy('id desc')->all();
        $currentUser = Yii::$app->user->identity;
        $limit = Yii::$app->params['feedPostLimit'];
        if ($currentUser) {
            $posts = $currentUser->getSubscriptionsPosts($limit);
        } else {
            $posts = '';
        }


        return $this->render('alternative', [
            'feedItems' => $posts,
            'currentUser' => $currentUser,
            'users' => $users,
        ]);
    }

    public function actionGenerateUser()
    {
        $facker = Factory::create();


        for ($i = 0; $i < 1000; $i++) {
            $user = new User([
                'username' => $facker->name,
                'email' => $facker->email,
                'about' => $facker->text( 1000),
                'nickname' => $facker->regexify('[A-Za-z0-9_]{5,15}'),
                'password_hash' => Yii::$app->security->generatePasswordHash('123123'),
                'created_at' => $time = time(),
                'updated_at' => $time,
                'auth_key' => Yii::$app->security->generateRandomString(),
            ]);

            $user->save(false);
        }

    }

}

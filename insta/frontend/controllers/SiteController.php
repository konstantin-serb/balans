<?php

namespace frontend\controllers;


use frontend\models\User;
use Yii;
use frontend\models\Post;
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

    public function actionIndex()
    {
        $color = 'green';
        $title = 'Balance | main';
        $bestPosts = Post::getBestPosts();

        $bestAuthors = User::find()->where(['status' => 10])->orderBy('rating desc')->limit(8)->all();
        $newbiesAuthors = User::find()->where(['status' => 10])
            ->andWhere(['>', 'rating', 0])
            ->andWhere(['!=', 'picture', 'null'])
            ->orderBy('created_at desc')->limit(8)->all();

        return $this->render('index', [
            'color' => $color,
            'title' => $title,
            'bestPosts' => $bestPosts,
            'bestAuthors' => $bestAuthors,
            'newbiesAuthors' => $newbiesAuthors,
        ]);
    }


    public function actionNewsFeed()
    {
                if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        $color = 'blue';

        $users = User::find()->orderBy('id desc')->all();
        $currentUser = Yii::$app->user->identity;
        $limit = Yii::$app->params['feedPostLimit'];
        if ($currentUser) {
            $posts = $currentUser->getSubscriptionsPosts($limit);
        } else {
            $posts = '';
        }


        return $this->render('alternative', [
            'color' => $color,
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

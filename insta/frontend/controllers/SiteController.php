<?php

namespace frontend\controllers;


use frontend\models\Blurb;
use frontend\models\Comment;
use frontend\models\CommentReport;
use frontend\models\forms\SearchForm;
use frontend\models\User;
use Yii;
use frontend\models\Post;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Faker\Factory;
use frontend\models\Articles;
use yii\web\Cookie;

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
        $horizontalBlurb = Blurb::find()->where(['insert' => 'home-horizont', 'sort' => 100])->one();
        $verticalBlurb = Blurb::find()->where(['insert' => 'home-vert-vert', 'sort' => 100])->one();
        $verticalHorizontalBlurb = Blurb::find()->where(['insert' => 'home-vert-horizont', 'sort' => 100])->one();

        $this->view->params['pageActive'] = 'home';
        $bestPosts = Post::getBestPosts();
        $articles = Articles::find()->where('status = 1')->orderBy('id desc')->limit(4)->all();
        $articleFirst = Articles::find()->where('status = 1')->orderBy('id desc')->limit(1)->one();
        if (!Yii::$app->user->isGuest) {
            $this->view->params['countMessage'] = CommentReport::countReports(Yii::$app->user->identity->getId());
        }


        $bestAuthors = User::find()->where(['status' => 10])->orderBy('rating desc')->limit(8)->all();
        $newbiesAuthors = User::find()->where(['status' => 10])
            ->andWhere(['>', 'rating', 0])
            ->andWhere(['!=', 'picture', 'null'])
            ->orderBy('created_at desc')->limit(8)->all();

        return $this->render('index', [
            'color' => $color,
            'title' => $title,
            'articles' => $articles,
            'bestPosts' => $bestPosts,
            'bestAuthors' => $bestAuthors,
            'newbiesAuthors' => $newbiesAuthors,
            'articleFirst' => $articleFirst,
            'horizontalBlurb' => $horizontalBlurb,
            'verticalBlurb' => $verticalBlurb,
            'verticalHorizontalBlurb' => $verticalHorizontalBlurb,
        ]);
    }


    public function actionNewsFeed()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        $this->view->params['countMessage'] = CommentReport::countReports(Yii::$app->user->identity->getId());
        $this->view->params['pageActive'] = 'newsFeed';
        $color = 'blue';
        $horizontalBlurb = Blurb::find()->where(['insert' => 'newsFeed', 'sort' => 100])->one();

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
            'horizontalBlurb' => $horizontalBlurb,
        ]);
    }


    public function actionSearch()
    {
        $color = 'black';
        $model = new SearchForm();
        $result = null;

        if($model->load(Yii::$app->request->post())) {
            $result = $model->search();
        }

        return $this->render('search', [
            'color' => $color,
            'model' => $model,
            'result' => $result,
        ]);
    }

    public function actionGenerateUser()
    {
        $facker = Factory::create();


        for ($i = 0; $i < 1000; $i++) {
            $user = new User([
                'username' => $facker->name,
                'email' => $facker->email,
                'about' => $facker->text(1000),
                'nickname' => $facker->regexify('[A-Za-z0-9_]{5,15}'),
                'password_hash' => Yii::$app->security->generatePasswordHash('123123'),
                'created_at' => $time = time(),
                'updated_at' => $time,
                'auth_key' => Yii::$app->security->generateRandomString(),
            ]);

            $user->save(false);
        }

    }
    public function actionLanguage()
    {
        $language = Yii::$app->request->post('language');
        Yii::$app->language = $language;

        $languageCookie = new Cookie([
            'name' => 'language',
            'value' => $language,
            'expire' => time() + 60 * 60 * 24 * 30,
        ]);

        Yii::$app->response->cookies->add($languageCookie);
        return $this->redirect(Yii::$app->request->referrer);
    }

}

















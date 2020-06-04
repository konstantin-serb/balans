<?php


namespace frontend\modules\articles\controllers;


use frontend\models\Blurb;
use frontend\modules\articles\models\forms\MainCommentForm;
use frontend\modules\articles\models\forms\MainCommentsViewForm;
use frontend\modules\articles\models\MainComments;
use yii\web\Controller;
use Yii;
use frontend\models\Articles;
use frontend\modules\articles\models\InfoFooter;
use yii\web\Response;


class NewsController extends Controller
{

    public function actionIndex()
    {
        $this->view->params['pageActive'] = 'home';
        if (Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        $horizontalBlurb = Blurb::find()->where(['insert' => 'home-horizont', 'sort' => 100])->one();
        $articles = Articles::find()->where(['status' => 1])->orderBy('id desc')->all();

        return $this->render('index',[
            'color' => 'green',
            'articles' => $articles,
            'horizontalBlurb' => $horizontalBlurb,
        ]);
    }

    public function actionView($id)
    {
        $this->view->params['pageActive'] = 'home';
        if (Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        $horizontalBlurb = Blurb::find()->where(['insert' => 'post', 'sort' => 100])->one();
        $article = Articles::findOne($id);
        $articles = Articles::find()->where(['status' => 1])->orderBy('id desc')->limit(8)->all();

        $commentModel = new MainCommentForm();
        $data = MainComments::getComments(20, $id);
        $commentCount = MainComments::CommentCount($id);

        return $this->render('view', [
            'color' => 'green',
            'article' => $article,
            'articles' => $articles,
            'commentModel' => $commentModel,
            'comments' => $data['comments'],
            'pagination' => $data['pagination'],
            'currentUser' => Yii::$app->user->identity,
            'commentCount' => $commentCount,
            'horizontalBlurb' => $horizontalBlurb
        ]);
    }

    public function actionLike()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $articleId = Yii::$app->request->post('id');
        $currentUser = Yii::$app->user->identity;
        $article = Articles::findOne($articleId);
        $likes = $article->like($currentUser->getId());


        return [
            'success' => true,
            'likesCount' => $likes,
        ];
    }


    public function actionAddComment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $comment = new MainCommentForm();

        $params = Yii::$app->request->post('params');
        $comment->articlesId = $params['articlesId'];
        $comment->userId = $params['userId'];
        $comment->comment = $params['comment'];

        if($comment->save()) {
            return [
                'success' => true
            ];
        } else {
        return [
            'success' => false,
        ];
        }

    }

    public function actionGetComments()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $comment = new MainCommentsViewForm();

        $params = Yii::$app->request->post('params');

       $comment->article_id = $params['articlesId'];
       $comment->user_id = $params['userId'];
////        $comment->comment = $params['comment'];
       $comment->currentUser = Yii::$app->user->identity->getId();
//
        $content = $comment->view();

        return [
            'success' => true,
            'html' => $content,
        ];
    }


    public function actionFooterView($name)
    {
        $footerContent = self::findFooterModel($name);

        return $this->render('footer',[
            'footerContent' => $footerContent,
            'color' => 'black',
        ]);
    }


    private static function findFooterModel($name)
    {
        return InfoFooter::find()->where(['article_name' => $name])->one();
    }

    public function actionTest()
    {

        return $this->render('test',[
            'color' => 'green',
        ]);

    }



}
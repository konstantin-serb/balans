<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostForm;
use frontend\models\Post;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    public function actionCreate()
    {
        $color = 'shockinBlue';
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $model = new PostForm(Yii::$app->user->identity);
        if ($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Post created!');
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'color' => $color,
        ]);
    }

    public function actionView($id)
    {
        $color = 'yellow';
        $currentUser = Yii::$app->user->identity;

        return $this->render('view', [
            'color' => $color,
            'post' => $this->findPost($id),
            'currentUser' => $currentUser,
        ]);
    }

    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);
        $likes = $post->like($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    public function actionUnlike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        Yii::$app->response->format =  Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);
        $unlike = $post->unlike($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    private function findPost($id)
    {
        if ($post = Post::findOne($id)) {
            return $post;
        }
        throw new NotFoundHttpException();
    }

}

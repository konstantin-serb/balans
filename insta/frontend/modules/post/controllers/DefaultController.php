<?php

namespace frontend\modules\post\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostForm;
use frontend\models\Post;
use frontend\modules\post\models\forms\PostEditForm;
use frontend\modules\post\models\forms\ImageEditForm;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    public function actionCreate()
    {
        $color = 'red';
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $model = new PostForm(Yii::$app->user->identity);
        if ($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Post created!');
                return $this->redirect(['/user/profile/my-page', 'nickname' => Yii::$app->user->identity->getNickname()]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'color' => $color,
        ]);
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $color = 'magenta';
//        $color = 'black';

        $model = $this->findPost($id);
        $editForm = new PostEditForm(Yii::$app->user->identity);
        if ($model->user_id == Yii::$app->user->identity->getId()) {
            if ($editForm->load(Yii::$app->request->post())) {                  
                if ($editForm->save($id)) {
                    Yii::$app->session->setFlash('success', 'Post created!');
                    return $this->redirect(['/user/profile/my-page', 'nickname' => Yii::$app->user->identity->getNickname()]);
                }

            }
        } else {
            return $this->redirect(['/error']);
        }
        return $this->render('update', [
            'id' => $id,
            'color' => $color,
            'model' => $model,
            'editForm' => $editForm,
        ]);
    }

    public function actionPhotoUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }

        $color = 'black';
        $imageModel = new ImageEditForm();
        $model = $this->findPost($id);
        $currentImage = $model->getImage();
        $linkCurrentImage = substr($currentImage, 1);

        if ($model->user_id == Yii::$app->user->identity->getId()) {
            if ($imageModel->load(Yii::$app->request->post())) {
                $picture = UploadedFile::getInstance($imageModel, 'picture');
                if (!empty($picture->name)){
                    if (file_exists($linkCurrentImage)) {
                        unlink($linkCurrentImage);
                    }
                    $imageModel->picture = Yii::$app->storagePostPicture->saveUploadedFile($picture);
                    if ($imageModel->save($id)) {
                        return $this->redirect(['/post/default/update', 'id' => $id]);
                    }
                } else {
                    return $this->redirect(['/post/default/update', 'id' => $id]);
                }
            }
        } else {
            return $this->redirect(['/error']);
        }

        return $this->render('photo-update', [
            'imageModel' => $imageModel,
            'color' => $color,
            'id' => $id,
            'currentImage' => $currentImage,
        ]);
    }

    public function actionView($id)
    {
        $color = 'yellow';
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);


        return $this->render('view', [
            'color' => $color,
            'post' => $post,
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
        Yii::$app->response->format = Response::FORMAT_JSON;
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

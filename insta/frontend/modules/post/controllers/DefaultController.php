<?php

namespace frontend\modules\post\controllers;


use frontend\models\Blurb;
use frontend\models\Comment;
use frontend\models\CommentReport;
use frontend\models\forms\CommentViewForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostForm;
use frontend\models\Post;
use frontend\modules\post\models\forms\PostEditForm;
use frontend\modules\post\models\forms\ImageEditForm;
use frontend\models\forms\CommentAddForm;


/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    public function actionCreate()
    {
        $horizontalBlurb = Blurb::find()->where(['insert' => 'home-horizont', 'sort' => 100])->one();
        $color = 'red';
        $this->view->params['pageActive'] = 'myPage';
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
            'horizontalBlurb' => $horizontalBlurb
        ]);
    }

    public function actionUpdate($id)
    {
        $this->view->params['pageActive'] = 'myPage';
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
                    return $this->redirect(['/user/profile/my-page', 'nickname' => Yii::$app->user->identity->getNickname(),
                        '#' => 'currentUserPosts']);
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

    public function actionDelete($id)
    {
        $this->view->params['pageActive'] = 'myPage';
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $color = 'red';
        $model = $this->findPost($id);
        if ($model->user_id == Yii::$app->user->identity->getId()) {
            if (Yii::$app->request->isPost) {
                $model->status = '6';
                if ($model->save()) {
                    return $this->redirect(['/user/profile/my-page', 'nickname' => Yii::$app->user->identity->getNickname(),
                        '#' => 'currentUserPosts']);
                }
            }

        } else {
            return $this->redirect(['/error']);
        }


        return $this->render('delete', [
            'color' => $color,
            'model' => $model,
        ]);
    }

    public function actionPhotoUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $this->view->params['pageActive'] = 'myPage';
        $color = 'black';
        $imageModel = new ImageEditForm();
        $model = $this->findPost($id);
        $currentImage = $model->getImage();
        $linkCurrentImage = substr($currentImage, 1);

        if ($model->user_id == Yii::$app->user->identity->getId()) {
            if ($imageModel->load(Yii::$app->request->post())) {
                $picture = UploadedFile::getInstance($imageModel, 'picture');
                if (!empty($picture->name)) {
                    if (file_exists($linkCurrentImage)) {
                        unlink($linkCurrentImage);
                    }
                    $imageModel->picture = Yii::$app->storagePostPicture
                        ->saveUploadedFile($picture, Yii::$app->params['paramsUploadPictureFromUserPosts']);
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        $horizontalBlurb = Blurb::find()->where(['insert' => 'post', 'sort' => 100])->one();
        $color = 'yellow';
        $currentUser = Yii::$app->user->identity;
        $this->view->params['countMessage'] = CommentReport::countReports(Yii::$app->user->identity->getId());
        $post = $this->findPost($id);
        if ($post->status == 6) {
            throw new NotFoundHttpException();
        }
        $comments = Comment::find()->where(['post_id' => $id])->andWhere(['status' => 10])
            ->orderBy('created_at desc')->all();
        $commentsCount = Comment::find()->where(['post_id' => $id])->andWhere(['status' => 10])
            ->orderBy('created_at desc')->count();

        $commentModel = new CommentAddForm();
//        if ($commentModel->load(Yii::$app->request->post())) {
//            $commentModel->user_id = $currentUser->getId();
//            $commentModel->post_id = $id;
//            if ($commentModel->save()) {
//                return $this->refresh('#buttonComment');
//            }
//        }

        return $this->render('view', [
            'color' => $color,
            'post' => $post,
            'currentUser' => $currentUser,
            'commentModel' => $commentModel,
            'comments' => $comments,
            'commentsCount' => $commentsCount,
            'horizontalBlurb' => $horizontalBlurb,
        ]);
    }

    public function actionAddComment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $commentModel = new CommentAddForm();
        $commentModel->comment = $_POST['params']['comment'];
        $commentModel->user_id = intval($_POST['params']['userId']);
        $commentModel->post_id = intval($_POST['params']['postId']);
        $post = Post::findOne($commentModel->post_id);
        $commentModel->postAuthorId = $post->user_id;
        if ($commentModel->validate() && $commentModel->save()) {
            return [
                'success' => true,
            ];
        }
    }

    public function actionDeleteComment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post('params');
        $model = new CommentAddForm();

        $model->commentId = $request['id'];
        $model->user_id = $request['userId'];
        $model->commentAuthorId = $request['commentAuthorId'];

        if ($model->delete()) {
            return [
                'success' => true,
                'message' => '',
            ];
        } else {
            return [
                'success' => false,
            ];
        }
    }

    public function actionComment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $comments = new CommentViewForm();
        $comments->userId = $_POST['params']['userId'];
        $comments->postId = $_POST['params']['postId'];
        $comments->currentUser = Yii::$app->user->identity;
        $value = $comments->view();

        return [
            'success' => true,
            'html' => $value,
        ];
    }

    public function actionComplain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);
        if ($post->complain($currentUser)) {
            return [
                'success' => 'true',
                'text' => 'Post reported',
            ];
        }

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

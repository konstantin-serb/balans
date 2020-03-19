<?php


namespace frontend\modules\user\controllers;

use frontend\models\Post;
use Yii;
use frontend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\forms\PictureForm;
use yii\web\Response;
use yii\web\UploadedFile;

class ProfileController extends Controller
{

    public function actionView($nickname)
    {
        $user = $this->findUser($nickname);
        $currentUser = Yii::$app->user->identity;
        $modelPicture = new PictureForm();
        $posts = Post::find()->where(['user_id' => $user->getId()])->orderBy('id desc')->limit(10)->all();

        return $this->render('view', [
            'user' => $user,
            'currentUser' => $currentUser,
            'modelPicture' => $modelPicture,
            'posts' => $posts,
        ]);
    }

    private function findUser($nickname)
    {
        $user = User::find()->where(['nickname'=>$nickname])->orWhere(['id' => $nickname])->one();
        if ($user) {
            return $user;
        }
//        echo 'Пользователь не найден'; die;
        throw new NotFoundHttpException();
    }

    public function actionSubscrire($id)
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        // Получаем экземпляр пользователя, который выполнил вход
        $currentUser = Yii::$app->user->identity;
        // получаем екземляр пользователя, на которого нужно подписаться
        $user = $this->findUserById($id);

        $currentUser->followUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }

    public function actionUnsubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        $currentUser = Yii::$app->user->identity;
        $user = $this->findUserById($id);

        $currentUser->unfollowUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }

    private function findUserById($id)
    {
        if($user = User::findOne($id)){
            return $user;
        }
        throw new NotFoundHttpException();
    }

    public function actionUploadPicture()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');

        if ($model->validate()) {
            $user = Yii::$app->user->identity;
            //printer($user->picture);die;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture);

            if ($user->save(false, ['picture']))
            {
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];

    }
}



























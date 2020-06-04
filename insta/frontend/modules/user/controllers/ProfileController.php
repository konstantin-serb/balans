<?php


namespace frontend\modules\user\controllers;

use frontend\models\Blurb;
use frontend\models\CommentReport;
use frontend\models\forms\MessagesReportView;
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
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/']);
        }
        $color = 'lightBlue';
        $horizontalBlurb = Blurb::find()->where(['insert' => 'newsFeed', 'sort' => 100])->one();

        $user = $this->findUser($nickname);
        $userId = $user->getId();
        $title = $user->username . ' page';
        $currentUser = Yii::$app->user->identity;
        $this->view->params['countMessage'] = CommentReport::countReports(Yii::$app->user->identity->getId());
        if ($user->getId() == $currentUser->getId()) {
            return $this->redirect(['my-page', 'nickname' => $currentUser->getNickname()]);
        }

        $modelPicture = new PictureForm();

        if ($currentUser->isUserYourSubscriber($user)) {
            $data = Post::getForFriends(48, $userId);

        } else {
            $data = Post::getAll(48, $userId);

        }

        return $this->render('userprofile', [
            'color' => $color,
            'title' => $title,
            'user' => $user,
            'currentUser' => $currentUser,
            'modelPicture' => $modelPicture,
            'posts' => $data['posts'],
            'pagination' => $data['pagination'],
            'horizontalBlurb' => $horizontalBlurb
        ]);
    }

    public function actionMyPage($nickname)
    {
        $color = 'brown';

        $horizontalBlurb = Blurb::find()->where(['insert' => 'newsFeed', 'sort' => 100])->one();
        $this->view->params['countMessage'] = $message = CommentReport::countReports(Yii::$app->user->identity->getId());
        $this->view->params['pageActive'] = 'myPage';
        $user = $this->findUser($nickname);

        $title = $user->username . Yii::t('my page', ' page');
        $currentUser = Yii::$app->user->identity;
        $modelPicture = new PictureForm();

        $userId = $currentUser->getId();
        $data = Post::getMyPosts(48,$userId);
//        $posts = Post::find()->where(['user_id' => $userId])->andWhere('status < 4')->orderBy('id desc')->all();

        return $this->render('view', [
            'color' => $color,
            'title' => $title,
            'user' => $user,
            'currentUser' => $currentUser,
            'modelPicture' => $modelPicture,
            'posts' => $data['posts'],
            'pagination' => $data['pagination'],
            'message' => $message,
            'horizontalBlurb' => $horizontalBlurb
        ]);
    }

    public function actionMyMessages($id)
    {
        $horizontalBlurb = Blurb::find()->where(['insert' => 'home-horizont', 'sort' => 100])->one();
        $this->view->params['pageActive'] = 'myPage';
        if ($id != Yii::$app->user->identity->getId()) {
            return $this->redirect(['/user/profile/my-messages/', 'id' => Yii::$app->user->identity->getId()]);
        }
        $color = 'brown';

        $currentUser = Yii::$app->user->identity->getId();
        $this->view->params['countMessage'] = CommentReport::countReports(Yii::$app->user->identity->getId());
        $messages = CommentReport::find()->where(['recipient' => $currentUser])->orderBy('created_at desc')->all();


        return $this->render('my-message', [
            'color' => $color,
            'messages' => $messages,
            'horizontalBlurb' => $horizontalBlurb
        ]);
    }

    public function actionDeleteMessage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = intval($_POST['params']['id']);
        $commentReport = CommentReport::findOne($id);
        if ($commentReport->delete()) {
            return [
                'success' => true,
            ];
        }
        return false;
    }

    public function actionMessageView()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $currentUserId = Yii::$app->user->identity->getId();
        $messReport = new MessagesReportView();
        $messReport->userId = $currentUserId;

        return [
            'html' => $messReport->view(),
        ];
    }

    private function findUser($nickname)
    {
        $user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one();
        if ($user) {
            return $user;
        }
//        echo 'Пользователь не найден'; die;
        throw new NotFoundHttpException();
    }

    public function actionSubscrire($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        // Получаем экземпляр пользователя, который выполнил вход
        $currentUser = Yii::$app->user->identity;
        // получаем екземляр пользователя, на которого нужно подписаться
        $user = $this->findUserById($id);

        $currentUser->followUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }

    public function actionAjaxSubscribe()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        $data = Yii::$app->request->post();

        $id = $data['id'];
        // Получаем экземпляр пользователя, который выполнил вход
        $currentUser = Yii::$app->user->identity;
        // получаем екземляр пользователя, на которого нужно подписаться
        $user = $this->findUserById($id);

        if (!$currentUser->isFollowersId($id)) {
        $currentUser->followUser($user);

        }
        return true;
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
        if ($user = User::findOne($id)) {
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

            $params = self::getResizeParams();
            $user->picture = Yii::$app->storagePostPicture->saveUploadedFile($model->picture, $params);

            if ($user->save(false, ['picture'])) {
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];

    }

    private function getResizeParams()
    {
        return Yii::$app->params['paramsUploadUserPhoto'];
    }
}



























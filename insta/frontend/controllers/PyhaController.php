<?php


namespace frontend\controllers;


use frontend\models\Post;
use frontend\models\User;
use Yii;
use yii\web\Controller;

class PyhaController extends Controller
{

    public function actionIndex()
    {



        return $this->render('index');
    }

    public function actionDirSize()
    {
            dumper(scandir(Yii::$app->params['storageUri']));
        die;
    }

    public function actionAddCount()
    {
        $users = User::find()->all();

        foreach ($users as $user) {
            $userOne = User::findOne($user->id);
            $userPosts = Post::find()->where(['user_id' => $user->getId()])->andWhere(['status' => 1])->count();
            $userOne->rating = $userPosts;
            $userOne->save(false);
        }

        return 'Yes!';
    }


}
<?php


namespace frontend\controllers;


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


}
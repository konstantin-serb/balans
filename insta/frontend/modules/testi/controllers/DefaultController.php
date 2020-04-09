<?php

namespace frontend\modules\testi\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\testi\models\UploadForm;
use yii\web\UploadedFile;

/**
 * Default controller for the `testi` module
 */
class DefaultController extends Controller
{
    public $layout = 'mainBase';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {


        return $this->render('index');
    }

    public function actionCreatePicture()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->upload()) {
                return $this->redirect(['/testi/default/index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}

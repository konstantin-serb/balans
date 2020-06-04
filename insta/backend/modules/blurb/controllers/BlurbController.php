<?php

namespace backend\modules\blurb\controllers;

use backend\models\forms\ArticlesPictureForm;
use backend\models\PostsImage;
use backend\modules\blurb\models\forms\VerticalPictureForm;
use frontend\models\forms\PictureForm;
use Yii;
use backend\modules\blurb\models\forms\BlurbCreateForm;
use backend\modules\blurb\models\forms\BlurbUpdateForm;
use backend\modules\blurb\models\Blurb;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * BlurbController implements the CRUD actions for Blurb model.
 */
class BlurbController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blurb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Blurb::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blurb model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blurb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlurbCreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blurb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $currentModel = $this->findModel($id);
        $model = new BlurbUpdateForm();

        $modelPicture = new PictureForm();
        $modelPictureVert = new VerticalPictureForm();

        $articlesPicture = PostsImage::find()->where(['title' => $currentModel->insert])
            ->andWhere(['status' => 3])
            ->orderBy('id desc')->all();

        $articlesPictureVert = PostsImage::find()->where(['title' => $currentModel->insert])
            ->andWhere(['status' => 4])
            ->orderBy('id desc')->all();

        $model->id = $currentModel->id;
        $model->title = $currentModel->title;
        $model->customer = $currentModel->customer;
        $model->text = $currentModel->text;
        $model->url = $currentModel->url;
        $model->photo = $currentModel->photo;
        $model->description = $currentModel->description;
        $model->status = $currentModel->status;
        $model->insert = $currentModel->insert;
        $model->sort = $currentModel->sort;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelPicture' => $modelPicture,
            'modelPictureVert' => $modelPictureVert,
            'articlesPicture' => $articlesPicture,
            'articlesPictureVert' => $articlesPictureVert,
        ]);
    }


    public function actionUploadimagesHorizontal($name)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');
        if($model->validate()) {
            $picture = new PostsImage();
            $picture->status = 3;
            $picture->title = $name;
            $picture->path = Yii::$app->storagePostPicture->saveUploadedFile($model->picture,
                Yii::$app->params['blurbHorizontal']);
            if($picture->save()) {
                $pictureForm = new ArticlesPictureForm();
                $value = $pictureForm->blurbVert($name);

                return [
                    'success' => true,
                    'html' => $value,
                ];
            }
            return [
                'success' => false,
            ];
        }

        return true;
    }


    public function actionUploadimagesVertical($name)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $modelPictureVert = new VerticalPictureForm();
        $modelPictureVert->picture = UploadedFile::getInstance($modelPictureVert, 'picture');
        if($modelPictureVert->validate()) {
            $picture = new PostsImage();
            $picture->status = 4;
            $picture->title = $name;
            $picture->path = Yii::$app->storagePostPicture->saveUploadedFile($modelPictureVert->picture,
                Yii::$app->params['blurbVertical']);
            if($picture->save()) {
                $pictureForm = new ArticlesPictureForm();
                $value = $pictureForm->blurbVert($name);

                return [
                    'success' => true,
                    'html' => $value,
                ];
            }
            return [
                'success' => false,
            ];
        }

        return true;
    }

    public function actionDeletePhoto()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $postId = $_POST['postId'];
        $photoId = $_POST['photoId'];

        $photo = PostsImage::findOne($photoId);
        $photoPath = substr($photo->getImage(),1);
        if (file_exists($photoPath)){
            if (unlink($photoPath)) {
                $photo->delete();
            }
        }

        $pictureForm = new ArticlesPictureForm();
        $value = $pictureForm->blurb($photo->title);
        return [
            'success' => true,
            'html' => $value,
        ];
    }


    public function actionDeleteVertphoto()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $postId = $_POST['postId'];
        $photoId = $_POST['photoId'];

        $photo = PostsImage::findOne($photoId);
        $photoPath = substr($photo->getImage(),1);
        if (file_exists($photoPath)){
            if (unlink($photoPath)) {
                $photo->delete();
            }
        }

        $pictureForm = new ArticlesPictureForm();
        $value = $pictureForm->blurbVert($photo->title);
        return [
            'success' => true,
            'html' => $value,
        ];
    }

    /**
     * Deletes an existing Blurb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blurb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blurb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blurb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

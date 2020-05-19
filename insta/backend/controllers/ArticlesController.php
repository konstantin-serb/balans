<?php

namespace backend\controllers;


use backend\models\forms\ArticlesPictureForm;
use backend\models\forms\ArticlesUpdateForm;
use backend\models\PostsImage;
use Yii;
use backend\models\Articles;
use backend\models\ArticlesSearch;
use backend\models\forms\ArticlesForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\models\forms\PictureForm;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'uploadimages', 'delete-photo'],
                        'roles' => ['admin', 'moderator'],
                    ],
                ],

            ],
        ];
    }

    /**
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticlesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $articlesPicture = PostsImage::find()->where(['post_id' => $id])->orderBy('id desc')->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'articlePicture' => $articlesPicture,
        ]);
    }

    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticlesForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');
            if ($id = $model->save() ) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUpdate = new ArticlesUpdateForm();
        $modelUpdate->id = $model->id;
        $modelPicture = new PictureForm();
        $articlesPicture = PostsImage::find()->where(['post_id' => $id])->orderBy('id desc')->all();

        if ($modelUpdate->load(Yii::$app->request->post())) {
            $modelUpdate->picture = UploadedFile::getInstance($modelUpdate, 'picture');
            if ( $modelUpdate->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'modelUpdate' => $modelUpdate,
            'modelPicture' => $modelPicture,
            'articlesPicture' => $articlesPicture,
        ]);
    }

    public function actionUploadimages($postId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');
        if ($model->validate()){
            $newPicture = new PostsImage();
            $newPicture->post_id = $postId;
            $newPicture->status = 1;
            $newPicture->path = Yii::$app->storagePostPicture->saveUploadedFile($model->picture,
                Yii::$app->params['ordinareParamsForArticles']);
            if ($newPicture->save()) {
                $pictureForm = new ArticlesPictureForm();
                $value = $pictureForm->view($postId);
                return [
                    'success' => true,
                    'html' => $value,
                ];
            }
             return [
                 'success' => false,
             ];
        }
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
        $value = $pictureForm->view($postId);
        return [
            'success' => true,
            'html' => $value,
        ];
    }

    /**
     * Deletes an existing Articles model.
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
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

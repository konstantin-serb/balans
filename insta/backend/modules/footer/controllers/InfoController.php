<?php

namespace backend\modules\footer\controllers;

use backend\models\forms\ArticlesPictureForm;
use backend\models\PostsImage;
use backend\modules\footer\models\forms\FooterAddForm;
use backend\modules\footer\models\forms\FooterUpdateForm;
use frontend\models\forms\PictureForm;
use Yii;
use backend\modules\footer\models\InfoFooter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * InfoController implements the CRUD actions for InfoFooter model.
 */
class InfoController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'uploadimages', 'delete-photo'],
                        'roles' => ['admin'],
                    ],
                ],

            ],
        ];
    }

    /**
     * Lists all InfoFooter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InfoFooter::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InfoFooter model.
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
     * Creates a new InfoFooter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FooterAddForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($id = $model->save()) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing InfoFooter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $update = new FooterUpdateForm();
        $modelPicture = new PictureForm();
        $articlesPicture = PostsImage::find()->where(['title' => $model->article_name])->orderBy('id desc')->all();
        $update->articleName = $model->article_name;
        $update->text = $model->text;
        $update->description = $model->description;
        $update->id = $model->id;

        if ($update->load(Yii::$app->request->post())) {
            if ($update->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'update' => $update,
            'modelPicture' => $modelPicture,
            'articlesPicture' => $articlesPicture,
        ]);
    }

    public function actionUploadimages($name)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');
        if ($model->validate()){
            $newPicture = new PostsImage();
            $newPicture->status = 2;
            $newPicture->title = $name;
            $newPicture->path = Yii::$app->storagePostPicture->saveUploadedFile($model->picture,
                Yii::$app->params['ordinareParamsForArticles']);
            if ($newPicture->save()) {
                $pictureForm = new ArticlesPictureForm();
                $value = $pictureForm->footer($name);

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
        $value = $pictureForm->footer($postId);
        return [
            'success' => true,
            'html' => $value,
        ];
    }



    /**
     * Finds the InfoFooter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InfoFooter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InfoFooter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

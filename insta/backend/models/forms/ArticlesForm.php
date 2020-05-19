<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use backend\models\Articles;

class ArticlesForm extends Model
{
    public $id;
    public $title;
    public $picture;
    public $text;
    public $description;
    public $status;

    private $date;


    public function rules()
    {
        return [
            [['title', 'text', 'status'], 'required'],
            [['title'], 'string', 'min' => 3, 'max' => 255],
            [['text'], 'string', 'min' => 10],
            [['description'], 'string', 'min' => 10],
            [['status'], 'integer'],
            [['date'], 'integer'],
            [['picture'], 'file',
//                'skipOnEmpty' => false,
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize()],
        ];
    }

    public function save()
    {
        $article = new Articles();
        $article->title = $this->title;
        $article->text = $this->text;
        $article->description = $this->description;
        if (!empty($this->picture)) {

            $params = self::getResizeParameters();
            $article->image = Yii::$app->storagePostPicture->saveUploadedFile($this->picture, $params);
        }
        $article->status = 0;
        $article->date = time();

        if ($article->save()) {
            $article = Articles::find()->orderBy('id desc')->one();
            $id = $article->id;
            return $id;
        }
        return false;
    }

    private function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }

    private function getResizeParameters()
    {
        return Yii::$app->params['pictureParamsForArticles'];
    }

}
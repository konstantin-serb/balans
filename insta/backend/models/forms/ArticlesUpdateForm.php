<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use backend\models\Articles;

class ArticlesUpdateForm extends Model
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
            [['title', 'text', 'status', 'description'], 'required'],
            [['title'], 'string', 'min' => 3, 'max' => 255],
            [['text','description'], 'string', 'min' => 10],
            [['status'], 'integer'],
            [['date'], 'integer'],
            [['picture'], 'file',
//                'skipOnEmpty' => false,
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
//                'maxSize' => $this->getMaxFileSize()
            ],
        ];
    }

    public function save()
    {
        $article = Articles::findOne($this->id);
        $article->title = $this->title;
        $article->text = $this->text;
        $article->description = $this->description;
        if (!empty($this->picture)) {

            $params = self::getResizeParameters();
            $article->image = Yii::$app->storagePostPicture->saveUploadedFile($this->picture, $params);
        }
        $article->status = $this->status;
        if ($article->save()) {
            return true;
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
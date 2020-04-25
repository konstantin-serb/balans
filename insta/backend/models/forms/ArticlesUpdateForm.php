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
    public $status;

    private $date;


    public function rules()
    {
        return [
            [['title', 'text', 'status'], 'required'],
            [['title'], 'string', 'min' => 3, 'max' => 255],
            [['text'], 'string', 'min' => 25],
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
        $article = Articles::findOne($this->id);
        $article->title = $this->title;
        $article->text = $this->text;
        if (!empty($this->picture)) {
            $article->image = Yii::$app->storagePostPicture->saveUploadedFile($this->picture);
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

}
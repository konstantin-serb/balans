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
        ];
    }

    public function save()
    {

        $article = new Articles();
        $article->title = $this->title;
        $article->text = $this->text;
        if (!empty($this->picture)) {
            $article->image = Yii::$app->storagePostPicture->saveUploadedFile($this->picture);
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

}
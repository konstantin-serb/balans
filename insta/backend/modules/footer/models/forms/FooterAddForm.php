<?php


namespace backend\modules\footer\models\forms;


use yii\base\Model;
use backend\modules\footer\models\InfoFooter;

class FooterAddForm extends Model
{
    public $articleName;
    public $text;
    public $description;

    public function rules()
    {
        return [
            [['articleName'], 'required'],
            [['text'], 'string', 'min'=>3],
            [['description'], 'string', 'min'=>3],
            [['description'], 'required'],
            [['text'], 'required'],
        ];
    }


    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $article = new InfoFooter();
        $article->article_name = $this->articleName;
        $article->text = $this->text;
        $article->description = $this->description;
        if ($article->save()) {

            $post = InfoFooter::find()->orderBy('id desc')->one();
            $id = $post->id;
            return $id;
        }
    }


}
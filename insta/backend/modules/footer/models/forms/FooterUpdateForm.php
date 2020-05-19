<?php


namespace backend\modules\footer\models\forms;


use yii\base\Model;
use backend\modules\footer\models\InfoFooter;

class FooterUpdateForm extends Model
{
    public $id;
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
        $article = InfoFooter::findOne($this->id);
        $article->article_name = $this->articleName;
        $article->text = $this->text;
        $article->description = $this->description;
        if ($article->save()) {
            return true;
        }
    }


}
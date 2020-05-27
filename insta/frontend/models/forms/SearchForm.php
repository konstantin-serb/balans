<?php


namespace frontend\models\forms;


use yii\base\Model;
use frontend\models\SearchUser;

class SearchForm extends Model
{

    public $keyWord;

    public function rules()
    {
        return [
            [['keyWord'], 'trim'],
            [['keyWord'], 'required'],
            [['keyWord'], 'string', 'max'=> 20, 'min'=> 3],
        ];
    }


    public function search()
    {
        if($this->validate()) {
            $model = new SearchUser();
            $result = $model->simpleSearch($this->keyWord);

            if ($result)   {
                return $result;
            } else {
                return false;
            }
        }
    }
}
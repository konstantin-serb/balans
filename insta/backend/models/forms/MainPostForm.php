<?php

namespace backend\models\forms;

use yii\base\Model;
use common\models\MainPosts;

class MainPostForm extends Model
{
    public $picture;
    public $title;
    public $content;
    public $status;

    private $created_at;


    public function rules()
    {
        return [
            [['title', 'content', 'status'], 'required'],
            [['title'], 'string', 'min'=> 3, 'max' => 255],
            [['content'], 'string', 'min' => 3],
            [['status'], 'integer'],
        ];
    }


    public function save()
    {

        return true;
    }

}
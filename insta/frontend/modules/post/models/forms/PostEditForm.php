<?php

namespace frontend\modules\post\models\forms;


use Yii;
use yii\base\Model;
use frontend\models\Post;
use frontend\models\User;
use Intervention\Image\ImageManager;
use frontend\models\events\PostCreatedEvent;


class PostEditForm extends Model
{

    const MAX_DESCRIPTIONS_LENGHT = 1000;


    public $picture;
    public $description;

    private $user;

    public function rules()
    {
        return [
            [['description'], 'string', 'max' => self::MAX_DESCRIPTIONS_LENGHT],
        ];
    }

//    public function __construct(User $user)
//    {
//        $this->user = $user;
//        //$this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
//        $this->on(self::EVENT_POST_CREATED, [Yii::$app->feedService, 'addToFeeds']);
//    }



    public function save($id)
    {
        if ($this->validate()) {
            $post = Post::findOne($id);
            $post->description = $this->description;
            if ($post->save()) {
                return true;
            }
            return false;
        }
    }



    private function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }

}
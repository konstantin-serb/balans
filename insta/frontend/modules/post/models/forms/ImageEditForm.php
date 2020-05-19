<?php

namespace frontend\modules\post\models\forms;


use Yii;
use yii\base\Model;
use frontend\models\Post;

class ImageEditForm extends Model
{

    const MAX_DESCRIPTIONS_LENGHT = 1000;
    const EVENT_POST_CREATED = 'post_created';

    public $picture;

    public function rules()
    {
        return [
            [['picture'], 'file',
//                'skipOnEmpty' => false,
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize()],
        ];
    }


    public function save($id)
    {

        if ($this->validate()) {

            $post = Post::findOne($id);

            $post->filename = $this->picture;
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
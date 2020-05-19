<?php


namespace backend\models\forms;

use Yii;
use yii\base\Model;


class PostImagesForm extends Model
{
    public $picture;

    public function rules()
    {
        return [
            [['picture'], 'file',
                'extensions' => ['jpg', 'jpeg','png','gif'],
                'checkExtensionByMimeType' => true,
            ],
        ];
    }

}
<?php


namespace frontend\models\forms;

use Yii;
use yii\base\Model;

class PictureForm extends Model
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

//    public function save()
//    {
//        return 1;
//    }

}
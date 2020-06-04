<?php


namespace backend\modules\blurb\models\forms;

use Yii;
use yii\base\Model;

class VerticalPictureForm extends Model
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

<?php

namespace backend\modules\footer\models;

use Yii;

/**
 * This is the model class for table "info_footer".
 *
 * @property int $id
 * @property string $article_name
 * @property string|null $text
 * @property string|null $description
 */
class InfoFooter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info_footer';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_name' => 'Article Name',
            'text' => 'Text',
            'description' => 'Description',
        ];
    }
}

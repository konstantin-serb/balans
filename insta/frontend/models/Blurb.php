<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "blurb".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $customer
 * @property string|null $text
 * @property string|null $url
 * @property string|null $description
 * @property string|null $photo
 * @property int|null $status
 * @property string|null $insert
 * @property int|null $sort
 */
class Blurb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blurb';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'customer' => 'Customer',
            'text' => 'Text',
            'url' => 'Url',
            'description' => 'Description',
            'photo' => 'Photo',
            'status' => 'Status',
            'insert' => 'Insert',
            'sort' => 'Sort',
        ];
    }
}

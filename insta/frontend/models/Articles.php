<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string|null $image
 * @property int|null $date
 * @property string|null $likes
 * @property int|null $likes_count
 * @property int|null $status
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'image' => 'Image',
            'date' => 'Date',
            'likes' => 'Likes',
            'likes_count' => 'Likes Count',
            'status' => 'Status',
        ];
    }

    public function getImage()
    {
        return 'http://admin.insta.com/uploads/'.$this->image;
    }

}

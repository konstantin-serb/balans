<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mainposts".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $picture
 * @property string|null $content
 * @property int|null $status
 * @property int|null $created_at
 * @property string|null $likes
 * @property int|null $countLikes
 */
class MainPosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mainposts';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'picture' => 'Picture',
            'content' => 'Content',
            'status' => 'Status',
            'created_at' => 'Created At',
            'likes' => 'Likes',
            'countLikes' => 'Count Likes',
        ];
    }
}

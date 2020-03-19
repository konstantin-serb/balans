<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property int $post_id
 * @property string|null $likes
 * @property int|null $count1
 *
 * @property Post $post
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'likes' => 'Likes',
            'count1' => 'Count1',
        ];
    }


}

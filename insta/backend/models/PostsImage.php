<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "posts_image".
 *
 * @property int $id
 * @property int|null $post_id
 * @property string|null $title
 * @property string|null $path
 * @property int|null $status
 */
class PostsImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts_image';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'title' => 'Title',
            'path' => 'Path',
            'status' => 'Status',
        ];
    }

    public function getImage()
    {
        return ($this->path) ? '/uploads/'.$this->path : '/no-image.jpg';
    }
}

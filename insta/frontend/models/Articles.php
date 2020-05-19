<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $description
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
            'description' => 'Description',
            'image' => 'Image',
            'date' => 'Date',
            'likes' => 'Likes',
            'likes_count' => 'Likes Count',
            'status' => 'Status',
        ];
    }

    public function getImage()
    {
        return ($this->image) ? Yii::$app->params['adminWeb'] . 'uploads/'
            . $this->image : Yii::$app->params['adminWeb'] . '/no-image.jpg';
    }

    public function Like($userId)
    {
        if (!self::isLikesBy($userId)) {
            $array = unserialize($this->likes);
            if (empty($array)){
                $array = [$userId];
            } else {
                array_push($array, $userId);
            }
            $this->likes = serialize($array);
            $this->likes_count = count($array);
            $this->save(false);
            return $this->likes_count;
        }

    }


    public function isLikesBy($userId)
    {
        if (!empty($this->likes)) {
            if (in_array($userId, unserialize($this->likes))) {
                return true;
            }
            return false;
        }
        return false;
    }

}

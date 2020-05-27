<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comment_report".
 *
 * @property int $id
 * @property int $comment_id
 * @property int|null $recipient
 * @property int|null $post_id
 * @property int|null $commentator
 * @property string|null $comment
 * @property int|null $created_at
 * @property int|null $status
 */
class CommentReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_report';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipient' => 'Recipient',
            'post_id' => 'Post ID',
            'commentator' => 'Commentator',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    public static function countReports($id)
    {
        $count = self::find()->where(['recipient' => $id])->andWhere('status > 9')->count();
        return (!empty($count)) ? $count : '';
    }

    public function getUserName($id)
    {
        return User::findOne($id)->username;
    }

    public function getPostImage($id)
    {
        return Post::findOne($id)->getImage();
    }
}

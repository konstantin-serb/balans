<?php

namespace frontend\modules\articles\models;

use frontend\models\User;
use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "main_comments".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $articles_id
 * @property string|null $comment
 * @property int|null $created_at
 * @property int|null $status
 */
class MainComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_comments';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'articles_id' => 'Articles ID',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function getComments($pageSize, $articleId)
    {
        $query = MainComments::find()
            ->where(['articles_id' => $articleId])
            ->andWhere(['status' => 10])
            ->orderBy('created_at desc');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $comments = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['comments'] = $comments;
        $data['pagination'] = $pagination;
        return $data;
    }

    public static function CommentCount($articlesId)
    {
        return MainComments::find()
            ->where(['articles_id' => $articlesId])
            ->andWhere(['status' => 10])->count();
    }
}


























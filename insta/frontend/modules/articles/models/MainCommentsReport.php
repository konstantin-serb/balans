<?php

namespace frontend\modules\articles\models;

use Yii;

/**
 * This is the model class for table "main_comments_report".
 *
 * @property int $id
 * @property int|null $articles_id
 * @property int|null $commentator
 * @property string|null $comment
 * @property int|null $created_at
 * @property int|null $status
 */
class MainCommentsReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_comments_report';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'articles_id' => 'Articles ID',
            'commentator' => 'Commentator',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}

<?php

namespace backend\models;


use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string|null $description
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $status
 * @property string|null $complaints
 * @property int|null $complaints_count
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'complaints' => 'Complaints',
            'complaints_count' => 'Complaints Count',
        ];
    }

    public static function findComplaints()
    {
        return Post::find()->where('complaints_count > 0')->andWhere('status < 3')->orderBy('complaints_count desc');
    }


    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    public function deletePost()
    {
        $this->status = '6';
        $this->complaints = null;
        $this->complaints_count = null;
        if ($this->save())
        {
            return true;
        }
        return false;
    }

    public function approve()
    {
        $this->complaints = null;
        $this->complaints_count = null;
        if ($this->save())
        {
            return true;
        }
        return false;
    }


}




















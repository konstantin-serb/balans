<?php

namespace frontend\modules\articles\models;

use Yii;

/**
 * This is the model class for table "info_footer".
 *
 * @property int $id
 * @property string $article_name
 * @property string|null $text
 * @property string|null $description
 */
class InfoFooter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info_footer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_name'], 'required'],
            [['text', 'description'], 'string'],
            [['article_name'], 'string', 'max' => 255],
            [['article_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_name' => 'Article Name',
            'text' => 'Text',
            'description' => 'Description',
        ];
    }
}

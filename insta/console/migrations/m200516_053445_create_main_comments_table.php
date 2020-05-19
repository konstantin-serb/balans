<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%main_comments}}`.
 */
class m200516_053445_create_main_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%main_comments}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'articles_id' => $this->integer(),
            'comment' => $this->text(),
            'created_at' => $this->integer(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%main_comments}}');
    }
}

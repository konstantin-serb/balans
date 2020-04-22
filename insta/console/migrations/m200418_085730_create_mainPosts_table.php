<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mainPosts}}`.
 */
class m200418_085730_create_mainPosts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mainPosts}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'picture' => $this->string(),
            'content' => $this->text(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'likes' => $this->text(),
            'countLikes' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mainPosts}}');
    }
}

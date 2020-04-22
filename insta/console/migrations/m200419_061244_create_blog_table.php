<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog}}`.
 */
class m200419_061244_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'url' => $this->string()->notNull(),
            'status_id' => $this->integer()->notNull()->defaultValue(1),
            'sort' => $this->integer()->notNull()->defaultValue(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog}}');
    }
}

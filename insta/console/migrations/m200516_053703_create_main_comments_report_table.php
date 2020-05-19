<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%main_comments_report}}`.
 */
class m200516_053703_create_main_comments_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%main_comments_report}}', [
            'id' => $this->primaryKey(),
            'articles_id' => $this->integer(),
            'commentator' => $this->integer(),
            'created_at' => $this->integer(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%main_comments_report}}');
    }
}

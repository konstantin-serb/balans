<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment_report}}`.
 */
class m200425_120708_create_comment_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment_report}}', [
            'id' => $this->primaryKey(),
            'recipient' => $this->integer(),
            'post_id' => $this->integer(),
            'commentator' => $this->integer(),
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
        $this->dropTable('{{%comment_report}}');
    }
}

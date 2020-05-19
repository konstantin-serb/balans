<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%main_comments_report}}`.
 */
class m200516_102320_add_comment_column_to_main_comments_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%main_comments_report}}', 'comment', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%main_comments_report}}', 'comment');
    }
}

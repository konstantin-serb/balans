<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%comment_report}}`.
 */
class m200527_061855_add_comment_id_column_to_comment_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%comment_report}}', 'comment_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%comment_report}}', 'comment_id');
    }
}

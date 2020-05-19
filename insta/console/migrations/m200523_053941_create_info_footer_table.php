<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%info_footer}}`.
 */
class m200523_053941_create_info_footer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%info_footer}}', [
            'id' => $this->primaryKey(),
            'article_name' => $this->string()->notNull()->unique(),
            'text' => $this->text(),
            'description' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%info_footer}}');
    }
}

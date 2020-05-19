<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts_image}}`.
 */
class m200512_070703_create_posts_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts_image}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'title' => $this->string(),
            'path' => $this->text(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_image}}');
    }
}

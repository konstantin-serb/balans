<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blurb}}`.
 */
class m200601_050003_create_blurb_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blurb}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'customer' => $this->string(),
            'text' => $this->text(),
            'url' => $this->text(),
            'description' => $this->string(),
            'photo' => $this->string(),
            'status' => $this->integer(),
            'insert' => $this->string(),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blurb}}');
    }
}

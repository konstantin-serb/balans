<?php

use yii\db\Migration;

/**
 * Class m200430_045500_alter_table_user_drop_index_unique_on_username
 */
class m200430_045500_alter_table_user_drop_index_unique_on_username extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('username', 'user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createIndex('username', 'user', 'username', $unique = true);
    }




}

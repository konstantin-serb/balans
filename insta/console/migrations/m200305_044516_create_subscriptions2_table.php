<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions2}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m200305_044516_create_subscriptions2_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions2}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'subscribe' => $this->text(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-subscriptions2-user_id}}',
            '{{%subscriptions2}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-subscriptions2-user_id}}',
            '{{%subscriptions2}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-subscriptions2-user_id}}',
            '{{%subscriptions2}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-subscriptions2-user_id}}',
            '{{%subscriptions2}}'
        );

        $this->dropTable('{{%subscriptions2}}');
    }
}

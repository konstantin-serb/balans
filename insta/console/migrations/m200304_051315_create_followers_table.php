<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%followers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m200304_051315_create_followers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%followers}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'followers' => $this->text(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-followers-user_id}}',
            '{{%followers}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-followers-user_id}}',
            '{{%followers}}',
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
            '{{%fk-followers-user_id}}',
            '{{%followers}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-followers-user_id}}',
            '{{%followers}}'
        );

        $this->dropTable('{{%followers}}');
    }
}

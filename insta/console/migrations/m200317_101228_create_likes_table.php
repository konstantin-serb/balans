<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%likes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%post}}`
 */
class m200317_101228_create_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%likes}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->unique()->notNull(),
            'likes' => $this->text(),
            'count1' => $this->integer(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-likes-post_id}}',
            '{{%likes}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-likes-post_id}}',
            '{{%likes}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-likes-post_id}}',
            '{{%likes}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-likes-post_id}}',
            '{{%likes}}'
        );

        $this->dropTable('{{%likes}}');
    }
}

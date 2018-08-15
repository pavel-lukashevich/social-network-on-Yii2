<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180815_114636_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->integer()->notNull(),
            'comment' => $this->string(2000)->notNull(),
            'like' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'dislike' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'count_like' => $this->integer(),
            'count_dislike' => $this->integer(),

        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comment');
    }
}

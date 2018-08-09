<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180808_062621_create_news_table extends Migration
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

        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->integer()->notNull(),
            'heading' => $this->string(150)->notNull(),
            'tags' => $this->string(255),
            'preview' => $this->string(255)->notNull(),
            'text' => $this->string(5000)->notNull(),
            'like' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'dislike' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');
    }
}

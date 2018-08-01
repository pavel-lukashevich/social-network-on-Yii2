<?php

use yii\db\Migration;

/**
 * Handles the creation of table `friends`.
 */
class m180801_100844_create_friends_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('friends', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'subscribe' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'follower' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('friends');
    }
}

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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('friends', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'subscribe' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'follower' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('friends');
    }
}

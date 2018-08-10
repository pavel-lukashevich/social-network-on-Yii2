<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gallery`.
 */
class m180810_184105_create_gallery_table extends Migration
{
    /**
     * @return bool|void
     * @throws \yii\base\NotSupportedException
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('gallery', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->integer('11')->notNull(),
            'heading' => $this->string(150)->notNull(),
            'tags' => $this->string(255),
            'image' => $this->string(255)->notNull(),
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
        $this->dropTable('gallery');
    }
}

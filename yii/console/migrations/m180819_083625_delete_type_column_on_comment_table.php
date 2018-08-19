<?php

use yii\db\Migration;

/**
 * Class m180819_083625_delete_type_column_on_comment_table
 */
class m180819_083625_delete_type_column_on_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('comment', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('comment', 'type', $this->integer(5));
    }

}

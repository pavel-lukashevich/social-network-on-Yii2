<?php

use yii\db\Migration;

/**
 * Class m180819_130217_add_comment_count_column_on_comment_table
 */
class m180819_130217_add_comment_count_column_on_comment_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('gallery', 'comment_count', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gallery', 'comment_count');
    }
}

<?php

use yii\db\Migration;

/**
 * Class m180815_114604_add_column_comment_count_to_news_table
 */
class m180815_114604_add_column_comment_count_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('news', 'comment_count', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('news', 'comment_count');
    }


}

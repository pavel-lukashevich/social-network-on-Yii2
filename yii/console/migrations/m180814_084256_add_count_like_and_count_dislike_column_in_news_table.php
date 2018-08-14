<?php

use yii\db\Migration;

/**
 * Class m180814_084256_add_count_like_and_count_dislike_column_in_news_table
 */
class m180814_084256_add_count_like_and_count_dislike_column_in_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('news', 'count_like', $this->integer(11));
        $this->addColumn('news', 'count_dislike', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('news', 'count_like');;
        $this->dropColumn('news', 'count_dislike');;
    }

}

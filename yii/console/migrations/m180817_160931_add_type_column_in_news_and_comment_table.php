<?php

use yii\db\Migration;

/**
 * Class m180817_160931_add_type_column_in_news_and_comment_table
 */
class m180817_160931_add_type_column_in_news_and_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('news', 'type', $this->integer(5));
        $this->addColumn('comment', 'type', $this->integer(5));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('news', 'type');
        $this->dropColumn('comment', 'type');
    }


}

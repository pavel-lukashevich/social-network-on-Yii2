<?php

use yii\db\Migration;

/**
 * Class m180817_122731_add_count_like_and_count_dislike_column_in_gallery_table
 */
class m180817_122731_add_count_like_and_count_dislike_column_in_gallery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gallery', 'count_like', $this->integer(11));
        $this->addColumn('gallery', 'count_dislike', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gallery', 'count_like');
        $this->dropColumn('gallery', 'count_dislike');
    }

}

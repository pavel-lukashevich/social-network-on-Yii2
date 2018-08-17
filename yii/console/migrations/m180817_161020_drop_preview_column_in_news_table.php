<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `preview_column_in_news`.
 */
class m180817_161020_drop_preview_column_in_news_table extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->dropColumn('news', 'preview');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->addColumn('news', 'preview', $this->string(255)->notNull())->defaultValue('preview...');
    }
}

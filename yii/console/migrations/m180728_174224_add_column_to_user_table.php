<?php

use yii\db\Migration;

/**
 * Class m180728_174224_add_column_to_user_table
 */
class m180728_174224_add_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('user', 'firstname', $this->string(30));
        $this->addColumn('user', 'lastname', $this->string(30));
        $this->addColumn('user', 'birthsday', $this->integer(11));
        $this->addColumn('user', 'country', $this->string(30));
        $this->addColumn('user', 'city', $this->string(30));
        $this->addColumn('user', 'phone', $this->integer(12));
        $this->addColumn('user', 'education', $this->string(255));
        $this->addColumn('user', 'job', $this->string(255));
        $this->addColumn('user', 'about', $this->text());
        $this->addColumn('user', 'avatar', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('user', 'firstname');
        $this->dropColumn('user', 'lastname');
        $this->dropColumn('user', 'birthsday');
        $this->dropColumn('user', 'country');
        $this->dropColumn('user', 'city');
        $this->dropColumn('user', 'phone');
        $this->dropColumn('user', 'education');
        $this->dropColumn('user', 'job');
        $this->dropColumn('user', 'about');
        $this->dropColumn('user', 'avatar');

        return false;
    }
}

<?php

use yii\db\Migration;

/**
 * Class m221114_090114_add_ordered_column_to_booked_books
 */
class m221114_090114_add_ordered_column_to_booked_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('booked_books', 'ordered', $this->boolean()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('booked_books', 'ordered');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221114_090114_add_ordered_column_to_booked_books cannot be reverted.\n";

        return false;
    }
    */
}

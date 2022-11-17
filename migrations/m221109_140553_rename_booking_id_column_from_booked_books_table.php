<?php

use yii\db\Migration;

/**
 * Class m221109_140553_rename_booking_id_column_from_booked_books_table
 */
class m221109_140553_rename_booking_id_column_from_booked_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('booked_books', 'booking_id', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('booked_books', 'id', 'booking_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221109_140553_rename_booking_id_column_from_booked_books_table cannot be reverted.\n";

        return false;
    }
    */
}

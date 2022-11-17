<?php

use yii\db\Migration;

/**
 * Class m221111_135511_add_one_to_one_relation_for_taken_books_on_booked_books
 */
class m221111_135511_add_one_to_one_relation_for_taken_books_on_booked_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('taken_books', 'booked_books_id', $this->integer(11)->unique()->after('book_id'));

        $this->addForeignKey(
            '{{%fk-taken_books-booked_books_id}}',
            '{{%taken_books}}',
            'booked_books_id',
            '{{%booked_books}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('taken_books', 'booked_books_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221111_135511_add_one_to_one_relation_for_taken_books_on_booked_books cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booked_books}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%book}}`
 */
class m221109_074630_create_booked_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booked_books}}', [
            'booking_id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'book_id' => $this->integer(11)->notNull(),
            'amount' => $this->integer(11)->notNull(),
            'booked_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-booked_books-user_id}}',
            '{{%booked_books}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-booked_books-user_id}}',
            '{{%booked_books}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-booked_books-book_id}}',
            '{{%booked_books}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-booked_books-book_id}}',
            '{{%booked_books}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-booked_books-user_id}}',
            '{{%booked_books}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-booked_books-user_id}}',
            '{{%booked_books}}'
        );

        // drops foreign key for table `{{%book}}`
        $this->dropForeignKey(
            '{{%fk-booked_books-book_id}}',
            '{{%booked_books}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-booked_books-book_id}}',
            '{{%booked_books}}'
        );

        $this->dropTable('{{%booked_books}}');
    }
}

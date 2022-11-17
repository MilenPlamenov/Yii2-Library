<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%taken_books}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%book}}`
 */
class m221109_094739_create_taken_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%taken_books}}', [
            'taking_id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'book_id' => $this->integer(11),
            'amount' => $this->integer(11)->notNull(),
            'taken_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'returned_date' => $this->timestamp()->defaultValue(null),
            'returned' => $this->boolean()->defaultValue(false),
            'date_for_return' => $this->timestamp()->defaultExpression('DATE_ADD(NOW(), INTERVAL 30 DAY)'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-taken_books-user_id}}',
            '{{%taken_books}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-taken_books-user_id}}',
            '{{%taken_books}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-taken_books-book_id}}',
            '{{%taken_books}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-taken_books-book_id}}',
            '{{%taken_books}}',
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
            '{{%fk-taken_books-user_id}}',
            '{{%taken_books}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-taken_books-user_id}}',
            '{{%taken_books}}'
        );

        // drops foreign key for table `{{%book}}`
        $this->dropForeignKey(
            '{{%fk-taken_books-book_id}}',
            '{{%taken_books}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-taken_books-book_id}}',
            '{{%taken_books}}'
        );

        $this->dropTable('{{%taken_books}}');
    }
}

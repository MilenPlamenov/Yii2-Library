<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "taken_books".
 *
 * @property int $taking_id
 * @property int|null $user_id
 * @property int|null $book_id
 * @property int|null $booked_books_id
 * @property int $amount
 * @property string $taken_date
 * @property string|null $returned_date
 * @property int|null $returned
 * @property string $date_for_return
 *
 * @property Book $book
 * @property BookedBooks $bookedBooks
 * @property User $user
 */
class TakenBooks extends \yii\db\ActiveRecord
{
    public $return_amount;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taken_books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'book_id', 'booked_books_id', 'amount', 'returned'], 'integer'],
            [['amount'], 'required'],
            [['taken_date', 'returned_date', 'date_for_return', 'return_amount'], 'safe'],
            [['booked_books_id'], 'unique'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['booked_books_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookedBooks::class, 'targetAttribute' => ['booked_books_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'taking_id' => 'Taking ID',
            'user_id' => 'User ID',
            'book_id' => 'Book ID',
            'booked_books_id' => 'Booked Books ID',
            'amount' => 'Amount',
            'taken_date' => 'Taken Date',
            'returned_date' => 'Returned Date',
            'returned' => 'Returned',
            'date_for_return' => 'Date For Return',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Gets query for [[BookedBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookedBooks()
    {
        return $this->hasOne(BookedBooks::class, ['id' => 'booked_books_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}

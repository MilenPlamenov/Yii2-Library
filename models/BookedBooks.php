<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "booked_books".
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property int $amount
 * @property string $booked_date
 * @property int|null $ordered
 * @property Book $book
 * @property User $user
 */

//[
//    $userID => [
//        [
//            'bookid' => 3
//            'amount'=> 5
//        ],
//        [
//            'bookid' => 4
//            'amount' => 2
//        ]
//    ]
//]
//if(!isset(cart[$userID][$bookid])){
//    =0
//}
//cart[$userID][41] += $amount

class BookedBooks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booked_books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'book_id', 'amount'], 'required'],
            [['user_id', 'book_id', 'amount'], 'integer'],
            [['booked_date', 'ordered'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Booking ID',
            'user_id' => 'User ID',
            'book_id' => 'Book ID',
            'amount' => 'Amount',
            'booked_date' => 'Booked Date',
            'ordered' => 'Ordered',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[TakenBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTakenBooks()
    {
        return $this->hasOne(TakenBooks::class, ['booked_books_id' => 'id']);
    }

    public function getUserEmail() {
        return $this->user->email;
    }

    public function getBookTitle() {
        return $this->book->title;
    }
}

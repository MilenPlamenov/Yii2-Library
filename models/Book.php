<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property int $isbn
 * @property string $author
 * @property string|null $description
 * @property string|null $post_year
 * @property int $total_books
 * @property int $available_books
 * @property resource $front_photo
 * @property resource $rear_photo
 * @property string $reg_date
 * @property int $genre_id
 *
 * @property Genre $genre
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'isbn', 'author', 'total_books', 'available_books'], 'required'],
            [['isbn', 'total_books', 'available_books', 'genre_id'], 'integer'],
            [['post_year', 'reg_date'], 'safe'],
            [['front_photo', 'rear_photo'], 'image', 'extensions' => 'png, jpg, jpeg'],
            [['title', 'author'], 'string', 'max' => 52],
            [['description'], 'string', 'max' => 255],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => ['genre_id' => 'genre_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'isbn' => 'Isbn',
            'author' => 'Author',
            'description' => 'Description',
            'post_year' => 'Post Year',
            'total_books' => 'Total Books',
            'available_books' => 'Available Books',
            'front_photo' => 'Front Photo',
            'rear_photo' => 'Rear Photo',
            'reg_date' => 'Reg Date',
            'genre_id' => 'Genre ID',
        ];
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::class, ['genre_id' => 'genre_id']);
    }

    public function getGenreName() {
        return $this->genre->name;
    }

    public function getGenreDropDown() {
        $genres = Genre::find()->asArray()->all();
        return ArrayHelper::map($genres, 'genre_id', 'name');
    }
}

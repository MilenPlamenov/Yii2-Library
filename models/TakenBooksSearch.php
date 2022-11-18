<?php

namespace app\models;

use app\models\TakenBooks;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * TakenBooksSearch represents the model behind the search form of `app\models\TakenBooks`.
 */
class TakenBooksSearch extends TakenBooks
{
    public $title;
    public $author;
    public $isbn;
    public $first_name;
    public $last_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taking_id', 'user_id', 'book_id', 'booked_books_id', 'amount', 'returned'], 'integer'],
            [['taken_date', 'returned_date', 'date_for_return', 'title', 'author', 'isbn', 'first_name', 'last_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $user_id=null, $returned=null)
    {
        $query = TakenBooks::find()
            ->joinWith('user')
            ->joinWith('book');

        if (!empty($user_id)) {
                $query->where("user_id=$user_id");
        }
        if($returned !== null) {
            $query->andWhere("returned=$returned");
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            'defaultOrder' => ['taken_date'=>SORT_DESC],
            'attributes' => [
                'taking_id',
                'title',
                'author',
                'isbn',
                'first_name',
                'last_name',
                'amount',
                'taken_date',
                'returned',
                'date_for_return',
                'returned_date',
            ]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'taking_id' => $this->taking_id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'booked_books_id' => $this->booked_books_id,
            'amount' => $this->amount,
            'taken_date' => $this->taken_date,
            'returned_date' => $this->returned_date,
            'returned' => $this->returned,
            'date_for_return' => $this->date_for_return,
        ]);

        $query->andFilterWhere(['like', 'book.title', $this->title])
            ->andFilterWhere(['like', 'book.author', $this->author])
            ->andFilterWhere(['like', 'book.isbn', $this->isbn])
            ->andFilterWhere(['like', 'user.first_name', $this->first_name])
            ->andFilterWhere(['like', 'user.last_name', $this->last_name]);
        return $dataProvider;
    }
}

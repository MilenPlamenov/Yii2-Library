<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BookedBooks;

/**
 * BookedBooksSearch represents the model behind the search form of `app\models\BookedBooks`.
 */
class BookedBooksSearch extends BookedBooks
{
    public $email;
    public $title;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'book_id', 'amount'], 'integer'],
            [['booked_date', 'email', 'title'], 'safe'],
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
    public function search($params)
    {
        $query = BookedBooks::find()
            ->joinWith('user')
            ->joinWith('book');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['booked_date'=>SORT_DESC],
            'attributes' => [
                'email',
                'title',
                'booked_date',
                'amount',
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
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'booked_date' => $this->booked_date,
            'ordered' => false
        ]);

        $query->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'book.title', $this->title]);

        return $dataProvider;
    }
}

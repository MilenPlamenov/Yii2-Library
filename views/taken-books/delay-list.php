<?php

use app\models\TakenBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TakenBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Delaying books';
?>
<div class="delay-books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'User email',
                'attribute' => 'email',
                'value' => fn($data) => $data->user->email,
                //'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'User phone',
                'attribute' => 'telephone_number',
                'value' => fn($data) => $data->user->telephone_number,
                //'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'Book Title',
                'attribute' => 'title',
                'value' => fn($data) => $data->book->title,
            ],
            'amount',
            [
                'label' => 'Date For Return',
                'attribute' => 'date_for_return',
            ],
            [
              'label' => 'Had to be returned',
              'value' => fn($data) => Yii::$app->formatter->format($data->date_for_return, 'relativeTime')
            ],
        ],
        'summary' => '',
    ]); ?>


</div>
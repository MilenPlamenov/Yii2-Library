<?php

use app\models\TakenBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TakenBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProviderAmount */
/** @var yii\data\ActiveDataProvider $dataProviderReturned */

$this->title = 'Delaying books';
?>

<div class="delay-books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <button class="nav-link active" aria-current="page" id="returned-btn">Returned Sort</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="amount-btn">Amount Sort</button>
        </li>
    </ul>

    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center',
            'id' => 'returned-sort-grid',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProviderReturned,
        'columns' => [
            [
                'label' => 'Name',
                'attribute' => 'first_name',
                'value' => fn($data) => $data->user->first_name,
                //'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
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

    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center',
            'id' => 'amount-sort-grid',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],

        'dataProvider' => $dataProviderAmount,
        'columns' => [
            [
                'label' => 'Name',
                'attribute' => 'first_name',
                'value' => fn($data) => $data->user->first_name,
                //'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
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
            [
                'label' => 'Date For Return',
                'attribute' => 'date_for_return',
            ],
            [
                'label' => 'Amount',
                'attribute' => 'amount',
            ],
        ],
        'summary' => '',
    ]); ?>

</div>


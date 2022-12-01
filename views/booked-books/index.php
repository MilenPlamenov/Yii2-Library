<?php

use app\models\BookedBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BookedBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Booked Books';
?>
<div class="booked-books-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center table-bordered',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'User Email',
                'attribute' => 'email',
                'value' => fn($data) => $data->user->email,
            ],
            [
                'label' => 'Book Title',
                'attribute' => 'title',
                'value' => fn($data) => $data->book->title,
            ],
            'amount',
            'booked_date',
            [
                'class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',
                'contentOptions' => ['style' => 'width:70px; white-space: normal;'],
            ],
            [
                'label' => 'Fast taking',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(Html::encode('Order now'. $data['book']['title']),
                        ['taken-books/create', 'id' => $data['id']], ['data' => [
                                'method' => 'post',
                                'confirm' => 'Are you sure you want to order the books?',
                        ]]);
                },
                'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
        ],
        'summary' => '',

    ]); ?>

    <?php
        if (Yii::$app->user->identity->isAdminOrLibrarian()) {
            echo Html::a('Add to cart', ['add-to-cart'], ['data' => [
                'method' => 'post',
            ], 'class' => 'btn btn-danger', 'id' => 'add-btn']);
        }
    ?>

</div>

<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var app\models\BookedBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>
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
            'label' => 'Ordering',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a(Html::encode('Order '. $data['book']['title']),
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

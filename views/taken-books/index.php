<?php

use app\models\TakenBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TakenBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Taken Books History';
?>
<div class="taken-books-index">

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
                'label' => 'User F Name',
                'attribute' => 'first_name',
                'value' => fn($data) => $data->user->first_name,
                'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'User L Name',
                'attribute' => 'last_name',
                'value' => fn($data) => $data->user->last_name,
                'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),

            ],
            [
                'label' => 'Book Title',
                'attribute' => 'title',
                'value' => fn($data) => $data->book->title,
            ],
            [
                'label' => 'Book ISBN',
                'attribute' => 'isbn',
                'value' => fn($data) => $data->book->isbn,
            ],
            'amount',
            [
                'label' => 'Taken',
                'attribute' => 'taken_date',
                'value' => fn($data) => Yii::$app->formatter->format($data->taken_date, 'relativeTime')
            ],
            [
                'attribute' => 'returned',
                'value' => function ($model) {
                    return $model->returned === 1 ? 'Returned' : 'Not returned yet';
                }
            ],
            [
                'label' => 'Date For Return',
                'attribute' => 'date_for_return',
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'contentOptions' => ['style' => 'width: 8.7%'],
                'urlCreator' => function ($action, TakenBooks $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'taking_id' => $model->taking_id]);
                },
                'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
        ],
        'summary' => '',
    ]); ?>


</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TakenBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var  app\models\User $user */

$this->title = 'Currently taken books for ' . $user->email;
?>
<div class="currently-taken-books">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3>*Note that all delay columns will be in <span class="text-danger">red color</span></h3>
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center table-bordered',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model) {
            $date = new DateTime('now');
            $targetDate = new DateTime($model->date_for_return);

            if ($date > $targetDate) {
                return ['class' => 'bg-danger'];
            }
        },
        'columns' => [
            [
                'label' => 'ID',
                'attribute' => 'taking_id',
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
            'date_for_return',
            [
                'label' => 'Return Part Of The Books',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(Html::encode('Return '. $data['book']['title']),
                        ['taken-books/part-time-return', 'taking_id' => $data['taking_id']]);
                },
                'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'Return All Books',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(Html::encode('Return all '. $data['book']['title']),
                        ['taken-books/return', 'taking_id' => $data['taking_id']], ['data' => [
                            'method' => 'post',
                            'confirm' => 'Are you sure you want to return the books?',
                        ]]);
                },
                'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
        ],
        'summary' => '',
        'pager' => [
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledPageCssClass' => ['class' => 'page-link'],
            'options' => ['class' => 'pagination justify-content-center']
        ],
    ]); ?>


</div>
<?php

use app\models\BookedBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\BookedBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Booked Books';
?>

<h1><?= Html::encode($this->title) ?></h1>


<div class="booked-books-index d-none d-sm-block">

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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{take} {update} {delete}',
                'buttons' => [
                        'take' => fn($url, $model) => Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                                </svg>',
                            ['taken-books/create', 'id' => $model->id],
                            ['data' => [
                            'method' => 'post',
                            'confirm' => 'Are you sure you want to order the books?',
                        ]])
                ],
                'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
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

<div class="booked-books-index-list container  d-sm-none">

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'summary' => '',
            'itemView' => '_booked_books_item',
            'pager' => [
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
                'disabledPageCssClass' => ['class' => 'page-link'],
                'options' => ['class' => 'pagination justify-content-center']
            ],
        ]) ?>

</div>
<?php
if (Yii::$app->user->identity->isAdminOrLibrarian()) {
    $bb = BookedBooks::find()
        ->where(['user_id' => Yii::$app->session->get('selected_user')])
        ->andWhere(['ordered' => 0])->one();
    if ($bb) {
        echo Html::a('Add to cart', ['add-to-cart'], ['data' => [
            'method' => 'post',
        ], 'class' => 'btn btn-primary m-2', 'id' => 'add-btn']);
        echo Html::a('Clear all bookings', ['clear-bookings', 'user_id' => Yii::$app->session->get('selected_user')], ['data' => [
            'method' => 'post',
        ], 'class' => 'btn btn-danger', 'id' => 'clear-bookings-btn']);
    }
}
?>
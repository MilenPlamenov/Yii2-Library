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
                'class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',
                'contentOptions' => ['style' => 'width:70px; white-space: normal;'],
            ],
            [
                'label' => 'Fast taking',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(Html::encode('Order now '. $data['book']['title']),
                        ['taken-books/create', 'id' => $data['id']], ['data' => [
                                'method' => 'post',
                                'confirm' => 'Are you sure you want to order the books?',
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

<div class="booked-books-index-list d-flex container d-block d-sm-none">
    <div class="row">
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
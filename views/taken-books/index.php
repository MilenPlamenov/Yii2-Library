<?php

use app\models\TakenBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\TakenBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Taken Books History';
?>
<h1 class="m-2"><?= Html::encode($this->title) ?></h1>

<div class="taken-books-index d-none d-sm-block">
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            $date = new DateTime('now');
            $targetDate = new DateTime($model->date_for_return);
            if ($date > $targetDate and !$model->returned) {
                return ['class' => 'border border-danger'];
            }
        },
        'columns' => [
            [
                'label' => 'First Name',
                'attribute' => 'first_name',
                'value' => fn($data) => $data->user->first_name,
                'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'Last Name',
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
                'label' => 'ISBN',
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
                'filter' => [ "1"=>"Returned", "0"=>"Not Returned"],
                'value' => function ($model) {
                    return $model->returned === 1 ? 'Returned' : 'Not returned yet';
                }
            ],
            [
                'label' => 'Date For Return',
                'attribute' => 'date_for_return',
            ],
//            [
//                'class' => ActionColumn::className(),
//                'template' => '{update} {delete}',
//                'contentOptions' => ['style' => 'width: 8.7%'],
//                'urlCreator' => function ($action, TakenBooks $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'taking_id' => $model->taking_id]);
//                },
//                'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
//            ],
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

<div class="taken-books-index-list d-flex container d-block d-sm-none">
    <div class="row">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'summary' => '',
        'itemView' => '_taken_books_item',
        'pager' => [
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledPageCssClass' => ['class' => 'page-link'],
            'options' => ['class' => 'pagination justify-content-center']
        ],
    ]) ?>
    </div>
</div>


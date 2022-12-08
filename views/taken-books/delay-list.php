<?php

use app\models\TakenBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\TakenBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProviderAmount */
/** @var yii\data\ActiveDataProvider $dataProviderReturned */

$this->title = 'Delaying books';
?>

<h1><?= Html::encode($this->title) ?></h1>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <button class="nav-link active" aria-current="page" id="returned-btn">Returned Sort</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="amount-btn">Amount Sort</button>
    </li>
</ul>

<div id="returned-sort-grid">
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center d-none d-sm-block',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProviderReturned,
        'columns' => [
            [
                'label' => 'Name',
                'attribute' => 'first_name',
                'format' => 'raw',
                'value' => fn($data) => Html::a($data->user->first_name, [
                        Url::toRoute(['user/currently-taken-books', 'id' => $data->user->id])]
                )
                //'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'Email',
                'attribute' => 'email',
                'value' => fn($data) => $data->user->email,
                //'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'Phone',
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

    <div class="returned-sort-list d-flex container d-block d-sm-none">
        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProviderReturned,
                'itemOptions' => ['class' => 'item'],
                'summary' => '',
                'itemView' => '_returned-sort_item',
                'pager' => [
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledPageCssClass' => ['class' => 'page-link'],
                    'options' => ['class' => 'pagination justify-content-center']
                ],
            ]) ?>
        </div>
    </div>
</div>

<div id="amount-sort-grid">
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center d-none d-sm-block',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],

        'dataProvider' => $dataProviderAmount,
        'columns' => [
            [
                'label' => 'Name',
                'attribute' => 'first_name',
                'format' => 'raw',
                'value' => fn($data) => Html::a($data->user->first_name, [
                        Url::toRoute(['user/currently-taken-books', 'id' => $data->user->id])]
                )
                //'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'Email',
                'attribute' => 'email',
                'value' => fn($data) => $data->user->email,
                //'visible' => Yii::$app->user->identity->isAdminOrLibrarian(),
            ],
            [
                'label' => 'Phone',
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


    <div class="amount-sort-list container d-block d-sm-none">
        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProviderAmount,
                'itemOptions' => ['class' => 'item'],
                'summary' => '',
                'itemView' => '_amount-sort_item',
                'pager' => [
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledPageCssClass' => ['class' => 'page-link'],
                    'options' => ['class' => 'pagination justify-content-center']
                ],
            ]) ?>
        </div>
    </div>
</div>


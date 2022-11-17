<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TakenBooks $model */

$this->title = $model->taking_id;
$this->params['breadcrumbs'][] = ['label' => 'Taken Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="taken-books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'taking_id' => $model->taking_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'taking_id' => $model->taking_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'taking_id',
            'user_id',
            'book_id',
            'booked_books_id',
            'amount',
            'taken_date',
            'returned_date',
            'returned',
            'date_for_return',
        ],
    ]) ?>

</div>

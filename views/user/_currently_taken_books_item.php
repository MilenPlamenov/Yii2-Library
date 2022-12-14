<?php
/** @var app\models\TakenBooks $model */

use yii\helpers\Html;

?>

<div class="card mb-3 <?= new DateTime('now') > new DateTime($model->date_for_return) ? !$model->returned ? 'bg-danger' : '' : '' ?>">
    <div class="card-body">
        <h1 class="text-end">ID: <?= $model->taking_id ?></h1>
        <h4>Book: <?= $model->book->title ?></h4>
        <h4>Amount: <?= $model->amount ?></h4>
        <h6>Taken: <?= $model->taken_date ?></h6>
        <h6>Date for return: <?= $model->date_for_return ?></h6>

        <div class="text-end mt-3">
            <?= Html::a(Html::encode('Return amount'),
                ['taken-books/part-time-return', 'taking_id' => $model->taking_id], ['class' => 'btn btn-info']) ?>

                <?= Html::a(Html::encode('Return all'),
                    ['taken-books/return', 'taking_id' => $model->taking_id], ['data' => [
                        'method' => 'post',
                        'confirm' => 'Are you sure you want to return the books?',
                    ], 'class' => 'btn btn-outline-dark']) ?>
        </div>
    </div>
</div>
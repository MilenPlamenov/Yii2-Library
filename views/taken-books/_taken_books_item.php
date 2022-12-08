<?php
/** @var app\models\TakenBooks $model */

?>

<div class="card mb-3 <?= new DateTime('now') > new DateTime($model->date_for_return) ? !$model->returned ? 'border-danger' : '' : '' ?>">
    <div class="card-body">
        <h2 class="card-title fw-bold">User: <?= $model->user->first_name ?> <?= $model->user->last_name ?></h2>
        <h4>Book: <?= $model->book->title ?></h4>
        <h4>ISBN: <?= $model->book->isbn ?></h4>
        <h4>Amount: <?= $model->amount ?></h4>
        <h5>Status: <?= $model->returned ?
                "<span class='text-success fw-bold'>Returned</span>"
                : "<span class='text-danger fw-bold'>Not returned yet</span>" ?></h5>
        <h6>Date for return: <?= $model->date_for_return ?></h6>
    </div>
</div>
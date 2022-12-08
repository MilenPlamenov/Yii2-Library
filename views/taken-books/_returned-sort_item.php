<?php
/** @var app\models\TakenBooks $model */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="card mb-3">
    <div class="card-body">
        <h2 class="card-title fw-bold">User: <?= Html::a($model->user->first_name, [
                Url::toRoute(['user/currently-taken-books', 'id' => $model->user->id])]) ?></h2>
        <h2>Email: <?= $model->user->email ?></h2>
        <h4>Book: <?= $model->book->title ?></h4>
        <h4>ISBN: <?= $model->book->isbn ?></h4>
        <h4>Amount: <?= $model->amount ?></h4>
        <h5>Status: <?= $model->returned ?
                "<span class='text-success text-decoration-underline'>Returned</span>"
                : "<span class='text-danger text-decoration-underline'>Not returned yet</span>" ?></h5>
        <h6>Date for return: <?= $model->date_for_return ?></h6>
        <h6>Had to be returned: <?= Yii::$app->formatter->format($model->date_for_return, 'relativeTime') ?></h6>
    </div>
</div>
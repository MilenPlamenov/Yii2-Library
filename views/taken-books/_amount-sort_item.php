<?php
/** @var app\models\TakenBooks $model */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="card mb-3">
    <div class="card-body">
        <h1 class="text-end text-decoration-underline">Amount: <?= $model->amount ?></h1>
        <h2 class="card-title">User: <?= Html::a($model->user->first_name, [
                Url::toRoute(['user/currently-taken-books', 'id' => $model->user->id])]) ?></h2>
        <h2>Email: <?= $model->user->email ?></h2>
        <h3>Phone: <?= $model->user->telephone_number ?></h3>
        <h4>Book: <?= $model->book->title ?> (<?= $model->book->isbn ?>)</h4>
        <h6>Date for return: <?= $model->date_for_return ?></h6>
    </div>
</div>
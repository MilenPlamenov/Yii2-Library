<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BookedBooks $model */

$this->title = $model->book->title

?>
<div class="booked-books-create mt-3">

    <h1>Booking: <?= Html::encode($this->title) ?> (<?= $model->book->isbn ?>)</h1>
    <h2 class="fw-bold text-decoration-underline"><?= $model->book->genre->name ?></h2>
    <h3>Available books: <?= $model->book->available_books ?></h3>
    <h5 class="text-danger">*Note that all bookmarks expire after one day!!</h5>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

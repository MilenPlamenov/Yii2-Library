<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\BookedBooks $model */

$this->title = 'Update Booked Books: ' . $model->book->title;

?>
<div class="booked-books-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h5 class="text-danger">*Note that all bookmarks expire after one day!</h5>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

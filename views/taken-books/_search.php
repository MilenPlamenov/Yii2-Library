<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TakenBooksSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="taken-books-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'taking_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'book_id') ?>

    <?= $form->field($model, 'booked_books_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'taken_date') ?>

    <?php // echo $form->field($model, 'returned_date') ?>

    <?php // echo $form->field($model, 'returned') ?>

    <?php // echo $form->field($model, 'date_for_return') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

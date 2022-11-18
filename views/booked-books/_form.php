<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BookedBooks $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="booked-books-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'amount')->textInput()->label('Enter wanted amount of books you want to book:') ?>

    <div class="mt-2">
        <?= Html::submitButton('Book', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

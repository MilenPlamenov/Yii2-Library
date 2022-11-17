<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-search">
    <h3>Search for book by keyword</h3>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'isbn') ?>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'post_year') ?>

    <div class="form-group m-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'search-btn']) ?>
        <?= Html::resetButton('Reset' ,['class' => 'btn btn-outline-secondary', 'id' => 'reset-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>

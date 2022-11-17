<?php

use app\models\Genre;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput() ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_year')->textInput() ?>

    <?= $form->field($model, 'total_books')->textInput() ?>

    <?= $form->field($model, 'available_books')->textInput() ?>

    <?= $form->field($model, 'front_photo')->fileInput() ?>

    <?= $form->field($model, 'rear_photo')->fileInput() ?>

    <?= $form->field($model, 'genre_id')
        ->dropDownList($model->getGenreDropDown(), ['prompt'=>'Select...'])
        ->label('Genre') ?>


    <div class="form-group m-2">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

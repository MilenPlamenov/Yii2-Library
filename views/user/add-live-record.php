<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TakenBooks $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Live taking for user: ' . $model->user->email;
?>

<div class="taken-books-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a(
        'Currently taken books',
        ['currently-taken-books', 'id' => $model->user_id],
        ['class' => 'btn btn-secondary']
    ); ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'book_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
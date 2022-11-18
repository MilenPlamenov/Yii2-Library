<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TakenBooks $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="taken-books-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'return_amount')->textInput() ?>

    <div class="form-group m-2">
        <?= Html::submitButton('Return the chosen amount', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

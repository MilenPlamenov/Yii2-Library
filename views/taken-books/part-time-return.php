<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TakenBooks $model */

$this->title = 'Custom amount return order ID:' . $model->taking_id . ' *Note max amount here is: ' . $model->amount;

?>
<div class="taken-books-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="taken-books-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'return_amount')->textInput() ?>

        <div class="form-group m-2">
            <?= Html::submitButton('Return the chosen amount', ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>

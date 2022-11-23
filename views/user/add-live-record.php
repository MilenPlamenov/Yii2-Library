<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var yii\widgets\ActiveForm $form */
echo var_export($_SESSION);

$this->title = 'Live taking for user: ' . $user->email;
?>

<div class="taken-books-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a(
        'Currently taken books',
        ['currently-taken-books', 'id' => $user->id],
        ['class' => 'btn btn-secondary']
    ); ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user, 'book_id')->textInput() ?>

    <?= $form->field($user, 'amount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
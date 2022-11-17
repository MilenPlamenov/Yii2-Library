<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TakenBooks $model */

$this->title = 'Update Taken Books: ' . $model->taking_id;

?>
<div class="taken-books-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

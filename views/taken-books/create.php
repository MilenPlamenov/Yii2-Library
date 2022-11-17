<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TakenBooks $model */

$this->title = 'Create Taken Books';

?>
<div class="taken-books-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

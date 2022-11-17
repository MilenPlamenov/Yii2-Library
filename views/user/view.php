<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->email;

\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        echo Html::a(
            'Currently taken books',
            ['currently-taken-books', 'id' => $model->id],
            ['class' => 'btn btn-secondary']
        );
        if (Yii::$app->user->identity->isAdminOrLibrarian()) {
            echo Html::a('Update', ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']);
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        } else {
            echo Html::a(
                    'Change Password',
                ['change-password', 'id' => $model->id],
                ['class' => 'btn btn-primary']
            );
        }
        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'User ID',
                'attribute' => 'id',
            ],
            'first_name',
            'last_name',
            'email:email',
            'address',
            'telephone_number',
        ],
    ]) ?>

</div>

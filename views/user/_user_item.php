<?php
/** @var app\models\User $model */

use yii\helpers\Html;

?>

<div class="card mb-3">
    <div class="card-body">
        <h1 class="card-title">User: <?= $model->first_name ?> <?= $model->last_name ?></h1>
        <h2>Email: <?= $model->email ?></h2>
        <h2>Number: <?= $model->telephone_number ?></h2>
        <hr/>
        <div class="text-center m-4">
            <h2><?= Html::a(Html::encode('Check out'),
                    ['user/currently-taken-books', 'id' => $model->id]) ?></h2>
            <h2><?= Html::a(Html::encode('Select User'),
                    ['user/setup-add-live-record', 'user_id' => $model->id], ['data' => [
                        'method' => 'post',
                    ]]) ?></h2>
        </div>

        <div class="text-end">
            <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                </svg>',
                ['update', 'id' => $model->id]) ?>
            <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                </svg>',
                ['view', 'id' => $model->id]) ?>
        </div>
    </div>
</div>
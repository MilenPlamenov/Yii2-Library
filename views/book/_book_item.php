<?php
/** @var app\models\Book $model */

use yii\helpers\Html;

?>

<div class="container d-flex shadow p-3 mt-4">
    <div class="col-lg-2 col-sm-4 col">
        <img alt="book-img" class="img-fluid" src="<?= Yii::getAlias('@bookImgUrl') . '/'. $model->front_photo ?>">
    </div>
    <div class="col-lg-10 col-sm-8 m-4 p-1">
        <h1><?= $model->title ?> (<?= $model->isbn ?>)</h1>
        <div>
            <strong><i>By <?= $model->author ?>. Published on: <?=$model->post_year?></i></strong>
            <p>In stock: <?= $model->available_books ?></p>
        </div>
        <p class=""><?= $model->description?></p>
        <div class="p-1">
            <?php
                if(!Yii::$app->user->isGuest) {
                    echo Html::a('Preview', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-lg m-2']);
                    echo $model->available_books ? Html::a('Bookmark', ['booked-books/create', 'id' => $model->id], ['class' => 'btn btn-warning btn-lg']) : '';
                    if(Yii::$app->user->identity->isAdminOrLibrarian()) {
                        echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-lg m-2']);
                        echo Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger btn-lg m-2',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                }
            ?>
        </div>
    </div>
</div>


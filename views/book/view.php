<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;

\yii\web\YiiAsset::register($this);
?>

<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-4 col-lg-4"><img class="card-img-top mb-5 mb-md-0 img-fluid" src="<?= Yii::getAlias('@bookImgUrl') . '/'. $model->front_photo ?>" alt="..." /></div>
            <div class="col-md-4 col-lg-4"><img class="card-img-top mb-5 mb-md-0 img-fluid" src="<?= Yii::getAlias('@bookImgUrl') . '/'. $model->rear_photo ?>" alt="..." /></div>

            <div class="col-md-4 col-lg-4">
                <div class="small mb-1">ISBN: <?= $model->isbn ?></div>
                <h1 class="display-5 fw-bolder"><?= $model->title ?></h1>
                <div class="fs-5 mb-5">
                    <span><i>Author: <?= $model->author ?></i></span>
                    <p><i>Posted on: <?= $model->post_year ?></i></p>
                    <p><i>In stock: <?= $model->available_books ?></i></p>
                    <p class="text-decoration-underline fw-bold"><?= $model->genre->name ?></p>

                    <p>
                        <?php
                        if(Yii::$app->user->identity->isAdminOrLibrarian()) {
                            echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                        ?>
                    </p>
                </div>
                <p class="overflow-scroll w-100 h-25">Description: <?= $model->description ?></p>
                <?= $model->available_books ? Html::a('Bookmark', ['booked-books/create', 'id' => $model->id],
                    ['class' => 'btn btn-outline-warning text-danger shadow']) : '';
                ?>

            </div>
        </div>
    </div>
</section>

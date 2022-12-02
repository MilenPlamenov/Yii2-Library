<?php
/** @var app\models\Book $model */

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

?>

<?php Modal::begin([
    'title' => 'Add live record',
    'id' => 'modal',
    'size' => 'modal-lg',
]);

echo "<div id='modelContent'></div>";

Modal::end()
?>


<div class="container d-flex shadow p-3 mt-4">
    <div class="col-lg-2 col-sm-4 col">
        <img alt="book-img" class="img-fluid"
             src="<?= Yii::getAlias('@bookImgUrl') . '/'. $model->front_photo ?>">
    </div>
    <div class="col-lg-10 col-sm-8 m-4 p-1">
        <h1><?= $model->title ?> (<?= $model->isbn ?>)</h1>
        <div>
            <strong><i>By <?= $model->author ?>. Published on: <?=$model->post_year?></i></strong>
            <p>In stock: <?= $model->available_books ?></p>
        </div>
        <p class=""><?= StringHelper::truncateWords($model->description, 20) ?></p>
        <div class="p-1">
            <?php
                if(!Yii::$app->user->isGuest) {
                    echo Html::a('Preview', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-lg m-2']);
                    if(Yii::$app->user->identity->isAdminOrLibrarian()) {
                        echo Html::a('Update', ['update', 'id' => $model->id],
                                    ['class' => 'btn btn-outline-primary btn-lg m-2']);
                        echo Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger btn-lg m-2',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                        if (isset($_SESSION['selected_user']) and $model->available_books){
                            echo Html::a('Add to cart', [Url::toRoute(['user/add-live-record']),
                                                                'book_id' => $model->id],
                                                                ['class' => 'update-modal-link btn btn-danger btn-lg']);
                        }
                    } else {
                        echo $model->available_books ? Html::a('Bookmark',
                            ['booked-books/create', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-lg'])
                            : '';
                    }
                }
            ?>
        </div>
    </div>
</div>


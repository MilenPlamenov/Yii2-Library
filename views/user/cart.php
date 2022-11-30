<?php

use app\models\Book;
use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<h1>Books Cart</h1>
<?= print_r($_SESSION['cart']); ?>
<div id="items">
    <?php if (isset($_SESSION['cart']) and !empty($_SESSION['cart'])): ?>
        <?php foreach ($_SESSION['cart'] as $user_id => $items_associative_arrays): ?>
            <?php foreach ($items_associative_arrays as $index => $book_and_amount_array): ?>
                <div class="card-group m-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?= Book::find()->where(['id' => $book_and_amount_array['book_id']])->one()->title ?>
                            (<?= Book::find()->where(['id' => $book_and_amount_array['book_id']])->one()->available_books ?> available)
                            </h3>
                            <p class="card-text">
                                <?= Book::find()->where(['id' => $book_and_amount_array['book_id']])->one()->description ?>
                            </p>
                            <h5 class="text-decoration-underline">Order
                                for: <?= User::find()->where(['id' => $user_id])->one()->email ?></h5>
                            <?php Pjax::begin() ?>
                            <?= $this->render('_buttons', ['user_id' => $user_id,
                                'book_and_amount_array' => $book_and_amount_array,
                                'index' => $index,
                            ]) ?>
                            <?php Pjax::end() ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <?php
        $form = ActiveForm::begin();
        echo Html::submitButton('Proceed', ['class' => 'btn btn-success', 'id' => 'proceed-btn']);
        ActiveForm::end();
        echo Html::a('Clear', ['clear'], ['data' => [
            'method' => 'post',
        ], 'class' => 'btn btn-danger', 'id' => 'clear-btn'])
        ?>
    <?php else: echo '<h2>Empty cart</h2>'; ?>

    <?php endif; ?>


<?php

use app\models\Book;
use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<h1>Books Cart</h1>
<?= print_r($_SESSION);
?>
<div id="items">
    <?php if (isset($_SESSION['cart']) and !empty($_SESSION['cart'])): ?>
        <?php foreach ($_SESSION['cart'] as $key => $value): ?>
            <div class="card-group m-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"><?= Book::find()->where(['id' => $value['book_id']])->one()->title ?></h3>
                        <p class="card-text">
                            <?= Book::find()->where(['id' => $value['book_id']])->one()->description ?>
                        </p>
                        <h5 class="text-decoration-underline">Order
                            for: <?= User::find()->where(['id' => $value['user_id']])->one()->email ?></h5>
                        <?php Pjax::begin() ?>
                        <?= $this->render('_buttons', ['key' => $key, 'value' => $value]) ?>
                        <?php Pjax::end() ?>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        <?php
        $form = ActiveForm::begin();
        echo Html::submitButton('Proceed', ['class' => 'btn btn-success', 'id' => 'proceed-btn']);
        ActiveForm::end();
        ?>
    <?php else: echo '<h2>Empty cart</h2>'; ?>

    <?php endif; ?>


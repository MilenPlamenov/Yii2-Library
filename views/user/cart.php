<?php

use app\models\Book;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<h1>Books Cart</h1>
<?= print_r($_SESSION);
?>
<div id="items">
<?php foreach ($_SESSION as $key => $value): ?>
    <?php if (strlen($key) == 12): ?>
<div class="card-group m-4">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title"><?= Book::find()->where(['id' => $value['book_id']])->one()->title ?></h3>
            <p class="card-text">
                <?= Book::find()->where(['id' => $value['book_id']])->one()->description ?>
            </p>
        <?php Pjax::begin() ?>
        <?= $this->render('_buttons', ['key' => $key, 'value' => $value]) ?>
        <?php Pjax::end() ?>
        </div>
    </div>
</div>
    <?php endif; ?>
<?php endforeach; ?>
</div>
<?php if (Yii::$app->session->has('has_books_in_cart')) {
    $form = ActiveForm::begin();
    echo Html::submitButton('Proceed', ['class' => 'btn btn-success', 'id' => 'proceed-btn']);
    ActiveForm::end();
} else {
    echo '<h2>Empty cart</h2>';
}
?>

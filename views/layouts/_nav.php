<?php

use app\models\Book;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Html;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-expand-lg navbar-dark bg-dark fixed-top']
]);
echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        !Yii::$app->user->isGuest ? (
        Yii::$app->user->identity->isAdminOrLibrarian() ?
            (['label' => 'Users', 'url' => ['/user/index']])
            : '') : '',

        ['label' => 'Books', 'url' => ['book/index']],

        !Yii::$app->user->isGuest ?
            ['label' => 'Bookings', 'url' => ['booked-books/index']] : '',

        !Yii::$app->user->isGuest
            ? ['label' => 'All Takings', 'url' => ['taken-books/index']] : '',

        Yii::$app->user->isGuest ?
            (['label' => 'Register', 'url' => ['/site/register']])
            : '',

        !Yii::$app->user->isGuest ? (
        Yii::$app->user->identity->isAdminOrLibrarian() ?
            (['label' => 'Delay List', 'url' => ['/taken-books/delay-list']])
            :
            '') : '',

        !Yii::$app->user->isGuest ? (
        Yii::$app->user->identity->isAdminOrLibrarian() ?
            (['label' => 'Add Book', 'url' => ['/book/create']])
            :
            ['label' => 'View Account', 'url' => ['user/view', 'id' => Yii::$app->user->identity->id]]) : '',

        !Yii::$app->user->isGuest ? (
        Yii::$app->user->identity->isAdminOrLibrarian() ?
            (['label' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
</svg>' . '(<span id="item-count">' . (Yii::$app->session->get('selected_user') ?
                                        (count($_SESSION['cart'][$_SESSION['selected_user']]) ?
                                            max(array_keys($_SESSION['cart'][$_SESSION['selected_user']])) + 1 : 0) : 0)
                                                . '</span>)', 'url' => ['/user/cart']])
            : '') : '',

        Yii::$app->user->isGuest ?
            ['label' => 'Login', 'url' => ['/site/login']]
            : ('<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->email . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        ),
    ]
]);
NavBar::end();

?>
<?php

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Html;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-expand-lg navbar-dark bg-dark fixed-top']
]);
echo Nav::widget([
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
            (['label' => 'Add Book', 'url' => ['/book/create']])
            :
            ['label' => 'View Account', 'url' => ['user/view', 'id' => Yii::$app->user->identity->id]]) : '',

        !Yii::$app->user->isGuest ? (
        Yii::$app->user->identity->isAdminOrLibrarian() ?
            (['label' => 'Live record cart', 'url' => ['/user/cart']])
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
<?php

use app\models\User;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
?>
<h1><?= Html::encode($this->title) ?></h1>


<div class="user-index d-none d-sm-block">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped text-center table-bordered',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'first_name',
            'last_name',
            'email',
            [
                    'attribute' => 'telephone_number',
                    'label' => 'Number',
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{select_user} {taken_books} {view} {update}',
                'contentOptions' => ['style' => 'width: 10%'],
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'buttons' => [
                       'taken_books' => fn($url, $model) => Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                      <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z"/>
                      <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                    </svg>',
                           ['user/currently-taken-books', 'id' => $model->id]),
                    'select_user' => fn($url, $model) => !Yii::$app->session->get('selected_user') ? Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                      <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
                    </svg>',
                        ['user/setup-add-live-record', 'user_id' => $model->id], ['data' => [
                        'method' => 'post',
                    ]]) : '',

                ],
            ],
        ],
        'summary' => '',
        'pager' => [
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledPageCssClass' => ['class' => 'page-link'],
            'options' => ['class' => 'pagination justify-content-center']
        ],
    ]); ?>


</div>

<div class="user-index-list d-flex container d-block d-sm-none">
    <div class="row">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'summary' => '',
            'itemView' => '_user_item',
            'pager' => [
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
                'disabledPageCssClass' => ['class' => 'page-link'],
                'options' => ['class' => 'pagination justify-content-center']
            ],
        ]) ?>
    </div>
</div>


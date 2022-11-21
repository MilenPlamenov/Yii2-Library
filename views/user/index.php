<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'template' => '{update} {view}',
                'contentOptions' => ['style' => 'width: 8.7%'],
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
            ],
            [
                'label' => 'Taken Books',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(Html::encode('Check out'),
                        ['user/currently-taken-books', 'id' => $data['id']]);
                },
                'contentOptions' => ['style' => 'width: 11.7%'],

            ],
            [
                'label' => 'Live taking',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a(Html::encode('Order'),
                        ['user/add-live-record', 'user_id' => $data['id']]);
                },
                'contentOptions' => ['style' => 'width: 11.7%'],

            ],
        ],
        'summary' => '',
    ]); ?>


</div>

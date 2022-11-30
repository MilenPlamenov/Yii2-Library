<?php

use app\models\Book;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<?php echo $this->render('_index_header'); ?>


<div class="book-index container mt-4">

    <div id="search-div">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <div id="sort-div">
        <h3>Sort the books base on (title, author or year)</h3>
        <?= LinkSorter::widget([
            'sort' => $dataProvider->sort,
            'attributes' => [
                'title',
                'author',
                'post_year',
            ],
            'options' => ['class' => 'list-group  nav'],
            'linkOptions' => ['class' => 'list-group-item list-group-item-action'],
        ]) ?>
    </div>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_book_item',
        'summary' => '',
    ]) ?>
</div>
